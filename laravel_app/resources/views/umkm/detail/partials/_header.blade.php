<div class="mb-6">
    {{-- MOBILE LAYOUT (md:hidden) --}}
    <div class="md:hidden bg-white -mx-4 sm:-mx-6 -mt-6 mb-4">

        {{-- 2. Profile Info --}}
        <div class="px-4 py-4">
            <div class="flex items-start gap-4">
                {{-- Logo (Circle) --}}
                <div class="w-16 h-16 rounded-full border border-slate-100 p-0.5 shrink-0 bg-white shadow-sm overflow-hidden">
                    <img loading="lazy" :src="shop.logo_url" class="w-full h-full object-cover rounded-full" :alt="shop.name">
                </div>

                {{-- Info Column --}}
                <div class="flex-1 min-w-0 pt-1">
                    {{-- Name & Badge --}}
                    <div class="flex items-center gap-1.5 mb-1">
                        <h1 class="font-bold text-slate-900 text-lg leading-tight truncate" x-text="shop.name"></h1>
                    </div>

                    {{-- Info Row: Location & License --}}
                    <div class="flex flex-wrap items-center">
                        {{-- Region --}}
                        <template x-if="shop.region">
                             <x-ui.badge variant="outline" class="border-slate-200 text-slate-600 gap-1 py-1 bg-slate-50">
                                <x-icons.map-pin size="w-3.5 h-3.5" class="text-slate-400" />
                                <span x-text="shop.region.name"></span>
                            </x-ui.badge>
                        </template>
                        <span class="w-1 h-1 rounded-full bg-slate-400 mx-1"></span>
                        {{-- Product Count --}}
                        <div class="flex items-center gap-1 text-xs text-slate-500">
                            <span class="font-bold text-slate-900" x-text="products ? products.length : 0"></span>
                            <span>Produk</span>
                        </div>
                    </div>
                </div>
                
            </div>
             
             {{-- Extra Details & Chat Button Row --}}
             <div class="flex items-center gap-3 mt-2 pl-[80px]">
                 <x-ui.button class="flex-1 text-slate-700 px-3 py-1.5 rounded-lg text-sm font-bold">
                     Lihat Lokasi
                 </x-ui.button>
             </div>
        </div>
    </div>


    {{-- DESKTOP LAYOUT (Hidden on Mobile, Visible on md+) --}}
    <div class="hidden md:block rounded-2xl border-x border-b border-slate-200 transition-shadow duration-300 overflow-hidden mb-6">
        <div class="p-5 md:p-6 flex flex-col md:flex-row gap-5 items-start">
    
            {{-- 1. LOGO SECTION (Fixed size on mobile & desktop) --}}
            <div class="shrink-0 relative">
                <div
                    class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden shadow-inner">
                    <img loading="lazy" :src="shop.logo_url" class="w-full h-full object-cover" :alt="shop.name">
                </div>
            </div>
    
            {{-- 2. INFO SECTION --}}
            <div class="flex-1 min-w-0 w-full">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
    
                    {{-- Shop Details --}}
                    <div class="space-y-2">
                        {{-- Title & Category Badge --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-xl md:text-2xl font-bold text-slate-900 leading-tight" x-text="shop.name"></h1>
                            <x-ui.badge variant="outline" class="border-slate-200 text-slate-600 py-1 bg-slate-50">
                                <span x-text="shop.business_type"></span>
                            </x-ui.badge>
                        </div>
    
                        {{-- Licenses List (Cleaner look) --}}
                        <div class="flex items-center gap-1.5 text-slate-500 md:mt-4">
                            <x-icons.data-document class="w-4 h-4 mt-0.5 shrink-0" />
                            <div class="flex flex-wrap gap-1">
                                <template x-for="(license, index) in licenses" :key="license.type">
                                    <span class="text-base font-medium text-slate-600">
                                        <span x-text="license.type"></span><span
                                            x-show="index !== licenses.length - 1">,</span>
                                    </span>
                                </template>
                                {{-- Fallback if empty --}}
                                <span x-show="!licenses.length" class="text-sm italic text-slate-400">
                                    {{ translate('Belum ada izin usaha') }}
                                </span>
                            </div>
                        </div>
                    </div>
    
                    {{-- 3. STATS CARD (Mobile: Full width below info, Desktop: Right side box) --}}
                    <div
                        class="bg-slate-50 rounded-xl p-3 md:p-4 border border-slate-100 flex items-center gap-3 md:min-w-[180px]">
                        <div class="p-2 bg-white rounded-lg border border-slate-100 text-primary shadow-sm">
                            <x-icons.shop-bag class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                {{ translate('Total Produk') }}</p>
                            <p class="text-slate-900 font-bold text-base">
                                <span x-text="products ? products.length : 0"></span>
                                <span class="text-xs font-normal text-slate-500">{{ translate('Produk') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
    
                {{-- 4. ACTION BUTTONS --}}
                <div class="pt-4 flex flex-col sm:flex-row gap-3">
                    <x-ui.button
                        href="#"
                        x-bind:href="`https://www.google.com/maps/dir/?api=1&destination=${shop.latitude},${shop.longitude}`"
                        target="_blank" class="w-full sm:w-auto h-0 py-5 rounded-lg gap-2">
                        <x-icons.map-pin class="w-4 h-4" />
                        {{ translate('Lihat Peta') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
