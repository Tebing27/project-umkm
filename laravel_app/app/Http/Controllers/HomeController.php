<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Shop;
use App\Models\Content;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch Admin Content
        $contents = Content::all()->groupBy('group'); // Keep for other parts if needed, or extract specifics

        // --- Wilayah Section Data ---
        $regions = Region::withCount('shops')->get();
        $colors = ['bg-[#c3daff]', 'bg-[#cbf3e3]'];
        
        $regionItems = $regions->map(function($region, $index) use ($colors) {
            return [
                'title' => $region->name,
                'count' => $region->shops_count . ' UMKM',
                'color' => $colors[$index % 2],
                'image' => $region->image ? asset('storage/' . str_replace('\\', '/', $region->image)) : 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80'
            ];
        });

        // Content for Wilayah
        $wilayahContent = $contents->get('home_wilayah', collect());
        $wilayahTitle = $wilayahContent->firstWhere('key', 'home_wilayah_title')->value ?? 'Wilayah';
        $wilayahSubtitle = $wilayahContent->firstWhere('key', 'home_wilayah_subtitle')->value ?? 'Ayo Jelajahi';
        $wilayahDesc = $wilayahContent->firstWhere('key', 'home_wilayah_desc')->value ?? 'Berbagai jenis usaha lokal di wilayah kalian berada';


        // --- Hero Section Data ---
        $allRegions = Region::whereHas('shops', fn($q) => $q->where('is_verified', true))
            ->with(['featuredShop' => fn($q) => $q->where('is_verified', true)->with(['photos', 'region']),
                    'shops' => fn($q) => $q->where('is_verified', true)->with(['photos', 'region'])])
            ->get();

        $featuredRegions = $allRegions->filter(fn($r) => $r->featuredShop !== null);
        $otherRegions = $allRegions->filter(fn($r) => $r->featuredShop === null)->shuffle();
        
        $heroRegions = $featuredRegions->merge($otherRegions)
            ->sortBy(function($region) {
                // If order is explicitly set (>0), use it. Null or 0 goes to the end (99999).
                return ($region->hero_order && $region->hero_order > 0) ? $region->hero_order : 99999;
            })
            ->take(5);

        $heroShops = collect();

        foreach ($heroRegions as $region) {
            if ($region->featuredShop) {
                $shop = $region->featuredShop;
            } else {
                $shop = $region->shops->isNotEmpty() ? $region->shops->random() : null;
            }

            if ($shop) {
                $heroShops->push($shop);
            }
        }

        $heroItems = $heroShops->map(function($shop) {
            $photo = $shop->photos->sortBy('order')->first();
            return [
                'id' => $shop->id,
                'title' => $shop->name,
                'category' => $shop->business_type,
                'description' => \Illuminate\Support\Str::limit($shop->description, 80),
                'sales' => $shop->omset_max ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_max), 0, ',', '.') : 'Rp. -',
                'region' => $shop->region ? $shop->region->name : 'Sasuma',
                'image' => $photo ? asset('storage/' . str_replace('\\', '/', $photo->path)) : 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?auto=format&fit=crop&w=800&q=60'
            ];
        });

        if ($heroItems->isEmpty()) {
            $heroItems = collect([
                [
                    'id' => 1,
                    'title' => 'Sasuma UMKM',
                    'category' => 'Kuliner',
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
        $heroImage = ($heroImageObj && $heroImageObj->value) ? asset('storage/' . str_replace('\\', '/', $heroImageObj->value)) : 'https://wia-mamung-nine.vercel.app/assets/logoumkm-B9AUVb8-.jpeg';


        // --- Map Section Data ---
        // --- Map Section Data ---
        $mapShopsRaw = Shop::with(['region', 'photos'])
            ->where('is_verified', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $mapShops = $mapShopsRaw->map(function ($shop) {
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

            // Icon type mapping
            $iconType = 'grid';
            $typeLower = strtolower($shop->business_type);
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
                'omset' => $omsetStr,
                'omsetVal' => $maxOmset / 1000000,
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
                        ? $shop->photos->sortBy('order')->map(fn($p) => asset('storage/' . $p->path))->values()->toArray()
                        : ['https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=400&q=80'],
                'img' => $photo
                    ? asset('storage/' . $photo->path)
                    : 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=200&q=80',
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

        return view('home', compact(
            'regions', 'heroShops', 'mapShops', 'contents', // mapShops is now transformed
            'regionItems', 'wilayahTitle', 'wilayahSubtitle', 'wilayahDesc',
            'heroItems', 'heroTitle', 'heroDesc', 'heroImage',
            'regionsMap' // Pass regions data for map specifically if needed, or use 'regions' if it has lat/lng
        ));
    }
}
