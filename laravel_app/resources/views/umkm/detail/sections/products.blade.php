<div x-data='productLogic(@json($productsData), "{{ translate("Semua") }}")'>
    @include('umkm.detail.sections.products-filter')
    @include('umkm.detail.sections.products-grid')
</div>
