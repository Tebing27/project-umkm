<section class="w-full min-h-screen bg-[#0a3c78] pt-34 pb-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-12">
            <div class="text-white flex flex-col justify-center space-y-2 lg:pt-24">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                    {{ $title }}
                </h1>
                <p class="text-lg md:text-xl opacity-90 leading-relaxed">
                   {{ translate($desc) }}
                </p>
            </div>

            <div
                class="flex justify-center md:justify-end order-2 md:order-none lg:justify-end order-2 lg:order-none lg:row-span-2">
                <img src="{{ $image }}"
                    class="rounded-lg shadow-2xl w-full max-w-md h-[188px] sm:h-80 md:h-[550px] object-cover" />
            </div>

            <div class="order-3 lg:order-none max-w-7xl md:col-span-2 lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6"
                    x-data="{
                        currentIndex: 0,
                        items: {{ json_encode($items) }},
                    }">
                    <div class="flex-1 space-y-1">
                        <p class="text-base font-medium text-gray-600" x-text="'UMKM SASUMA - ' + items[currentIndex].region.toUpperCase()">
                        </p>
                        <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-2">
                            <span x-text="items[currentIndex].title"></span>
                            <x-ui.badge x-text="items[currentIndex].category" class="px-2.5 py-1.5"></x-ui.badge>
                        </h2>
                        <p class="text-gray-600 text-base" x-text="items[currentIndex].product_type"></p>
                        <p class="text-gray-800 font-semibold text-base"
                            x-text="'Omset Penjualan - ' + items[currentIndex].sales"></p>

                        <div class="hidden sm:flex justify-center">
                            <x-ui.button variant="link" size="icon-link">
                                {{ translate('Lihat Lokasi') }}
                                <x-icons.ui-arrow-right class="w-2 h-2" />
                            </x-ui.button>
                        </div>
                    </div>

                    <div class="flex-shrink-0 relative w-full sm:w-48 md:w-72 lg:w-48 h-32 md:w-48 lg:h-32">
                        <img x-bind:src="items[currentIndex].image"
                            class="w-full h-full object-cover rounded-lg shadow-md" alt="Gambar Produk UMKM" />

                        <x-ui.button x-on:click="currentIndex = (currentIndex - 1 + items.length) % items.length"
                            class="absolute top-1/2 -translate-y-1/2 -left-4 sm:left-0 sm:-translate-x-4 bg-blue-600 text-white p-2 rounded-full opacity-85 hover:opacity-100 hover:bg-blue-700 flex items-center justify-center shadow-md border-none transition-all"
                            size="icon">
                            <x-icons.ui-arrow-left />
                        </x-ui.button>

                        <x-ui.button x-on:click="currentIndex = (currentIndex - 1 + items.length) % items.length"
                            class="absolute top-1/2 -translate-y-1/2 -right-4 sm:right-0 sm:translate-x-4 bg-blue-600 text-white p-2 rounded-full opacity-85 hover:opacity-100 hover:bg-blue-700 w-8 h-8 flex items-center justify-center shadow-md border-none transition-all"
                            size="icon">
                            <x-icons.ui-arrow-right />
                        </x-ui.button>

                    </div>
                    <div class="w-full block sm:hidden -mt-2">
                        <div class="flex justify-center">
                            <x-ui.button variant="link" size="icon-link">
                                {{ translate('Lihat Lokasi') }}
                                <x-icons.ui-arrow-right class="w-2 h-2" />
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>