@props(['regions'])
<div class="absolute top-0 left-0 md:relative z-30 bg-[#003366] transition-all duration-500 ease-in-out flex-shrink-0 w-full md:h-full shadow-2xl md:shadow-none"
    :class="sidebarOpen ? 'translate-y-0 md:translate-y-0 md:w-[430px]' :
        '-translate-y-full md:translate-y-0 md:w-0 md:overflow-hidden'">

    <div class="w-full h-auto md:h-full flex flex-col gap-3 p-4 md:p-6"
        :class="!sidebarOpen && window.innerWidth >= 768 ? 'opacity-0' : 'opacity-100'"
        style="transition: opacity 0.2s ease-in-out;">

        <x-home.location-section.sidebar.search-filter :regions="$regions" />

        <x-home.location-section.sidebar.mobile-section />

        <x-home.location-section.sidebar.desktop-list />

        <x-home.location-section.sidebar.desktop-pagination />

        <div x-show="sidebarOpen"
            class="md:hidden absolute -bottom-6.5 left-1/2 transform -translate-x-1/2 z-50 flex gap-2 items-center">
            <x-ui.button @click="sidebarOpen = false" variant="circle-yellow" size="icon-lg"
                class="hover:scale-105">
                <x-icons.ui-arrow-down class="w-5 h-5 -rotate-180" />
            </x-ui.button>
        </div>
    </div>
</div>
