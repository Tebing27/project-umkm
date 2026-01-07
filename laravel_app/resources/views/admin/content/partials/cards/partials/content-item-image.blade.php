<div class="relative group border border-slate-100 bg-slate-50 overflow-hidden mx-auto
    @if ($item->is_hero_image) rounded-lg w-full max-w-md object-cover aspect-[3/4] md:aspect-auto md:h-[550px]
    @elseif($item->is_umkm_image) object-cover h-[400px] lg:h-[500px] w-full 
    @else w-full aspect-video rounded-2xl shadow-inner @endif">

    @if ($item->value)
        <img src="{{ asset('storage/' . str_replace('\\', '/', $item->value)) }}"
            x-show="!photoPreview"
            class="w-full h-full object-cover {{ $item->is_umkm_image ? 'object-center' : '' }}">
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

    @include('admin.content.partials.cards.partials.content-item-image-overlay')
</div>

<div class="mt-3 flex justify-between items-center px-1">
    <span class="text-base text-slate-400 font-medium">
        {{ translate($item->image_dimensions_label) }}
    </span>
    <button type="button"
        @click="$refs.photo_{{ $item->id }}.click()"
        class="lg:hidden text-base text-[#004a85] font-bold underline">{{translate('Unggah')}}</button>
</div>
@include('admin.content.partials.cards.partials.content-item-image-input')

