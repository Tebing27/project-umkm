<x-ui.card
    class="group rounded-2xl border-transparent shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full p-4 hover:border-gray-100 cursor-default">

    <div class="flex items-start gap-4 mb-3">
        <div class="w-14 h-14 shrink-0 rounded-full border border-slate-100 p-0.5 bg-white shadow-sm overflow-hidden">
            <img loading="lazy" :src="item.logo_url"
                class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500"
                :alt="item.name">
        </div>

        <div class="flex-1 min-w-0 flex flex-col justify-center gap-1">

            <div class="flex justify-between items-start gap-2">

                <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors leading-tight line-clamp-2"
                    x-text="item.name">
                </h3>

                <div class="flex items-center gap-0.5 text-xs font-medium text-slate-500 shrink-0 pt-0.5">
                    <x-icons.map-pin class="w-3.5 h-3.5 text-slate-400" />
                    <span class="truncate max-w-[80px] sm:max-w-[120px] text-right" x-text="item.location"></span>
                </div>
            </div>

            <div>
                <x-ui.badge x-text="item.category" class="px-2.5 py-1.5 mt-2"></x-ui.badge>
            </div>

        </div>
    </div>

    <div class="flex-1 mb-4 border-t border-gray-50 pt-2">
        <p class="text-base text-slate-600 font-medium line-clamp-1" x-text="item.product_type"></p>
    </div>

    <div class="flex justify-center text-sm items-center mt-auto">
        <x-ui.button href="#" x-bind:href="item.link" variant="link" size="icon-link">
            {{ translate('Lihat Toko') }}
            <x-icons.ui-area-right class="w-4 h-4 -ml-1" />
        </x-ui.button>
    </div>
</x-ui.card>
