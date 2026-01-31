<div class="bg-white p-2 border border-gray-200 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative z-30">
    <div class="flex items-center gap-2">
        {{-- Search Input --}}
        <div class="flex-1">
            <div class="relative group h-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <x-icons.map-pin-search class="h-5 w-5 text-slate-400" />
                </div>
                <div class="flex-1 h-full">
                    <x-ui.input variant="transparent" x-model="searchQuery" placeholder="{{translate('Cari Nama Toko...')}}"
                        class="!text-base font-medium placeholder-slate-400">
                        <x-slot:icon>
                            <x-icons.map-pin-search class="h-5 w-5 text-slate-400" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>

        {{-- Location Dropdown --}}
        <div class="relative hidden sm:block" x-data="{ open: false }" @click.outside="open = false">
            <x-ui.button variant="trigger" size="compact" @click="open = !open" type="button"
                class="min-w-[160px]">
                <div class="flex items-center gap-2">
                    <x-icons.map-pin class="w-4 h-4 text-slate-400" />
                    <span class="truncate max-w-[150px] text-base"
                        x-text="selectedLocation || '{{translate('Wilayah')}}'"></span>
                </div>
                <x-icons.ui-chevron-down class="w-4 h-4 text-slate-400 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </x-ui.button>
            {{-- Dropdown Menu --}}
            <div x-show="open" x-transition.origin.top x-cloak
                class="absolute top-full right-0 mt-4 w-56 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-gray-100 z-50 overflow-hidden py-1">
                <div @click="selectedLocation = ''; open = false"
                    class="px-5 py-3 text-base font-medium text-slate-600 hover:bg-gray-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                    <span>{{translate('Semua')}}</span>
                    <x-icons.ui-check x-show="selectedLocation === ''" class="w-4 h-4 text-primary" />
                </div>
                @foreach($regions as $region)
                    <div @click="selectedLocation = '{{ $region }}'; open = false"
                        class="px-5 py-3 text-base font-medium text-slate-600 hover:bg-gray-50 hover:text-primary cursor-pointer flex items-center justify-between transition-colors">
                        <span>{{ $region }}</span>
                        <x-icons.ui-check x-show="selectedLocation === '{{ $region }}'"
                            class="w-4 h-4 text-primary" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Search Button --}}
        <x-ui.button type="button" variant="default" size="icon"
            class="rounded-full w-10 h-10 bg-brand-yellow text-slate-900 shadow-sm min-w-[2.5rem] border-none outline-none">
            <x-icons.map-pin-search class="h-5 w-5 text-slate-900" />
        </x-ui.button>
    </div>
</div>
