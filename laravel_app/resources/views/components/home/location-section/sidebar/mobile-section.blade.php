<div class="md:hidden flex items-center gap-2 mt-2 w-full">
    <div class="flex-1 min-w-0">
        <template x-for="item in paginatedList" :key="item.id">
            <div class="bg-white rounded-xl p-3 h-[150px] shadow-sm animate-fade-in flex gap-3">
                <div
                    class="w-[90px] h-full rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                    <img :src="item.img"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <div class="flex-1 flex flex-col justify-between h-full py-0.5 min-w-0">
                    <div>
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <h3 class="text-base font-semibold text-gray-800 leading-tight line-clamp-2"
                                x-text="item.name"></h3>
                            <x-ui.badge x-text="item.badge" class="px-2 py-1"></x-ui.badge>
                        </div>
                        <div class="text-[11px]">
                            <p class="font-medium">{{ translate('Omset') }}: </p>
                            <p class="font-reguler" x-text="item.omset"></p>
                        </div>
                    </div>
                    <div class="w-full flex justify-center mt-2">
                        <x-ui.button @click="focusLocation(item)" variant="link" size="icon-link"
                            class="p-0 text-[12px]">
                            {{ translate('Lihat Lokasi') }}
                            <x-icons.ui-area-right class="w-3 h-3" />
                        </x-ui.button>

                    </div>
                </div>
            </div>
        </template>
        <div x-show="filteredList.length === 0"
            class="text-center text-white/70 mt-4 text-sm w-full">{{ translate('Tidak ada data.') }}</div>
    </div>
    <x-ui.button variant="circle-white" size="icon-lg" @click="prevPage()"
        x-bind:disabled="currentPage == 1" class="flex-shrink-0">
        <x-icons.ui-arrow-left class="w-5 h-5" />
    </x-ui.button>
    <x-ui.button variant="circle-white" size="icon-lg" @click="nextPage()"
        x-bind:disabled="currentPage == totalPages" class="flex-shrink-0">
        <x-icons.ui-arrow-right class="w-5 h-5" />
    </x-ui.button>
</div>
