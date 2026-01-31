<x-layouts.guest :title="translate('Dashboard User - UMKM Sasuma')" :header-title="translate('Dashboard')" :header-subtitle="translate('Ringkasan Aktivitas')">
    <div x-data="dashboardStats({
        totalProducts: {{ $totalProducts }},
        activeProducts: {{ $activeProducts }},
        totalViews: {{ $totalViews ?? 0 }},
        productCategories: {{ $productCategories->toJson() }},
        shop: @js($shop),
        userId: {{ auth()->id() }},
        chartColors: @js($chartColors)
    })">
        {{-- Welcome Section --}}
        @include('users.dashboard.partials.welcome')
        @include('users.dashboard.partials.stats-card')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardStats', (initial) => ({
                stats: initial,
                cleanupListener: null,
                
                init() {
                    // Initialize Firebase Listener (Lazy Load)
                    if (this.stats.shop && this.stats.shop.id) {
                        import("{{ Vite::asset('resources/js/pages/realtime-dashboard.js') }}")
                            .then(module => {
                                this.cleanupListener = module.initVerificationListener(this.stats.shop.id, (data) => {
                                    this.refreshStats();
                                });
                            })
                            .catch(err => {});
                    }
                },
                
                destroy() {
                    if (this.cleanupListener) this.cleanupListener();
                },

                refreshStats() {
                    fetch(window.location.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.stats.totalProducts = data.totalProducts;
                        this.stats.activeProducts = data.activeProducts;
                        this.stats.totalViews = data.totalViews;
                        this.stats.productCategories = data.productCategories;
                        this.stats.shop = data.shop;
                    });
                }
            }));
        });
    </script>
    @endpush
</x-layouts.guest>
