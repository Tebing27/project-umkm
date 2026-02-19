<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreLocationRequest;
use App\Http\Requests\User\UpdateShopRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\StoreShopPhotoRequest;
use App\Http\Requests\User\StoreProductRequest;
use App\Http\Requests\User\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserDashboardController extends Controller
{
    /**
     * @var \App\Services\ImageService
     */
    protected $imageService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\ImageService $imageService
     */
    public function __construct(\App\Services\ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $shop = $user->shop;

        // --- Section: Statistik Workshop ---
        $totalProducts = $shop->products()->count();
        $activeProducts = $shop->products()->where('is_active', true)->count();
        
        $productCategories = $shop->products()
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Menggunakan view count dari database (saat ini masih placeholder karena kolom belum ada)
        $totalViews = $shop->views; 

        // --- Section: Konfigurasi Tampilan ---
        $chartColors = ['bg-blue-500', 'bg-orange-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500'];

        if (request()->wantsJson()) {
            return response()->json([
                'totalProducts' => $totalProducts,
                'activeProducts' => $activeProducts,
                'totalViews' => $totalViews,
                'productCategories' => $productCategories,
                'shop' => $shop,
            ]);
        }

        return view('users.dashboard.index', compact('shop', 'totalProducts', 'activeProducts', 'productCategories', 'totalViews', 'chartColors'));
    }

    /**
     * Show the location settings page.
     *
     * @return \Illuminate\View\View
     */
    public function detailLokasi()
    {
        $user = Auth::user();
        $shop = $user->shop;
        $regions = \App\Models\Region::all();
        $initialId = old('region_id', $shop->region_id ?? '');
        $initialName = 'Pilih Wilayah';
        if ($initialId) {
            $found = $regions->where('id', $initialId)->first();
            if ($found) {
                $initialName = $found->name;
            }
        }

        return view('users.location.index', compact('shop', 'regions', 'initialId', 'initialName'));
    }



    /**
     * Update the shop's location and address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLokasi(StoreLocationRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $shop = $user->shop;

        $shop->update([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'address' => $validated['address'] ?? null,
            'region_id' => $validated['region_id'],
        ]);

        // Memeriksa ulang status verifikasi karena data lokasi wajib diisi untuk verified shop
        $shop->updateVerificationStatus();

        \App\Events\ShopUpdated::dispatch($shop->id);

        return redirect()->back()->with('success', 'Titik lokasi dan alamat berhasil disimpan.');
    }

    /**
     * Display the shop's product management page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function toko(Request $request)
    {
        $user = Auth::user();
        $shop = $user->shop;

        $query = $shop->products();

        // --- Section: Pencarian Produk ---
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // --- Section: Filter Status ---
        if ($request->has('status') && $request->status !== 'semua') {
            $isActive = $request->status === 'aktif';
            $query->where('is_active', $isActive);
        }

        // --- Section: Pagination ---
        $products = $query->with('images')->orderByDesc('created_at')->paginate(6);

        if ($request->ajax()) {
             return response()->json([
                 'html' => view('users.products.partials.product-list', compact('products'))->render(),
                 'hasMore' => $products->hasMorePages()
             ]);
        }

        return view('users.products.index', compact('shop', 'products'));
    }

    /**
     * Toggle the active status of a product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleProductStatus($id)
    {
        $user = Auth::user();
        $shop = $user->shop;
        $product = $shop->products()->findOrFail($id);

        $product->update([
            'is_active' => !$product->is_active
        ]);
        
        // --- Section: Realtime Broadcast ---
        // Menyiapkan data snapshot untuk UI frontend agar update in-place tanpa refresh
        $productData = [
            'is_active' => $product->is_active,
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'variant' => $product->variant,
            'image' => $product->image ? storage_url($product->image) : null,
        ];

        \App\Events\ProductUpdated::dispatch($user->id, 'update', $product->id, $productData);
        \App\Events\ShopUpdated::dispatch($shop->id); // Update tampilan toko publik

        return response()->json([
            'success' => true,
            'is_active' => (bool)$product->is_active,
            'message' => 'Status produk berhasil diperbarui.'
        ]);
    }

    /**
     * Toggle the best seller status of a product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleBestSeller($id)
    {
        $user = Auth::user();
        $shop = $user->shop;
        $product = $shop->products()->findOrFail($id);

        $product->update([
            'is_best_seller' => !$product->is_best_seller
        ]);

        // Status best seller mungkin mempengaruhi urutan/tampilan, jadi perlu broadcast data baru
        $productData = [
            'is_best_seller' => $product->is_best_seller
        ];

        \App\Events\ProductUpdated::dispatch($user->id, 'update', $product->id, $productData);
        \App\Events\ShopUpdated::dispatch($shop->id);

        return response()->json([
            'success' => true,
            'is_best_seller' => (bool)$product->is_best_seller,
            'message' => 'Status produk terlaris berhasil diperbarui.'
        ]);
    }

    /**
     * Show the shop profile edit form.
     *
     * @return \Illuminate\View\View
     */
    public function editToko()
    {
        $user = Auth::user();
        $shop = $user->shop;
        $regions = \App\Models\Region::all();
        $licenses = [];
        if ($shop && $shop->licenses) {
            $licenses = is_string($shop->licenses) ? json_decode($shop->licenses, true) : $shop->licenses;
        }
        if (empty($licenses)) {
            $licenses = [['type' => '', 'number' => '']];
        }

        // --- Section: Dynamic Logos ---
        // Mengambil logo dynamic berdasarkan tipe bisnis untuk fallback jika user belum upload logo
        $businessTypes = \App\Models\Content::where('group', 'business_types')->get();
        $logoContents = \App\Models\Content::where('group', 'business_type_logos')->get();
        
        $businessTypeLogos = [];
        foreach ($businessTypes as $bt) {
            $logoKey = 'logo_fallback_for_' . $bt->id;
            $logo = $logoContents->where('key', $logoKey)->first();
            if ($logo && $logo->value) {
                $businessTypeLogos[strtolower($bt->value)] = storage_url($logo->value);
            }
        }

        // Fetch All Business Types for dropdown
        $allBusinessTypes = \App\Models\Shop::getBusinessTypes();

        return view('users.shop-profile.index', compact('shop', 'regions', 'licenses', 'businessTypeLogos', 'allBusinessTypes'));
    }

    /**
     * Update shop profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateToko(UpdateShopRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $shop = $user->shop;
        
        // --- Section: Handle Logo ---
        $logoPath = $shop->logo;
        // User requesting to delete existing logo
        if ($request->boolean('delete_logo') && $shop->logo) {
            $this->imageService->delete($shop->logo);
            $logoPath = null;
        }
        
        // User uploading new logo
        if ($request->hasFile('logo')) {
            if ($shop->logo) {
                // Hapus logo lama sebelum replace
                $this->imageService->delete($shop->logo);
            }
            // Resize ke 300px untuk optimasi
            $logoPath = $this->imageService->resizeAndSave($request->file('logo'), 'shops/logos', 300);
        }

        // --- Section: Sanitasi Omset ---
        $omset_min = $request->omset_min ? preg_replace('/[^0-9]/', '', $request->omset_min) : null;
        $omset_max = $request->omset_max ? preg_replace('/[^0-9]/', '', $request->omset_max) : null;

        // --- Section: Konstruksi JSON Licenses ---
        $licenses = [];
        if($request->license_type && $request->license_number) {
            foreach($request->license_type as $key => $type) {
                if($type && isset($request->license_number[$key])) {
                    $licenses[] = ['type' => $type, 'number' => $request->license_number[$key]];
                }
            }
        }

        $shop->update([
            'name' => $request->shop_name,
            'description' => $request->description,
            'product_type' => $request->product_type,
            'business_type' => $request->business_type,
            'omset_min' => $omset_min,
            'omset_max' => $omset_max,
            'licenses' => !empty($licenses) ? json_encode($licenses) : null,
            'social_instagram' => $request->social_instagram,
            'social_facebook' => $request->social_facebook,
            'social_tiktok' => $request->social_tiktok,
            'social_website' => $request->social_website,
            'logo' => $logoPath,
        ]);

        // --- Section: Update & Event Dispatch ---
        $shop->updateVerificationStatus();

        \App\Events\ShopUpdated::dispatch($shop->id);

        // Menjalankan job translasi di background untuk mendukung multi-bahasa
        \App\Jobs\TranslateShopAttributes::dispatch($shop);

        return redirect()->back()->with('success', 'Informasi toko berhasil diperbarui.');
    }

    /**
     * Show settings page.
     *
     * @return \Illuminate\View\View
     */
    public function setting()
    {
        $user = Auth::user();
        $shop = $user->shop;
        return view('users.settings.index', compact('user', 'shop'));
    }

    /**
     * Update user profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'place_of_birth' => $validated['place_of_birth'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'domicile_address' => $validated['domicile_address'] ?? null,
        ]);

        // --- Section: Reset Verifikasi ---
        // Jika email berubah, reset status verifikasi email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        \App\Events\UserUpdated::dispatch($user->id, 'profile_update');
        
        if ($user->shop) {
             \App\Events\ShopUpdated::dispatch($user->shop->id);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui. Jika email berubah, silakan verifikasi ulang.');
    }

    /**
     * Update user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Show photo management page.
     *
     * @return \Illuminate\View\View
     */
    public function foto()
    {
        $user = Auth::user();
        $shop = $user->shop;
        $photos = $shop->photos()->orderBy('order')->get();
        // Placeholder array for 5 slots
        $photoArray = array_fill(0, 5, ['id' => null, 'url' => null]);
        foreach($photos as $photo) {
            if(isset($photoArray[$photo->order])) {
                $photoArray[$photo->order] = [
                    'id' => $photo->id,
                    'url' => storage_url($photo->path, 800)
                ];
            }
        }
        
        return view('users.shop-profile.manage-photos', compact('shop', 'photos', 'photoArray'));
    }

    /**
     * Update shop photos (add, replace, delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePhoto(StoreShopPhotoRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $shop = $user->shop;

        try {
            DB::beginTransaction();

            // --- Section: Hapus Foto ---
            if ($request->has('delete_ids')) {
                foreach ($request->delete_ids as $id) {
                    $photo = $shop->photos()->find($id);
                    if ($photo) {
                        $this->imageService->delete($photo->path);
                        $photo->delete();
                    }
                }
            }

            // --- Section: Upload/Replace Foto ---
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $order => $file) {
                    // Cek jika ada foto eksisting di slot ini, hapus dulu (replace)
                    $existing = $shop->photos()->where('order', $order)->first();
                    if ($existing) {
                         $this->imageService->delete($existing->path);
                         $existing->delete();
                    }

                    // Upload Cloudinary max 800px
                    $path = $this->imageService->uploadToCloudinary($file, 'shops/photos', 800);
                    $shop->photos()->create([
                        'path' => $path,
                        'order' => $order,
                    ]);
                }
            }

            $shop->updateVerificationStatus();

            \App\Events\ShopUpdated::dispatch($shop->id);

            DB::commit();
            return redirect()->back()->with('success', 'Foto berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Photo update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan. Silakan coba lagi.');
        }
    }

    /**
     * Delete a specific photo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePhoto($id)
    {
        $user = Auth::user();
        $shop = $user->shop;
        
        $photo = $shop->photos()->findOrFail($id);
        
        // Hapus file fisik dari storage
        $this->imageService->delete($photo->path);
        
        $photo->delete();
        
        $shop->updateVerificationStatus();

        \App\Events\ShopUpdated::dispatch($shop->id);
        
        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }

    /**
     * Store a new product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProduct(StoreProductRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $shop = $user->shop;
            
            // --- Section: Create Product ---
            $product = $shop->products()->create([
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'variant' => $request->variant,
                'description' => $request->description,
                'image' => null, // Akan diupdate setelah upload gambar
            ]);

            $mainImagePath = null;

            // --- Section: Handle Upload Gambar (Slot 0-4) ---
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    if ($index >= 5) break; 

                    // Upload Cloudinary max 600px untuk produk
                    $path = $this->imageService->uploadToCloudinary($file, 'shops/products', 600);
                    
                    $product->images()->create([
                        'image' => $path,
                        'sort_order' => $index
                    ]);

                    // Set Main Image (Slot 0 atau yang pertama tersedia)
                    if ($index == 0 || $mainImagePath === null) {
                        $mainImagePath = $path;
                    }
                }
            }

            // Sync main image (kolom lama) untuk backward compatibility
            if ($mainImagePath) {
                $product->update(['image' => $mainImagePath]);
            }

            // --- Section: Realtime Broadcast ---
             $productData = [
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'variant' => $product->variant,
                'category' => $product->category,
                'image' => $mainImagePath ? storage_url($mainImagePath) : null,
                'is_active' => $product->is_active
            ];

            \App\Events\ProductUpdated::dispatch($user->id, 'create', $product->id, $productData);
            \App\Events\ShopUpdated::dispatch($shop->id);

            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan produk. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Update an existing product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(UpdateProductRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $shop = $user->shop;
            $product = $shop->products()->with('images')->findOrFail($id);

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'variant' => $request->variant,
                'description' => $request->description,
            ]);

            // --- Section: Handle Penghapusan Gambar ---
            if ($request->has('delete_image_indices')) {
                foreach ($request->delete_image_indices as $index) {
                    $existing = $product->images()->where('sort_order', $index)->first();
                    if ($existing) {
                        $this->imageService->delete($existing->image);
                        $existing->delete();
                    }
                }
            }

            // --- Section: Handle Upload/Replace Gambar ---
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                     // Replace existing at this slot
                    $existing = $product->images()->where('sort_order', $index)->first();
                    if ($existing) {
                        $this->imageService->delete($existing->image);
                        $existing->delete();
                    }

                    // Cloudinary max 600px
                    $path = $this->imageService->uploadToCloudinary($file, 'shops/products', 600);
                    $product->images()->create([
                        'image' => $path,
                        'sort_order' => $index
                    ]);
                }
            }
            
            // Sync Slot 0 ke Main Image
            $slot0 = $product->images()->where('sort_order', 0)->first();
            $product->update(['image' => $slot0 ? $slot0->image : null]);

            $productData = [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category,
                'variant' => $product->variant,
                'description' => $product->description,
                'image' => $product->image ? storage_url($product->image) : null,
                'is_active' => $product->is_active
            ];

            \App\Events\ProductUpdated::dispatch($user->id, 'update', $product->id, $productData);
            \App\Events\ShopUpdated::dispatch($shop->id);

            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui produk.');
        }
    }

    /**
     * Delete a product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct($id)
    {
        $user = Auth::user();
        $shop = $user->shop;
        $product = $shop->products()->with('images')->findOrFail($id);

        // Hapus main image jika ada
        if ($product->image) {
            $this->imageService->delete($product->image);
        }

        // Hapus semua gambar varian terkait
        foreach ($product->images as $img) {
             $this->imageService->delete($img->image);
        }

        $product->delete();

        \App\Events\ProductUpdated::dispatch($user->id, 'delete', $id, []);
        
        // Cek ulang status verifikasi setelah penghapusan (misal produk jadi 0)
        $shop->updateVerificationStatus();
        
        \App\Events\ShopUpdated::dispatch($shop->id);

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    // --- Section: Removed Dead Code ---
    // (Removed unused comments/methods)
}
