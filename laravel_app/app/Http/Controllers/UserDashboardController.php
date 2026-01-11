<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shop = $user->shop;

        // Statistics
        $totalProducts = $shop->products()->count();
        $activeProducts = $shop->products()->where('is_active', true)->count();
        
        $productCategories = $shop->products()
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(5) // Limit to top 5 categories
            ->get();

        // Placeholder for views (needs database column)
        $totalViews = $shop->views; 

        // Chart Colors for Dashboard
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



    public function storeLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'region_id' => 'required|exists:regions,id', // Validasi region
        ]);

        $user = Auth::user();
        $shop = $user->shop;

        $shop->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address, // Update main address
            'region_id' => $request->region_id, // Simpan region_id
        ]);

        $this->checkVerificationStatus($shop);

        \App\Events\ShopUpdated::dispatch($shop->id);

        return redirect()->back()->with('success', 'Titik lokasi dan alamat berhasil disimpan.');
    }

    public function toko(Request $request)
    {
        $user = Auth::user();
        $shop = $user->shop;

        $query = $shop->products();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->has('status') && $request->status !== 'semua') {
            $isActive = $request->status === 'aktif';
            $query->where('is_active', $isActive);
        }

        // Pagination
        $products = $query->orderByDesc('created_at')->paginate(6);

        if ($request->ajax()) {
             return response()->json([
                 'html' => view('users.products.partials.product-list', compact('products'))->render(),
                 'hasMore' => $products->hasMorePages()
             ]);
        }

        return view('users.products.index', compact('shop', 'products'));
    }

    public function toggleProductStatus($id)
    {
        $user = Auth::user();
        $shop = $user->shop;
        $product = $shop->products()->findOrFail($id);

        $product->update([
            'is_active' => !$product->is_active
        ]);
        

        \App\Events\ProductUpdated::dispatch($user->id, 'update');
        \App\Events\ShopUpdated::dispatch($shop->id); // Updates public shop view

        return response()->json([
            'success' => true,
            'is_active' => (bool)$product->is_active,
            'message' => 'Status produk berhasil diperbarui.'
        ]);
    }

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

        // Fetch Dynamic Business Type Logos (Fallback for Shop Profile)
        $businessTypes = \App\Models\Content::where('group', 'business_types')->get();
        $logoContents = \App\Models\Content::where('group', 'business_type_logos')->get();
        
        $businessTypeLogos = [];
        foreach ($businessTypes as $bt) {
            $logoKey = 'logo_fallback_for_' . $bt->id;
            $logo = $logoContents->where('key', $logoKey)->first();
            if ($logo && $logo->value) {
                // Map lowercase type name to logo URL
                $businessTypeLogos[strtolower($bt->value)] = asset('storage/' . $logo->value);
            }
        }

        return view('users.shop-profile.index', compact('shop', 'regions', 'licenses', 'businessTypeLogos'));
    }

    public function updateToko(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_type' => 'required|string|max:255',
            'business_type' => ['required', 'string', \Illuminate\Validation\Rule::in(\App\Models\Shop::BUSINESS_TYPES)],
            'omset_min' => 'nullable|string',
            'omset_max' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'delete_logo' => 'nullable|boolean', 
        ]);

        $user = Auth::user();
        $shop = $user->shop;
        
        // Handle Logo Deletion
        $logoPath = $shop->logo;
        if ($request->boolean('delete_logo') && $shop->logo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($shop->logo);
            $logoPath = null;
        }
        
        if ($request->hasFile('logo')) {
            if ($shop->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($shop->logo);
            }
            // Resize to max 300px
            $logoPath = $this->resizeUpload($request->file('logo'), 'shops/logos', 300);
        }

        // Omset cleanup
        $omset_min = $request->omset_min ? preg_replace('/[^0-9]/', '', $request->omset_min) : null;
        $omset_max = $request->omset_max ? preg_replace('/[^0-9]/', '', $request->omset_max) : null;

        // Licenses JSON Construction
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

        $this->checkVerificationStatus($shop);

        \App\Events\ShopUpdated::dispatch($shop->id);

        // Dispatch Translation Job
        \App\Jobs\TranslateShopAttributes::dispatch($shop);

        return redirect()->back()->with('success', 'Informasi toko berhasil diperbarui.');
    }

    public function setting()
    {
        $user = Auth::user();
        $shop = $user->shop;
        return view('users.settings.index', compact('user', 'shop'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Security: Validate string length to prevent DoS (Memory Exhaustion)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['required', 'string', 'max:20'],
            'place_of_birth' => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],
            'domicile_address' => ['nullable', 'string', 'max:500'], // Limit address length
            'current_password' => ['required', 'current_password'], // Security: Confirm ownership
        ]);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'domicile_address' => $request->domicile_address,
        ]);

        // Security: Reset email verification if email changed
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }

    public function foto()
    {
        $user = Auth::user();
        $shop = $user->shop;
        $photos = $shop->photos()->orderBy('order')->get();
        $photoArray = array_fill(0, 5, ['id' => null, 'url' => null]);
        foreach($photos as $photo) {
            if(isset($photoArray[$photo->order])) {
                $photoArray[$photo->order] = [
                    'id' => $photo->id,
                    'url' => asset('storage/' . $photo->path)
                ];
            }
        }
        
        return view('users.shop-profile.manage-photos', compact('shop', 'photos', 'photoArray'));
    }

    public function storePhoto(Request $request)
    {
        $request->validate([
            'photos.*' => 'image|max:2048', // Validate each photo
            'delete_ids' => 'nullable|array',
            'delete_ids.*' => 'exists:shop_photos,id',
        ]);

        $user = Auth::user();
        $shop = $user->shop;

        try {
            DB::beginTransaction();

            // 1. Handle Deletions
            if ($request->has('delete_ids')) {
                foreach ($request->delete_ids as $id) {
                    $photo = $shop->photos()->find($id);
                    if ($photo) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
                        $photo->delete();
                    }
                }
            }

            // 2. Handle Uploads (Key is order)
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $order => $file) {
                    // Check existing at this order and delete it first (replace)
                    $existing = $shop->photos()->where('order', $order)->first();
                    if ($existing) {
                         \Illuminate\Support\Facades\Storage::disk('public')->delete($existing->path);
                         $existing->delete();
                    }

                    $path = $this->resizeUpload($file, 'sliders', 800);
                    $shop->photos()->create([
                        'path' => $path,
                        'order' => $order,
                    ]);
                }
            }

            $this->checkVerificationStatus($shop);

            \App\Events\ShopUpdated::dispatch($shop->id); // Trigger Real-time Update

            DB::commit();
            return redirect()->back()->with('success', 'Foto berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan: ' . $e->getMessage());
        }
    }

    public function deletePhoto($id)
    {
        $user = Auth::user();
        $shop = $user->shop;
        
        $photo = $shop->photos()->findOrFail($id);
        
        // Delete file from storage
        \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
        
        $photo->delete();
        
        $this->checkVerificationStatus($shop);
        
        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }

    public function storeProduct(Request $request)
    {
        // Sanitize price (remove non-numeric chars)
        if ($request->has('price')) {
            $request->merge([
                'price' => preg_replace('/[^0-9]/', '', $request->price)
            ]);
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('products')->where('shop_id', Auth::user()->shop->id)
            ],
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'variant' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($request->hasFile('image')) {
                // Resize to max 600px
                $imagePath = $this->resizeUpload($request->file('image'), 'shops/products', 600);
            }

            $user = Auth::user();
            $shop = $user->shop;

            $shop->products()->create([
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'image' => $imagePath,
                'variant' => $request->variant,
                'description' => $request->description,
            ]);

            \App\Events\ProductUpdated::dispatch($user->id, 'create');
            \App\Events\ShopUpdated::dispatch($shop->id);

            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())->withInput();
        }
    }

    public function updateProduct(Request $request, $id)
    {
        // Sanitize price
        if ($request->has('price')) {
            $request->merge([
                'price' => preg_replace('/[^0-9]/', '', $request->price)
            ]);
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('products')->where('shop_id', Auth::user()->shop->id)->ignore($id)
            ],
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'variant' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $shop = $user->shop;
        $product = $shop->products()->findOrFail($id);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'variant' => $request->variant,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            // Resize to max 600px
            $data['image'] = $this->resizeUpload($request->file('image'), 'shops/products', 600);
        }

        $product->update($data);

        \App\Events\ProductUpdated::dispatch($user->id, 'update');
        \App\Events\ShopUpdated::dispatch($shop->id);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduct($id)
    {
        $user = Auth::user();
        $shop = $user->shop;
        $product = $shop->products()->findOrFail($id);

        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        $product->delete();

        \App\Events\ProductUpdated::dispatch($user->id, 'delete');
        
        // Check verification after deletion (in case products count becomes 0)
        $this->checkVerificationStatus($shop);
        
        \App\Events\ShopUpdated::dispatch($shop->id);

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Resize uploaded image using native GD.
     * Preserves original format (JPG/PNG/WebP).
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param int $maxWidth
     * @return string
     */
    private function resizeUpload($file, $directory, $maxWidth)
    {
        // 1. Get original image info
        $imagePath = $file->getRealPath();
        $imageInfo = getimagesize($imagePath);
        
        if (!$imageInfo) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'image' => 'File gambar tidak valid.'
            ]);
        }

        list($origWidth, $origHeight, $type) = $imageInfo;

        // PREVENTION: Image Bomb / DoS Check
        // Limit Max Resolution (e.g., 3000x3000px) regardless of file size
        if ($origWidth > 3000 || $origHeight > 3000) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'image' => 'Resolusi gambar terlalu besar. Maksimal 3000x3000px.'
            ]);
        }

        // 2. Load image based on type
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_WEBP:
                $source = imagecreatefromwebp($imagePath);
                break;
            default:
                // SECURITY: STRICTLY UNSUPPORTED TYPES
                // Do NOT fallback to store(). This prevents SVG/HTML upload bypass.
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'image' => 'Format file tidak didukung. Gunakan JPG, PNG, atau WebP.'
                ]);
        }
        
        if (!$source) {
              throw \Illuminate\Validation\ValidationException::withMessages([
                    'image' => 'Gagal memproses gambar.'
              ]);
        }

        // 3. Calculate new dimensions
        if ($origWidth > $maxWidth) {
            $ratio = $maxWidth / $origWidth;
            $newWidth = $maxWidth;
            $newHeight = (int) ($origHeight * $ratio);
        } else {
            // No resize needed, but we can still re-save to compress
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        }

        // 4. Create new image resource
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // 5. Handle Transparency for PNG/WebP
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_WEBP) {
            imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }

        // 6. Resize
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // 7. Save to Buffer (Capture output)
        ob_start();
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, null, 80); // Quality 80
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage, null, 8); // Compression level 8 (0-9)
                break;
            case IMAGETYPE_WEBP:
                imagewebp($newImage, null, 80); // Quality 80
                break;
        }
        $imageData = ob_get_clean();

        // Cleanup resources
        imagedestroy($source);
        imagedestroy($newImage);

        // 8. Store using Laravel Storage
        $filename = $file->hashName();
        $path = $directory . '/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $imageData);

        return $path;
    }

    /**
     * Check if the shop is still complete. If not, revoke verification.
     */
    private function checkVerificationStatus($shop)
    {
        if ($shop->is_verified && !$shop->isComplete()) {
            $shop->is_verified = false;
            $shop->save();

            // Notify Admin and User
            \App\Events\ShopUpdated::dispatch($shop->id);
            \App\Events\UserUpdated::dispatch($shop->user_id, 'refresh');
        }
    }
}
