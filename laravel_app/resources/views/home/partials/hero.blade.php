<section id="hero-section" class="w-full min-h-screen bg-[#0a3c78] pt-28 md:pt-34 pb-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-12">
            <div class="text-white flex flex-col justify-center space-y-6 lg:pt-24">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                    {{ $title }}
                </h1>
                <p class="text-lg md:text-xl opacity-90 leading-relaxed">
                    {{ translate($desc) }}
                </p>
            </div>

            <div
                class="flex justify-center md:justify-end order-2 md:order-none lg:justify-end order-2 lg:order-none lg:row-span-2">
                <img loading="lazy" src="{{ $image }}"
                    srcset="{{ cloudinary_srcset($image) }}"
                    sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                    class="rounded-lg shadow-2xl w-full max-w-md h-48 sm:h-80 md:h-[550px] object-cover" />
            </div>

            <div class="order-3 lg:order-none max-w-7xl md:col-span-2 lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6"
                    x-data="{
                        currentIndex: 0,
                        items: {{ json_encode($items) }},
                    }">
                    <div class="flex-1 space-y-1">
                        <p class="text-sm md:text-base font-medium text-slate-600"
                            x-text="'UMKM SASUMA - ' + items[currentIndex].region.toUpperCase()">
                        </p>

                        <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                            <h2 class="text-xl md:text-2xl font-semibold text-slate-900 flex items-center gap-2">
                                <span x-text="items[currentIndex].title"></span>
                            </h2>
                            <x-ui.badge x-text="items[currentIndex].category" class="px-2.5 py-1.5"></x-ui.badge>
                        </div>

                        <p class="text-slate-600 text-base md:text-lg font-medium mt-2" x-text="items[currentIndex].product_type"></p>
                        <p class="text-slate-900 font-semibold text-base md:text-lg mt-1"
                            x-text="'Omset Penjualan - ' + items[currentIndex].sales"></p>

                        <div class="hidden md:flex justify-center">
                            <x-ui.button variant="link" size="icon-link">
                                {{ translate('Lihat Lokasi') }}
                                <x-icons.ui-arrow-right class="w-2 h-2" />
                            </x-ui.button>
                        </div>
                    </div>

                    <div class="flex-shrink-0 relative w-full sm:w-48 md:w-72 lg:w-48 h-32 lg:h-32">
                        <img x-bind:src="items[currentIndex].image"
                            x-bind:srcset="items[currentIndex].srcset"
                            sizes="(max-width: 640px) 100vw, 200px"
                            class="w-full h-full object-cover rounded-lg shadow-md"
                            x-bind:alt="items[currentIndex].title + ' - ' + items[currentIndex].category + ' - Sasuma'"
                            loading="lazy" />

                        <x-ui.button variant="primary"
                            x-on:click="currentIndex = (currentIndex - 1 + items.length) % items.length"
                            class="absolute top-1/2 -translate-y-1/2 -left-4 sm:left-0 sm:-translate-x-4 p-2 rounded-full flex items-center justify-center shadow-md border-none transition-all"
                            size="icon">
                            <x-icons.ui-arrow-left />
                        </x-ui.button>

                        <x-ui.button variant="primary"
                            x-on:click="currentIndex = (currentIndex + 1 + items.length) % items.length"
                            class="absolute top-1/2 -translate-y-1/2 -right-4 sm:right-0 sm:translate-x-4 p-2 rounded-full w-8 h-8 flex items-center justify-center shadow-md border-none"
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
