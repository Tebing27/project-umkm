<x-layouts.admin :title="translate('Dashboard Admin - UMKM Sasuma')" :header-title="translate('Dashboard Admin')" :header-subtitle="translate('Overview & Statistik')">
    @include('admin.dashboard.partials.welcome')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @include('admin.dashboard.partials.total-shops-card')
        @include('admin.dashboard.partials.registration-status-card')
    </div>
</x-layouts.admin>

