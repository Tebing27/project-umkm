<x-layouts.admin :title="translate('Kelola User - UMKM Sasuma Admin')" :header-title="translate('Kelola User')" :header-subtitle="translate('Verifikasi & Data UMKM')">
    @include('admin.users.partials._header-filters')
    @include('admin.users.partials._shop-grid')

    @push('scripts')
    <script type="module">
        import { initGlobalListener } from "{{ Vite::asset('resources/js/pages/realtime-dashboard.js') }}";
        
        document.addEventListener('DOMContentLoaded', () => {
            let isInitialLoad = true;

            initGlobalListener((data) => {
                // Ignore the very first snapshot that fires immediately on connection
                if (isInitialLoad) {
                    isInitialLoad = false;
                    return;
                }

                // If a refresh action is specifically requested, or just general update
                // For simplicity on the index page, we reload to get fresh data (new users, status changes etc)
                if (data && (data.action === 'refresh' || data.shop_id || data.user_id)) {
                    window.location.reload();
                }
            });
        });
    </script>
    @endpush
</x-layouts.admin>
