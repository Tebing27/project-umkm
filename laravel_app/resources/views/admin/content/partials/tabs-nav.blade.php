<div class="sticky top-[73px] lg:top-0 z-30 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
    <div class="relative max-w-7xl mx-auto">
        {{-- Fade Gradients --}}
        <div class="absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"
            x-show="showLeftArrow"></div>
        <div class="absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"
            x-show="showRightArrow"></div>

        {{-- Scroll Container --}}
        <div class="overflow-x-auto no-scrollbar snap-x scroll-smooth flex gap-3 pb-1" x-ref="tabContainer"
            @scroll.debounce.10ms="checkScroll()"
            style="scrollbar-width: none; -ms-overflow-style: none;">
            <style>
                .no-scrollbar::-webkit-scrollbar {
                    display: none;
                }
            </style>

            @foreach ($tabs as $key => $data)
                <a
                    href="?tab={{ $key }}"
                    class="shrink-0 snap-start flex items-center gap-2 px-4 py-2 rounded-full border text-base font-semibold whitespace-nowrap scroll-mt-4"
                    :class="activeTab === '{{ $key }}'
                        ?
                        'bg-[#004a85] text-white border-[#004a85] shadow-md' :
                        'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50'"
                    @if(request()->query('tab') === $key || (!request()->has('tab') && $key === 'home_hero'))
                        x-init="$el.scrollIntoView({ block: 'nearest', inline: 'center' })"
                    @endif
                    >
                    <span>
                        @if ($key === 'home_hero')
                            <x-icons.nav-home class="w-4 h-4" />
                        @elseif($key === 'home_wilayah')
                            <x-icons.map-pin class="w-4 h-4" />
                        @elseif($key === 'umkm_index')
                            <x-icons.shop-bag class="w-4 h-4" />
                        @else
                            <x-icons.ui-settings class="w-4 h-4" />
                        @endif
                    </span>
                    {{translate($data['label']) }}
                </a>
            @endforeach
        </div>
    </div>
</div>
