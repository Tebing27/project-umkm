<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Region;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use enshrined\svgSanitize\Sanitizer;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        // Ensure default structure exists for specific sections if they don't exist
        $this->ensureDefaultContents();
        
        $group = $request->query('tab', 'home_hero');
        
        // Organize contents by group for easier access in the view
        $contents = Content::where('group', $group)->get()->groupBy('group');
        
        // Data khusus untuk tab tertentu
        $regions = collect([]);
        if ($group === 'home_wilayah' || $group === 'home_hero') {
            $regions = Region::with(['shops' => function($query) {
                $query->where('is_verified', true)->select('id', 'name', 'region_id');
            }])->get();

            // Pre-calculate selected shop name for the view to avoid inline PHP
            $regions->each(function($region) {
                $selectedName = translate('Acak / Tidak Ada');
                if ($region->featured_shop_id) {
                    // Since we eager loaded verified shops, check if the featured one is in that list
                    $found = $region->shops->firstWhere('id', $region->featured_shop_id);
                    if ($found) {
                        $selectedName = $found->name;
                    }
                }
                $region->selected_shop_name = $selectedName;
            });
        }

        $tabs = [
            'home_hero' => ['label' => 'Hero Section', 'icon' => 'home'],
            'home_wilayah' => ['label' => 'Wilayah', 'icon' => 'map'],
            'umkm_index' => ['label' => 'Halaman UMKM', 'icon' => 'shopping-bag'],
            'business_types' => ['label' => 'Jenis Usaha', 'icon' => 'tag'],
            'logo' => ['label' => 'Logo', 'icon' => 'star'],
        ];

        // Prepare data for Business Types
        $businessTypes = $contents->get('business_types') ?? collect([]);
        // Fetch icons for business types
        $businessTypeIcons = Content::where('group', 'business_type_icons')->get()->keyBy('key');
        // Fetch logos for business types
        $businessTypeLogos = Content::where('group', 'business_type_logos')->get()->keyBy('key');
        
        // Attach icon, logo and fallback values to businessType object (for view)
        foreach ($businessTypes as $bt) {
            $iconKey = 'icon_for_' . $bt->id;
            $bt->icon_url = isset($businessTypeIcons[$iconKey]) ? $businessTypeIcons[$iconKey]->value : null;

            $logoKey = 'logo_fallback_for_' . $bt->id;
            $bt->logo_url = isset($businessTypeLogos[$logoKey]) ? $businessTypeLogos[$logoKey]->value : null;
            
            // Pre-compute fallback values for view (Zero PHP Blade)
            $bt->fallback_marker_icon = $this->getFallbackMarkerIcon($bt->value);
            $bt->fallback_logo = $this->getFallbackLogo($bt->value);
        }

        // Prepare data for Logo
        $logoData = $contents->get('logo') ?? collect([]);
        $logoType = $logoData->where('key', 'logo_type')->first();
        $logoText = $logoData->where('key', 'logo_text')->first();
        $logoImage = $logoData->where('key', 'logo_image')->first();
        $logoShowImage = $logoData->where('key', 'logo_show_image')->first();
        $logoShowText = $logoData->where('key', 'logo_show_text')->first();
        
        return view('admin.content.index', compact('contents', 'regions', 'tabs', 'businessTypes', 'logoType', 'logoText', 'logoImage', 'logoShowImage', 'logoShowText'));
    }

    private function ensureDefaultContents()
    {
        // Business Types Defaults
        $types = ['Kuliner', 'Pakaian & Aksesoris', 'Kelontong', 'Agribisnis', 'Jasa', 'Kerajinan Tangan'];
        foreach ($types as $type) {
            Content::firstOrCreate(
                ['group' => 'business_types', 'value' => $type],
                ['type' => 'text', 'label' => 'Jenis Usaha', 'key' => 'business_type_' . Str::random(10)]
            );
        }

        // Logo Defaults
        Content::firstOrCreate(['key' => 'logo_type'], ['group' => 'logo', 'value' => 'text', 'type' => 'text', 'label' => 'Tipe Logo']);
        Content::firstOrCreate(['key' => 'logo_text'], ['group' => 'logo', 'value' => 'Sasuma UMKM', 'type' => 'text', 'label' => 'Teks Logo']);
        Content::firstOrCreate(['key' => 'logo_image'], ['group' => 'logo', 'value' => '', 'type' => 'image', 'label' => 'Gambar Logo']);
        Content::firstOrCreate(['key' => 'logo_show_image'], ['group' => 'logo', 'value' => '0', 'type' => 'text', 'label' => 'Tampilkan Gambar']);
        Content::firstOrCreate(['key' => 'logo_show_text'], ['group' => 'logo', 'value' => '1', 'type' => 'text', 'label' => 'Tampilkan Teks']);

        $defaults = [
            'home_hero' => [
                'home_hero_title' => ['label' => 'Hero Title', 'type' => 'text', 'value' => 'UMKM SASUMA.'],
                'home_hero_desc'  => ['label' => 'Hero Description', 'type' => 'textarea', 'value' => 'Temukan berbagai jenis usaha lokal, dari kuliner, kerajinan, sampai layanan jasa.'],
                'home_hero_image' => ['label' => 'Hero Image', 'type' => 'image', 'value' => ''],
            ],
            'home_wilayah' => [
                'home_wilayah_title' => ['label' => 'Section Title', 'type' => 'text', 'value' => 'Wilayah'],
                'home_wilayah_subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'value' => 'Ayo Jelajahi'],
                'home_wilayah_desc' => ['label' => 'Description', 'type' => 'textarea', 'value' => 'Berbagai jenis usaha lokal di wilayah kalian berada'],
            ],
            'umkm_index' => [
                'umkm_index_title' => ['label' => 'Page Title', 'type' => 'text', 'value' => 'UMKM SASUMA.'],
                'umkm_index_subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'value' => 'Temukan umkm sasuma yang ingin kamu kunjungi disetiap wilayah'],
                'umkm_index_banner' => ['label' => 'Banner Image', 'type' => 'image', 'value' => ''],
                'umkm_banner_stat_number' => ['label' => 'Banner Stat Number', 'type' => 'text', 'value' => '100+ UMKM'],
                'umkm_banner_stat_text' => ['label' => 'Banner Stat Text', 'type' => 'text', 'value' => 'Terdaftar di Sasuma'],
            ],
        ];

        foreach ($defaults as $group => $items) {
            foreach ($items as $key => $data) {
                Content::firstOrCreate(
                    ['key' => $key],
                    [
                        'group' => $group,
                        'label' => $data['label'],
                        'type' => $data['type'],
                        'value' => $data['value']
                    ]
                );
            }
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:contents,key',
            'value' => 'nullable',
            'type' => 'required|in:text,textarea,editor,image',
            'group' => 'nullable|string',
            'label' => 'nullable|string',
            'image' => 'nullable|image|max:5048', 
            'icon' => 'nullable|file|mimes:svg|max:1024',
            'logo_fallback' => 'nullable|file|mimes:svg|max:1024',
        ]);

        $data = $request->only(['key', 'type', 'group', 'label']);
        
        if ($request->type === 'image') {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = 'content/' . Str::random(20) . '.jpg';
                
                $maxWidth = ($request->group === 'umkm_index') ? 1200 : 800;
                
                $this->resizeAndSaveImage($file, $filename, $maxWidth);
                $data['value'] = $filename;
            }
        } else {
            $data['value'] = $request->value;
            // Auto Translate if NOT in exclusion list
            if ($data['value'] && !in_array($data['key'], ['home_hero_title', 'umkm_index_title'])) {
                $this->triggerTranslation($data['value']);
            }
        }

        $content = Content::create($data);
        
        // Handle Icon Upload for Business Types
        if ($request->group === 'business_types') {
            if ($request->hasFile('icon')) {
                $this->saveIcon($request->file('icon'), $content->id);
            }
            if ($request->hasFile('logo_fallback')) {
                $this->saveLogoFallback($request->file('logo_fallback'), $content->id);
            }
        }

        \App\Events\ContentUpdated::dispatch('create');

        return redirect()->route('admin.contents.index', ['tab' => $data['group'] ?? 'home_hero'])->with('success', translate('Konten berhasil dibuat.'));
    }

    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);
        
        $rules = [
            'value' => 'nullable',
            'image' => 'nullable|image|max:5048',
        ];
        
        if ($content->group === 'business_types') {
             $rules['icon'] = 'nullable|file|mimes:svg|max:1024';
             $rules['logo_fallback'] = 'nullable|file|mimes:svg|max:1024';
        }

        $request->validate($rules);

        if ($content->type === 'image') {
            if ($request->hasFile('image')) {
                // Delete old image
                if ($content->value && Storage::disk('public')->exists($content->value)) {
                    Storage::disk('public')->delete($content->value);
                }
                
                $file = $request->file('image');
                $filename = 'content/' . Str::random(20) . '.jpg';
                
                $maxWidth = ($content->group === 'umkm_index') ? 1200 : 800;
                
                $this->resizeAndSaveImage($file, $filename, $maxWidth);
                $content->value = $filename;
            }
        } else {
            $content->value = $request->value;
            // Auto Translate if NOT in exclusion list
            if ($content->value && !in_array($content->key, ['home_hero_title', 'umkm_index_title'])) {
                $this->triggerTranslation($content->value);
            }
        }
        
        $content->save();

        if ($content->group === 'business_types') {
            // Handle Icon Deletion
            if ($request->boolean('remove_icon')) {
                $iconKey = 'icon_for_' . $content->id;
                $this->deleteAssociatedImage($iconKey);
            }
            // Handle Logo Deletion
            if ($request->boolean('remove_logo')) {
                $logoKey = 'logo_fallback_for_' . $content->id;
                $this->deleteAssociatedImage($logoKey);
            }

            // Handle Icon Update
            if ($request->hasFile('icon')) {
                $this->saveIcon($request->file('icon'), $content->id);
            }
            // Handle Logo Update
            if ($request->hasFile('logo_fallback')) {
                $this->saveLogoFallback($request->file('logo_fallback'), $content->id);
            }
        }

        \App\Events\ContentUpdated::dispatch('update');

        return redirect()->route('admin.contents.index', ['tab' => $content->group])->with('success', translate('Konten berhasil diperbarui.'));
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        
        if ($content->type === 'image' && $content->value && Storage::disk('public')->exists($content->value)) {
            Storage::disk('public')->delete($content->value);
        }

        // If Business Type, delete associated icon and logo
        if ($content->group === 'business_types') {
            $iconKey = 'icon_for_' . $content->id;
            $this->deleteAssociatedImage($iconKey);

            $logoKey = 'logo_fallback_for_' . $content->id;
            $this->deleteAssociatedImage($logoKey);
        }

        $content->delete();
        \App\Events\ContentUpdated::dispatch('delete');
        return redirect()->back()->with('success', translate('Konten berhasil dihapus.'));
    }

    private function deleteAssociatedImage($key)
    {
        $item = Content::where('key', $key)->first();
        if ($item) {
            if ($item->value && Storage::disk('public')->exists($item->value)) {
                Storage::disk('public')->delete($item->value);
            }
            $item->delete();
        }
    }

    private function saveIcon($file, $businessTypeId)
    {
        $this->saveSvgContent($file, $businessTypeId, 'icon_for_', 'business_type_icons', 'Icon for ');
    }

    private function saveLogoFallback($file, $businessTypeId)
    {
         $this->saveSvgContent($file, $businessTypeId, 'logo_fallback_for_', 'business_type_logos', 'Logo Fallback for ');
    }

    private function saveSvgContent($file, $businessTypeId, $keyPrefix, $group, $labelPrefix)
    {
         // Check availability of Sanitizer code handled by function logic
        if (!class_exists('enshrined\svgSanitize\Sanitizer')) {
             throw new \Exception('SVG Sanitizer library not found. Please run composer require enshrined/svg-sanitize');
        }

        $sanitizer = new Sanitizer();
        $fileContent = file_get_contents($file->getRealPath());
        $cleanSvg = $sanitizer->sanitize($fileContent);
        
        $filename = 'icons/' . Str::random(20) . '.svg';
        Storage::disk('public')->put($filename, $cleanSvg);

        $key = $keyPrefix . $businessTypeId;
        
        Content::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $filename,
                'type' => 'image',
                'label' => $labelPrefix . $businessTypeId
            ]
        );
    }
    
    protected function triggerTranslation($text)
    {
        try {
            translate($text, 'en');
        } catch (\Exception $e) {
            \Log::error('Auto translation failed: ' . $e->getMessage());
        }
    }

    private function resizeAndSaveImage($file, $path, $maxWidth)
    {
        // ... (existing code)
        // No changes needed here, just keep content
        if (!extension_loaded('gd')) {
            $directory = dirname($path);
            $filename = basename($path);
            $file->storeAs($directory, $filename, 'public');
            return;
        }

        try {
            $imageInfo = \getimagesize($file->getRealPath());
            if (!$imageInfo) return; 

            list($width, $height, $type) = $imageInfo;
            
            if ($width > 4000 || $height > 4000) {
                 throw \Illuminate\Validation\ValidationException::withMessages([
                    'image' => 'Resolusi gambar konten terlalu besar. Maksimal 4000x4000px.'
                ]);
            }
            
            $newWidth = $width;
            $newHeight = $height;

            if ($width > $maxWidth) {
                $ratio = $maxWidth / $width;
                $newWidth = $maxWidth;
                $newHeight = $height * $ratio;
            }

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
                
                if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_WEBP) {
                    \imagecolortransparent($dst, \imagecolorallocatealpha($dst, 0, 0, 0, 127));
                    \imagealphablending($dst, false);
                    \imagesavealpha($dst, true);
                }

                \imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                
                $fullPath = storage_path('app/public/' . $path);
                $directory = dirname($fullPath);
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                \imagejpeg($dst, $fullPath, 85);
                
                \imagedestroy($src);
                \imagedestroy($dst);
            } else {
                $directory = dirname($path);
                $filename = basename($path);
                $file->storeAs($directory, $filename, 'public');
            }
        } catch (\Throwable $e) {
            \Log::warning('Image resize failed: ' . $e->getMessage());
            $directory = dirname($path);
            $filename = basename($path);
            $file->storeAs($directory, $filename, 'public');
        }
    }

    /**
     * Get fallback marker icon name based on business type value.
     */
    private function getFallbackMarkerIcon(string $value): string
    {
        $val = strtolower($value);
        if (str_contains($val, 'kuliner') || str_contains($val, 'makan') || str_contains($val, 'food')) {
            return 'map-pin-food';
        } elseif (str_contains($val, 'fashion') || str_contains($val, 'baju') || str_contains($val, 'pakaian')) {
            return 'map-pin-fashion';
        } elseif (str_contains($val, 'jasa') || str_contains($val, 'service') || str_contains($val, 'work')) {
            return 'map-pin-work';
        }
        return 'content-tag';
    }

    /**
     * Get fallback logo filename based on business type value.
     */
    private function getFallbackLogo(string $value): string
    {
        $val = strtolower($value);
        $defaultLogos = [
            'kuliner' => 'kuliner.svg',
            'pakaian & aksesoris' => 'pakaian.svg',
            'pakaian & fashion' => 'pakaian.svg',
            'kerajinan tangan' => 'kerajinan.svg',
            'kelontong' => 'kelontong.svg',
            'jasa' => 'jasa.svg',
            'agribisnis' => 'agribisnis.svg',
        ];
        
        // Try exact match
        if (isset($defaultLogos[$val])) {
            return $defaultLogos[$val];
        }
        
        // Try loose match
        foreach ($defaultLogos as $key => $logo) {
            if (str_contains($val, $key)) {
                return $logo;
            }
        }
        
        return 'kuliner.svg'; // Ultimate fallback
    }

    public function deleteImage($id)
    {
        $content = Content::findOrFail($id);
        
        if ($content->type === 'image' && $content->value) {
            if (Storage::disk('public')->exists($content->value)) {
                Storage::disk('public')->delete($content->value);
            }
            $content->value = null;
            $content->save();
            \App\Events\ContentUpdated::dispatch('delete_image');
        }

        return redirect()->route('admin.contents.index', ['tab' => $content->group])->with('success', translate('Gambar berhasil dihapus.'));
    }
}
