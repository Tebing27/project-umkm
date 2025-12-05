<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - UMKM Sasuma Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#004a85',
                        secondary: '#FFC107',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 font-sans text-slate-800 antialiased"
    x-data="{
        sidebarOpen: false,
        sidebarExpanded: true
    }">

    <div class="flex min-h-screen relative">

        {{-- SIDEBAR --}}
        <x-navigation-admin />

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out bg-slate-50"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-24'">

            {{-- MOBILE HEADER --}}
            <x-header-mobile title="Kelola User" subtitle="Verifikasi & Data UMKM" />

            {{-- CONTENT AREA --}}
            <main class="flex-1 p-6 md:p-10 lg:p-12 w-full max-w-7xl mx-auto">

                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kelola User</h2>
                        <p class="text-slate-500 mt-2 text-base font-medium">Verifikasi dan kelola data UMKM yang terdaftar.</p>
                    </div>
                    
                    {{-- Search / Filter --}}
                    <div class="w-full md:w-72">
                        <div class="relative group">
                            <input type="text" placeholder="Cari user atau usaha..."
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-sm group-hover:shadow-md">
                            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3 group-focus-within:text-primary transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Cards Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    {{-- Card 1: Verified --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group flex flex-col overflow-hidden relative">
                        {{-- Status Indicator Strip --}}
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-green-500"></div>

                        {{-- Card Header --}}
                        <div class="p-6 pb-4 border-b border-slate-50 flex justify-between items-start gap-4 pt-8">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-1">Tebing UMKM</h3>
                                <p class="text-xs font-semibold text-slate-500 mt-1">Kuliner • Sejak 2023</p>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-bold uppercase border border-green-100 tracking-wide ring-1 ring-green-500/20">
                                Terverifikasi
                            </span>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6 flex-1 space-y-5">
                            {{-- Owner Info --}}
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm border border-slate-200 ring-2 ring-white shadow-sm">
                                    BS
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Budi Santoso</p>
                                    <p class="text-xs text-slate-500">Pemilik Usaha</p>
                                </div>
                            </div>

                            {{-- Details --}}
                            <div class="space-y-3">
                                <div class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="truncate font-medium">tebing@example.com</span>
                                </div>
                                <div class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="truncate font-medium">081234567890</span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="p-4 bg-slate-50 border-t border-slate-100 grid grid-cols-2 gap-3 mt-auto">
                            <a href="/admin/users/detail" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm group/btn">
                                Detail
                                <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <button class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all shadow-sm">
                                Hapus
                            </button>
                        </div>
                    </div>

                    {{-- Card 2: Pending --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group flex flex-col overflow-hidden relative">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-yellow-500"></div>
                        
                        <div class="p-6 pb-4 border-b border-slate-50 flex justify-between items-start gap-4 pt-8">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-1">Warung Sejahtera</h3>
                                <p class="text-xs font-semibold text-slate-500 mt-1">Sembako • Baru Daftar</p>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[10px] font-bold uppercase border border-yellow-100 tracking-wide ring-1 ring-yellow-500/20">
                                Menunggu
                            </span>
                        </div>

                        <div class="p-6 flex-1 space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm border border-slate-200 ring-2 ring-white shadow-sm">
                                    SR
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Siti Rahma</p>
                                    <p class="text-xs text-slate-500">Pemilik Usaha</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="truncate font-medium">siti.rahma@example.com</span>
                                </div>
                                <div class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="truncate font-medium">085678901234</span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer (Action: Verify) --}}
                        <div class="p-4 bg-slate-50 border-t border-slate-100 grid grid-cols-2 gap-3 mt-auto">
                            <a href="/admin/users/detail" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition-all active:scale-95">
                                Verifikasi
                            </a>
                            <button class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all shadow-sm">
                                Tolak
                            </button>
                        </div>
                    </div>

                    {{-- Card 3: Failed --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group flex flex-col overflow-hidden relative">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-red-500"></div>

                        <div class="p-6 pb-4 border-b border-slate-50 flex justify-between items-start gap-4 pt-8">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-1">Toko Mainan Anak</h3>
                                <p class="text-xs font-semibold text-slate-500 mt-1">Retail • Ditolak</p>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-[10px] font-bold uppercase border border-red-100 tracking-wide ring-1 ring-red-500/20">
                                Gagal
                            </span>
                        </div>

                        <div class="p-6 flex-1 space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm border border-slate-200 ring-2 ring-white shadow-sm">
                                    AD
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Andi Dermawan</p>
                                    <p class="text-xs text-slate-500">Pemilik Usaha</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="truncate font-medium">andi@example.com</span>
                                </div>
                                <div class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="truncate font-medium">089988776655</span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="p-4 bg-slate-50 border-t border-slate-100 grid grid-cols-1 mt-auto">
                            <a href="/admin/users/detail" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-100 hover:text-slate-900 transition-all shadow-sm">
                                Detail
                            </a>
                        </div>
                    </div>

                </div>

            </main>
        </div>

        {{-- OVERLAY SIDEBAR MOBILE --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" x-cloak>
        </div>

    </div>
</body>
</html>
