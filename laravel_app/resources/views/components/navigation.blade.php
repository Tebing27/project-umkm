<header class="fixed top-0 left-0 w-full z-50 transition-all duration-300" x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">

    <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-10 pt-4">
        <nav :class="scrolled ? 'bg-white/80 backdrop-blur-md shadow-md border-transparent' :
            'bg-white shadow-sm border border-slate-200'"
            class="relative flex w-full items-center justify-between rounded-lg p-3 md:p-4 md:rounded-2xl transition-all duration-300 border">

            <a href="#" class="shrink-0 inline-flex items-center gap-4">
                <span class="text-4xl md:text-3xl font-bold items-center text-slate-900">Logo</span>
            </a>

            <div class="hidden md:flex flex-1 justify-center items-center space-x-4 md:space-x-5 lg:space-x-8">
                <a href="#" class="text-lg font-reguler hover:text-black">Beranda</a>
                <a href="#" class="text-lg font-reguler hover:text-black">Wilayah</a>
                <a href="#" class="text-lg font-reguler hover:text-black">Lokasi</a>
                <a href="#" class="text-lg font-reguler hover:text-black">UMKKM</a>
            </div>

            <div class="hidden md:flex shrink-0 items-center space-x-2 md:space-x-3 lg:space-x-4">

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 px-3 py-3 rounded-lg font-reguler bg-yellow-400 hover:bg-yellow-500 md:py-2 md:px-2">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                            alt="ID" class="w-5 h-5 rounded-full object-cover">
                        <span class="text-sm font-reguler">ID</span>

                        <svg x-bind:class="open ? 'rotate-180' : ''" class="h-4 w-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 9l6 6 6-6" />
                        </svg>

                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-40 rounded-lg shadow-lg bg-white p-1 z-50 border border-slate-100"
                        style="display: none;">
                        <a href="#"
                            class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                alt="ID" class="w-5 h-5 rounded-full object-cover">
                            <span>Indonesia (ID)</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                alt="EN" class="w-5 h-5 rounded-full object-cover">
                            <span>English (EN)</span>
                        </a>
                    </div>
                </div>

                <a href="#"
                    class="bg-yellow-400 text-black lg:px-8 lg:py-2 rounded-lg font-reguler text-xl hover:bg-yellow-500 md:py-2 md:px-6">
                    Daftar
                </a>
            </div>

            <div class="md:hidden" x-data="{ open: false }">

                <button @click="open = !open" class="inline-flex p-2 rounded-md text-slate-800">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" @scroll.window="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute top-[4.5rem] right-0 w-52 z-50" style="display: none;">

                    <div class="rounded-xl bg-white shadow-lg border border-slate-200 p-6 space-y-0.5 text-center">

                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">
                            Beranda
                        </a>
                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">
                            Wilayah
                        </a>
                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">
                            Lokasi
                        </a>
                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">
                            Toko
                        </a>

                        <div x-data="{ langOpen: false }" class="!mb-4 !mt-6">
                            <button @click="langOpen = !langOpen"
                                class="flex items-center mx-auto px-1.5 py-2 rounded-lg font-reguler bg-yellow-400 hover:bg-yellow-500">
                                <span class="flex items-center space-x-2">
                                    <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                        alt="ID" class="w-5 h-5 rounded-full object-cover">
                                    <span>ID</span>
                                </span>
                                <svg x-bind:class="langOpen ? 'rotate-180' : ''"
                                    class="h-4 w-4 transition-transform duration-200" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </button>

                            <div x-show="langOpen" x-transition class="pl-5 pt-2 space-y-2 text-center">
                                <a href="#"
                                    class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                    <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/id.svg"
                                        alt="ID" class="w-5 h-5 rounded-full object-cover">
                                    <span>Indonesia (ID)</span>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                    <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg"
                                        alt="EN" class="w-5 h-5 rounded-full object-cover">
                                    <span>English (EN)</span>
                                </a>
                            </div>
                        </div>

                        <a href="#"
                            class="bg-yellow-400 text-black px-6 py-2 !mt-4 block w-full rounded-lg font-reguler text-xl hover:bg-yellow-500">
                            Daftar
                        </a>

                    </div>
                </div>
            </div>

        </nav>
    </div>
</header>
