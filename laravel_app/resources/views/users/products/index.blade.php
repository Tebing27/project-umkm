<x-layouts.guest :title="translate('Kelola Toko - UMKM Sasuma')" :header-title="translate('Kelola Toko')" :header-subtitle="translate('Manajemen produk & stok')">

    {{-- 1. PEMBUKA X-DATA UTAMA --}}
    <div x-data="{
        addProductModal: {{ $errors->hasAny(['image', 'images', 'images.*', 'name', 'price', 'category', 'description']) ? 'true' : 'false' }},
        editProductModal: false,
        selectedProduct: null,
        showFab: false,
    
        openEditModal(product) {
            this.selectedProduct = product;
            this.editProductModal = true;
        }
    }" @edit-product.window="openEditModal($event.detail)"
        @scroll.window="showFab = (window.scrollY > 200)">

        {{-- 1. HEADER --}}
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
                <span class="text-slate-900 text-base font-semibold">{{ translate('Edit Data Toko') }}</span>
            </x-ui.button>
        </div>

        {{-- 2. ALERTS --}}
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
                <button @click="show = false" class="text-green-600 hover:bg-green-100 p-2 rounded-lg transition-colors">
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

        {{-- 3. SHOP PROFILE CARD --}}
        @include('users.shop-profile.partials._shop-info-card', ['shop' => $shop])

        @include('users.products.partials._product-manager')

        {{-- 4. FAB EDIT TOKO (MOBILE ONLY) --}}
        <div x-show="showFab" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-90" class="lg:hidden fixed bottom-6 right-6 z-40"
            x-cloak>

            <x-ui.button href="/users/edit-toko" variant="fab" size="fab" class="shadow-2xl shadow-blue-900/40">
                <x-icons.ui-edit class="w-6 h-6" />
            </x-ui.button>
        </div>

        {{-- 5. MODALS --}}
        <x-ui.modal show="addProductModal" maxWidth="2xl">
            @include('users.products.partials._add-product-form')
        </x-ui.modal>

        <x-ui.modal show="editProductModal" maxWidth="2xl">
            @include('users.products.partials._edit-product-form')
        </x-ui.modal>

        {{-- Hidden Delete Form --}}
        <form id="delete-product-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

</x-layouts.guest>

