<header class="fixed top-0 left-0 w-full z-50 transition-colors duration-300" x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">

    <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-10 pt-4">
        <nav :class="scrolled ? 'bg-white/80 backdrop-blur-lg border-none' :
            'bg-white border-none'"
            class="relative flex w-full items-center justify-between rounded-lg p-3 md:p-4 md:rounded-2xl transition-colors duration-300 border-none">

            {{-- Logo data provided by NavigationComposer --}}
            <a href="#" class="shrink-0 inline-flex items-center gap-3">
                @if ($logoShowImage == '1' && $logoImage)
                    <img loading="lazy" src="{{ asset('storage/' . $logoImage) }}" alt="Sasuma Logo"
                        class="h-10 w-auto object-contain">
                @endif

                @if ($logoShowText == '1')
                    <span
                        class="text-xl md:text-2xl font-bold items-center text-slate-900 tracking-tight">{{ $logoText }}</span>
                @endif
            </a>

            <div class="hidden md:flex flex-1 justify-center items-center space-x-4 md:space-x-5 lg:space-x-8">
                <a href="{{ url('/') }}"
                    class="text-base font-medium hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('Beranda') }}</a>
                <a href="{{ url('/#regions') }}"
                    class="text-base font-medium hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('Wilayah') }}</a>
                <a href="{{ url('/#locations') }}"
                    class="text-base font-medium hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('Lokasi') }}</a>
                <a href="/umkm"
                    class="text-base font-medium hover:text-black p-0 h-auto text-slate-900 hover:no-underline rounded-none inline-flex items-center justify-center transition-colors">{{ translate('UMKM') }}</a>
            </div>


            <div class="flex shrink-0 items-center space-x-3 lg:space-x-4">
                {{-- Language Selector --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 rounded-lg font-medium bg-yellow-400 hover:bg-yellow-500 py-2 px-2 border-none h-auto text-slate-900 shadow-sm transition-colors duration-300 focus:outline-none cursor-pointer">
                        @if (app()->getLocale() == 'id')
                            <img loading="lazy"
                                src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-medium">ID</span>
                        @else
                            <img loading="lazy"
                                src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
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
                            <img loading="lazy"
                                src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span>ID</span>
                        </a>

                        <a href="{{ route('switch_language', 'en') }}"
                            class="flex w-full items-center justify-start space-x-2 px-2 py-2 text-sm text-slate-900 hover:bg-yellow-400 rounded-md h-auto transition-colors">
                            <img loading="lazy"
                                src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span>EN</span>
                        </a>
                    </div>
                </div>

                @auth
                    <div class="hidden md:flex">
                        <x-ui.button href="{{ route('dashboard') }}"
                            class="bg-yellow-400 text-slate-900 rounded-lg hover:bg-yellow-500 md:py-2 md:px-6 lg:px-8 lg:py-2 text-base font-semibold h-auto">
                            {{ translate('Dashboard') }}
                        </x-ui.button>
                    </div>
                @else
                    <div class="hidden md:flex">
                        <x-ui.button href="{{ route('register') }}"
                            class="bg-yellow-400 text-slate-900 rounded-lg hover:bg-yellow-500 md:py-2 md:px-6 lg:px-8 lg:py-2 text-base font-semibold h-auto">
                            {{ translate('Daftar') }}
                        </x-ui.button>
                    </div>
                @endauth

                {{-- Mobile Menu Button --}}
                <div class="md:hidden flex items-center" x-data="{ open: false }">
                    <x-ui.button @click="open = !open" variant="ghost" size="icon"
                        class="text-slate-800 hover:bg-transparent h-auto p-0">
                        <x-icons.ui-menu x-show="!open" class="w-6 h-6" />
                        <x-icons.ui-close x-show="open" style="display: none;" class="w-6 h-6" />
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

                            <a href="{{ url('/') }}"
                                class="block w-full px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:text-black hover:bg-gray-50 h-auto transition-colors">
                                {{ translate('Beranda') }}
                            </a>
                            <a href="{{ url('/#regions') }}"
                                class="block w-full px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:text-black hover:bg-gray-50 h-auto transition-colors">
                                {{ translate('Wilayah') }}
                            </a>
                            <a href="{{ url('/#locations') }}"
                                class="block w-full px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:text-black hover:bg-gray-50 h-auto transition-colors">
                                {{ translate('Lokasi') }}
                            </a>
                            <a href="/umkm"
                                class="block w-full px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:text-black hover:bg-gray-50 h-auto transition-colors">
                                {{ translate('UMKM') }}
                            </a>

                            @auth
                                <x-ui.button href="{{ route('dashboard') }}"
                                    class="bg-yellow-400 text-slate-900 w-[120px] h-[44px] block rounded-lg font-semibold text-base hover:bg-yellow-500 shadow-sm text-center flex items-center justify-center mx-auto mt-2">
                                    {{ translate('Dashboard') }}
                                </x-ui.button>
                            @else
                                <x-ui.button href="{{ route('register') }}"
                                    class="bg-yellow-400 text-slate-900 w-[120px] h-[44px] block rounded-lg font-semibold text-base hover:bg-yellow-500 shadow-sm text-center flex items-center justify-center mx-auto mt-2">
                                    {{ translate('Daftar') }}
                                </x-ui.button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>


        </nav>
    </div>
</header>
