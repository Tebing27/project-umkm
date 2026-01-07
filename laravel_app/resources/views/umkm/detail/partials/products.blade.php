<div x-data='productLogic(@json($productsData), "{{ translate("Semua") }}")'>
    @include('umkm.detail.partials.products-filter')
    @include('umkm.detail.partials.products-grid')
</div>

