@props(['regions'])
<div class="flex gap-2 relative z-40">
    <div class="relative flex-1 shadow-sm md:shadow-none rounded-lg">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <x-icons.map-pin-search class="w-5 h-5" />
        </span>
        <input type="text" x-model.debounce.500ms="search" placeholder="{{ translate('Cari Nama UMKM...') }}"
            class="w-full h-[40px] pl-10 pr-10 bg-white rounded-lg text-sm focus:outline-none text-gray-700 font-medium shadow-sm border border-gray-100">
        <button x-show="search.length > 0" @click="search = ''"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-500 w-auto">
            <x-icons.ui-close />
        </button>
    </div>

    <div class="relative w-[120px] flex-shrink-0" @click.outside="showRegionDropdown = false">
        <x-ui.button @click="showRegionDropdown = !showRegionDropdown" variant="dropdown-trigger"
            size="compact"
            x-bind:class="$store.region.selected !== '' ? 'bg-blue-50 text-[#003366]' : ''"
            class="w-full h-[40px] px-2.5">
            <div class="flex items-center gap-1 overflow-hidden">
                <span class="truncate text-sm md:text-sm"
                    x-text="$store.region.selected === '' ? '{{ translate('Wilayah') }}' : $store.region.selected"></span>
            </div>
            <x-icons.ui-arrow-down
                class="w-4 h-4 text-gray-400 group-hover:text-[#003366] transition-transform duration-200 flex-shrink-0"
                x-bind:class="showRegionDropdown ? 'rotate-180 text-[#003366]' : ''" />
        </x-ui.button>

        <div x-show="showRegionDropdown"
            class="absolute top-full right-0 mt-1 w-[140px] bg-white rounded-lg shadow-xl z-[9999] overflow-hidden border border-gray-100">
            <div class="py-1">
                <a href="#" @click.prevent="$store.region.reset(); showRegionDropdown = false"
                    class="group flex items-center gap-2 px-3 py-1.5 text-[12px] text-gray-700 hover:bg-blue-50 hover:text-[#003366] transition"
                    :class="$store.region.selected === '' ?
                        'bg-blue-50 font-reguler text-[#003366]' : ''">
                    <span>{{ translate('Wilayah') }}</span>
                </a>
                @foreach($regions as $region)
                    <a href="#"
                        @click.prevent="$store.region.set('{{ $region->name }}'); showRegionDropdown = false"
                        class="group flex items-center gap-2 px-3 py-1.5 text-[12px] text-gray-700 hover:bg-blue-50 hover:text-[#003366] transition"
                        :class="$store.region.selected === '{{ $region->name }}' ?
                            'bg-blue-50 font-reguler text-[#003366]' : ''">
                        <span>{{ $region->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="flex flex-row gap-1.5 overflow-visible z-[10] relative flex-shrink-0 w-full">
    <div class="relative w-[28%] md:w-[30%] flex-shrink-0 z-20"
        @click.outside="showCatDropdown = false">
        <x-ui.button @click="showCatDropdown = !showCatDropdown" variant="dropdown-trigger"
            size="compact"
            x-bind:class="(selectedCategory !== 'Semua' && selectedCategory !== '') ?
            'bg-blue-50 text-[#003366]' : ''"
            class="w-full h-[36px] px-2.5">
            <div class="flex items-center gap-1 overflow-hidden">
                <div class="w-4 h-4 flex-shrink-0"
                    x-show="selectedCategory !== 'Semua' && selectedCategory !== ''"
                    x-bind:class="(selectedCategory !== 'Semua' && selectedCategory !== '') ?
                    'text-[#003366]' : 'text-gray-800'"
                    x-html="getCategoryIcon(selectedCategory)">
                </div>
                <span class="truncate text-sm md:text-sm"
                    x-text="(selectedCategory === 'Semua' || selectedCategory === '') ? '{{ translate('Kategori') }}' : selectedCategory"></span>
            </div>
            <x-icons.ui-arrow-down
                class="w-4 h-4 text-gray-400 group-hover:text-[#003366] transition-transform duration-200 flex-shrink-0"
                x-bind:class="showCatDropdown ? 'rotate-180 text-[#003366]' : ''" />
        </x-ui.button>
        <div x-show="showCatDropdown"
            class="absolute top-full left-0 mt-1 w-[140px] bg-white rounded-lg shadow-xl z-[100] overflow-hidden border border-gray-100">
            <div class="py-1">
                <template x-for="(cat, idx) in categories" :key="idx">
                    <a href="#"
                        @click.prevent="selectedCategory = cat; showCatDropdown = false"
                        class="group flex items-center gap-2 px-3 py-1.5 text-[12px] text-gray-700 hover:bg-blue-50 hover:text-[#003366] transition"
                        :class="selectedCategory === cat ? 'bg-blue-50 font-reguler text-[#003366]' : ''">
                        <div class="w-3.5 h-3.5" x-show="cat !== '{{ translate('Kategori') }}' && cat !== 'Semua'"
                            x-html="getCategoryIcon(cat)"></div>
                        <span x-text="cat"></span>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <div class="flex gap-1 items-center flex-1 min-w-0 relative z-0">
        <div
            class="relative flex-1 min-w-0 shadow-md md:shadow-none rounded-lg bg-white group hover:border-blue-300 border border-transparent transition h-[36px]">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="text-[11px] font-bold text-gray-400">Rp</span>
            </div>
            <input type="text" x-model="minInput" placeholder="{{ translate('Min') }}"
                class="w-full h-full py-1 pl-8 pr-2 rounded-lg text-[12px] focus:outline-none font-medium bg-transparent"
                :class="minInput !== '' ? 'text-black' : 'text-gray-700'">
        </div>
        <div class="text-gray-400 font-bold text-xs flex-shrink-0">-</div>
        <div
            class="relative flex-1 min-w-0 shadow-md md:shadow-none rounded-lg bg-white group hover:border-blue-300 border border-transparent transition h-[36px]">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="text-[11px] font-bold text-gray-400">Rp</span>
            </div>
            <input type="text" x-model="maxInput" placeholder="{{ translate('Max') }}"
                class="w-full h-full py-1 pl-8 pr-2 rounded-lg text-[12px] focus:outline-none font-medium bg-transparent"
                :class="maxInput !== '' ? 'text-black' : 'text-gray-700'">
        </div>
    </div>
</div>
