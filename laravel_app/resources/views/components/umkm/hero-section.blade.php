@props(['regions', 'content'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-16 lg:mb-24 mt-8">

    <div class="flex flex-col justify-center pt-4">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 leading-tight">
            {{ $content['umkm_index_title']->value ?? 'UMKM SASUMA.' }}
        </h1>
        <p class="text-slate-500 mb-10 max-w-md">
            {{ translate($content['umkm_index_subtitle']->value ?? 'Temukan umkm sasuma yang ingin kamu kunjungi disetiap wilayah') }}
        </p>

        <div class="w-full max-w-xl space-y-6">

            <!-- Search Bar & Location Combined -->
            <div
                class="flex items-center gap-2 bg-white p-2 border border-slate-200 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative z-30">

                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative group h-full">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-icons.location-search class="h-5 w-5 text-slate-400" />
                        </div>

                        <div class="flex-1 h-full">
                            <x-ui.input variant="transparent" x-model="searchQuery" placeholder="{{translate('Cari nama toko')}}"
                                class="text-sm font-medium placeholder-slate-400">
                                <x-slot:icon>
                                    <x-icons.location-search class="h-5 w-5 text-slate-400" />
                                </x-slot:icon>
                            </x-ui.input>

                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

                <!-- Location Dropdown -->
                <div class="relative hidden sm:block" x-data="{ open: false }" @click.outside="open = false">
                    <x-ui.button variant="trigger" size="compact" @click="open = !open" type="button"
                        class="min-w-[160px]">
                        <div class="flex items-center gap-2">
                            <x-icons.location class="w-4 h-4 text-slate-400" />
                            <span class="truncate max-w-[150px] text-sm"
                                x-text="selectedLocation || '{{translate('Semua Wilayah')}}'"></span>
                        </div>
                        <x-icons.chevron-down class="w-4 h-4 text-slate-400 transition-transform duration-200"
                            x-bind:class="open ? 'rotate-180' : ''" />
                    </x-ui.button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition.origin.top x-cloak
                        class="absolute top-full right-0 mt-4 w-56 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden py-1">
                        <div @click="selectedLocation = ''; open = false"
                            class="px-5 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                            <span>{{translate('Semua Wilayah')}}</span>
                            <x-icons.check x-show="selectedLocation === ''" class="w-4 h-4 text-primary" />
                        </div>
                        @foreach($regions as $region)
                            <div @click="selectedLocation = '{{ $region }}'; open = false"
                                class="px-5 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                                <span>{{ $region }}</span>
                                <x-icons.check x-show="selectedLocation === '{{ $region }}'"
                                    class="w-4 h-4 text-primary" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Search Button -->
                <x-ui.button type="button" variant="default" size="icon"
                    class="rounded-full w-10 h-10 bg-[#FFC107] text-slate-900 shadow-sm min-w-[2.5rem] border-none outline-none">
                    <x-icons.location-search class="h-5 w-5 text-slate-900" />
                </x-ui.button>
            </div>

            <div class="flex md:hidden items-center gap-3 mt-4 relative z-20">

                <div class="relative shrink-0" x-data="{ open: false }" @click.outside="open = false">

                    <x-ui.button variant="filter" size="default" @click="open = !open"
                        x-bind:class="selectedLocation !== '' ? 'bg-[#00509D] text-white border-[#00509D]' :
                            'bg-white border-slate-200 text-slate-600'">

                        <x-icons.location class="w-4 h-4" />
                        <span x-text="selectedLocation || '{{translate('Wilayah')}}'"></span>
                        <x-icons.chevron-down class="w-3 h-3 transition-transform duration-200"
                            x-bind:class="open ? 'rotate-180' : ''" />
                    </x-ui.button>

                    <div x-show="open" x-transition.origin.top.left x-cloak
                        class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden py-1">

                        <div @click="selectedLocation = ''; open = false"
                            class="px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                            <span>{{translate('Semua Wilayah')}}</span>
                            <x-icons.check x-show="selectedLocation === ''" class="w-4 h-4 text-primary" />
                        </div>
                        @foreach($regions as $region)
                            <div @click="selectedLocation = '{{ $region }}'; open = false"
                                class="px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                                <span>{{ $region }}</span>
                                <x-icons.check x-show="selectedLocation === '{{ $region }}'"
                                    class="w-4 h-4 text-primary" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="h-6 w-px bg-slate-200 shrink-0"></div>

                <div class="flex-1 overflow-x-auto no-scrollbar flex items-center gap-3 pr-4 -mr-4">
                    <template x-for="cat in ['Semua', 'Kuliner', 'Jasa', 'Retail', 'Fashion', 'Kerajinan']">
                        <x-ui.button variant="filter" size="chip"
                            @click="selectedCategory = (cat === 'Semua' ? '' : cat)" class="shrink-0"
                            x-bind:class="(selectedCategory === (cat === 'Semua' ? '' : cat) || (cat === 'Semua' &&
                                selectedCategory === '')) ?
                            'bg-[#00509D] bg-opacity-80 text-white' :
                            'bg-white border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                            <span x-text="cat"></span>
                        </x-ui.button>
                    </template>
                </div>

            </div>

        </div>
    </div>

    <div
        class="hidden md:block relative h-[400px] lg:h-[500px] w-full rounded-3xl overflow-hidden shadow-2xl shadow-primary/20 order-1 lg:order-2 group">
        <img src="{{ ($content['umkm_index_banner']->value ?? null) ? asset('storage/' . str_replace('\\', '/', $content['umkm_index_banner']->value)) : 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2574&auto=format&fit=crop' }}"
            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
            alt="Supermarket Shelf">
        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent"></div>

        <div class="absolute bottom-0 left-0 p-8">
            <div class="bg-white/90 backdrop-blur-sm p-4 rounded-2xl inline-block shadow-lg">
                <p class="text-primary font-bold text-lg">100+ UMKM</p>
                <p class="text-slate-600 text-sm">{{translate('Terdaftar di Sasuma')}}</p>
            </div>
        </div>
    </div>
</div>
