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

        // Search by name or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
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

        $shops = $query->with('region')->orderByDesc('created_at')->get();

        // Get all regions for filter dropdown
        $regions = Region::pluck('name');

        // Prepare Shops Data for Frontend (AlpineJS)
        $shopsData = $shops->map(function($shop) {
            return [
                'id' => $shop->id,
                'name' => $shop->name,
                'location' => optional($shop->region)->name ?? '',
                'category' => $shop->business_type,
                'desc' => \Illuminate\Support\Str::limit($shop->description, 100),
                'image' => $shop->logo_url,
                'link' => route('umkm.comment', $shop->id)
            ];
        });

        // Fetch Admin Content for this page
        $contents = Content::where('group', 'umkm_index')->get()->keyBy('key');

        $businessTypes = Shop::BUSINESS_TYPES;

        if ($request->wantsJson()) {
             return response()->json($shopsData);
        }

        return view('umkm.index', compact('shops', 'regions', 'shopsData', 'contents', 'businessTypes'));
    }

    public function show($id)
    {
        $shop = Shop::with(['region', 'photos', 'products' => function($q) {
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

        // View Increment Logic (Cache based: IP + ShopID)
        $ip = request()->ip();
        $cacheKey = 'shop_view_' . $shop->id . '_' . $ip;
        
        if (!Cache::has($cacheKey)) {
            $shop->increment('views');
            Cache::put($cacheKey, true, 60 * 60);
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

        return view('umkm.detail.index', compact('shop', 'relatedShops', 'productsData', 'productCategories', 'licenses', 'formattedOmset'));
    }
}
