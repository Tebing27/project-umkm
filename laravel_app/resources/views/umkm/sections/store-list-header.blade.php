<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 border-b border-slate-100 pb-6">
    <h2 class="text-2xl font-bold text-slate-900 shrink-0">{{translate('Daftar Toko')}}</h2>

    <div class="hidden md:flex flex-1 justify-center px-6 overflow-x-auto no-scrollbar"
    x-data="{ allLabel: '{{ translate('Semua') }}' }">

    <div class="flex items-center gap-2">
        <template x-for="cat in [allLabel, ...{{ json_encode($businessTypes) }}]">
            <button 
                @click="selectedCategory = (cat === allLabel ? '' : cat)"

                class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border whitespace-nowrap"
                :class="(selectedCategory === (cat === allLabel ? '' : cat) || (cat === allLabel && selectedCategory === '')) ?
                    'bg-[#004a85] text-white border-[#004a85] shadow-md' :
                    'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                <span x-text="cat"></span>
            </button>
        </template>
    </div>
</div>

    <div class="text-sm text-slate-500 shrink-0">
        {{translate('Menampilkan')}} <span x-text="paginatedItems.length" class="font-bold text-slate-900"></span>
        {{translate('dari')}} <span x-text="items.length" class="font-bold text-slate-900"></span> {{translate('toko')}}
    </div>
</div>
