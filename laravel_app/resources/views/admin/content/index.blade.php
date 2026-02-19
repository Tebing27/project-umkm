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
}" class="w-full min-h-screen pb-24 bg-gray-50/50">

    @include('admin.content.partials._notifications')
    @include('admin.content.partials._tabs-nav')

    <div class="w-full max-w-7xl mx-auto mt-6">
        @foreach ($contents as $group => $items)
            <div x-show="activeTab === '{{ in_array($group, array_keys($tabs)) ? $group : 'other' }}'"
                class="space-y-8">

                
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-2xl font-bold text-slate-900">{{translate($tabs[$group]['label'] ?? 'Lainnya') }}</h2>
                    <p class="text-slate-500 text-base mt-1">{{translate('Kelola konten untuk bagian ini.')}}</p>
                </div>

                @include('admin.content.partials._tab-regions')
                @if($group !== 'logo' && $group !== 'business_types')
                @include('admin.content.partials._tab-standard')
                @endif
                @include('admin.content.partials._tab-featured')
                @if($group === 'business_types')
                    @include('admin.content.partials._tab-business-types')
                @endif
                @if($group === 'logo')
                    @include('admin.content.partials._tab-logo')
                @endif
            </div>
        @endforeach
    </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let attempts = 0;
            const maxAttempts = 120;
            
            const checkEcho = setInterval(() => {
                attempts++;
                
                if (window.Echo && window.Echo.connector) {
                    clearInterval(checkEcho);
                    
                    try {
                        const channel = window.Echo.channel('public-content');
                        
                        channel.listen('.ContentUpdated', (e) => {
                            const notification = document.createElement('div');
                            notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #0ea5e9; color: white; padding: 1rem; border-radius: 0.5rem; z-index: 9999; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);';
                            notification.textContent = 'Konten diperbarui, memuat ulang...';
                            document.body.appendChild(notification);
                            
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        });

                    } catch (error) {
                    }
                } else if (attempts >= maxAttempts) {
                    clearInterval(checkEcho);
                }
            }, 500);
        });
    </script>
    @endpush
</x-layouts.admin>

