<x-layouts.guest :title="translate('Dashboard User - UMKM Sasuma')" :header-title="translate('Dashboard')" :header-subtitle="translate('Ringkasan Aktivitas')">
    {{-- Welcome Section --}}
    @include('users.dashboard.partials.welcome')
    @include('users.dashboard.partials.stats-card')
</x-layouts.guest>
