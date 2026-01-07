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

        @include('users.products.partials.header')
        @include('users.products.partials.alerts')

        {{-- === SHOP PROFILE CARD === --}}
        @include('users.shop-profile.partials.shop-info-card', ['shop' => $shop])

        @include('users.products.partials.product-manager')

        @include('users.products.partials.fab')
        @include('users.products.partials.modals')
    </div>

</x-layouts.guest>

