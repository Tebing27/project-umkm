<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Region;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    /**
     * Show the public shop listing page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Shop::where('is_verified', true);

        $search = $request->input('search');

        // --- Section: Logika Pencarian & Keamanan ---
        // Mencegah Search Flooding / CPU Spike dengan membatasi panjang karakter minimum
        if ($search) {
             if (strlen($search) < 3) {
                 // Abaikan pencarian jika kurang dari 3 karakter untuk mengurangi beban database
             } else {
                 // Full Text Search (MySQL MATCH AGAINST)
                 // Mode Boolean memungkinkan penggunaan wildcard '*' untuk pencarian prefix (contoh: "kop*" cocok dengan "kopi")
                 // Ini jauh lebih efisien daripada LIKE '%...%' karena menggunakan index
                 $query->whereFullText(['name', 'description'], $search . '*', ['mode' => 'boolean']);
             }
        }

        // --- Section: Filtering ---
        // Filter by Region
        if ($request->has('region') && $request->region) {
            $regionName = $request->region;
            $query->whereHas('region', function($q) use ($regionName) {
                $q->where('name', $regionName);
            });
        }

        // Filter by Category/Business Type
        if ($request->has('category') && $request->category) {
             $query->where('business_type', $request->category);
        }

        // --- Section: Pagination & Security ---
        // PENTING: Jangan gunakan get() tanpa limit pada dataset yang berpotensi besar untuk menghindari Memory Exhaustion (DoS).
        $shops = $query->with(['region', 'photos'])->orderByDesc('created_at')->paginate(12)->withQueryString();

        // Get all regions for filter dropdown
        $regions = Region::pluck('name');

        // --- Section: Transformasi Data Frontend ---
        // Hanya mengembalikan data halaman saat ini ke AlpineJS untuk mengurangi ukuran payload HTML.
        $shopsData = collect($shops->items())->map(function($shop) {
            $formattedOmset = 'Rp. -';
            if ($shop->omset_min || $shop->omset_max) {
                 $min = $shop->omset_min ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_min), 0, ',', '.') : '';
                 $max = $shop->omset_max ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_max), 0, ',', '.') : '';
                 
                 if ($min && $max) {
                     $formattedOmset = "$min - $max";
                 } elseif ($min) {
                     $formattedOmset = $min;
                 } elseif ($max) {
                     $formattedOmset = $max;
                 }
            }

            $formattedLicenses = '-';
            if ($shop->licenses) {
                 $licenses = is_string($shop->licenses) ? json_decode($shop->licenses, true) : $shop->licenses;
                 if (is_array($licenses) && count($licenses) > 0) {
                     // FIX: Ensure all elements are strings to prevent "Array to string conversion"
                     $formattedLicenses = collect($licenses)->pluck('type')->filter()->implode(', ');
                 }
            }

            // Prepare Images Array (Popup Slider)
            // Logic: Use Shop Photos (Manage Photos) as source of truth.
            // Sidebar Cover = Photo index 0
            // Popup Slider = All Photos
            $photoUrls = [];
            if ($shop->photos && $shop->photos->count() > 0) {
                $photoUrls = $shop->photos->sortBy('order')->pluck('path')->map(function($path) {
                    return storage_url($path);
                })->values()->toArray();
            }
            
            // If has photos, use them. Else fallback to logo/icon.
            if (count($photoUrls) > 0) {
                $images = $photoUrls;
                $mainImage = $photoUrls[0];
            } else {
                $images = [$shop->logo_url];
                $mainImage = $shop->logo_url;
            }
            
            // Map Icon Logic (Simple fallback logic similar to Shop Model)
            $iconType = 'default';
            $customIcon = null;
            $typeLower = strtolower($shop->business_type ?? '');
            
            if (str_contains($typeLower, 'kuliner') || str_contains($typeLower, 'makan')) $iconType = 'food';
            elseif (str_contains($typeLower, 'fashion') || str_contains($typeLower, 'pakaian')) $iconType = 'fashion';
            elseif (str_contains($typeLower, 'jasa')) $iconType = 'work';
            elseif (str_contains($typeLower, 'kelontong')) $iconType = 'kelontong';
            elseif (str_contains($typeLower, 'agribisnis') || str_contains($typeLower, 'tani')) $iconType = 'agribisnis';
            elseif (str_contains($typeLower, 'kerajinan')) $iconType = 'kerajinan';
            
            return [
                'id' => $shop->id,
                'name' => $shop->name,
                'location' => optional($shop->region)->name ?? '',
                'region' => optional($shop->region)->name ?? '', 
                'category' => $shop->business_type,
                'badge' => $shop->business_type, // Frontend expects 'badge'
                'product_type' => $shop->product_type,
                'description' => \Illuminate\Support\Str::limit($shop->description, 100),
                'omset' => $formattedOmset,
                'image' => $mainImage, // Sidebar uses Cover Photo (index 0)
                'img' => $mainImage, // Frontend expects 'img' fallback
                'srcset' => cloudinary_srcset($mainImage) ?: null, // Generate SrcSet for Responsive Image
                'images' => $images, // Frontend expects 'images' array
                'surat' => $formattedLicenses, // Frontend expects 'surat'
                'link' => route('umkm.comment', $shop->id),
                'lat' => $shop->latitude,
                'lng' => $shop->longitude,
                'omset_min' => (int) preg_replace('/[^0-9]/', '', $shop->omset_min),
                'omset_max' => (int) preg_replace('/[^0-9]/', '', $shop->omset_max),
                'logo_url' => $shop->logo_url,
                'iconType' => $iconType,
                'customIcon' => $customIcon
            ];
        });

        // Fetch Admin Content for this page
        $contents = Content::where('group', 'umkm_index')->get()->keyBy('key');

        $businessTypes = Shop::getBusinessTypes();

        if ($request->wantsJson() || $request->has('json')) {
             return response()->json($shopsData);
        }

        return view('umkm.index', compact('shops', 'regions', 'shopsData', 'contents', 'businessTypes'));
    }

    /**
     * Show the shop detail page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $shop = Shop::with(['user', 'region', 'photos', 'products' => function($q) {
            $q->where('is_active', true);
        }])->where('is_verified', true)->findOrFail($id);

        if (!$shop->isComplete()) {
            abort(404);
        }
        
        // --- Section: Related Shops ---
        // Optimization: Removed extra 3 queries for related shops since they are not displayed in the current UI.
        $relatedShops = collect([]);

        // --- Section: View Increment Logic (Business Rule) ---
        // Menggunakan Cookie (Device ID) 5 Tahun + Cache Harian untuk mencegah spam view count dari user yang sama di hari yang sama.
        $deviceId = request()->cookie('umkm_device_id');
        if (!$deviceId) {
            $deviceId = \Illuminate\Support\Str::uuid()->toString();
             \Illuminate\Support\Facades\Cookie::queue('umkm_device_id', $deviceId, 2628000); // 5 Tahun
        }

        $todayStr = now()->toDateString();
        $cacheKey = "shop_view_daily:{$shop->id}:{$deviceId}:{$todayStr}";

        if (!Cache::has($cacheKey)) {
            $shop->increment('views');
            Cache::put($cacheKey, true, now()->endOfDay());
        }

        // --- Section: Transformasi Produk untuk Frontend ---
        $productsData = $shop->products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'variant' => $product->variant,
                'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'description' => $product->description,
                'image' => storage_url($product->image, 300),
                'link' => route('umkm.product', $product->id),
                'is_best_seller' => $product->is_best_seller
            ];
        });


        // Extract unique categories from loaded products
        $productCategories = $shop->products->pluck('category')->unique()->values()->all();

        // Prepare License Data (Zero PHP in View)
        $licenses = [];
        if ($shop->licenses) {
            $licenses = json_decode($shop->licenses);
        }

        // Prepare Omset Data (Zero PHP in View)
        $formattedOmset = '';
        if ($shop->omset_min || $shop->omset_max) {
             $min = $shop->omset_min ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_min), 0, ',', '.') : '';
             $max = $shop->omset_max ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_max), 0, ',', '.') : '';
             
             if ($min && $max) {
                 $formattedOmset = "$min - $max";
             } elseif ($min) {
                 $formattedOmset = $min;
             } elseif ($max) {
                 $formattedOmset = $max;
             }
        }

        // Append accessors for both View (Initial Load) and JSON (Real-time)
        $shop->append(['logo_url', 'instagram_username', 'tiktok_username', 'facebook_username', 'website_url']);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'shop' => $shop,
                'products' => $productsData,
                'categories' => $productCategories, // Add categories to JSON response
                'licenses' => $licenses,
                'formattedOmset' => $formattedOmset
            ]);
        }

        return view('umkm.detail.index', compact('shop', 'relatedShops', 'productsData', 'productCategories', 'licenses', 'formattedOmset'));
    }

    /**
     * Show the product detail page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function productDetail($id)
    {
        $product = \App\Models\Product::with(['shop.user', 'shop.region', 'images'])->findOrFail($id);
        
        // Memastikan toko terverifikasi sebelum menampilkan produk
        if (!$product->shop->is_verified) {
             abort(404);
        }
        
        $shop = $product->shop;
        
        // Similar Logic for Shop Data as in Show method if needed
        $shop->append(['logo_url', 'instagram_username', 'tiktok_username', 'facebook_username']);
        
        $otherProducts = \App\Models\Product::where('shop_id', $shop->id)
                            ->where('id', '!=', $product->id)
                            ->where('is_active', true)
                            ->with('images') // Prevent N+1 query when displaying product images
                            ->inRandomOrder()
                            ->take(5)
                            ->get();

        return view('umkm.product.index', compact('product', 'shop', 'otherProducts'));
    }
}