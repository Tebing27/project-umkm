<div class="relative group border border-slate-100 bg-slate-50 overflow-hidden mx-auto
    @if ($item->is_hero_image) rounded-lg w-full max-w-md object-cover h-[188px] sm:h-80 md:h-[550px]
    @elseif($item->is_umkm_image) rounded-3xl w-full h-[400px] lg:h-[500px]
    @else w-full aspect-video rounded-2xl @endif">

    @if ($item->value)
        <img loading="lazy" src="{{ asset('storage/' . str_replace('\\', '/', $item->value)) }}"
            x-show="!photoPreview"
            class="w-full h-full object-cover {{ $item->is_umkm_image ? 'object-center transform group-hover:scale-105 transition-transform duration-700' : '' }}">
    @else
        <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-300 gap-3 bg-slate-50"
            x-show="!photoPreview">
            <x-icons.data-photo class="w-10 h-10 opacity-50" />
            <span class="text-base font-bold uppercase tracking-widest text-slate-400">{{translate('Tidak Ada Gambar')}}</span>
        </div>
    @endif

    <div x-show="photoPreview"
        class="absolute inset-0 bg-cover bg-center"
        :style="'background-image: url(\'' + photoPreview + '\');'"
        style="display: none;"></div>
    
    {{-- UMKM Banner Overlay --}}
    @if ($item->is_umkm_image)
        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent pointer-events-none"></div>

        <div class="absolute bottom-0 left-0 p-8 pointer-events-none">
            <div class="bg-white/90 backdrop-blur-sm p-4 rounded-2xl inline-block shadow-lg">
                <p class="text-primary font-bold text-lg">{{ cms_content('umkm_banner_stat_number', '100+ UMKM') }}</p>
                <p class="text-slate-600 text-sm">{{ translate(cms_content('umkm_banner_stat_text', 'Terdaftar di Sasuma')) }}</p>
            </div>
        </div>
    @endif

    @include('admin.content.partials.content-items._content-item-image-overlay')
</div>

<div class="mt-3 flex justify-between items-center px-1">
    <span class="text-base text-slate-400 font-medium">
        {{ translate($item->image_dimensions_label) }}
    </span>
    <button type="button"
        @click="$refs.photo_{{ $item->id }}.click()"
        class="lg:hidden text-base text-brand-blue-dark font-bold underline">{{translate('Unggah')}}</button>
</div>
@include('admin.content.partials.content-items._content-item-image-input')

