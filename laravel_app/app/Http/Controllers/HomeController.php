<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Shop;
use App\Models\Content;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch Admin Content
        $contents = Content::all()->groupBy('group'); // Keep for other parts if needed, or extract specifics

        // --- Section: Data Wilayah ---
        $regions = Region::withCount(['shops' => function ($query) {
            $query->where('is_verified', true);
        }])
        ->orderByRaw('CASE WHEN hero_order IS NULL OR hero_order = 0 THEN 1 ELSE 0 END, hero_order ASC')
        ->orderBy('name', 'asc')
        ->get();
        $colors = ['bg-[#c3daff]', 'bg-[#cbf3e3]'];
        
        $regionItems = $regions->map(function($region, $index) use ($colors) {
            return [
                'title' => $region->name,
                'count' => $region->shops_count . ' UMKM',
                'color' => $colors[$index % 2],
                'image' => $region->image ? storage_url($region->image) : 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80',
                'srcset' => $region->image ? cloudinary_srcset(storage_url($region->image)) : ''
            ];
        });

        // Content for Wilayah
        $wilayahContent = $contents->get('home_wilayah', collect());
        $wilayahTitle = $wilayahContent->firstWhere('key', 'home_wilayah_title')->value ?? 'Wilayah';
        $wilayahSubtitle = $wilayahContent->firstWhere('key', 'home_wilayah_subtitle')->value ?? 'Ayo Jelajahi';
        $wilayahDesc = $wilayahContent->firstWhere('key', 'home_wilayah_desc')->value ?? 'Berbagai jenis usaha lokal di wilayah kalian berada';


        // --- Section: Hero Section Data ---
        
        // Aturan Bisnis:
        // Kita tidak me-load relasi 'shops' secara langsung untuk semua region karena akan menyebabkan N+1 Query dan Memory Bloat.
        // Solusi: Hanya ambil Featured Shop atau satu Random Shop per region secara efisien.
        $allRegions = Region::whereHas('shops', fn($q) => $q->where('is_verified', true))
            ->with(['featuredShop' => fn($q) => $q->where('is_verified', true)->with(['photos', 'region'])])
            ->get();

        // Separate logic for filling the slider
        $heroShops = collect();
        
        // Collect regions that need top shops (by views/clicks)
        $regionsNeedingTopShop = collect();

        foreach ($allRegions as $region) {
            if ($region->featuredShop) {
                // Prioritas 1: Shop yang dipilih admin sebagai Featured
                $heroShops->push($region->featuredShop);
            } else {
                // Prioritas 2: Shop dengan views tertinggi (atau terbaru jika views sama)
                $regionsNeedingTopShop->push($region);
            }
        }
        
        // Batch load top shops (by views) for all regions needing them in a single query
        if ($regionsNeedingTopShop->isNotEmpty()) {
            $regionIds = $regionsNeedingTopShop->pluck('id');
            
            // Get all verified shops, sorted by views DESC, then newest first
            $topShopsByRegion = Shop::whereIn('region_id', $regionIds)
                ->where('is_verified', true)
                ->with(['photos', 'region'])
                ->orderByDesc('views')
                ->orderByDesc('created_at')  // Fallback: newest when views are tied
                ->get()
                ->groupBy('region_id');
            
            // Pick the top shop (highest views) per region
            foreach ($regionsNeedingTopShop as $region) {
                if (isset($topShopsByRegion[$region->id]) && $topShopsByRegion[$region->id]->isNotEmpty()) {
                    $topShop = $topShopsByRegion[$region->id]->first(); // Already sorted by DB
                    $heroShops->push($topShop);
                }
            }
        }
        
        // Batasi maksimal 5 toko unik untuk slider
        $heroShops = $heroShops->unique('id')->take(5);

        // Transformasi data untuk View
        $heroItems = $heroShops->map(function($shop) {
            $photo = $shop->photos->sortBy('order')->first();
            return [
                'id' => $shop->id,
                'title' => $shop->name,
                'category' => $shop->business_type,
                'product_type' => $shop->product_type,
                'description' => \Illuminate\Support\Str::limit($shop->description, 80),
                'sales' => $shop->omset_max ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_max), 0, ',', '.') : 'Rp. -',
                'region' => $shop->region ? $shop->region->name : 'Sasuma',
                'image' => $photo ? storage_url($photo->path) : 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?auto=format&fit=crop&w=800&q=60',
                'srcset' => $photo ? cloudinary_srcset(storage_url($photo->path)) : ''
            ];
        });

        if ($heroItems->isEmpty()) {
            $heroItems = collect([
                [
                    'id' => 1,
                    'title' => 'Sasuma UMKM',
                    'category' => 'Kuliner',
                    'product_type' => 'Pecel lele, daun singkong, dan lontong sayur',
                    'description' => 'Pecel lele, daun singkong, dan lontong sayur',
                    'sales' => 'Rp. 10.000.000',
                    'region' => 'Sasuma',
                    'image' => 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?auto=format&fit=crop&w=800&q=60'
                ],
            ]);
        }

        // Content for Hero
        $heroContent = $contents->get('home_hero', collect());
        $heroTitle = $heroContent->firstWhere('key', 'home_hero_title')->value ?? 'UMKM SASUMA.';
        $heroDesc = $heroContent->firstWhere('key', 'home_hero_desc')->value ?? 'Temukan berbagai jenis usaha lokal, dari kuliner, kerajinan, sampai layanan jasa.';
        $heroImageObj = $heroContent->firstWhere('key', 'home_hero_image');
        $heroImage = ($heroImageObj && $heroImageObj->value) ? storage_url($heroImageObj->value) : 'https://wia-mamung-nine.vercel.app/assets/logoumkm-B9AUVb8-.jpeg';


        // --- Section: Map Section Data ---
        
        // Mengambil Icon Jenis Usaha
        // Map: Business Type Value (lowercase) -> Icon URL
        $businessTypes = $contents->get('business_types', collect());
        $businessTypeIcons = $contents->get('business_type_icons', collect())->keyBy('key');
        
        $iconMap = [];
        foreach ($businessTypes as $bt) {
            $iconKey = 'icon_for_' . $bt->id;
            if (isset($businessTypeIcons[$iconKey])) {
                $iconMap[strtolower($bt->value)] = storage_url($businessTypeIcons[$iconKey]->value);
            }
        }

        // Fetch Categories for Filter (Unique Values)
        $categories = $businessTypes->pluck('value')->unique()->sort()->values();

        // Build Business Types with Icons for Dropdown
        $businessTypesWithIcons = [];
        foreach ($businessTypes as $bt) {
            $businessTypesWithIcons[] = [
                'name' => $bt->value,
                'icon_url' => isset($iconMap[strtolower($bt->value)]) ? $iconMap[strtolower($bt->value)] : null,
                'fallback_icon' => Shop::getFallbackMarkerIconForType($bt->value)
            ];
        }

        // --- Section: Optimasi Peta ---
        // Hanya memilih kolom yang dibutuhkan untuk mengurangi ukuran payload response (karena data peta bisa besar)
        $mapShopsRaw = Shop::select('id', 'name', 'description', 'business_type', 'latitude', 'longitude', 'omset_min', 'omset_max', 'licenses', 'region_id')
            ->with([
                'region:id,name', 
                'photos:id,shop_id,path,order' // Specify columns to reduce payload size
            ])
            ->where('is_verified', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $mapShops = $mapShopsRaw->map(function ($shop) use ($iconMap) {
            $photo = $shop->photos->sortBy('order')->first();
            $minOmset = $shop->omset_min ? (float) preg_replace('/[^0-9]/', '', $shop->omset_min) : 0;
            $maxOmset = $shop->omset_max ? (float) preg_replace('/[^0-9]/', '', $shop->omset_max) : 0;

            // Helper for omset string
            $omsetStr =
                'Rp ' .
                number_format($minOmset / 1000000, 0, ',', '.') .
                ' Jt - Rp ' .
                number_format($maxOmset / 1000000, 0, ',', '.') .
                ' Jt';

            // Icon type mapping (Legacy Fallback)
            $iconType = 'grid';
            $typeLower = strtolower($shop->business_type);
            
            // Primary: Cek jika custom icon tersedia untuk jenis usaha ini
            $customIconUrl = null;
            // Iterasi map keys untuk pencocokan
            if (isset($iconMap[$typeLower])) {
                $customIconUrl = $iconMap[$typeLower];
            } else {
                 // Coba pencocokan parsial (loose matching)
                 foreach ($iconMap as $k => $v) {
                     if (str_contains($typeLower, $k) || str_contains($k, $typeLower)) {
                         $customIconUrl = $v;
                         break;
                     }
                 }
            }

            if (str_contains($typeLower, 'kuliner')) {
                $iconType = 'food';
            } elseif (str_contains($typeLower, 'fashion') || str_contains($typeLower, 'pakaian')) {
                $iconType = 'fashion';
            } elseif (str_contains($typeLower, 'kerajinan')) {
                $iconType = 'fashion';
            } elseif (str_contains($typeLower, 'jasa')) {
                $iconType = 'work';
            } elseif (str_contains($typeLower, 'agribisnis')) {
                $iconType = 'work';
            } elseif (str_contains($typeLower, 'kelontong')) {
                $iconType = 'food';
            }

            return [
                'id' => $shop->id,
                'name' => $shop->name,
                'region' => $shop->region ? $shop->region->name : '',
                'badge' => $shop->business_type,
                'category' => $shop->business_type,
                'iconType' => $iconType,
                'customIcon' => $customIconUrl, // New Field
                'omset' => $omsetStr,
                'omsetVal' => $maxOmset / 1000000,
                'omset_min' => $minOmset,
                'omset_max' => $maxOmset,
                'description' => \Illuminate\Support\Str::limit($shop->description, 100),
                'surat' => (function() use ($shop) {
                    // Use model accessor logic here or just call it if available, 
                    // but since we are transforming explicit array for JS, strict logic here is fine.
                    $licenses = $shop->licenses;
                    if (is_string($licenses)) $licenses = json_decode($licenses, true);
                    if (is_array($licenses) && count($licenses) > 0) {
                        return collect($licenses)->pluck('type')->join(', ');
                    }
                    return '-';
                })(),
                'lat' => (float) $shop->latitude,
                'lng' => (float) $shop->longitude,
                'images' =>
                    $shop->photos->count() > 0
                        ? $shop->photos->sortBy('order')->map(fn($p) => storage_url($p->path))->values()->toArray()
                        : ['https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=400&q=80'],
                'img' => $photo
                    ? storage_url($photo->path)
                    : 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=200&q=80',
                'srcset' => $photo ? cloudinary_srcset(storage_url($photo->path)) : ''
            ];
        });

        // Regions Data for Map
        $regionsMap = $regions->map(function ($region) {
            return [
                'name' => $region->name,
                'lat' => (float) $region->latitude,
                'lng' => (float) $region->longitude,
            ];
        });

        return view('home.index', compact(
            'regions', 'heroShops', 'mapShops', 'contents', // mapShops is now transformed
            'regionItems', 'wilayahTitle', 'wilayahSubtitle', 'wilayahDesc',
            'heroItems', 'heroTitle', 'heroDesc', 'heroImage',
            'regionsMap', // Pass regions data for map specifically if needed, or use 'regions' if it has lat/lng
            'categories', // Pass dynamic categories
            'businessTypesWithIcons' // Pass business types with icon URLs
        ));
    }
}
