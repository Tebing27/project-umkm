<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 md:py-6">

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

        {{-- Sidebar Categories (Desktop Only) --}}
        <aside class="w-full lg:w-64 shrink-0 space-y-4 hidden lg:block">
            <div class="bg-white rounded-lg border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.05)] p-4">
                <h3 class="font-bold text-slate-900 mb-3">Etalase Toko</h3>
                <div class="max-h-[300px] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent">
                    <ul class="space-y-1">
                        <template x-for="cat in categories" :key="cat">
                            <li>
                                <x-ui.button @click="setCategory(cat)" variant="ghost" size="compact"
                                    class="w-full justify-start text-sm rounded-md font-medium transition-colors"
                                    x-bind:class="category === cat ? 'bg-gray-100 text-slate-900 font-bold' :
                                        'text-slate-600 hover:bg-gray-50'">
                                    <span class="text-left" x-text="cat === 'Semua' ? 'Semua Kategori' : cat"></span>
                                </x-ui.button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </aside>

        <main class="flex-1">

            {{-- Header & Sorting (Desktop Only) --}}
            <div class="hidden lg:flex sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h2 class="text-lg font-bold text-slate-900">Semua Produk</h2>

                <div class="flex items-center gap-3">
                    <p class="text-sm text-slate-700 font-bold min-w-fit">Urutkan</p>
                    <div class="relative" x-data="{ open: false }">
                            <x-ui.button @click="open = !open" @click.away="open = false" variant="dropdown-trigger"
                                class="min-w-[170px] justify-between h-[40px] px-3 shadow-none border border-slate-400 bg-white">
                                <span class="text-sm font-medium text-slate-700 text-left w-full truncate"
                                    x-text="sortBy === 'newest' ? 'Terbaru' : (sortBy === 'best_seller' ? 'Terlaris' : (sortBy === 'price_high' ? 'Harga Tertinggi' : 'Harga Terendah'))"></span>
                                <x-icons.ui-chevron-down class="w-4 h-4 ml-2 text-slate-700 transition-transform duration-200 shrink-0"
                                    ::class="open ? 'rotate-180' : ''" />
                            </x-ui.button>

                        <div x-show="open" x-cloak x-transition
                            class="absolute right-0 z-10 mt-1 w-full min-w-[170px] bg-white border border-slate-400 rounded-lg shadow-xl overflow-hidden py-1">
                            <button @click="sortBy = 'newest'; open = false"
                                class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-gray-50"
                                :class="sortBy === 'newest' ? 'font-semibold bg-gray-50' : ''">
                                Terbaru
                            </button>
                            <button @click="sortBy = 'best_seller'; open = false"
                                class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-gray-50"
                                :class="sortBy === 'best_seller' ? 'font-semibold bg-gray-50' : ''">
                                Terlaris
                            </button>
                            <button @click="sortBy = 'price_high'; open = false"
                                class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-gray-50"
                                :class="sortBy === 'price_high' ? 'font-semibold bg-gray-50' : ''">
                                Harga Tertinggi
                            </button>
                            <button @click="sortBy = 'price_low'; open = false"
                                class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-gray-50"
                                :class="sortBy === 'price_low' ? 'font-semibold bg-gray-50' : ''">
                                Harga Terendah
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Filter Bar (Mobile Only) --}}
            <div class="lg:hidden flex items-center gap-2 overflow-x-auto pb-4 -mx-4 px-4 scrollbar-hide mb-2">

                {{-- Sort Dropdown (Terbaru) --}}
                <div x-data="{ open: false }" class="relative shrink-0" @click.away="open = false">
                    <x-ui.button @click="open = !open" variant="outline" size="sm"
                        class="rounded-full flex items-center justify-between gap-2 h-9 px-3 shadow-none border border-slate-400 bg-white">
                        <span class="font-semibold text-slate-700 text-sm"
                            x-text="sortBy === 'newest' ? 'Terbaru' : (sortBy === 'best_seller' ? 'Terlaris' : (sortBy === 'price_high' ? 'Harga Tertinggi' : 'Harga Terendah'))"></span>
                        <x-icons.ui-chevron-down class="w-4 h-4 text-slate-700 transition-transform duration-200"
                            ::class="open ? 'rotate-180' : ''" />
                    </x-ui.button>

                    {{-- Bottom Sheet (No Backdrop) --}}
                    <div x-show="open" x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-y-full"
                        x-transition:enter-end="translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="translate-y-0"
                        x-transition:leave-end="translate-y-full"
                        class="fixed bottom-0 left-0 right-0 z-50 bg-white rounded-t-2xl shadow-[0_-4px_20px_-4px_rgba(0,0,0,0.15)] border-t border-gray-100 overflow-hidden pb-safe">
                        
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-slate-900 text-lg">Urutkan Produk</h3>
                            <button @click="open = false" class="p-1 rounded-full hover:bg-gray-100">
                                <x-icons.ui-close class="w-6 h-6 text-slate-500" />
                            </button>
                        </div>

                        <div class="p-2 space-y-1">
                            <button @click="sortBy = 'newest'; open = false"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-left transition-colors"
                                :class="sortBy === 'newest' ? 'bg-gray-100 text-slate-900 font-semibold' : 'text-slate-700 hover:bg-gray-50'">
                                <span>Terbaru</span>
                            </button>
                            <button @click="sortBy = 'best_seller'; open = false"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-left transition-colors"
                                :class="sortBy === 'best_seller' ? 'bg-gray-100 text-slate-900 font-semibold' : 'text-slate-700 hover:bg-gray-50'">
                                <span>Terlaris</span>
                            </button>
                            <button @click="sortBy = 'price_high'; open = false"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-left transition-colors"
                                :class="sortBy === 'price_high' ? 'bg-gray-100 text-slate-900 font-semibold' : 'text-slate-700 hover:bg-gray-50'">
                                <span>Harga Tertinggi</span>
                            </button>
                            <button @click="sortBy = 'price_low'; open = false"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-left transition-colors"
                                :class="sortBy === 'price_low' ? 'bg-gray-100 text-slate-900 font-semibold' : 'text-slate-700 hover:bg-gray-50'">
                                <span>Harga Terendah</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Category Dropdown (Etalase Toko) --}}
                <div x-data="{ open: false }" class="relative shrink-0" @click.away="open = false">
                    <x-ui.button @click="open = !open" variant="outline" size="sm"
                        class="rounded-full flex items-center justify-between gap-2 h-9 px-3 shadow-none border border-slate-400 bg-white">
                        <span class="font-semibold text-slate-700 text-sm" x-text="category === 'Semua' ? 'Etalase Toko' : category"></span>
                        <x-icons.ui-chevron-down class="w-4 h-4 text-slate-700 transition-transform duration-200"
                            ::class="open ? 'rotate-180' : ''" />
                    </x-ui.button>

                    {{-- Bottom Sheet (No Backdrop) --}}
                    <div x-show="open" x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-y-full"
                        x-transition:enter-end="translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="translate-y-0"
                        x-transition:leave-end="translate-y-full"
                        class="fixed bottom-0 left-0 right-0 z-50 bg-white rounded-t-2xl shadow-[0_-4px_20px_-4px_rgba(0,0,0,0.15)] border-t border-gray-100 overflow-hidden pb-safe max-h-[80vh] flex flex-col">
                        
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                            <h3 class="font-bold text-slate-900 text-lg">Pilih Etalase</h3>
                            <button @click="open = false" class="p-1 rounded-full hover:bg-gray-100">
                                <x-icons.ui-close class="w-6 h-6 text-slate-500" />
                            </button>
                        </div>

                        <div class="p-2 overflow-y-auto">
                            <template x-for="cat in categories" :key="cat">
                                <x-ui.button variant="ghost" size="compact" @click="setCategory(cat); open = false"
                                    class="w-full flex items-center !justify-between px-4 py-3 rounded-xl text-left transition-colors"
                                    x-bind:class="category === cat ? 'bg-gray-100 text-slate-900' : 'text-slate-700 hover:bg-gray-50'">
                                    <span x-text="cat === 'Semua' ? 'Semua Etalase' : cat"></span>
                                </x-ui.button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-5 gap-3 sm:gap-4">
                <template x-for="product in displayedProducts" :key="product.id">
                    <a :href="product.link" class="block h-full group">
                        <div class="h-full flex flex-col bg-white">
                            {{-- Image Section --}}
                            <div class="aspect-square relative overflow-hidden rounded-lg mb-2">
                                <img :src="toStorageUrl(product.image)"
                                    :srcset="toCloudinarySrcset(product.image)"
                                    sizes="(max-width: 640px) 50vw, (max-width: 1024px) 33vw, 200px"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    :alt="'Jual ' + product.name + ' di ' + shop.name + ' - Sasuma'" loading="lazy">
                                
                                {{-- Terlaris Badge --}}
                                <div x-show="product.is_best_seller" class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-br-lg shadow-sm">
                                    Terlaris
                                </div>
                            </div>

                            {{-- Content Section --}}
                            <div class="flex flex-col flex-1">
                                {{-- Title --}}
                                <h3 class="font-medium text-slate-900 text-sm line-clamp-2 leading-snug mb-1 transition-colors"
                                    x-text="product.name"></h3>

                                {{-- Price & Menu --}}
                                <div class="mt-auto flex items-end justify-between">
                                    <span class="font-bold text-slate-900 text-base" x-text="product.price"></span>
                                    
                                    {{-- Menu Dots --}}
                                    <button @click.prevent.stop="shareProduct(product)" class="text-slate-400 hover:text-slate-600 p-1" title="Bagikan">
                                        <x-icons.ui-share class="w-4 h-4 rotate-90" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            {{-- Empty State --}}
            <div x-show="filteredProducts.length === 0" x-cloak class="py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                    <x-icons.ui-search class="w-8 h-8 text-slate-400" />
                </div>
                <h3 class="text-lg font-medium text-slate-900">Tidak ada produk ditemukan</h3>
                <p class="text-slate-500 mt-1">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <div class="mt-6">
                    <x-ui.button class="rounded-lg" variant="outline" @click="resetAll">
                        Reset Filter
                    </x-ui.button>
                </div>
            </div>

            {{-- Load More --}}
            <div class="flex flex-col items-center justify-center pt-8 pb-12">
                <x-ui.button type="button" x-show="!isLoading && hasMore" @click="fetchProducts()"
                    variant="outline"
                    class="group flex items-center gap-2 mx-auto px-6 py-2.5 rounded-full border-gray-200 text-slate-900 font-bold text-base hover:border-primary hover:text-primary hover:bg-gray-50 transition-all duration-300 shadow-sm hover:shadow-md">

                    <span class="flex items-center gap-2">
                        <span>{{ translate('Lihat Lebih Banyak') }}</span>
                        <x-icons.ui-chevron-down class="w-5 h-5 group-hover:translate-y-0.5 transition-transform" />
                    </span>
                </x-ui.button>

                {{-- Empty State / All Loaded --}}
                <div x-show="!hasMore && !isLoading && page > 1" class="text-slate-400 text-sm font-medium mt-4">
                    {{ translate('Semua produk sudah ditampilkan') }}
                </div>
                
                {{-- Initial Loading --}}
                <div class="flex flex-col items-center justify-center pt-8" x-show="isLoading">
                     <x-icons.status-loading class="w-8 h-8 text-brand-blue-dark animate-spin" />
                </div>
            </div>

        </main>
    </div>
</div>
