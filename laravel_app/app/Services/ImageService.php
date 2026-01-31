<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Validation\ValidationException;

class ImageService
{
    /**
     * Resize and save an image.
     *
     * @param UploadedFile $file
     * @param string $directory Directory relative to 'public' disk
     * @param int $maxWidth
     * @param int $maxResolution Max resolution (width or height) to prevent Image Bombs
     * @return string The stored file path relative to 'public' disk
     * @throws ValidationException
     */

    /**
     * Resize and save an image (Local Storage).
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $maxWidth
     * @param int $maxResolution
     * @return string
     * @throws ValidationException
     */
    public function resizeAndSave(UploadedFile $file, string $directory, int $maxWidth = 800, int $maxResolution = 4000): string
    {
        return $this->resizeAndSaveLocal($file, $directory, $maxWidth, $maxResolution);
    }

    private function resizeAndSaveLocal(UploadedFile $file, string $directory, int $maxWidth, int $maxResolution): string
    {
        // ... (Keep existing GD Logic wrapper for Logo/Legacy) ...
        // For simplicity reusing existing logic but wrapped to separate concerns if we wanted.
        // But to minimize diff, let's keep the logic inline or just refer to the original implementation.
        // I will re-implement the existing logic here for clarity since I am strictly replacing.
        
        // 1. Get original image info
        $imagePath = $file->getRealPath();
        $imageInfo = @getimagesize($imagePath);

        if (!$imageInfo) {
            throw ValidationException::withMessages(['image' => 'File gambar tidak valid atau rusak.']);
        }

        list($origWidth, $origHeight, $type) = $imageInfo;

        if ($origWidth > $maxResolution || $origHeight > $maxResolution) {
             throw ValidationException::withMessages(['image' => "Resolusi gambar terlalu besar. Maksimal {$maxResolution}x{$maxResolution}px."]);
        }

        if (!extension_loaded('gd')) {
            return $this->storeOriginal($file, $directory);
        }

        $source = null;
        switch ($type) {
            case IMAGETYPE_JPEG: 
                if (!function_exists('imagecreatefromjpeg')) return $this->storeOriginal($file, $directory);
                $source = \imagecreatefromjpeg($imagePath); 
                break;
            case IMAGETYPE_PNG: 
                if (!function_exists('imagecreatefrompng')) return $this->storeOriginal($file, $directory);
                $source = \imagecreatefrompng($imagePath); 
                break;
            case IMAGETYPE_WEBP: 
                if (!function_exists('imagecreatefromwebp')) return $this->storeOriginal($file, $directory);
                $source = \imagecreatefromwebp($imagePath); 
                break;
            default:
                return $this->storeOriginal($file, $directory);
        }

        if (!$source) {
             throw ValidationException::withMessages(['image' => 'Gagal memproses gambar.']);
        }

        if ($origWidth > $maxWidth) {
            $ratio = $maxWidth / $origWidth;
            $newWidth = $maxWidth;
            $newHeight = (int) ($origHeight * $ratio);
        } else {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        }

        $newImage = \imagecreatetruecolor($newWidth, $newHeight);

        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_WEBP) {
            \imagecolortransparent($newImage, \imagecolorallocatealpha($newImage, 0, 0, 0, 127));
            \imagealphablending($newImage, false);
            \imagesavealpha($newImage, true);
        } else {
            // For JPEG, we still want to support alpha if we convert to WebP, 
            // though source didn't have it. Good to be safe for uniform handling.
            \imagealphablending($newImage, false);
            \imagesavealpha($newImage, true);
        }

        \imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        ob_start();
        // Always convert to WebP
        // Quality 90 is very high (almost lossless perception) but much smaller file size.
        \imagewebp($newImage, null, 90); 
        $imageData = ob_get_clean();

        \imagedestroy($source);
        \imagedestroy($newImage);

        // Ubah ekstensi file jadi .webp
        $filename = pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';
        $path = $directory . '/' . $filename;
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }

    /**
     * Upload to Cloudinary with resizing.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param int $maxWidth
     * @return string Secure URL
     */
    public function uploadToCloudinary(UploadedFile $file, string $folder, int $maxWidth = 800): string
    {
        try {
            $response = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::uploadApi()->upload($file->getRealPath(), [
                'folder' => $folder,
                'transformation' => [
                    'width' => $maxWidth,
                    'crop' => 'limit'
                    // removed quality and fetch_format to control order manually
                ]
            ]);
            
            // Optimization for CDN Economics: "One image -> one fixed URL"
            // We inject f_auto,q_auto at the START of transformations to ensure consistent order:
            // /upload/f_auto,q_auto/v... or /upload/f_auto,q_auto,w_800,c_limit/v...
            // Note: If the SDK returns params in the URL (like w_800), they usually appear after /upload/.
            // We want strict prefixing: /upload/f_auto,q_auto,...
            
            $url = $response['secure_url'];
            
            // If URL has transformations (e.g. /upload/w_800...), insert f_auto,q_auto before them
            if (strpos($url, '/upload/w_') !== false) {
                 $optimizedUrl = str_replace('/upload/', '/upload/f_auto,q_auto,', $url);
            } else {
                 // No validations params yet, just standard inject
                 $optimizedUrl = str_replace('/upload/', '/upload/f_auto,q_auto/', $url);
            }
            
            return $optimizedUrl;
        } catch (\Exception $e) {
             \Illuminate\Support\Facades\Log::error('Cloudinary Upload Failed: ' . $e->getMessage());
            throw ValidationException::withMessages([
                'image' => 'Gagal mengupload gambar ke Cloudinary: ' . $e->getMessage()
            ]);
        }
    }



    /**
     * Delete file (Local or Cloudinary).
     *
     * @param string|null $path
     */
    public function delete(?string $path): void
    {
        if (!$path) return;

        if (Str::startsWith($path, ['http://', 'https://'])) {
            $this->deleteFromCloudinary($path);
        } else {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * Delete from Cloudinary using Public ID extraction.
     *
     * @param string $url
     */
    public function deleteFromCloudinary(string $url): void
    {
        try {
            // Extract public ID from URL
            // URL Structure: https://res.cloudinary.com/demo/image/upload/v1234567890/folder/filename.jpg
            // We need 'folder/filename' (without extension)
            
            $path = parse_url($url, PHP_URL_PATH);
            $segments = explode('/', $path);
            
            // Look for 'upload' segment and take everything after 'v<version>'
            // Or simpler regex approach to get public_id with folder
            
            // Improved Regex to match /upload/, optional transformations (non-greedy), optional version, and capture filename
            if (preg_match('/\/upload\/(?:.*\/)?(?:v\d+\/)?(.+)\.[^.]+$/', $path, $matches)) {
                $publicId = $matches[1];
                \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::uploadApi()->destroy($publicId);
            }
        } catch (\Exception $e) {
            // Log error but don't block
             \Illuminate\Support\Facades\Log::error('Failed to delete from Cloudinary: ' . $e->getMessage());
        }
    }

    /**
     * Store original file without resizing.
     */
    private function storeOriginal(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    /**
     * Sanitize and save SVG file.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string
     * @throws \Exception
     */
    public function saveSvg(UploadedFile $file, string $directory): string
    {
        if (!class_exists('enshrined\svgSanitize\Sanitizer')) {
             throw new \Exception('SVG Sanitizer library not found.');
        }

        $sanitizer = new Sanitizer();
        $fileContent = file_get_contents($file->getRealPath());
        $cleanSvg = $sanitizer->sanitize($fileContent);
        
        $filename = Str::random(40) . '.svg';
        $path = $directory . '/' . $filename;
        
        Storage::disk('public')->put($path, $cleanSvg);

        return $path;
    }
}
