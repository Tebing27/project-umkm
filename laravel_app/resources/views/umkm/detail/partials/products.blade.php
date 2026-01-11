<div x-data='productLogic(@json($productsData), @json($productCategories), "{{ translate("Semua") }}")'>
    @include('umkm.detail.partials.products-filter')
    @include('umkm.detail.partials.products-grid')
</div>

