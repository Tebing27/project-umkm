<x-layouts.app :title="translate('Detail Toko - ' . $shop->name)" :hideNavigation="true" :shop="$shop">
    {{-- Section: Initialize Alpine Shop Detail --}}
    <div x-data="shopDetail({
        shop: @js($shop),
        formattedOmset: '{{ $formattedOmset }}',
        products: @js($productsData),
        categories: @js($productCategories),
        licenses: @js($licenses ?? []),
        defaultLabel: '{{ translate('Semua') }}'
    })" class="min-h-screen pb-20">
    {{-- End Section: Initialize Alpine Shop Detail --}}

        {{-- Section: Custom Navigation --}}
        <x-navigation-umkm/>
        {{-- End Section: Custom Navigation --}}

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            {{-- Section: Shop Header --}}
            @include('umkm.detail.partials._header')
            {{-- End Section: Shop Header --}}

            {{-- Section: Tabs Navigation --}}
            <div class="border-b border-gray-200 mb-6 flex space-x-8">
                <button @click="tab = 'toko'" class="pb-4 px-1 text-base font-bold transition-colors border-b-2"
                    :class="tab === 'toko' ? 'border-brand-blue-dark text-brand-blue-dark' :
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-gray-300'">
                    {{ translate('Toko') }}
                </button>
                <button @click="tab = 'produk'" class="pb-4 px-1 text-base font-bold transition-colors border-b-2"
                    :class="tab === 'produk' ? 'border-brand-blue-dark text-brand-blue-dark' :
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-gray-300'">
                    {{ translate('Produk') }}
                </button>
            </div>
            {{-- End Section: Tabs Navigation --}}

            {{-- Section: Tab Contents --}}
            <div>
                {{-- Tab: Toko --}}
                <div x-show="tab === 'toko'" x-transition.opacity>
                    @include('umkm.detail.partials._tab-shop')
                </div>

                {{-- Tab: Produk --}}
                <div x-show="tab === 'produk'" x-transition.opacity>
                    @include('umkm.detail.partials._products')
                </div>
            </div>
            {{-- End Section: Tab Contents --}}
        </main>
    </div>

    @push('scripts')
        {{-- Script logic moved to resources/js/pages/realtime-shop-detail.js --}}
    @endpush
</x-layouts.app>
