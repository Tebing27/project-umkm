<aside
    class="fixed inset-y-0 left-0 z-50 bg-white text-slate-800 transition-all duration-300 ease-in-out border-r border-slate-200 flex flex-col shadow-2xl shadow-slate-200/50"
    :class="[
        sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
        sidebarExpanded ? 'lg:w-72' : 'lg:w-24',
        'w-72'
    ]"
    x-cloak>

    {{-- HEADER SIDEBAR --}}
    <div class="flex transition-all duration-300 relative shrink-0"
        :class="sidebarExpanded ? 'h-28 items-center justify-between px-8' : 'h-auto flex-col items-center pt-6 gap-3'">

        {{-- LOGO --}}
        <a href="/users/dashboard" class="flex items-center gap-3 overflow-hidden whitespace-nowrap group relative z-10">
            {{-- Logo Icon (Collapsed) --}}
            <div x-show="!sidebarExpanded" class="w-10 h-10 flex items-center justify-center transition-colors shrink-0">
                <span class="text-2xl font-bold font-sans text-primary">L.</span>
            </div>

            {{-- Logo Teks Full (Expanded) --}}
            <div class="flex flex-col transition-opacity duration-300" x-show="sidebarExpanded"
                x-transition:enter="delay-100">
                <h1 class="text-2xl font-bold tracking-wide leading-tight pb-1 text-primary">Logo.</h1>
            </div>
        </a>

        {{-- TOMBOL TOGGLE --}}
        <button
            @click="if(window.innerWidth < 1024) { sidebarOpen = false } else { sidebarExpanded = !sidebarExpanded }"
            class="text-slate-400 hover:text-primary focus:outline-none transition-all p-1.5 rounded-lg hover:bg-slate-100 active:scale-95"
            {{-- Saat collapsed, tombol tidak perlu margin top besar, cukup gap-3 dari parent --}} :class="sidebarExpanded ? '' : ''">

            <svg class="w-5 h-5 transition-transform duration-300" :class="sidebarExpanded ? 'rotate-0' : 'rotate-180'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>

    {{-- MENU NAVIGATION --}}
    <nav class="flex-1 px-4 space-y-2 mt-2 overflow-y-auto overflow-x-hidden flex flex-col scrollbar-hide"
        :class="sidebarExpanded ? 'items-stretch' : 'items-center'">

        @php
            $menus = [
                [
                    'name' => 'Dashboard',
                    'url' => '/users/dashboard',
                    'icon' =>
                        'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                ],
                [
                    'name' => 'Kelola Foto',
                    'url' => '/users/foto',
                    'icon' =>
                        'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                ],
                [
                    'name' => 'Kelola Lokasi',
                    'url' => '/users/lokasi',
                    'icon' =>
                        'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                ],
                [
                    'name' => 'Kelola Toko',
                    'url' => '/users/toko',
                    'icon' =>
                        'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                ],
                [
                    'name' => 'Setting',
                    'url' => '/users/setting',
                    'icon' =>
                        'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                ],
            ];
        @endphp

        @foreach ($menus as $menu)
            <a href="{{ $menu['url'] }}"
                class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 relative overflow-hidden gap-4
            {{-- LOGIKA ACTIVE STATE --}}
            {{ request()->is(ltrim($menu['url'], '/')) || request()->is(ltrim($menu['url'], '/') . '/*')
                ? 'bg-[#004a85] text-white shadow-lg shadow-blue-900/30'
                : 'text-slate-500 hover:bg-slate-50 hover:text-[#004a85]' }}"
                :class="sidebarExpanded ? 'justify-start' : 'justify-center'" title="{{ $menu['name'] }}">

                {{-- Background Effect (Hanya muncul saat Active) --}}
                @if (request()->is(ltrim($menu['url'], '/')) || request()->is(ltrim($menu['url'], '/') . '/*'))
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-white/10 to-transparent opacity-50 pointer-events-none">
                    </div>
                @endif

                {{-- Icon --}}
                <svg class="w-6 h-6 shrink-0 transition-transform duration-300 relative z-10"
                    :class="[
                                                        request()->is(ltrim($menu['url'], '/')) || request()->is(ltrim($menu['url'], '/') . '/*') ? 'scale-110' : 'group-hover:scale-110'
                                                    ]"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}">
                    </path>
                </svg>

                {{-- Text Menu --}}
                {{-- Menambahkan lg:w-0 agar teks hilang total saat collapsed di desktop --}}
                <span class="font-semibold text-[15px] whitespace-nowrap transition-all duration-300 relative z-10"
                    :class="sidebarExpanded ? 'opacity-100 translate-x-0' : 'lg:opacity-0 lg:hidden opacity-100 lg:w-0'">
                    <span x-show="sidebarExpanded || window.innerWidth < 1024">{{ $menu['name'] }}</span>
                </span>

                {{-- Tooltip (Desktop Collapsed) --}}
                <div class="hidden lg:group-hover:block absolute left-full ml-4 px-3 py-2 bg-slate-800 text-white text-xs font-semibold rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-all duration-200 z-50 whitespace-nowrap pointer-events-none translate-x-2 group-hover:translate-x-0"
                    x-show="!sidebarExpanded">
                    {{ $menu['name'] }}
                    <div class="absolute top-1/2 -left-1 -translate-y-1/2 w-2 h-2 bg-slate-800 rotate-45"></div>
                </div>
            </a>
        @endforeach

    </nav>

    {{-- FOOTER SIDEBAR --}}
    <div class="p-4 mt-auto mb-2">
        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 shadow-sm relative overflow-hidden group">

            {{-- Decorative Background --}}
            <div
                class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -mr-4 -mt-4 transition-transform duration-500 group-hover:scale-150">
            </div>

            {{-- Profile --}}
            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-slate-200 relative z-10"
                :class="sidebarExpanded ? 'justify-start' : 'lg:justify-center justify-start'">
                <div class="relative shrink-0 cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-md transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full ring-2 ring-white">
                    </div>
                </div>

                <div class="overflow-hidden" x-show="sidebarExpanded || window.innerWidth < 1024">
                    <p class="text-sm font-bold text-slate-800 truncate group-hover:text-primary transition-colors">
                        Tebing UMKM</p>
                    <p class="text-xs text-slate-500 truncate font-medium">Administrator</p>
                </div>
            </div>

            {{-- Logout Button --}}
            <a href="#"
                class="flex items-center text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 group/logout relative z-10"
                :class="sidebarExpanded ? 'justify-start px-3 py-2.5' : 'lg:justify-center justify-start px-0 py-2.5'">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover/logout:-translate-x-1"
                    :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <span x-show="sidebarExpanded || window.innerWidth < 1024" class="font-semibold text-sm">Logout</span>
            </a>
        </div>
    </div>

</aside>
