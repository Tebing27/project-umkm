<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Region;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index()
    {
        // Ensure default structure exists for specific sections if they don't exist
        $this->ensureDefaultContents();
        
        // Organize contents by group for easier access in the view
        $contents = Content::orderBy('group')->orderBy('key')->get()->groupBy('group');
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

        $tabs = [
            'home_hero' => ['label' => 'Hero Section', 'icon' => 'home'],
            'home_wilayah' => ['label' => 'Wilayah', 'icon' => 'map'],
            'umkm_index' => ['label' => 'Halaman UMKM', 'icon' => 'shopping-bag'],
        ];
        
        return view('admin.content.index', compact('contents', 'regions', 'tabs'));
    }

    private function ensureDefaultContents()
    {
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
            ]
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

        Content::create($data);

        return redirect()->route('admin.contents.index', ['tab' => $data['group'] ?? 'home_hero'])->with('success', translate('Konten berhasil dibuat.'));
    }

    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);
        
        $request->validate([
            'value' => 'nullable',
            'image' => 'nullable|image|max:5048',
        ]);

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

        return redirect()->route('admin.contents.index', ['tab' => $content->group])->with('success', translate('Konten berhasil diperbarui.'));
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        if ($content->type === 'image' && $content->value) {
            Storage::disk('public')->delete($content->value);
        }
        $content->delete();
        return redirect()->back()->with('success', translate('Konten berhasil dihapus.'));
    }

    protected function triggerTranslation($text)
    {
        try {
            translate($text, 'en');
        } catch (\Exception $e) {
            \Log::error('Auto translation failed: ' . $e->getMessage());
        }
    }

    /**
     * Resizes and saves an image using native PHP GD.
     */
    private function resizeAndSaveImage($file, $path, $maxWidth)
    {
        // Check if GD extension is loaded
        if (!extension_loaded('gd')) {
            // Fallback: Just store the file directly
            // $path is like 'content/filename.jpg' or 'regions/filename.jpg'
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
        $content = Content::findOrFail($id);
        
        if ($content->type === 'image' && $content->value) {
            if (Storage::disk('public')->exists($content->value)) {
                Storage::disk('public')->delete($content->value);
            }
            $content->value = null;
            $content->save();
        }

        return redirect()->route('admin.contents.index', ['tab' => $content->group])->with('success', translate('Gambar berhasil dihapus.'));
    }
}
