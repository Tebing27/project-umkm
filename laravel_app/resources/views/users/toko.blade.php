<x-layouts.guest title="Kelola Toko - UMKM Sasuma" header-title="Kelola Toko" header-subtitle="Manajemen produk & stok">

    {{-- 1. PEMBUKA X-DATA UTAMA --}}
    <div x-data="{
        addProductModal: false,
        editProductModal: false,
        activeTab: 'semua',
        showFab: false,
        isLoadingMore: false,
        hasMoreData: true
    }" @scroll.window="showFab = (window.scrollY > 200)">

        {{-- === HEADER PAGE === --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Toko</h2>
                <p class="text-slate-500 mt-2 text-base font-medium">Atur produk, stok, dan etalase toko Anda.</p>
            </div>

            {{-- Tombol Edit Toko (Desktop) --}}
            <x-ui.button href="/users/edit-toko" variant="shiny" size="xl"
                class="w-full md:w-auto flex items-center justify-center gap-2.5">
                <div class="bg-white/20 p-1 rounded-md group-hover:rotate-90 transition-transform duration-300">
                    <x-icons.pencil class="text-slate-900" />
                </div>
                <span class="text-slate-900 font-medium">Edit Data Toko</span>
            </x-ui.button>
        </div>

        {{-- === SHOP PROFILE CARD === --}}
        <x-users.shop-profile-card />

        {{-- === CONTENT AREA === --}}
        <div class="space-y-8">

            {{-- 1. Tabs & Search --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                {{-- Tabs --}}
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2 sm:pb-0">
                    @foreach (['semua' => 'Semua', 'aktif' => 'Aktif', 'tidak_aktif' => 'Tidak Aktif'] as $key => $label)
                        <button @click="activeTab = '{{ $key }}'"
                            class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap"
                            :class="activeTab === '{{ $key }}'
                                ?
                                'bg-[#004a85] text-white border-[#004a85] shadow-md' :
                                'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Search --}}
                <div class="relative w-full sm:w-72">
                    <x-ui.input variant="search" x-model.debounce.300ms="location-search" type="text"
                        placeholder="Cari nama produk..." class="text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.location-search class="h-5 w-5 text-slate-400" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>
            </div>

            {{-- 2. Grid Produk --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                {{-- Card Shortcut Tambah --}}
                <x-users.product-card-shortcut />

                {{-- Contoh Data Produk --}}
                <x-users.product-card
                    image="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=500&q=80"
                    category="Makanan" name="Salad Buah Segar" price="Rp 25.000" />
                <x-users.product-card
                    image="https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=500&q=80"
                    category="Minuman" name="Es Krim Vanilla" price="Rp 25.000" />
                <x-users.product-card
                    image="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=500&q=80"
                    category="Makanan" name="Salad Buah Segar" price="Rp 25.000" />
                <x-users.product-card
                    image="https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=500&q=80"
                    category="Minuman" name="Es Krim Vanilla" price="Rp 25.000" />
            </div>

            {{-- 3. Load More Pagination --}}
            <div class="flex flex-col items-center justify-center pt-4 pb-12">

                {{-- Tombol Load More --}}
                <button type="button" x-show="hasMoreData"
                    @click="isLoadingMore = true; setTimeout(() => { isLoadingMore = false; }, 2000)"
                    :disabled="isLoadingMore"
                    class="group relative flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-white border border-slate-200 text-slate-600 font-bold text-sm shadow-sm hover:bg-slate-50 hover:border-[#004a85] hover:text-[#004a85] hover:shadow-md transition-all disabled:opacity-70 disabled:cursor-not-allowed w-full md:w-auto">

                    {{-- State 1: Teks Normal --}}
                    <span x-show="!isLoadingMore" class="flex items-center gap-2">
                        <span>Lihat Lebih Banyak</span>
                        <x-icons.chevron-down class="w-5 h-5 group-hover:translate-y-0.5 transition-transform" />
                    </span>

                    {{-- State 2: Loading Spinner --}}
                    <span x-show="isLoadingMore" class="flex items-center gap-2" x-cloak>
                        <svg class="animate-spin h-5 w-5 text-[#004a85]" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Sedang Memuat...</span>
                    </span>
                </button>

                {{-- Pesan Data Habis --}}
                <div x-show="!hasMoreData" x-cloak class="text-center">
                    <p class="text-slate-400 text-sm font-medium">Semua produk sudah ditampilkan</p>
                    <div class="h-1 w-12 bg-slate-200 rounded-full mx-auto mt-3"></div>
                </div>

            </div>
        </div>

        {{-- === FAB EDIT TOKO (MOBILE ONLY) === --}}
        <div x-show="showFab" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-90" class="lg:hidden fixed bottom-6 right-6 z-40"
            x-cloak>

            <x-ui.button href="/users/edit-toko" variant="fab" size="fab" class="shadow-2xl shadow-blue-900/40">
                <x-icons.pencil class="w-6 h-6" />
            </x-ui.button>
        </div>

        {{-- === MODALS === --}}
        <x-users.modals.add-product />
        <x-users.modals.edit-product />

    </div>

</x-layouts.guest>
