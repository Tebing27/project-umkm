<div class="bg-[#FEFBE8] rounded-3xl p-6 md:p-10 mb-12 relative overflow-hidden">
    <div class="flex flex-col md:flex-row gap-8 items-start">
        {{-- Store Image --}}
        <div class="w-32 h-32 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white shadow-lg shrink-0 mx-auto md:mx-0">
            <img src="{{ $shop->logo_url }}" class="w-full h-full object-cover" alt="{{ $shop->name }}">
        </div>

        {{-- Store Info Container --}}
        <div class="flex-1 space-y-4 w-full">
            @include('umkm.detail.partials.header')
            @include('umkm.detail.partials.metrics')
            @include('umkm.detail.partials.contacts')
        </div>
    </div>
</div>

