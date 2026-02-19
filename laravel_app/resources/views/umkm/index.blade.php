<x-layouts.app :title="translate('Toko - UMKM Sasuma')">
    <x-navigation />

    {{-- Section: Main Content (AlpineJS Store App) --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20" x-data='storeApp(@json($shopsData))'>
        {{-- Section: Hero Banner --}}
        @include('umkm.partials._hero')
        {{-- End Section: Hero Banner --}}

        {{-- Section: Store List Header (Filters) --}}
        @include('umkm.partials._store-list-header')
        {{-- End Section: Store List Header (Filters) --}}

        {{-- Section: Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="store-list">
            <template x-for="item in paginatedItems" :key="item.id">
                @include('umkm.partials._store-card')
            </template>
        </div>
        {{-- End Section: Product Grid --}}

        {{-- Section: Empty State --}}
        <div x-show="paginatedItems.length === 0" class="text-center py-20" x-cloak>
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <x-icons.ui-search class="w-8 h-8 text-slate-400" />
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-1">{{translate('Tidak ada toko ditemukan')}}</h3>
            <p class="text-slate-500">{{translate('Coba kata kunci lain atau ubah filter pencarian Anda.')}}</p>
        </div>
        {{-- End Section: Empty State --}}

        {{-- Section: Pagination --}}
        <x-ui.pagination />
        {{-- End Section: Pagination --}}
    </main>
    {{-- End Section: Main Content (AlpineJS Store App) --}}
    @push('scripts')
    @endpush
</x-layouts.app>

