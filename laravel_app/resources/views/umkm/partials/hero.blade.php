<div id="umkm-hero" class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-16 lg:mb-24 mt-8">

    <div class="flex flex-col justify-center pt-4">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 leading-tight">
            {{ $contents['umkm_index_title']->value ?? 'UMKM SASUMA.' }}
        </h1>
        <p class="text-slate-500 mb-10 max-w-md md:max-w-lg">
            {{ translate($contents['umkm_index_subtitle']->value ?? 'Temukan umkm sasuma yang ingin kamu kunjungi disetiap wilayah') }}
        </p>

        <div class="w-full lg:max-w-xl space-y-6">
            @include('umkm.partials.hero-search')
            
            {{-- Mobile Filter --}}
            <div class="flex md:hidden items-center gap-3 mt-4 relative z-20">
                {{-- Simplified Dropdown for Mobile --}}
                 <div class="relative shrink-0" x-data="{ open: false }" @click.outside="open = false">
                    <x-ui.button variant="filter" size="default" @click="open = !open"
                        x-bind:class="selectedLocation !== '' ? 'bg-[#00509D] text-white border-[#00509D]' :
                            'bg-white border-slate-200 text-slate-600'">
                        <x-icons.map-pin class="w-4 h-4" />
                        <span x-text="selectedLocation || '{{translate('Wilayah')}}'"></span>
                        <x-icons.ui-chevron-down class="w-3 h-3 transition-transform duration-200"
                            x-bind:class="open ? 'rotate-180' : ''" />
                    </x-ui.button>
                     <div x-show="open" x-transition.origin.top.left x-cloak
                        class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden py-1">
                        <div @click="selectedLocation = ''; open = false"
                            class="px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                            <span>{{translate('Semua')}}</span>
                            <x-icons.ui-check x-show="selectedLocation === ''" class="w-4 h-4 text-primary" />
                        </div>
                        @foreach($regions as $region)
                            <div @click="selectedLocation = '{{ $region }}'; open = false"
                                class="px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                                <span>{{ $region }}</span>
                                <x-icons.ui-check x-show="selectedLocation === '{{ $region }}'"
                                    class="w-4 h-4 text-primary" />
                            </div>
                        @endforeach
                    </div>
                 </div>
                 <div class="h-6 w-px bg-slate-200 shrink-0"></div>
                 {{-- Mobile Chips --}}
                  <div class="flex-1 overflow-x-auto no-scrollbar flex items-center gap-3 pr-4 -mr-4">
                    <template x-for="cat in [allLabel, ...{{ json_encode($businessTypes) }}]">
                        <x-ui.button variant="filter" size="chip"
                            @click="selectedCategory = (cat === allLabel ? '' : cat)" class="shrink-0"
                           x-bind:class="(selectedCategory === (cat === allLabel ? '' : cat) || (cat === allLabel && selectedCategory === '')) ?
                            'bg-[#00509D] bg-opacity-80 text-white' :
                            'bg-white border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                            <span x-text="cat"></span>
                        </x-ui.button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    @include('umkm.partials.hero-banner')
</div>

