<?php

use App\Services\TranslationService;

if (!function_exists('translate')) {
    /**
     * Translate text using the TranslationService.
     *
     * @param string $text
     * @param string $targetLang
     * @return string
     */

    function translate(string $text, string $targetLang = null): string
    {
        if (is_null($targetLang)) {
            $targetLang = app()->getLocale();
        }
        
        // Return original if target is same as source (assumed 'id')
        if ($targetLang === 'id') {
            return $text;
        }

        return app(TranslationService::class)->translate($text, $targetLang);
    }
}

if (!function_exists('storage_url')) {
    /**
     * Get the full URL for a storage path (local or cloud).
     *
     * @param string|null $path
     * @param int|null $width Optional width for Cloudinary transformations
     * @return string
     */
    function storage_url(?string $path, int $width = null): string
    {
        if (!$path) {
            return asset('storage/default-placeholder.jpg');
        }
        
        // Normalize slashes
        $path = str_replace('\\', '/', $path);

        // If path is already a URL
        if (filter_var($path, FILTER_VALIDATE_URL) || \Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            
            // Cloudinary Resizing Logic
            if ($width && str_contains($path, 'res.cloudinary.com')) {
                if (str_contains($path, '/upload/')) {
                    // Match /upload/ followed optionally by (params/) and/or (v123/)
                    // Capture group 1: params (if present)
                    // Capture group 2: version (if present)
                    if (preg_match('/\/upload\/(?:([^\/]+)\/)?(?:v\d+\/)?/', $path, $matches)) {
                        $params = $matches[1] ?? '';
                        
                        // Check if captured 'params' are actually params (must have underscore or comma)
                        // If no underscore/comma, it might be the filename if no version exists, so treat as empty.
                        if (!empty($params) && !str_contains($params, '_') && !str_contains($params, ',')) {
                            $params = '';
                        }

                        if (!empty($params)) {
                            // Handle comma-separated params
                            if (str_contains($params, 'w_')) {
                                $newParams = preg_replace('/w_\d+/', 'w_' . $width, $params);
                            } else {
                                $newParams = $params . ',w_' . $width . ',c_limit';
                            }
                            // Replace the old params segment
                            return str_replace('/upload/' . $params . '/', '/upload/' . $newParams . '/', $path);
                        } else {
                             // No params found, inject after /upload/
                            return str_replace('/upload/', '/upload/w_' . $width . ',c_limit/', $path);
                        }
                    }
                }
            }
            
            return $path;
        }

        // Otherwise assume local storage
        return asset('storage/' . $path);
    }
}

if (!function_exists('cloudinary_srcset')) {
    /**
     * Generate srcset for Cloudinary URL.
     * Assumes URL already has f_auto,q_auto injected by ImageService.
     *
     * @param string|null $url
     * @param array $widths
     * @return string
     */
    function cloudinary_srcset(?string $url, array $widths = [320, 640, 800]): string
    {
        if (!$url || !str_contains($url, 'res.cloudinary.com')) {
            return '';
        }

        $srcSet = [];
        
        foreach ($widths as $w) {
            $newUrl = $url;
            
            // Regex Analysis:
            // 1. Match /upload/
            // 2. Capture optional existing transformation group (anything not containing / that has known cloudinary param keys OR is followed by /v\d+)
            // 3. Match /v\d+ OR end of string/filename start
            
            // Strategy: Attempt to find the segment between /upload/ and /v...
            if (preg_match('/(\/upload\/)(?:([^\/]+)\/)?(v\d+\/)?/', $url, $matches)) {
                $prefix = $matches[1]; // /upload/
                $transforms = $matches[2] ?? ''; // Existing params or empty
                $version = $matches[3] ?? ''; // v123/ or empty
                
                // If the "transforms" capture looks like a filename (no keys, ends in dot ext), treat as empty transforms
                // Cloudinary params usually have _, so if no _, likely just filename in a flat URL (though upload URLs usually have structure)
                // But let's assume if it doesn't have typical params, we treat it as empty or we append.
                
                $hasParams = !empty($transforms) && (str_contains($transforms, '_') || str_contains($transforms, ','));
                
                // If what we captured as transforms is actually part of the path (no params, no version), fallback
                // E.g. /upload/sample.jpg -> matches[2] is sample.jpg. We don't want to replace "sample.jpg" with "w_320"!
                
                if (!empty($transforms) && !$hasParams && empty($version)) {
                    // Likely just filename directly after upload
                    $transforms = ''; 
                    // Reset matches index to reconstructed URL doesn't lose filename
                    // Actually, str_replace approach below is safer if we just identify the insertion point.
                }

                if ($hasParams) {
                    // Update existing params
                    if (preg_match('/w_\d+/', $transforms)) {
                         $newTransforms = preg_replace('/w_\d+/', 'w_' . $w, $transforms);
                    } else {
                         $newTransforms = $transforms . ',w_' . $w;
                    }
                    
                    // Add c_limit if missing
                    if (!str_contains($newTransforms, 'c_limit') && !str_contains($newTransforms, 'c_fit') && !str_contains($newTransforms, 'c_fill')) {
                         $newTransforms .= ',c_limit';
                    }
                    
                    // Reassemble: Replace the /upload/transforms/ part
                    $newUrl = str_replace($prefix . $transforms . '/', $prefix . $newTransforms . '/', $url);
                    
                } else {
                    // No existing params found (or it was filename), inject new params
                    $newTransforms = "f_auto,q_auto,w_{$w},c_limit";
                    $newUrl = str_replace($prefix, $prefix . $newTransforms . '/', $url);
                }
            } 
            
            $srcSet[] = "{$newUrl} {$w}w";
        }
        
        return implode(', ', $srcSet);
    }
}

if (!function_exists('cms_content')) {
    /**
     * Get content from CMS (Content model) by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function cms_content(string $key, $default = null)
    {
        return \App\Models\Content::get($key, $default);
    }
}
