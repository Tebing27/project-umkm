<x-layouts.admin :title="translate('Manajemen Konten')" :header-title="translate('Manajemen Konten')"
    :header-subtitle="translate('Atur tampilan dan konten website')">

    <div x-data="{
        activeTab: '{{ request()->query('tab') ?? 'home_hero' }}',
        showLeftArrow: false, showRightArrow: false,
        checkScroll() {
            const el = this.$refs.tabContainer;
            if (el) {
                this.showLeftArrow = el.scrollLeft > 0;
                this.showRightArrow = el.scrollLeft < (el.scrollWidth - el.clientWidth - 5);
            }
        },
        init() {
            this.$nextTick(() => this.checkScroll());
            window.addEventListener('resize', () => this.checkScroll());
        }
}" class="w-full min-h-screen pb-24 bg-slate-50/50">

    @include('admin.content.partials.notifications')
    @include('admin.content.partials.tabs-nav')

    <div class="w-full max-w-7xl mx-auto mt-6">
        @foreach ($contents as $group => $items)
            <div x-show="activeTab === '{{ in_array($group, array_keys($tabs)) ? $group : 'other' }}'"
                class="space-y-8">

                
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-2xl font-bold text-slate-900">{{translate($tabs[$group]['label'] ?? 'Lainnya') }}</h2>
                    <p class="text-slate-500 text-base mt-1">{{translate('Kelola konten untuk bagian ini.')}}</p>
                </div>

                @include('admin.content.partials.tab-regions')
                @if($group !== 'logo' && $group !== 'business_types')
                @include('admin.content.partials.tab-standard')
                @endif
                @include('admin.content.partials.tab-featured')
                @if($group === 'business_types')
                    @include('admin.content.partials.tab-business-types')
                @endif
                @if($group === 'logo')
                    @include('admin.content.partials.tab-logo')
                @endif
            </div>
        @endforeach
    </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log("Global script loaded: Admin Content Index");
            console.log('Admin Content: Initializing Echo listener...');
            
            let attempts = 0;
            const maxAttempts = 120; // Increase to 60 seconds
            
            const checkEcho = setInterval(() => {
                attempts++;
                
                // Check if Echo is defined and fully initialized
                if (window.Echo && window.Echo.connector) {
                    clearInterval(checkEcho);
                    console.log(`Admin Content: Echo instance found after ${attempts} attempts. Subscribing...`);
                    
                    try {
                        // Subscribe to the public channel
                        const channel = window.Echo.channel('public-content');
                        
                        // Listen for the event (using standard namespace App.Events)
                        channel.listen('.ContentUpdated', (e) => {
                            console.log('Admin Content: Received ContentUpdated event:', e);
                            
                            // Visual feedback
                            const notification = document.createElement('div');
                            notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #0ea5e9; color: white; padding: 1rem; border-radius: 0.5rem; z-index: 9999; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);';
                            notification.textContent = 'Konten diperbarui, memuat ulang...';
                            document.body.appendChild(notification);
                            
                            setTimeout(() => {
                                console.log('Reloading page...');
                                window.location.reload();
                            }, 1500);
                        });

                        // Explicitly log subscription status using Pusher's binding if accessible
                        channel.on('pusher:subscription_succeeded', () => {
                            console.log('Admin Content: SUCCESSFULLY SUBSCRIBED to public-content');
                        });
                            
                        console.log('Admin Content: Channel subscription requested.');
                    } catch (error) {
                        console.error('Admin Content: Error subscribing to Echo channel:', error);
                    }
                } else if (attempts >= maxAttempts) {
                    clearInterval(checkEcho);
                    console.error('Admin Content: Timed out waiting for window.Echo. PLEASE REFRESH THE PAGE.');
                }
            }, 500);
        });
    </script>
    @endpush
</x-layouts.admin>

