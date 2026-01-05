<x-layouts.admin :title="translate('Kelola User - UMKM Sasuma Admin')" :header-title="translate('Kelola User')" :header-subtitle="translate('Verifikasi & Data UMKM')">
    @include('admin.users.sections.header-filters')
    @include('admin.users.sections.shop-grid')
</x-layouts.admin>
