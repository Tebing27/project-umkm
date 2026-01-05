<div class="relative w-full h-48 md:h-64 aspect-square bg-slate-100 overflow-hidden relative">
    @if ($region->image)
        <img src="{{ asset('storage/' . str_replace('\\', '/', $region->image)) }}"
            x-show="!photoPreview"
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
    @else
        <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-300 gap-3 bg-slate-50">
            <x-icons.data-photo class="w-10 h-10 opacity-50" />
            <span class="text-base font-bold uppercase text-slate-400">{{translate('Tidak Ada Gambar')}}</span>
        </div>
    @endif

    <div x-show="photoPreview"
        class="absolute inset-0 bg-cover bg-center z-10 transition-opacity duration-300"
        :style="'background-image: url(\'' + photoPreview + '\');'"></div>

    @include('admin.content.sections.cards.partials.region-overlay-info')
    @include('admin.content.sections.cards.partials.region-overlay-actions')
</div>
