<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <template x-for="product in displayedProducts" :key="product.id">
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 group flex flex-col">
            <div class="aspect-[4/3] sm:aspect-square bg-slate-100 relative overflow-hidden shrink-0">
                <img :src="product.image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" :alt="product.name">
                <span class="absolute top-3 left-3 px-2.5 py-1.5 bg-white/90 backdrop-blur-md rounded-lg text-[10px] font-bold uppercase tracking-wider text-slate-800 shadow-sm" x-text="product.category"></span>
            </div>
            <div class="p-5 flex flex-col flex-1 justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 text-lg line-clamp-1 group-hover:text-primary transition-colors mb-1" x-text="product.name"></h3>
                    <p class="text-base text-slate-500 line-clamp-2" x-text="product.variant"></p>
                </div>
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                    <div>
                        <p class="text-[12px] text-slate-400 font-bold tracking-wider mb-0.5">Harga</p>
                        <span class="font-extrabold text-slate-900 text-xl" x-text="product.price"></span>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <div x-show="filteredProducts.length === 0" x-cloak class="col-span-full text-center py-12">
        <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 inline-block">
            <p class="text-slate-900 mb-2">Produk "<span x-text="search" class="font-bold"></span>" tidak ditemukan.</p>
            <x-ui.button @click="resetAll" variant="link" class="text-primary font-bold hover:underline p-0 h-auto">Reset Semua Filter</x-ui.button>
        </div>
    </div>
</div>

<div class="mt-8 text-center" x-show="hasMore" x-cloak>
    <x-ui.button @click="loadMore" variant="outline" class="group flex items-center gap-2 mx-auto px-6 py-2.5 rounded-full border-slate-200 text-slate-900 font-bold text-base hover:border-primary hover:text-primary hover:bg-slate-50 transition-all duration-300 shadow-sm hover:shadow-md">
        <span>{{translate('Lihat Lebih Banyak')}}</span>
        <x-icons.ui-chevron-down class="w-5 h-5 group-hover:translate-y-0.5 transition-transform" />
    </x-ui.button>
</div>
