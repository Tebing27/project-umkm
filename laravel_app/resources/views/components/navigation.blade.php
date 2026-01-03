<header class="fixed top-0 left-0 w-full z-50 transition-colors duration-300" x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">

    <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-10 pt-4">
        <nav :class="scrolled ? 'bg-white/80 backdrop-blur-md border-none' :
            'bg-white border-none'"
            class="relative flex w-full items-center justify-between rounded-lg p-3 md:p-4 md:rounded-2xl transition-colors duration-300 border-none">

            <a href="#" class="shrink-0 inline-flex items-center gap-4">
                <span class="text-4xl md:text-3xl font-bold items-center text-slate-900">Logo</span>
            </a>

            <div class="hidden md:flex flex-1 justify-center items-center space-x-4 md:space-x-5 lg:space-x-8">
                <a href="#"
                    class="text-lg font-reguler hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('Beranda') }}</a>
                <a href="#wilayah"
                    class="text-lg font-reguler hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('Wilayah') }}</a>
                <a href="#lokasi"
                    class="text-lg font-reguler hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('Lokasi') }}</a>
                <a href="/umkm"
                    class="text-lg font-reguler hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('UMKM') }}</a>
            </div>

            <div class="hidden md:flex shrink-0 items-center space-x-2 md:space-x-3 lg:space-x-4">

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 px-3 py-3 rounded-lg font-reguler bg-yellow-400 hover:bg-yellow-500 md:py-2 md:px-2 border-none h-auto text-slate-900 shadow-sm transition-colors duration-300 focus:outline-none cursor-pointer">
                        @if(app()->getLocale() == 'id')
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-reguler">ID</span>
                        @else
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-reguler">EN</span>
                        @endif

                        <x-icons.chevron-down x-bind:class="open ? 'rotate-180' : ''"
                            class="h-4 w-4 transition-transform duration-200" />
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-40 rounded-lg shadow-lg bg-white p-1 z-50 border-none"
                        style="display: none;">
                        
                        @if(app()->getLocale() == 'id')
                        <a href="{{ route('switch_language', 'en') }}"
                            class="flex w-full items-center justify-start space-x-2 px-4 py-2 text-sm text-gray-900 hover:bg-yellow-400 rounded-md h-auto transition-colors">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span>EN</span>
                        </a>
                        @else
                        <a href="{{ route('switch_language', 'id') }}"
                            class="flex w-full items-center justify-start space-x-2 px-4 py-2 text-sm text-gray-900 hover:bg-yellow-400 rounded-md h-auto transition-colors">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span>ID</span>
                        </a>
                        @endif
                    </div>
                </div>

                @auth
                    <x-ui.button href="{{ route('dashboard') }}"
                        class="bg-yellow-400 text-slate-900 rounded-lg hover:bg-yellow-500 md:py-2 md:px-6 lg:px-8 lg:py-2 text-xl font-reguler h-auto">
                        {{ translate('Dashboard') }}
                    </x-ui.button>
                @else
                    <x-ui.button href="{{ route('register') }}"
                        class="bg-yellow-400 text-slate-900 rounded-lg hover:bg-yellow-500 md:py-2 md:px-6 lg:px-8 lg:py-2 text-xl font-reguler h-auto">
                        {{ translate('Daftar') }}
                    </x-ui.button>
                @endauth
            </div>

            <div class="md:hidden" x-data="{ open: false }">
                <x-ui.button @click="open = !open" variant="ghost" size="icon"
                    class="text-slate-800 hover:bg-transparent h-auto">
                    <x-icons.menu x-show="!open" class="w-6 h-6" />
                    <x-icons.x-mark x-show="open" style="display: none;" class="w-6 h-6" />
                </x-ui.button>

                <div x-show="open" @click.away="open = false" @scroll.window="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute top-[4.5rem] right-0 w-52 z-50" style="display: none;">

                    <div class="rounded-xl bg-white shadow-sm border-none p-6 space-y-0.5 text-center">

                        <a href="#"
                            class="block w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 h-auto transition-colors">
                            {{ translate('Beranda') }}
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 h-auto transition-colors">
                            {{ translate('Wilayah') }}
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 h-auto transition-colors">
                            {{ translate('Lokasi') }}
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 h-auto transition-colors">
                            {{ translate('UMKM') }}
                        </a>

                        <div x-data="{ open: false }" class="!mb-4 !mt-6">
                            <x-ui.button @click="open = !open" size="sm"
                                class="flex items-center mx-auto rounded-lg font-reguler bg-yellow-400 hover:bg-yellow-500 h-[40px] min-w-[80px] border-none text-slate-900 transition-colors">
                                @if(app()->getLocale() == 'id')
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-reguler">ID</span>
                        @else
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-reguler">EN</span>
                        @endif
                                <x-icons.chevron-down x-bind:class="open ? 'rotate-180' : ''"
                            class="h-4 w-4 transition-transform duration-200" />
                            </x-ui.button>


                            <div x-show="open" x-transition class="pl-5 pt-2 space-y-2 text-center cursor-pointer">
                                 @if(app()->getLocale() == 'id')
                        <a href="{{ route('switch_language', 'en') }}"
                            class="flex w-full items-center justify-start space-x-2 px-4 py-2 text-sm text-gray-900 hover:bg-yellow-400 rounded-md h-auto transition-colors">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span>EN</span>
                        </a>
                        @else
                        <a href="{{ route('switch_language', 'id') }}"
                            class="flex w-full items-center justify-start space-x-2 px-4 py-2 text-sm text-gray-900 hover:bg-yellow-400 rounded-md h-auto transition-colors">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span>ID</span>
                        </a>
                        @endif
                            </div>
                        </div>

                        @auth
                            <x-ui.button href="{{ route('dashboard') }}"
                                class="bg-yellow-400 text-slate-900 w-[120px] h-[44px] block rounded-lg font-reguler text-[16px] hover:bg-yellow-500 shadow-sm text-center flex items-center justify-center">
                                {{ translate('Dashboard') }}
                            </x-ui.button>
                        @else
                            <x-ui.button href="{{ route('register') }}"
                                class="bg-yellow-400 text-slate-900 w-[120px] h-[44px] block rounded-lg font-reguler text-[16px] hover:bg-yellow-500 shadow-sm text-center flex items-center justify-center">
                                {{ translate('Daftar') }}
                            </x-ui.button>
                        @endauth

                    </div>
                </div>
            </div>

        </nav>
    </div>
</header>
