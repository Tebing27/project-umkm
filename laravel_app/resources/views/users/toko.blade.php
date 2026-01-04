<x-layouts.guest :title="translate('Kelola Toko - UMKM Sasuma')" :header-title="translate('Kelola Toko')" :header-subtitle="translate('Manajemen produk & stok')">

    {{-- 1. PEMBUKA X-DATA UTAMA --}}
    <div x-data="{
        addProductModal: {{ $errors->hasAny(['image', 'name', 'price', 'category']) ? 'true' : 'false' }},
        editProductModal: false,
        selectedProduct: null,
        showFab: false,
    
        openEditModal(product) {
            this.selectedProduct = product;
            this.editProductModal = true;
        }
    }" @edit-product.window="openEditModal($event.detail)"
        @scroll.window="showFab = (window.scrollY > 200)">

        {{-- === HEADER PAGE === --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ translate('Kelola Toko') }}</h2>
                <p class="text-slate-500 mt-2 text-base font-medium">
                    {{ translate('Atur produk, stok, dan etalase toko Anda.') }}</p>
            </div>

            {{-- Tombol Edit Toko (Desktop) --}}
            <x-ui.button href="/users/edit-toko" variant="shiny" size="xl"
                class="w-full md:w-auto flex items-center justify-center gap-2.5">
                <div class="bg-white/20 p-1 rounded-md group-hover:rotate-90 transition-transform duration-300">
                    <x-icons.ui-edit class="text-slate-900" />
                </div>
                <span class="text-slate-900 font-medium">{{ translate('Edit Data Toko') }}</span>
            </x-ui.button>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity
                class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-2 rounded-full">
                        <x-icons.ui-check class="w-5 h-5 text-green-600" />
                    </div>
                    <div>
                        <h4 class="font-bold text-green-800">{{ translate('Berhasil!') }}</h4>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false"
                    class="text-green-600 hover:bg-green-100 p-2 rounded-lg transition-colors">
                    <x-icons.ui-close class="w-5 h-5" />
                </button>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity
                class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-red-100 p-2 rounded-full">
                        <x-icons.ui-close class="w-5 h-5 text-red-600" />
                    </div>
                    <div>
                        <h4 class="font-bold text-red-800">{{ translate('Gagal!') }}</h4>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-red-600 hover:bg-red-100 p-2 rounded-lg transition-colors">
                    <x-icons.ui-close class="w-5 h-5" />
                </button>
            </div>
        @endif

        {{-- === SHOP PROFILE CARD === --}}
        <x-users.shop-profile-card :shop="$shop" />

        {{-- === CONTENT AREA === --}}
        <div class="space-y-8">

            {{-- 2. Grid Produk & Filter Logic --}}
            <div x-data="{
                search: '',
                status: 'semua',
                page: 1,
                hasMore: {{ $products->hasMorePages() ? 'true' : 'false' }},
                isLoading: false,
                loadingMore: false,
                productsContainer: null,
            
                init() {
                    // Watchers for search and status to trigger fetch
                    this.$watch('search', () => this.fetchProducts(true));
                    this.$watch('status', () => this.fetchProducts(true));
                },
            
                fetchProducts(reset = false) {
                    if (reset) {
                        this.page = 1;
                        this.isLoading = true;
                    } else {
                        this.page++;
                        this.loadingMore = true;
                    }
            
                    const params = new URLSearchParams({
                        search: this.search,
                        status: this.status,
                        page: this.page
                    });
            
                    fetch(`${window.location.pathname}?${params.toString()}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (reset) {
                                document.getElementById('product-list-container').innerHTML = data.html;
                            } else {
                                document.getElementById('product-list-container').insertAdjacentHTML('beforeend', data.html);
                            }
            
                            this.hasMore = data.hasMore;
                        })
                        .finally(() => {
                            this.isLoading = false;
                            this.loadingMore = false;
                        });
                }
            }">

                {{-- Search & Tabs UI --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    {{-- Tabs --}}
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2 sm:pb-0">
                        @foreach (['semua' => translate('Semua'), 'aktif' => translate('Aktif'), 'tidak_aktif' => translate('Tidak Aktif')] as $key => $label)
                            <button @click="status = '{{ $key }}'"
                                class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-200 border whitespace-nowrap"
                                :class="status === '{{ $key }}'
                                    ?
                                    'bg-[#004a85] text-white border-[#004a85] shadow-md' :
                                    'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Search --}}
                    <div class="relative w-full sm:w-72">
                        <x-ui.input variant="search" x-model.debounce.500ms="search" type="text"
                            placeholder="{{ translate('Cari nama produk...') }}" class="text-sm md:text-base">
                            <x-slot:icon>
                                <x-icons.map-pin-search class="h-5 w-5 text-slate-400" />
                            </x-slot:icon>
                        </x-ui.input>
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 relative min-h-[200px]">

                    {{-- Shortcut Tambah (Always Visible) --}}
                    <x-users.product-card-shortcut />

                    {{-- Products List Container --}}
                    <div id="product-list-container" class="contents">
                        @include('components.users.product-list', ['products' => $products])
                    </div>

                    {{-- Loading Overlay for Search/Filter --}}
                    <div x-show="isLoading"
                        class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center rounded-xl backdrop-blur-sm"
                        x-transition>
                        <x-icons.status-loading class="animate-spin h-10 w-10 text-[#004a85]" />
                    </div>
                </div>

                {{-- Load More Pagination --}}
                <div class="flex flex-col items-center justify-center pt-8 pb-12">
                    <button type="button" x-show="!isLoading && hasMore" @click="fetchProducts()"
                        :disabled="loadingMore"
                        class="group relative flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-white border border-slate-200 text-slate-600 font-bold text-sm shadow-sm hover:bg-slate-50 hover:border-[#004a85] hover:text-[#004a85] hover:shadow-md transition-all disabled:opacity-70 disabled:cursor-not-allowed w-full md:w-auto">

                        <span x-show="!loadingMore" class="flex items-center gap-2">
                            <span>{{ translate('Lihat Lebih Banyak') }}</span>
                            <x-icons.ui-chevron-down class="w-5 h-5 group-hover:translate-y-0.5 transition-transform" />
                        </span>

                        <span x-show="loadingMore" class="flex items-center gap-2" x-cloak>
                            <x-icons.status-loading class="animate-spin h-5 w-5 text-[#004a85]" />
                            <span>{{ translate('Sedang Memuat...') }}</span>
                        </span>
                    </button>

                    <div x-show="!hasMore && !isLoading && page > 1" class="text-slate-400 text-sm font-medium mt-4">
                        {{ translate('Semua produk sudah ditampilkan') }}
                    </div>
                </div>
            </div>

            {{-- Custom Delete Modal --}}
            <div x-data="{
                open: false,
                productId: null,
            
                confirmDelete(id) {
                    this.productId = id;
                    this.open = true;
                },
            
                proceed() {
                    const form = document.getElementById('delete-product-form');
                    form.action = '/toko/produk/' + this.productId;
                    form.submit();
                }
            }" @delete-product.window="confirmDelete($event.detail)" x-show="open"
                class="fixed inset-0 z-[60] flex items-center justify-center px-4 py-6 sm:px-6" x-cloak>

                <div @click="open = false" x-transition.opacity class="absolute inset-0 bg-slate-900/60"></div>

                <div x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-sm relative z-10 overflow-hidden flex flex-col p-6 text-center">

                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <x-icons.ui-delete class="w-8 h-8 text-red-600" />
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ translate('Hapus Produk?') }}</h3>
                    <p class="text-sm text-slate-500 mb-6">
                        {{ translate('Produk yang dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin melanjutkan?') }}
                    </p>

                    <div class="grid grid-cols-2 gap-3">
                        <button @click="open = false" type="button"
                            class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                            {{ translate('Batal') }}
                        </button>
                        <button @click="proceed()" type="button"
                            class="px-4 py-2.5 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 shadow-lg shadow-red-600/30 transition-all active:scale-95">
                            {{ translate('Ya, Hapus') }}
                        </button>
                    </div>
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

            <x-ui.button href="/users/edit-toko" variant="fab" size="fab"
                class="shadow-2xl shadow-blue-900/40">
                <x-icons.ui-edit class="w-6 h-6" />
            </x-ui.button>
        </div>

        {{-- === MODALS === --}}
        <x-users.modals.add-product />
        <x-users.modals.edit-product />

        {{-- Hidden Delete Form --}}
        <form id="delete-product-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

    </div>

</x-layouts.guest>
