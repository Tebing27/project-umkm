<div class="md:hidden flex items-center gap-2 mt-2 w-full">
    <div class="flex-1 min-w-0">
        <template x-for="item in paginatedList" :key="item.id">
            <div class="bg-white rounded-xl p-3 h-[110px] min-[360px]:h-[150px] shadow-sm animate-fade-in flex gap-3">
                
                <div
                    class="w-[80px] min-[360px]:w-[90px] h-full rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                    <img :src="item.img"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                
                <div class="flex-1 flex flex-col justify-between h-full py-0.5 min-w-0">
                    <div>
                        <div class="flex flex-col items-start gap-1 mb-2">
                            <h3 class="text-sm min-[360px]:text-base font-semibold text-gray-800 leading-tight line-clamp-2 min-[360px]:line-clamp-1"
                                x-text="item.name"></h3>
                            
                            <x-ui.badge 
                                x-text="item.badge" 
                                class="hidden min-[360px]:block px-2 py-1 truncate min-[360px]:max-[375px]:max-w-[110px]">
                            </x-ui.badge>
                        </div>
                        
                        <div class="text-sm hidden min-[360px]:block">
                            <p class="font-medium">{{ translate('Omset') }}: </p>
                            <p class="font-regular truncate" x-text="item.omset"></p>
                        </div>
                    </div>

                    <div class="w-full flex justify-start min-[360px]:justify-center items-center">
                        <x-ui.button @click="focusLocation(item)" variant="link" size="icon-link"
                            class="p-0 text-xs">
                            {{ translate('Lihat Lokasi') }}
                            <x-icons.ui-area-right class="w-3 h-3 min-[360px]:ml-1" />
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </template>
        <div x-show="filteredList.length === 0"
            class="text-center text-white/70 text-base w-full">{{ translate('Tidak ada data.') }}</div>
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