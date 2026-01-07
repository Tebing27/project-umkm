<x-layouts.app :title="translate('Toko - UMKM Sasuma')">
    <x-navigation />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20" x-data='storeApp(@json($shopsData))'>
        @include('umkm.partials.hero')

        @include('umkm.partials.store-list-header')

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="store-list">
            <template x-for="item in paginatedItems" :key="item.id">
                @include('umkm.partials.store-card')
            </template>
        </div>

        <div x-show="paginatedItems.length === 0" class="text-center py-20" x-cloak>
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                <x-icons.ui-search class="w-8 h-8 text-slate-400" />
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-1">{{translate('Tidak ada toko ditemukan')}}</h3>
            <p class="text-slate-500">{{translate('Coba kata kunci lain atau ubah filter pencarian Anda.')}}</p>
        </div>

        <x-ui.pagination />
    </main>
    @push('scripts')
    @endpush
</x-layouts.app>

