{{-- Right: Details --}}
<div class="lg:col-span-7">
    {{-- Diubah menjadi flex-col agar properti 'order' berfungsi --}}
    <div class="rounded-lg p-6 md:p-8 pt-0 lg:pt-0 flex flex-col">
        
        {{-- Badge (Selalu urutan 1) --}}
        <div class="inline-block mb-2 order-1">
            <x-ui.badge variant="outline" class="text-xs font-medium" x-text="product.category">
                {{ $product->category }}
            </x-ui.badge>
        </div>

        {{-- Title (Desktop: 2, Mobile: 3) --}}
        <h1 class="text-xl md:text-2xl font-medium text-slate-900 mb-2 leading-tight order-3 md:order-2" x-text="product.name">
            {{ $product->name }}
        </h1>
        
        {{-- Price (Desktop: 3, Mobile: 2) --}}
        <div class="flex items-baseline gap-2 mb-4 order-2 md:order-3">
            <p class="text-2xl font-extrabold text-primary" x-text="formattedPrice">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
        </div>

        {{-- Meta (Varian & Stok - Order 4) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 py-4 border-y border-slate-100 order-4">
            {{-- Varian --}}
            <div class="flex flex-col gap-1">
                <span class="text-xs uppercase tracking-wider font-semibold text-slate-400">{{ translate('Varian Produk') }}</span>
                <span class="text-sm font-semibold text-slate-700" x-text="product.variant || 'Tidak ada varian'">{{ $product->variant ?: "Tidak ada varian" }}</span>
            </div>

            {{-- Ketersediaan --}}
            <div class="flex flex-col gap-1">
                <span class="text-xs uppercase tracking-wider font-semibold text-slate-400">{{ translate('Ketersediaan') }}</span>
                <span class="text-sm font-semibold flex items-center gap-1" :class="product.is_active ? 'text-green-600' : 'text-red-600'">
                    <template x-if="product.is_active">
                        <div class="flex items-center gap-1">
                            <x-icons.ui-check class="w-4 h-4" /> {{ translate('Stok Tersedia') }}
                        </div>
                    </template>
                    <template x-if="!product.is_active">
                        <div class="flex items-center gap-1">
                            <x-icons.ui-block class="w-4 h-4" />
                            {{ translate('Stok Habis') }}
                        </div>
                    </template>
                </span>
            </div>
        </div>

        {{-- Description & Shop Profile (Order 5) --}}
        <div class="order-5">
            {{-- Description --}}
            <div class="mb-4">
                <h3 class="text-lg font-bold text-slate-900 mb-2">
                    {{ translate('Deskripsi Produk') }}</h3>
                <div class="relative">
                    <p class="text-slate-600 text-base leading-relaxed transition-all duration-300"
                        :class="expanded ? '' : 'line-clamp-4'"
                        x-text="displayDescription">
                        {{ $product->description ?: translate('Tidak ada deskripsi.') }}
                    </p>
                    <button x-show="isLongDescription" 
                            @click="expanded = !expanded"
                            class="mt-1 text-brand-blue-dark font-semibold text-sm hover:underline focus:outline-none flex items-center gap-1"
                            x-text="expanded ? '{{ translate('Lihat Lebih Sedikit') }}' : '{{ translate('Lihat Lebih Banyak') }}'">
                    </button>
                </div>
            </div>

            <hr class="border-slate-100 mb-4">

            {{-- Shop Profile Card --}}
            <div class="flex items-center gap-3 bg-slate-50 p-3 sm:p-4 rounded-xl border border-slate-200">
                <img loading="lazy" src="{{ $shop->logo_url }}" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border border-white shadow-sm object-cover shrink-0">
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-xs md:text-base text-slate-900 leading-tight truncate">
                        {{ $shop->name }}
                    </h4>
                    <p class="text-xs md:text-sm text-slate-500 flex items-center gap-1 mt-0.5 truncate">
                        <x-icons.map-pin class="md:!w-3.5 md:!h-3.5 min-[321px]:!w-3.5 min-[321px]:!h-3.5 !w-2.5 !h-2.5" />
                        <span class="truncate">{{ $shop->region->name ?? 'Indonesia' }}</span>
                    </p>
                </div>
                <a href="http://maps.google.com/?q={{ $shop->latitude }},{{ $shop->longitude }}" target="_blank" class="shrink-0 whitespace-nowrap rounded-lg border border-brand-yellow px-4 py-1.5 text-xs md:text-sm font-bold text-slate-900">
                    {{ translate('Lokasi') }}
                </a>
            </div>
        </div> {{-- End Order 5 --}}

    </div> {{-- End Container Details --}}
</div>
