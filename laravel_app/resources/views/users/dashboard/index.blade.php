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
                
                init() {
                    let attempt = 0;
                    const waitForEcho = setInterval(() => {
                        attempt++;
                        if (window.Echo) {
                            clearInterval(waitForEcho);
                            
                            // Listen to private user channel
                            window.Echo.private(`private-user.${this.stats.userId}`)
                                .listen('UserUpdated', (e) => {
                                    console.log('User Updated, refreshing dashboard stats...', e);
                                    setTimeout(() => {
                                        this.refreshStats();
                                    }, 1000);
                                });

                            // Listen to admin-global for ShopUpdated (Verification status changes)
                            window.Echo.channel('admin-global')
                                .listen('ShopUpdated', (e) => {
                                    console.log('Shop Updated (Global), checking target...', e);
                                    if (e.shop_id && parseInt(e.shop_id) === this.stats.shop.id) {
                                       console.log('This shop updated! Refreshing...');
                                       setTimeout(() => {
                                            this.refreshStats();
                                        }, 1000);
                                    }
                                });

                        } else if (attempt > 20) {
                            clearInterval(waitForEcho);
                            console.error("Critical: Pusher Echo failed to load in Dashboard.");
                        }
                    }, 500);
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
