<div class="md:hidden flex flex-col gap-3 mt-2 w-full">
    <template x-for="item in paginatedList" :key="item.id">
        <div
            class="bg-white rounded-xl p-3 min-h-[120px] h-auto shadow-sm animate-fade-in flex gap-3 relative overflow-hidden">

            <div
                class="w-[90px] h-auto min-h-[100px] self-stretch rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                <img loading="lazy" :src="item.img"
                    class="w-full h-full object-cover absolute inset-0 transition-transform duration-500 group-hover:scale-110">
            </div>

            <div class="flex-1 flex flex-col justify-between min-w-0">
                <div class="flex flex-col gap-1.5">
                    <h3 class="text-lg max-[320px]:text-base font-bold text-slate-800 leading-tight line-clamp-2"
                        x-text="item.name"></h3>

                    <div class="flex flex-col items-start gap-1">
                        <x-ui.badge x-text="item.badge"
                            class="px-2 py-1.5 max-[320px]:px-1.5 max-[320px]:py-0.5 leading-tight truncate">
                        </x-ui.badge>

                        <div class="text-sm max-[320px]:text-xs text-slate-800 flex flex-col items-start gap-0.5 mt-1">
                            <p class="font-medium">{{ translate('Omset') }}:</p>
                            <p class="truncate font-medium" x-text="formatOmsetRange(item.omset_min, item.omset_max)">
                            </p>
                        </div>
                    </div>
                </div>

                <div class="w-full flex justify-center items-center mt-1">
                    <x-ui.button @click="focusLocation(item)" variant="link" size="icon-link"
                        class="p-0 text-sm max-[320px]:text-xs font-semibold h-auto hover:no-underline">
                        {{ translate('Lihat Lokasi') }}
                        <x-icons.ui-area-right class="w-3 h-3 ml-1" />
                    </x-ui.button>
                </div>
            </div>
        </div>
    </template>

    <div x-show="filteredList.length === 0" class="text-center text-slate-500 text-sm py-4 w-full">
        {{ translate('Tidak ada data.') }}
    </div>

    <div class="flex gap-2 justify-end items-center px-1">
        <x-ui.button variant="circle-white" size="icon-lg" @click="prevPage()" x-bind:disabled="currentPage == 1"
            class="flex-shrink-0 shadow-md border border-gray-100">
            <x-icons.ui-arrow-left class="w-5 h-5" />
        </x-ui.button>
        <x-ui.button variant="circle-white" size="icon-lg" @click="nextPage()"
            x-bind:disabled="currentPage == totalPages" class="flex-shrink-0 shadow-md border border-gray-100">
            <x-icons.ui-arrow-right class="w-5 h-5" />
        </x-ui.button>
    </div>
</div>
