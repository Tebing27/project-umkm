<x-ui.card
    class="group rounded-2xl border-transparent shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full p-5 hover:border-slate-100 cursor-default">

    <div class="flex items-start gap-4 mb-4">
        <div class="w-14 h-14 shrink-0 rounded-full border border-slate-100 bg-slate-50 overflow-hidden">
            <img :src="item.image"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                :alt="item.name">
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex justify-between items-center mb-1 gap-3">
                <div class="flex items-center gap-1 text-xs font-medium text-slate-500 flex-1 min-w-0">
                    <x-icons.map-pin class="!w-4.5 !h-4.5 text-primary shrink-0" />
                    <span class="truncate" x-text="item.location"></span>
                </div>
                <x-ui.badge x-text="item.category" class="px-2.5 py-1 shrink-0"></x-ui.badge>
            </div>
            <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors truncate"
                x-text="item.name"></h3>
        </div>
    </div>

    <div class="flex-1 mb-6 border-t border-slate-50 pt-3">
        <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed" x-text="item.desc">
        </p>
    </div>

    <div class="flex justify-center">
        <x-ui.button href="#" x-bind:href="item.link" variant="link" size="icon-link">
            {{translate('Lihat Lokasi')}}
            <x-icons.ui-area-right class="w-3 h-3" />
        </x-ui.button>
    </div>
</x-ui.card>
