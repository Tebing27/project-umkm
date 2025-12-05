<x-maps.style />
<x-maps.popup />

<div class="hidden">
    <div id="icon-grid"><x-icons.svg name="arrow-down" class="w-full h-full" /></div>
    <div id="icon-food"><x-icons.svg name="location-food" class="w-full h-full" /></div>
    <div id="icon-fashion"><x-icons.svg name="location-fashion" class="w-full h-full" /></div>
    <div id="icon-work"><x-icons.svg name="location-work" class="w-full h-full" /></div>
</div>

<section id="lokasi" class="py-0 md:py-12 bg-white overflow-hidden" x-data="umkmMap" x-init="initMap()">
    <div class="container mx-auto max-w-7xl">
        <h1 class="text-center lg:text-center text-3xl md:text-4xl lg:text-5xl font-medium text-black mb-4 md:mb-8 lg:mb-16 tracking-tight pt-4 md:pt-0">
            Lokasi
        </h1>

        <div class="relative flex flex-col md:flex-row h-[90vh] md:h-[1002px] w-full md:w-[1281px] rounded-b-3xl overflow-hidden shadow-2xl bg-white border border-gray-200">

            <div class="absolute top-0 left-0 md:relative z-30 bg-[#003366] transition-all duration-500 ease-in-out flex-shrink-0 w-full md:h-full shadow-2xl md:shadow-none"
                :class="sidebarOpen ? 'translate-y-0 md:translate-y-0 md:w-[430px]' : '-translate-y-full md:translate-y-0 md:w-0 md:overflow-hidden'">

                <div class="w-full h-auto md:h-full flex flex-col gap-3 p-4 md:p-6"
                    :class="!sidebarOpen && window.innerWidth >= 768 ? 'opacity-0' : 'opacity-100'"
                    style="transition: opacity 0.2s ease-in-out;">

                    <div class="flex gap-2 relative z-40">
                        <div class="relative flex-1 shadow-sm md:shadow-none rounded-lg">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <x-icons.svg name="location-search" class="w-5 h-5" />
                            </span>
                            <input type="text" x-model="search" placeholder="Cari..."
                                class="w-full h-[40px] pl-10 pr-10 bg-white rounded-lg text-sm focus:outline-none text-gray-700 font-medium shadow-sm border border-gray-100">
                            <button x-show="search.length > 0" @click="search = ''"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <x-icons.svg name="location-search" class="w-5 h-5" />
                            </button>
                        </div>

                        <div class="relative w-[120px] flex-shrink-0" @click.outside="showRegionDropdown = false">
                            <button @click="showRegionDropdown = !showRegionDropdown"
                                :class="$store.region.selected !== '' ? 'bg-blue-50 text-[#003366]' : ''"
                                class="w-full h-[40px] bg-white text-gray-700 text-[12px] font-medium px-2.5 rounded-lg hover:bg-gray-50 transition whitespace-nowrap flex items-center justify-between gap-2 shadow-sm border border-gray-100 group">
                                <div class="flex items-center gap-1 overflow-hidden">
                                    <span class="truncate" x-text="$store.region.selected === '' ? 'Wilayah' : $store.region.selected"></span>
                                </div>
                                <x-icons.svg name="arrow-down"
                                    class="w-4 h-4 text-gray-400 group-hover:text-[#003366] transition-transform duration-200 flex-shrink-0"
                                    ::class="showRegionDropdown ? 'rotate-180 text-[#003366]' : ''" />
                            </button>

                            <div x-show="showRegionDropdown"
                                class="absolute top-full right-0 mt-1 w-[140px] bg-white rounded-lg shadow-xl z-[100] overflow-hidden border border-gray-100">
                                <div class="py-1">
                                    <a href="#" @click.prevent="$store.region.reset(); showRegionDropdown = false"
                                        class="group flex items-center gap-2 px-3 py-1.5 text-[12px] text-gray-700 hover:bg-blue-50 hover:text-[#003366] transition"
                                        :class="$store.region.selected === '' ? 'bg-blue-50 font-reguler text-[#003366]' : ''">
                                        <span>Semua</span>
                                    </a>
                                    <template x-for="region in regions" :key="region">
                                        <a href="#" @click.prevent="$store.region.set(region); showRegionDropdown = false"
                                            class="group flex items-center gap-2 px-3 py-1.5 text-[12px] text-gray-700 hover:bg-blue-50 hover:text-[#003366] transition"
                                            :class="$store.region.selected === region ? 'bg-blue-50 font-reguler text-[#003366]' : ''">
                                            <span x-text="region"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row gap-1.5 overflow-visible z-0 relative flex-shrink-0 w-full">
                        <div class="relative w-[28%] md:w-[30%] flex-shrink-0 z-20" @click.outside="showCatDropdown = false">
                            <button @click="showCatDropdown = !showCatDropdown"
                                :class="selectedCategory !== 'Semua' ? 'bg-blue-50 text-[#003366]' : ''"
                                class="w-full h-[36px] bg-white text-gray-700 text-[12px] font-medium px-2.5 rounded-lg hover:bg-gray-50 transition whitespace-nowrap flex items-center justify-center gap-2 shadow-md md:shadow-sm border border-transparent group">
                                <div class="flex items-center gap-1 overflow-hidden">
                                    <div class="w-4 h-4 flex-shrink-0" x-show="selectedCategory !== 'Semua'"
                                        :class="selectedCategory !== 'Semua' ? 'text-[#003366]' : 'text-gray-800'"
                                        x-html="getCategoryIcon(selectedCategory)">
                                    </div>
                                    <span class="truncate" x-text="selectedCategory === 'Semua' ? 'Semua' : selectedCategory"></span>
                                </div>
                                <x-icons.svg name="arrow-down"
                                    class="w-4 h-4 text-gray-400 group-hover:text-[#003366] transition-transform duration-200 flex-shrink-0"
                                    ::class="showCatDropdown ? 'rotate-180 text-[#003366]' : ''" />
                            </button>
                            <div x-show="showCatDropdown"
                                class="absolute top-full left-0 mt-1 w-[140px] bg-white rounded-lg shadow-xl z-[100] overflow-hidden border border-gray-100">
                                <div class="py-1">
                                    <template x-for="cat in categories" :key="cat">
                                        <a href="#" @click.prevent="selectedCategory = cat; showCatDropdown = false"
                                            class="group flex items-center gap-2 px-3 py-1.5 text-[12px] text-gray-700 hover:bg-blue-50 hover:text-[#003366] transition"
                                            :class="selectedCategory === cat ? 'bg-blue-50 font-reguler text-[#003366]' : ''">
                                            <div class="w-3.5 h-3.5" x-show="cat !== 'Semua'" x-html="getCategoryIcon(cat)"></div>
                                            <span x-text="cat"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-1 items-center flex-1 min-w-0 relative z-10">
                            <div class="relative flex-1 min-w-0 shadow-md md:shadow-none rounded-lg bg-white group hover:border-blue-300 border border-transparent transition h-[36px]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-[11px] font-bold text-gray-400">Rp</span>
                                </div>
                                <input type="text" x-model="minInput" placeholder="Min"
                                    class="w-full h-full py-1 pl-8 pr-2 rounded-lg text-[12px] focus:outline-none font-medium bg-transparent"
                                    :class="minInput !== '' ? 'text-black' : 'text-gray-700'">
                            </div>
                            <div class="text-gray-400 font-bold text-xs flex-shrink-0">-</div>
                            <div class="relative flex-1 min-w-0 shadow-md md:shadow-none rounded-lg bg-white group hover:border-blue-300 border border-transparent transition h-[36px]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-[11px] font-bold text-gray-400">Rp</span>
                                </div>
                                <input type="text" x-model="maxInput" placeholder="Max"
                                    class="w-full h-full py-1 pl-8 pr-2 rounded-lg text-[12px] focus:outline-none font-medium bg-transparent"
                                    :class="maxInput !== '' ? 'text-black' : 'text-gray-700'">
                            </div>
                        </div>
                    </div>

                    <div class="md:hidden flex items-center gap-2 mt-2 w-full">
                        <div class="flex-1 min-w-0">
                            <template x-for="item in paginatedList" :key="item.id">
                                <div class="bg-white rounded-xl p-3 h-[150px] shadow-sm animate-fade-in flex gap-3">
                                    <div class="w-[90px] h-full rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                                        <img :src="item.img" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <div class="flex-1 flex flex-col justify-between h-full py-0.5 min-w-0">
                                        <div>
                                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                <h3 class="text-base font-bold text-gray-800 leading-tight line-clamp-2" x-text="item.name"></h3>
                                                <span class="text-[10px] bg-yellow-400 px-2 py-0.5 rounded font-bold" x-text="item.badge"></span>
                                            </div>
                                            <div class="text-[11px]">
                                                <p class="font-medium">Omset: </p>
                                                <p class="font-reguler" x-text="item.omset"></p>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-center mt-2">
                                            <button @click="focusLocation(item)" class="text-[11px] flex items-center gap-1 group transition cursor-pointer hover:text-[#003366] px-3 py-1 rounded-md font-reguler w-fit">
                                                Lokasi <x-icons.svg name="area-right" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="filteredList.length === 0" class="text-center text-white/70 mt-4 text-sm w-full">Tidak ada data.</div>
                        </div>
                        <button @click="prevPage()" :disabled="currentPage === 1" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] shadow-lg border border-gray-100 active:scale-95 transition disabled:opacity-50 flex-shrink-0">
                            <x-icons.svg name="arrow-left" class="w-5 h-5" />
                        </button>
                        <button @click="nextPage()" :disabled="currentPage === totalPages" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] shadow-lg border border-gray-100 active:scale-95 transition disabled:opacity-50 flex-shrink-0">
                            <x-icons.svg name="arrow-right" class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="hidden md:flex flex-1 w-full flex-col items-stretch gap-4 overflow-y-auto custom-scrollbar pr-2 -mr-2 pl-1 py-2 min-h-[150px]">
                        <div class="flex-1 min-w-0 w-full flex flex-col gap-4">
                            <template x-for="item in paginatedList" :key="item.id">
                                <div class="bg-white rounded-xl p-3 md:p-4 h-[140px] md:h-[180px] hover:shadow-lg w-full shadow-sm animate-fade-in flex gap-3">
                                    <div class="w-[90px] md:w-[120px] h-full rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                                        <img :src="item.img" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <div class="flex-1 flex flex-col justify-between h-full py-0.5 min-w-0">
                                        <div>
                                            <div class="flex items-center gap-2 mb-2 flex-wrap md:mb-6">
                                                <h3 class="text-base md:text-lg font-bold text-gray-800 leading-tight line-clamp-2" x-text="item.name"></h3>
                                                <span class="text-xs bg-yellow-400 px-2 py-1 rounded-md font-medium" x-text="item.badge"></span>
                                            </div>
                                            <div class="text-[12px] md:text-[16px]">
                                                <p class="font-medium">Omset: </p>
                                                <p class="font-reguler" x-text="item.omset"></p>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-center mt-2">
                                            <button @click="focusLocation(item)" class="text-[11px] md:text-[14px] flex items-center gap-1 group transition cursor-pointer hover:text-[#003366] text-black bg-gray-100 px-3 py-1 rounded-md md:bg-transparent md:p-0 font-semibold md:font-normal w-fit">
                                                Lokasi <x-icons.svg name="area-right" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="filteredList.length === 0" class="text-center text-white/70 mt-4 text-sm w-full">Tidak ada data.</div>
                        </div>
                    </div>

                    <div class="hidden md:flex justify-center gap-4 items-center pb-0 pt-2 mt-auto">
                        <button @click="prevPage()" :disabled="currentPage === 1" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] transition border border-gray-100 shadow-md disabled:opacity-50">
                            <x-icons.svg name="arrow-down" class="w-6 h-6 -rotate-180" />
                        </button>
                        <span class="text-white text-xs font-bold tracking-wider"><span x-text="currentPage"></span> / <span x-text="totalPages"></span></span>
                        <button @click="nextPage()" :disabled="currentPage === totalPages" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] transition border border-gray-100 shadow-md disabled:opacity-50">
                            <x-icons.svg name="arrow-down" class="w-6 h-6" />
                        </button>
                    </div>

                    <div x-show="sidebarOpen" class="md:hidden absolute -bottom-6.5 left-1/2 transform -translate-x-1/2 z-50 flex gap-2 items-center">
                        <button @click="sidebarOpen = false" class="w-10 h-10 bg-[#FFC107] rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-yellow-400 text-[#003366] transition-transform hover:scale-105">
                            <x-icons.svg name="arrow-down" class="w-5 h-5 -rotate-180" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="relative flex-1 bg-gray-200 h-full w-full min-w-0">

                <div class="hidden md:flex absolute top-32 -left-4 z-50 transition-all duration-300" x-show="sidebarOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-x-5"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <button @click="sidebarOpen = false"
                        class="w-10 h-10 bg-[#FFC107] rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-yellow-400 text-[#003366] transition-transform hover:scale-110">
                        <x-icons.svg name="arrow-left" class="w-4.5 h-4.5" />
                    </button>
                </div>

                <div class="absolute top-4 md:top-6 left-1/2 transform -translate-x-1/2 z-[400]" x-show="!sidebarOpen" x-cloak>
                    <button @click="sidebarOpen = true"
                        class="group flex items-center gap-2 md:gap-3 bg-white pl-2 pr-4 py-1.5 md:pl-4 md:pr-5 md:py-2.5 rounded-full shadow-xl border border-gray-200/80 cursor-pointer">
                        <div class="w-7 h-7 md:w-8 md:h-8 bg-[#003366] rounded-full flex items-center justify-center text-white">
                            <x-icons.svg name="location-search" class="w-3.5 h-3.5 md:w-4 md:h-4" />
                        </div>
                        <div class="flex flex-col text-left">
                            <span class="text-[#003366] text-[11px] md:text-xs font-bold tracking-wider whitespace-nowrap">Cari Lokasi</span>
                        </div>
                    </button>
                </div>

                <div x-ref="mapContainer" class="w-full h-full outline-none z-10 bg-gray-100"></div>

                <div class="absolute bottom-4 md:bottom-8 right-8 flex flex-col bg-white rounded-md shadow-lg z-[400] overflow-hidden border border-gray-200">
                    <button @click="map.zoomIn()" class="w-8 h-8 flex items-center justify-center text-gray-600 border-b hover:bg-gray-50 text-xl font-bold">+</button>
                    <button @click="map.zoomOut()" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xl font-bold">-</button>
                </div>
            </div>
            
        </div> </div>
</section>
<x-maps.script />