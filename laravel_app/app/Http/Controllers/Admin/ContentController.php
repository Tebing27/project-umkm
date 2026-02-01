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
     * Show the content management dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // --- Section: Inisialisasi Konten Default ---
        // Memastikan struktur konten dasar tersedia jika belum ada di database
        $this->ensureDefaultContents();
        
        $group = $request->query('tab', 'home_hero');
        
    // --- Section: Pengelompokan Data ---
        $contents = Content::where('group', $group)->get()->groupBy('group');
        
        // --- Section: Data Wilayah (Khusus Tab Wilayah/Hero) ---
        $regions = collect([]);
        if ($group === 'home_wilayah' || $group === 'home_hero') {
            $regions = Region::with(['shops' => function($query) {
                // Hanya ambil toko verified untuk featured selection
                $query->where('is_verified', true)->select('id', 'name', 'region_id');
            }])->get();

            // Pre-calculate selected shop name (business logic: avoid inline PHP logic in view)
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

        // --- Section: Tab Configuration ---
        $tabs = [
            'home_hero' => ['label' => 'Hero Section', 'icon' => 'home'],
            'home_wilayah' => ['label' => 'Wilayah', 'icon' => 'map'],
            'umkm_index' => ['label' => 'Halaman UMKM', 'icon' => 'shopping-bag'],
            'footer' => ['label' => 'Footer', 'icon' => 'archive'],
            'business_types' => ['label' => 'Jenis Usaha', 'icon' => 'tag'],
            'logo' => ['label' => 'Logo', 'icon' => 'star'],
        ];

        // --- Section: Data Jenis Usaha ---
        $businessTypes = $contents->get('business_types') ?? collect([]);
        // Fetch icons for business types
        $businessTypeIcons = Content::where('group', 'business_type_icons')->get()->keyBy('key');
        // Fetch logos for business types
        $businessTypeLogos = Content::where('group', 'business_type_logos')->get()->keyBy('key');
        
        // Menggabungkan data icon dan logo ke object businessType untuk kemudahan akses di view
        foreach ($businessTypes as $bt) {
            $iconKey = 'icon_for_' . $bt->id;
            $bt->icon_url = isset($businessTypeIcons[$iconKey]) ? $businessTypeIcons[$iconKey]->value : null;

            $logoKey = 'logo_fallback_for_' . $bt->id;
            $bt->logo_url = isset($businessTypeLogos[$logoKey]) ? $businessTypeLogos[$logoKey]->value : null;
            
            // Fallback values (Zero PHP Blade logic)
            $bt->fallback_marker_icon = \App\Models\Shop::getFallbackMarkerIconForType($bt->value);
            $bt->fallback_logo = \App\Models\Shop::getFallbackLogoForType($bt->value);
        }

        // --- Section: Data Logo ---
        $logoData = $contents->get('logo') ?? collect([]);
        $logoType = $logoData->where('key', 'logo_type')->first();
        $logoText = $logoData->where('key', 'logo_text')->first();
        $logoImage = $logoData->where('key', 'logo_image')->first();
        $logoShowImage = $logoData->where('key', 'logo_show_image')->first();
        $logoShowText = $logoData->where('key', 'logo_show_text')->first();
        
        return view('admin.content.index', compact('contents', 'regions', 'tabs', 'businessTypes', 'logoType', 'logoText', 'logoImage', 'logoShowImage', 'logoShowText'));
    }

    /**
     * Ensure default contents exist in the database.
     * 
     * @return void
     */
    private function ensureDefaultContents()
    {
        // --- Section: Default Jenis Usaha ---
        $types = ['Kuliner', 'Pakaian & Aksesoris', 'Kelontong', 'Agribisnis', 'Jasa', 'Kerajinan Tangan'];
        foreach ($types as $type) {
            Content::firstOrCreate(
                ['group' => 'business_types', 'value' => $type],
                ['type' => 'text', 'label' => 'Jenis Usaha', 'key' => 'business_type_' . Str::random(10)]
            );
        }

        // --- Section: Default Logo Configuration ---
        Content::firstOrCreate(['key' => 'logo_type'], ['group' => 'logo', 'value' => 'text', 'type' => 'text', 'label' => 'Tipe Logo']);
        Content::firstOrCreate(['key' => 'logo_text'], ['group' => 'logo', 'value' => 'Sasuma UMKM', 'type' => 'text', 'label' => 'Teks Logo']);
        Content::firstOrCreate(['key' => 'logo_image'], ['group' => 'logo', 'value' => '', 'type' => 'image', 'label' => 'Gambar Logo']);
        Content::firstOrCreate(['key' => 'logo_show_image'], ['group' => 'logo', 'value' => '0', 'type' => 'text', 'label' => 'Tampilkan Gambar']);
        Content::firstOrCreate(['key' => 'logo_show_text'], ['group' => 'logo', 'value' => '1', 'type' => 'text', 'label' => 'Tampilkan Teks']);

        // --- Section: Default Page Contents ---
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
            'footer' => [
                'footer_about' => ['label' => 'About Text', 'type' => 'textarea', 'value' => 'Small change. Big change.'],
                'footer_cta_text' => ['label' => 'CTA Button Text', 'type' => 'text', 'value' => 'CONTACT US'],
                'footer_cta_link' => ['label' => 'CTA Button Link', 'type' => 'text', 'value' => '/contact'],
                'footer_section_1_title' => ['label' => 'Link Section 1 Title', 'type' => 'text', 'value' => 'Home'],
                'footer_section_2_title' => ['label' => 'Link Section 2 Title', 'type' => 'text', 'value' => 'How it works'],
                'footer_social_facebook' => ['label' => 'Facebook URL', 'type' => 'text', 'value' => '#'],
                'footer_social_instagram' => ['label' => 'Instagram URL', 'type' => 'text', 'value' => '#'],
                'footer_social_tiktok' => ['label' => 'TikTok URL', 'type' => 'text', 'value' => '#'],
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

    /**
     * Store new content in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
        
        // --- Section: Handle Content Value ---
        if ($request->type === 'image') {
            if ($request->hasFile('image')) {
                // Resize image depending on use-case
                $file = $request->file('image');
                $maxWidth = ($request->group === 'umkm_index') ? 1200 : 800; // Banner needs more width

                $filename = $this->imageService->resizeAndSave($file, 'content', $maxWidth);
                $data['value'] = $filename;
            }
        } else {
            $data['value'] = $request->value;
            // --- Section: Auto Translation ---
            // Trigger translasi otomatis jika bukan exclude list
            if ($data['value'] && !in_array($data['key'], ['home_hero_title', 'umkm_index_title'])) {
                $this->triggerTranslation($data['value']);
            }
        }

        $content = Content::create($data);
        
        // --- Section: Business Type Special Assets (Icon/Logo) ---
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

    /**
     * Update existing content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

        // --- Section: Update Content ---
        if ($content->type === 'image') {
            if ($request->hasFile('image')) {
                // Hapus image lama sebelum replace
                $this->imageService->delete($content->value);
                
                $file = $request->file('image');
                $maxWidth = ($content->group === 'umkm_index') ? 1200 : 800;
                
                $filename = $this->imageService->resizeAndSave($file, 'content', $maxWidth);
                $content->value = $filename;
            }
        } else {
            $content->value = $request->value;
            // --- Section: Auto Translation ---
            if ($content->value && !in_array($content->key, ['home_hero_title', 'umkm_index_title'])) {
                $this->triggerTranslation($content->value);
            }
        }
        
        $content->save();

        // --- Section: Business Type Assets Updates ---
        if ($content->group === 'business_types') {
            // Hapus assets jika checkbox dicentang
            if ($request->boolean('remove_icon')) {
                $iconKey = 'icon_for_' . $content->id;
                $this->deleteAssociatedImage($iconKey);
            }
            if ($request->boolean('remove_logo')) {
                $logoKey = 'logo_fallback_for_' . $content->id;
                $this->deleteAssociatedImage($logoKey);
            }

            // Update/Upload assets baru
            if ($request->hasFile('icon')) {
                $this->saveIcon($request->file('icon'), $content->id);
            }
            if ($request->hasFile('logo_fallback')) {
                $this->saveLogoFallback($request->file('logo_fallback'), $content->id);
            }
        }

        \App\Events\ContentUpdated::dispatch('update');

        return redirect()->route('admin.contents.index', ['tab' => $content->group])->with('success', translate('Konten berhasil diperbarui.'));
    }

    /**
     * Delete content.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        
        if ($content->type === 'image' && $content->value) {
            $this->imageService->delete($content->value);
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
            $this->imageService->delete($item->value);
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

    // --- Section: Helpers for SVG Assets ---

    private function saveSvgContent($file, $businessTypeId, $keyPrefix, $group, $labelPrefix)
    {
        try {
            $filename = $this->imageService->saveSvg($file, 'icons');
            
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
        } catch (\Exception $e) {
            \Log::error('SFG Upload Failed: ' . $e->getMessage());
            throw \Illuminate\Validation\ValidationException::withMessages([
                 'icon' => 'Gagal mengupload file SVG: ' . $e->getMessage()
            ]);
        }
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
     * Delete a specific image file from content.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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
