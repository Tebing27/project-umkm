<div class="relative flex-1 bg-gray-200 h-full w-full min-w-0">

    <div class="hidden md:flex absolute top-32 -left-4 z-45 transition-all duration-300" x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-5"
        x-transition:enter-end="opacity-100 translate-x-0">
        <x-ui.button size="icon-lg" variant="circle-yellow" @click="sidebarOpen = false" class="hover:scale-110">
            <x-icons.ui-arrow-left class="w-4.5 h-4.5" />
        </x-ui.button>

    </div>

    <div class="absolute top-4 md:top-6 left-1/2 transform -translate-x-1/2 z-40" x-show="!sidebarOpen" x-cloak>

        <x-ui.button @click="sidebarOpen = true" variant="pill-white" size="compact"
            class="gap-2 md:gap-3 pl-2 pr-4 py-1.5 md:pl-4 md:pr-5 md:py-2.5">
            <div class="w-7 h-7 md:w-8 md:h-8 bg-brand-navy rounded-full flex items-center justify-center text-white">
                <x-icons.map-pin-search class="w-3.5 h-3.5 md:w-4 md:h-4" />
            </div>
            <div class="flex flex-col text-left">
                <span
                    class="text-brand-navy text-base font-bold tracking-wider whitespace-nowrap">{{ translate('Cari Lokasi') }}</span>
            </div>
        </x-ui.button>
    </div>

    <div x-ref="mapContainer" class="w-full h-full outline-none z-10 bg-gray-100"></div>

    <div
        class="absolute bottom-4 md:bottom-8 right-8 flex flex-col bg-white rounded-md shadow-lg z-[400] overflow-hidden border border-gray-200">
        <x-ui.button @click="map.zoomIn()" variant="map-control" size="map-ctrl">
            <x-icons.ui-plus />
        </x-ui.button>
        <x-ui.button @click="map.zoomOut()" variant="map-control" size="map-ctrl">
            <x-icons.ui-minus />
        </x-ui.button>
    </div>
</div>
