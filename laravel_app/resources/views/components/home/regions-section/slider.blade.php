<div class="w-full md:w-2/3 min-w-0">
    <div x-ref="slider"
        class="flex gap-6 overflow-x-auto pb-8 pt-2 snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:pl-4 lg:pr-4">
        <template x-for="(item, index) in items" :key="index">
            <div class="min-w-[260px] md:min-w-[320px] snap-center rounded-xl overflow-hidden flex flex-col transition-transform hover:scale-[1.02] duration-300 shadow-sm border border-gray-100/50"
                :class="item.color">
                <div class="px-6 pt-8 md:px-8 md:pt-12 pb-0 flex justify-center items-end h-48 md:h-64">
                    <img :src="item.image"
                        class="w-full h-full object-cover rounded-t-xl shadow-md object-center"
                        alt="Kategori Image" loading="lazy">
                </div>

                <div class="p-6 md:p-8 text-center flex flex-col items-center flex-grow bg-opacity-50">
                    <h3 class="text-2xl md:text-3xl font-bold text-black mb-1" x-text="item.title"></h3>
                    <p class="text-gray-700 text-sm mb-4 md:mb-6 font-medium" x-text="item.count"></p>

                    <div class="flex justify-center">
                        <x-ui.button
                            @click.prevent="$store.region.set(item.title); document.getElementById('location').scrollIntoView({behavior: 'smooth'})"
                            variant="link" size="icon-link" class="p-0 text-sm">
                            {{ translate('Lihat Lokasi') }}
                            <x-icons.ui-arrow-right class="w-4 h-4" />
                        </x-ui.button>

                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
