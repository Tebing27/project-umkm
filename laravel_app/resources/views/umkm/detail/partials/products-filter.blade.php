<div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
    {{-- Judul --}}
    <div class="text-left w-full md:w-auto order-1 shrink-0">
        <h2 class="text-2xl font-bold text-slate-900">{{translate('Daftar Produk')}}</h2>
        <p class="text-base text-slate-500 mt-1 hidden md:block">
            {{translate('Kategori')}}: <span class="font-bold text-primary" x-text="category"></span>
        </p>
    </div>

    {{-- Filter Categories --}}
    <div class="w-full order-3 md:order-2 md:flex-1 md:mx-6 overflow-hidden">
        <div class="flex gap-2 overflow-x-auto scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0 md:justify-center items-center pb-2 md:pb-0">
            <template x-for="cat in categories" :key="cat">
                <button @click="setCategory(cat)" 
                    class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border whitespace-nowrap"
                    x-bind:class="category === cat 
                        ? 'bg-[#004a85] text-white border-[#004a85] shadow-md' 
                        : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                    <span x-text="cat"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Search Input --}}
    <div class="relative w-full md:w-72 order-2 md:order-3 shrink-0">
        <div class="absolute left-3 top-1/2 -translate-y-[46%] md:-translate-y-[54%] pointer-events-none text-slate-400">
            <x-icons.map-pin-search class="w-5 h-5" />
        </div>
        <x-ui.input variant="search" name="search" x-model="search" placeholder="{{translate('Cari produk...')}}">
            <x-slot:icon>
                <x-icons.map-pin-search class="w-5 h-5" />
            </x-slot:icon>
        </x-ui.input>
    </div>
</div>
