<header class="fixed top-0 left-0 w-full z-50 transition-colors duration-300 outline-none border-none" 
    x-data="{ 
        scrolled: false,
        search: '',
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.pageYOffset > 20;
            });
        }
    }">

    <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-10 pt-4">
        {{-- Flex Container --}}
        <nav 
    :class="scrolled 
        ? 'bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/20 border-none' 
        : 'bg-transparent shadow-none border-transparent'"
    class="relative flex w-full items-center justify-between gap-3 rounded-lg p-3 md:p-4 md:rounded-2xl transition-all duration-500 ease-in-out border-none">
            
    {{-- 1. Left Section --}}
            <div class="flex items-center gap-3 md:gap-6 shrink-0 h-10">
                
                {{-- MOBILE: Back Button --}}
                <button onclick="history.back()" class="md:hidden text-slate-900 items-center justify-center">
                    <x-icons.ui-arrow-left class="w-6 h-6" />
                </button>

                {{-- DESKTOP: Logo --}}
                <a href="/" class="hidden md:inline-flex items-center gap-3 h-full">
                    @if (isset($logoShowImage) && $logoShowImage == '1' && $logoImage)
                        <img loading="lazy" src="{{ asset('storage/' . $logoImage) }}" alt="Sasuma Logo" class="h-10 w-auto object-contain">
                    @endif

                    @if (isset($logoShowText) && $logoShowText == '1')
                        <span class="text-xl md:text-2xl font-bold flex items-center h-full text-slate-900 tracking-tight">{{ $logoText }}</span>
                    @endif
                </a>

                {{-- DESKTOP: Beranda Link --}}
               <a href="/umkm"
            class="hidden md:flex h-auto self-center text-base font-medium text-slate-900 hover:text-black hover:no-underline transition-colors ml-2">
            {{ translate('Beranda') }}
        </a>
            </div>

            {{-- 2. Center: Search Bar --}}
            <div class="flex-1 max-w-full flex items-center md:max-w-3xl min-w-0">
                 <div class="relative w-full">
                    <x-ui.input variant="search" name="search" x-model="search" @input.debounce.300ms="$dispatch('search-update', $el.value)" @keydown.enter="$dispatch('search-submit', $el.value)" placeholder="{{translate('Cari produk...')}}">
                        <x-slot:icon>
                            <x-icons.map-pin-search class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>
            </div>

            {{-- 3. Right: Language Selector --}}
            <div class="flex items-center h-full">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 rounded-lg font-medium bg-yellow-400 hover:bg-yellow-500 py-2 px-2 border-none h-auto text-slate-900 shadow-sm transition-colors duration-300 focus:outline-none cursor-pointer">
                        @if (app()->getLocale() == 'id')
                            <img loading="lazy" src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-medium">ID</span>
                        @else
                            <img loading="lazy" src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-medium">EN</span>
                        @endif

                        <x-icons.ui-chevron-down x-bind:class="open ? 'rotate-180' : ''"
                            class="h-4 w-4 transition-transform duration-200" />
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-max min-w-[100px] rounded-lg shadow-lg bg-white p-1 z-50 border-none"
                        style="display: none;">

                        <a href="{{ route('switch_language', 'id') }}"
                            class="flex w-full items-center justify-start space-x-2 px-2 py-2 text-sm text-slate-900 hover:bg-yellow-400 rounded-md h-auto transition-colors">
                            <img loading="lazy" src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span>ID</span>
                        </a>

                        <a href="{{ route('switch_language', 'en') }}"
                            class="flex w-full items-center justify-start space-x-2 px-2 py-2 text-sm text-slate-900 hover:bg-yellow-400 rounded-md h-auto transition-colors">
                            <img loading="lazy" src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span>EN</span>
                        </a>
                    </div>
                </div>
            </div>

        </nav>
    </div>
</header>

{{-- Spacer --}}
<div class="h-24"></div>
