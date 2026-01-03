<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RegionController extends Controller
{
    public function updateImage(Request $request, $id)
    {
        $region = Region::findOrFail($id);

        $request->validate([
            'image' => 'required|image|max:2048', // 2MB Max
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($region->image && Storage::disk('public')->exists($region->image)) {
                Storage::disk('public')->delete($region->image);
            }

            $file = $request->file('image');
            $filename = 'regions/' . Str::random(20) . '.jpg';
            
            // Re-using the resize logic logic (or duplicating it if not easily shareable without a Trait/Service)
            // For now, I'll implement a simple resize here or use the same logic as ContentController.
            // Since I don't want to duplicate too much, I'll just store it directly or create a Trait later.
            // But wait, the user likes optimization. I should validly resize it.
            // Let's implement the resize logic here as well for now.
            
            $this->resizeAndSaveImage($file, $filename, 800); // 800px max width for region cards
            
            $region->image = $filename;
            $region->save();
        }

        return redirect()->route('admin.contents.index', ['tab' => 'home_wilayah'])->with('success', translate('Gambar wilayah berhasil diperbarui.'));
    }

    public function updateFeaturedShop(Request $request, $id)
    {
        $region = Region::findOrFail($id);
        
        $request->validate([
            'shop_id' => 'nullable|exists:shops,id',
            'hero_order' => 'nullable|integer|min:0',
        ]);

        // Check for duplicate order if order > 0
        if ($request->hero_order > 0) {
            $existing = Region::where('hero_order', $request->hero_order)
                ->where('id', '!=', $id)
                ->first();
                
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => translate('Urutan nomor ' . $request->hero_order . ' sudah digunakan oleh region ' . $existing->name)
                ], 422);
            }
        }

        $region->featured_shop_id = $request->shop_id;
        $region->hero_order = $request->hero_order;
        $region->save();

        return response()->json([
            'success' => true,
            'message' => translate('Konfigurasi region slider berhasil diperbarui.'),
        ]);
    }

    private function resizeAndSaveImage($file, $path, $maxWidth)
    {
        // Check if GD extension is loaded
        if (!extension_loaded('gd')) {
            // Fallback: Just store the file directly
            $directory = dirname($path);
            $filename = basename($path);
            $file->storeAs($directory, $filename, 'public');
            return;
        }

        try {
            list($width, $height, $type) = \getimagesize($file->getRealPath());
            
            $newWidth = $width;
            $newHeight = $height;

            // Calculate new dimensions if width exceeds max
            if ($width > $maxWidth) {
                $ratio = $maxWidth / $width;
                $newWidth = $maxWidth;
                $newHeight = $height * $ratio;
            }

            // Create new image resource
            $src = null;
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $src = \imagecreatefromjpeg($file->getRealPath());
                    break;
                case IMAGETYPE_PNG:
                    $src = \imagecreatefrompng($file->getRealPath());
                    break;
                case IMAGETYPE_WEBP:
                    $src = \imagecreatefromwebp($file->getRealPath());
                    break;
            }

            if ($src) {
                $dst = \imagecreatetruecolor($newWidth, $newHeight);
                
                // Handle transparency for PNG/WebP
                if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_WEBP) {
                    \imagecolortransparent($dst, \imagecolorallocatealpha($dst, 0, 0, 0, 127));
                    \imagealphablending($dst, false);
                    \imagesavealpha($dst, true);
                }

                \imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                
                // Ensure directory exists
                $fullPath = storage_path('app/public/' . $path);
                $directory = dirname($fullPath);
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Save as JPEG with 85% quality for consistency & size
                \imagejpeg($dst, $fullPath, 85);
                
                \imagedestroy($src);
                \imagedestroy($dst);
            } else {
                // Fallback
                $directory = dirname($path);
                $filename = basename($path);
                $file->storeAs($directory, $filename, 'public');
            }
        } catch (\Throwable $e) {
            // Final fallback if anything inside GD fails
            \Log::warning('Image resize failed: ' . $e->getMessage());
            $directory = dirname($path);
            $filename = basename($path);
            $file->storeAs($directory, $filename, 'public');
        }
    }
    public function deleteImage($id)
    {
        $region = Region::findOrFail($id);

        if ($region->image) {
            if (Storage::disk('public')->exists($region->image)) {
                Storage::disk('public')->delete($region->image);
            }
            $region->image = null;
            $region->save();
        }

        return redirect()->route('admin.contents.index', ['tab' => 'home_wilayah'])->with('success', translate('Gambar wilayah berhasil dihapus.'));
    }
}
