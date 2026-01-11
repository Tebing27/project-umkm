{{-- Social Media Links --}}
@include('umkm.detail.partials.socials')

{{-- Description --}}
<div class="border-t border-[#FFF0A6] pt-3">
    <p class="text-slate-900 leading-relaxed" x-text="shop.description">
        {{ translate($shop->description) }}
    </p>
</div>

{{-- Action Button --}}
<div class="pt-2">
    <x-ui.button tag="a"
        x-bind:href="`https://www.google.com/maps/dir/?api=1&destination=${shop.latitude},${shop.longitude}`"
        target="_blank"
        class="bg-[#FFC107] hover:bg-yellow-400 text-slate-900 font-medium px-6 py-2.5 rounded-lg shadow-sm transition-all active:scale-95 text-base h-auto border-none inline-flex decoration-0">
        {{translate('Lihat Lokasi')}}
    </x-ui.button>
</div>

