<x-layouts.app :title="translate('Detail Toko - UMKM Sasuma')">

    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">

        {{-- Store Header Section --}}
        <div class="bg-[#FEFBE8] rounded-3xl p-6 md:p-10 mb-12 relative overflow-hidden">
            <div class="flex flex-col md:flex-row gap-8 items-start">

                {{-- Store Image --}}
                <div
                    class="w-32 h-32 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white shadow-lg shrink-0 mx-auto md:mx-0">
                    <img src="{{ $shop->logo_url }}"
                        class="w-full h-full object-cover" alt="{{ $shop->name }}">
                </div>

                {{-- Store Info --}}
                <div class="flex-1 space-y-4 w-full">
                    <div>
                        <p class="text-slate-500 font-medium text-base mb-1">{{translate('Pemilik')}}: <span
                        class="text-slate-900 font-bold">{{ $shop->user->name ?? 'Nama Pemilik' }}</span></p>
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">{{ $shop->name }}</h1>

                            <x-ui.badge class="px-2.5 py-1">{{ $shop->business_type }}</x-ui.badge>
                        </div>

                        <div class="flex items-start gap-2 text-slate-900 text-base">
                            <x-icons.map-pin class="shrink-0" />
                            <span>{{ $shop->address }}</span>
                        </div>
                    </div>

                    {{-- Omset --}}
                    @if($shop->omset_min || $shop->omset_max)
                    <div class="border-t border-[#FFF0A6] pt-3">
                        <h3 class="font-bold text-slate-900 text-base mb-1">{{translate('Omset Penjualan')}}</h3>
                        <p class="text-slate-900 text-base">
                            {{ $shop->omset_min ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_min), 0, ',', '.') : '' }}
                            {{ $shop->omset_min && $shop->omset_max ? '-' : '' }}
                            {{ $shop->omset_max ? 'Rp. ' . number_format((float) preg_replace('/[^0-9]/', '', $shop->omset_max), 0, ',', '.') : '' }}
                        </p>
                    </div>
                    @endif

                    {{-- Izin --}}
                   @if($shop->licenses)
<div class="border-t border-[#FFF0A6] pt-3">
    <h3 class="font-bold text-slate-900 text-base mb-2">{{translate('Izin Usaha')}}</h3>
    
    {{-- Tambahkan grid-cols-1 (mobile) dan sm:grid-cols-2 (desktop) di sini --}}
    <ol class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 list-decimal list-inside text-base text-slate-900">
        @foreach(json_decode($shop->licenses) as $license)
           <li>
                <span class="font-semibold text-slate-900">{{ $license->type }}</span>
                <span class="mx-1 text-slate-400">—</span>
                <span class="font-medium text-slate-700">{{ $license->number }}</span>
            </li>
        @endforeach
    </ol>
</div>
@endif

                    {{-- Social Media Links --}}
                    <div class="border-t border-[#FFF0A6] pt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">
                    {{-- IG --}}
                    @if ($shop->instagram_username)
                        <a href="https://instagram.com/{{ $shop->instagram_username }}" target="_blank"
                            class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <x-icons.social-instagram class="text-red-500" />
                            <span class="font-medium text-base text-slate-900">{{ '@' . $shop->instagram_username }}</span>
                        </a>
                    @endif

                    {{-- Tiktok --}}
                    @if ($shop->tiktok_username)
                        <a href="{{ 'https://tiktok.com/@' . $shop->tiktok_username }}" target="_blank"
                            class="flex items-center gap-1 hover:opacity-80 transition-opacity">
                            <x-icons.social-tiktok class="text-slate-900" />
                            <span class="font-medium text-base text-slate-900">{{ '@' . $shop->tiktok_username }}</span>
                        </a>
                    @endif

                    {{-- FB --}}
                    @if ($shop->facebook_username)
                        <a href="https://facebook.com/{{ $shop->facebook_username }}" target="_blank"
                            class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <x-icons.social-facebook class="text-[#1877F2]" />
                            <span class="font-medium text-base text-slate-900">{{ $shop->facebook_username }}</span>
                        </a>
                    @endif

                    {{-- Website --}}
                    @if ($shop->website_url)
                        <a href="{{ $shop->website_url }}"
                            target="_blank" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            <x-icons.map-globe class="text-slate-900" />
                            <span class="font-medium text-base text-slate-900">Website</span>
                        </a>
                    @endif
                </div>

                    {{-- Description --}}
                    <div class="border-t border-[#FFF0A6] pt-3">
                        <p class="text-slate-900 leading-relaxed">
                            {{ translate($shop->description) }}
                        </p>
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-2">
                        <x-ui.button
                            tag="a"
                            href="https://www.google.com/maps/dir/?api=1&destination={{ $shop->latitude }},{{ $shop->longitude }}"
                            target="_blank"
                            class="bg-[#FFC107] hover:bg-yellow-400 text-slate-900 font-medium px-6 py-2.5 rounded-lg shadow-sm transition-all active:scale-95 text-base h-auto border-none inline-flex decoration-0">
                            {{translate('Lihat Lokasi')}}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Section Logic --}}
        <div x-data='productLogic(@json($productsData), "{{ translate("Semua") }}")'>

    {{-- Header Produk (Judul, Search, Filter) --}}
<div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
    
    {{-- 1. Judul (Kiri di Desktop, Atas di Mobile) --}}
    <div class="text-left w-full md:w-auto order-1 shrink-0">
        <h2 class="text-2xl font-bold text-slate-900">{{translate('Daftar Produk')}}</h2>
        <p class="text-base text-slate-500 mt-1 hidden md:block">
            {{translate('Kategori')}}: <span class="font-bold text-primary" x-text="category"></span>
        </p>
    </div>

    {{-- 2. Filter (Tengah di Desktop, Bawah di Mobile - YouTube Style) --}}
    {{-- Mobile: Order 3 (paling bawah), Desktop: Order 2 (di tengah) --}}
    <div class="w-full order-3 md:order-2 md:flex-1 md:mx-6 overflow-hidden">
        
        {{-- Container Scroll --}}
        {{-- overflow-x-auto: Agar bisa discroll --}}
        {{-- md:justify-center: Agar rata tengah di desktop jika muat --}}
        {{-- -mx-4 px-4: Agar scroll mentok pinggir layar di HP --}}
        <div class="flex gap-2 overflow-x-auto scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0 md:justify-center items-center pb-2 md:pb-0">
            
                <template x-for="cat in ['{{ translate('Semua') }}', ...{{ json_encode($productCategories) }}]" :key="cat">
                <button 
                    @click="setCategory(cat)" 
                    class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border whitespace-nowrap"
                    x-bind:class="category === cat 
                        ? 'bg-[#004a85] text-white border-[#004a85] shadow-md' 
                        : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50'"
                >
                    <span x-text="cat"></span>
                </button>
            </template>

        </div>
    </div>

    {{-- 3. Search (Kanan di Desktop, Tengah di Mobile) --}}
    {{-- Mobile: Order 2, Desktop: Order 3 --}}
    <div class="relative w-full md:w-72 order-2 md:order-3 shrink-0">
        <div class="absolute left-3 top-1/2 -translate-y-[46%] md:-translate-y-[54%] pointer-events-none text-slate-400">
            <x-icons.map-pin-search class="w-5 h-5" />
        </div>
        
        <x-ui.input variant="search" name="search" x-model="search" placeholder="{{translate('Cari produk...')}}">
            <x-slot:icon>
                <x-icons.map-pin-search class="w-5 h-5" />
            </x-slot:icon>
        </x-ui.input>
    </div>

</div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <template x-for="product in displayedProducts" :key="product.id">
                    {{-- Card Produk --}}
                    <div
                        class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 group flex flex-col">

                        {{-- Image Container --}}
                        <div class="aspect-[4/3] sm:aspect-square bg-slate-100 relative overflow-hidden shrink-0">
                            <img :src="product.image"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                :alt="product.name">

                            {{-- Badge Kategori Produk --}}
                            <span
                                class="absolute top-3 left-3 px-2.5 py-1.5 bg-white/90 backdrop-blur-md rounded-lg text-[10px] font-bold uppercase tracking-wider text-slate-800 shadow-sm"
                                x-text="product.category"></span>
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex flex-col flex-1 justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg line-clamp-1 group-hover:text-primary transition-colors mb-1"
                                    x-text="product.name"></h3>
                                <p class="text-base text-slate-500 line-clamp-2" x-text="product.variant"></p>
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                                <div>
                                    <p class="text-[12px] text-slate-400 font-bold tracking-wider mb-0.5">Harga</p>
                                    <span class="font-extrabold text-slate-900 text-xl" x-text="product.price"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Empty State --}}
                <div x-show="filteredProducts.length === 0" x-cloak class="col-span-full text-center py-12">
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 inline-block">
                        <p class="text-slate-900 mb-2">Produk "<span x-text="search" class="font-bold"></span>" tidak
                            ditemukan.</p>
                        <x-ui.button @click="resetAll" variant="link"
                            class="text-primary font-bold hover:underline p-0 h-auto">Reset Semua
                            Filter</x-ui.button>
                    </div>
                </div>
            </div>

            {{-- Load More Button --}}
            <div class="mt-8 text-center" x-show="hasMore" x-cloak>
                <x-ui.button @click="loadMore" variant="outline"
                    class="group flex items-center gap-2 mx-auto px-6 py-2.5 rounded-full border-slate-200 text-slate-900 font-bold text-base hover:border-primary hover:text-primary hover:bg-slate-50 transition-all duration-300 shadow-sm hover:shadow-md">
                    <span>{{translate('Lihat Lebih Banyak')}}</span>
                    <x-icons.ui-chevron-down class="w-5 h-5 group-hover:translate-y-0.5 transition-transform" />
                </x-ui.button>
            </div>
        </div>

    </main>

    {{-- Script AlpineJS --}}
    @push('scripts')
        
    @endpush

</x-layouts.app>
