<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 border-b border-gray-100 pb-6">
    <h2 class="text-2xl font-bold text-slate-900 shrink-0">{{translate('Daftar Toko')}}</h2>

    <div class="flex-1 w-full md:w-auto min-w-0 overflow-x-auto no-scrollbar mx-0 md:mx-6">
        <div class="flex items-center gap-2 pb-2 md:pb-0">
            <template x-for="cat in [allLabel, ...{{ json_encode($businessTypes) }}]">
                <button 
                    @click="selectedCategory = (cat === allLabel ? '' : cat)"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition-colors duration-200 border whitespace-nowrap shrink-0"
                    x-bind:class="(selectedCategory === (cat === allLabel ? '' : cat) || (cat === allLabel && selectedCategory === '')) ?
                        'bg-brand-blue-dark text-white border-brand-blue-dark shadow-md' :
                        'bg-white text-slate-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
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
