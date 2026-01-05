<x-layouts.guest :title="translate('Dashboard User - UMKM Sasuma')" :header-title="translate('Dashboard')" :header-subtitle="translate('Ringkasan Aktivitas')">
    {{-- Welcome Section --}}
    @include('users.dashboard.sections.welcome-header')
    
    @include('users.dashboard.sections.stats-overview')
</x-layouts.guest>