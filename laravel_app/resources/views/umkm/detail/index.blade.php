<x-layouts.app :title="translate('Detail Toko - UMKM Sasuma')">
    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32" x-data="shopDetail({
        shop: @js($shop),
        products: @js($productsData),
        formattedOmset: '{{ $formattedOmset }}',
        licenses: @js($licenses),
        id: {{ $shop->id }}
    })">
        @include('umkm.detail.partials.card')
        @include('umkm.detail.partials.products')
    </main>

    @push('scripts')
        @if(isset($shop) && $shop->id)
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('shopDetail', (initial) => ({
                    shop: initial.shop,
                    products: initial.products,
                    formattedOmset: initial.formattedOmset,
                    licenses: initial.licenses,
                    
                    init() {
                        let attempt = 0;
                        const waitForEcho = setInterval(() => {
                            attempt++;
                            if (window.Echo) {
                                clearInterval(waitForEcho);
                                console.log("Echo found! Subscribing to shop detail...");
                                
                                window.Echo.channel('shops')
                                    .listen('ShopUpdated', (e) => {
                                        console.log('Shop Update Received:', e);
                                        if (e.shop_id == this.shop.id) {
                                            setTimeout(() => {
                                                this.refreshShop();
                                            }, 1000);
                                        }
                                    });
                            } else if (attempt > 20) {
                                clearInterval(waitForEcho);
                                console.error("Critical: Pusher Echo failed to load in Detail Page.");
                            }
                        }, 500);
                    },
                    
                    refreshShop() {
                        // Use Cache Busting for fresh data
                        const freshUrl = window.location.href + (window.location.href.includes('?') ? '&' : '?') + 't=' + new Date().getTime();
                        
                        fetch(freshUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.shop = data.shop;
                            this.products = data.products; // Update internal products state
                            this.formattedOmset = data.formattedOmset; 
                            this.licenses = data.licenses;
                            this.$dispatch('shop-data-updated', data);
                        });
                    }
                }));
            });
        </script>
        @endif
    @endpush
</x-layouts.app>

