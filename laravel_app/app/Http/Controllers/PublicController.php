<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Region;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::where('is_verified', true);

        $search = $request->input('search');

        // Search Prevention: Minimum 3 characters to prevent CPU Spike
        if ($search) {
             if (strlen($search) < 3) {
                 // Or just return empty or ignore
                 // For UX, maybe just ignore or search exact if very short? 
                 // Safeguard: Only perform DB search if reasonable length.
                 // We will filter by name using standard LIKE for short words if absolutely needed, but for DoS prevention, we strictly limit.
             } else {
                 // Full Text Search (MySQL MATCH AGAINST)
                 // Mode: Boolean Mode allows * wildcard for prefix matching (e.g. "kop*" matches "kopi")
                 // This avoids Full Table Scan.
                 $query->whereFullText(['name', 'description'], $search . '*', ['mode' => 'boolean']);
             }
        }

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

        // PAGINATION: Essential for DoS Prevention (Memory)
        // Never use get() on potentially large datasets.
        $shops = $query->with('region')->orderByDesc('created_at')->paginate(12)->withQueryString();

        // Get all regions for filter dropdown
        $regions = Region::pluck('name');

        // Prepare Shops Data for Frontend (AlpineJS)
        // Only return the *current page* data to Alpine.
        // This breaks "Client-Side Filtering" for all data, but enables scalability for 1000s of shops.
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

            return [
                'id' => $shop->id,
                'name' => $shop->name,
                'location' => optional($shop->region)->name ?? '',
                'category' => $shop->business_type,
                'desc' => \Illuminate\Support\Str::limit($shop->description, 100),
                'omset' => $formattedOmset,
                'image' => $shop->logo_url,
                'link' => route('umkm.comment', $shop->id)
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

    public function show($id)
    {
        $shop = Shop::with(['user', 'region', 'photos', 'products' => function($q) {
            $q->where('is_active', true);
        }])->where('is_verified', true)->findOrFail($id);

        if (!$shop->isComplete()) {
            abort(404);
        }
        
        $relatedShops = Shop::where('is_verified', true)
            ->where('id', '!=', $shop->id)
            ->where('business_type', $shop->business_type)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // View Increment Logic (Device ID Cookie + Cache)
        // Solusi Hemat Storage: Gunakan Cache Key (ShopID + DeviceID + Tanggal)
        // Data akan hilang otomatis besoknya, tapi count di table shops tetap bertambah permanen.
        
        $deviceId = request()->cookie('umkm_device_id');
        if (!$deviceId) {
            $deviceId = \Illuminate\Support\Str::uuid()->toString();
             \Illuminate\Support\Facades\Cookie::queue('umkm_device_id', $deviceId, 2628000); // 5 Tahun
        }

        $todayStr = now()->toDateString();
        $cacheKey = "shop_view_daily:{$shop->id}:{$deviceId}:{$todayStr}";

        if (!Cache::has($cacheKey)) {
            $shop->increment('views');
            // Cache valid sampai akhir hari ini saja (besok bisa view lagi)
            Cache::put($cacheKey, true, now()->endOfDay());
        }

        // Prepare Products Data for Frontend (AlpineJS)
        $productsData = $shop->products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'variant' => $product->variant,
                'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'image' => $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=300&q=80'
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
}
