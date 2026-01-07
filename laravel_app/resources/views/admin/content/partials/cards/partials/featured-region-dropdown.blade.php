<div class="relative w-full">
    {{-- INPUT HIDDEN: Nilai yang dikirim ke server --}}
    <input type="hidden" name="shop_id" :value="selectedId">

    {{-- TRIGGER BUTTON --}}
    <button type="button" @click="open = !open"
        class="w-full h-[40px] px-3 bg-white border border-slate-200 rounded-lg shadow-sm flex items-center justify-between gap-2 hover:border-[#004a85] transition-colors group text-left"
        :class="open ? 'border-[#004a85] ring-1 ring-[#004a85]' : ''">

        <span class="truncate text-sm font-medium"
            :class="selectedId ? 'text-[#004a85]' : 'text-slate-600'"
            x-text="selectedName"></span>

        <x-icons.ui-arrow-down
            class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0"
            x-bind:class="open ? 'rotate-180 text-[#004a85]' : ''" />
    </button>

    {{-- DROPDOWN BODY --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0" style="display: none;"
        class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-xl border border-slate-100 z-[60] overflow-hidden max-h-[250px] flex flex-col">

        {{-- Search Filter --}}
        <div class="p-2 border-b border-slate-100 bg-slate-50 sticky top-0 z-10">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-[#004a85] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                
                <input type="text" x-model="filter" placeholder="{{ translate('Cari Nama Toko...') }}" x-ref="searchInput"
                    x-init="$watch('open', value => { if (value) $nextTick(() => $refs.searchInput.focus()) })"
                    class="w-full pl-9 pr-3 py-1.5 text-sm text-slate-700 bg-white border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#004a85] focus:border-[#004a85] placeholder:text-slate-400 shadow-sm">
            </div>
        </div>

        {{-- List Items --}}
        <div class="overflow-y-auto custom-scrollbar p-1">
            <div @click="selectedId = ''; selectedName = '{{ translate('Acak / Tidak Ada') }}'; open = false"
                class="cursor-pointer px-3 py-2 rounded-md text-sm hover:bg-slate-50 transition-colors flex items-center justify-between group"
                :class="selectedId === '' ? 'bg-blue-50/50 text-[#004a85] font-semibold' : 'text-slate-600'">
                <span>{{ translate('Acak / Tidak Ada') }}</span>
                <div x-show="selectedId === ''">
                    <x-icons.ui-check class="w-4 h-4 text-[#004a85]" />
                </div>
            </div>

            @foreach ($region->shops as $shop)
                <div @click="selectedId = '{{ $shop->id }}'; selectedName = '{{ addslashes($shop->name) }}'; open = false"
                    x-show="!filter || '{{ strtolower($shop->name) }}'.includes(filter.toLowerCase())"
                    class="cursor-pointer px-3 py-2 z-50 rounded-md text-sm hover:bg-blue-50 transition-colors flex items-center justify-between group mt-0.5"
                    :class="selectedId == '{{ $shop->id }}' ? 'bg-blue-50 text-[#004a85] font-semibold' : 'text-slate-700'">
                    <span class="truncate">{{ $shop->name }}</span>
                    <div x-show="selectedId == '{{ $shop->id }}'">
                        <x-icons.ui-check class="w-4 h-4 text-[#004a85]" />
                    </div>
                </div>
            @endforeach

            <div x-show="filter && $el.querySelectorAll('[x-show*=\'includes\']:not([style*=\'none\'])').length === 0"
                class="px-3 py-2 text-xs text-slate-400 text-center">
                {{ translate('Tidak ditemukan') }}
            </div>
        </div>
    </div>
</div>
