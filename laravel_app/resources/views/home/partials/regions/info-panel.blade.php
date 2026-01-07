
<div class="w-full md:w-1/3 flex flex-col lg:sticky lg:left-0 lg:top-4">

    <div class="flex flex-col justify-between items-start w-full gap-4 mb-6 lg:mb-0">

        <div class="w-full px-4 sm:px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight mb-2 lg:mb-4">
                {{ translate($subtitle) }}
            </h2>
            <p class="text-gray-600 text-lg leading-relaxed text-balance">
                {{ translate($desc) }}
            </p>
        </div>

        <div class="flex gap-3 shrink-0 md:mt-8 w-full px-4 sm:px-6 justify-end">
            <x-ui.button @click="prev()" variant="primary"
                class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center p-0 transition-all shadow-lg active:scale-95 border-none p-0">
                <x-icons.ui-arrow-left class="w-4 h-4 md:w-5 md:h-5 shrink-0" />
            </x-ui.button>

            <x-ui.button @click="next()" variant="primary"
                class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center p-0 transition-all shadow-lg active:scale-95 border-none p-0">
                <x-icons.ui-arrow-right class="w-4 h-4 md:w-5 md:h-5 shrink-0" />
            </x-ui.button>
        </div>
    </div>
</div>
