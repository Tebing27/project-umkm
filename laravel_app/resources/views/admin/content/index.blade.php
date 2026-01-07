<x-layouts.admin :title="translate('Manajemen Konten')" :header-title="translate('Manajemen Konten')"
    :header-subtitle="translate('Atur tampilan dan konten website')">

    <div x-data="{
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'home_hero',
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
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-8">

                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-2xl font-bold text-slate-900">{{translate($tabs[$group]['label'] ?? 'Lainnya') }}</h2>
                    <p class="text-slate-500 text-base mt-1">{{translate('Kelola konten untuk bagian ini.')}}</p>
                </div>

                @include('admin.content.partials.tab-regions')
                @include('admin.content.partials.tab-standard')
                @include('admin.content.partials.tab-featured')
            </div>
        @endforeach
    </div>
    </div>
</x-layouts.admin>

