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

        @include('users.products.sections.header')
        @include('users.products.sections.alerts')

        {{-- === SHOP PROFILE CARD === --}}
        @include('users.shop-profile.sections.shop-info-card', ['shop' => $shop])

        @include('users.products.sections.product-manager')

        @include('users.products.sections.fab')
        @include('users.products.sections.modals')
    </div>

</x-layouts.guest>
