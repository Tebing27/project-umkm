<div
    class="hidden md:flex flex-1 w-full flex-col items-stretch gap-4 overflow-y-auto custom-scrollbar pr-2 -mr-2 pl-1 py-2 min-h-[150px]">
    <div class="flex-1 min-w-0 w-full flex flex-col gap-4">
        <template x-for="item in paginatedList" :key="item.id">
            <div
                class="bg-white rounded-xl p-3 md:p-4 h-[140px] md:h-[180px] hover:shadow-lg w-full shadow-sm animate-fade-in flex gap-3">
                <div
                    class="w-[90px] md:w-[120px] h-full rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                    <img :src="item.img"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <div class="flex-1 flex flex-col justify-between h-full py-0.5 min-w-0">
                    <div>
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <h3 class="text-xl font-bold text-gray-800 leading-tight line-clamp-1"
                                x-text="item.name"></h3>
                            <x-ui.badge x-text="item.badge" class="px-2.5 py-1.5"></x-ui.badge>
                        </div>
                        <div class="text-base">
                            <p class="font-medium">{{ translate('Omset') }}: </p>
                            <p class="font-reguler" x-text="item.omset"></p>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <x-ui.button @click="focusLocation(item)" variant="link" size="icon-link"
                            class="p-0 text-sm">
                            {{ translate('Lihat Lokasi') }}
                            <x-icons.ui-area-right class="w-3 h-3" />
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </template>
        <div x-show="filteredList.length === 0"
            class="text-center text-white/70 mt-4 text-base w-full">{{ translate('Tidak ada data.') }}</div>
    </div>
</div>
