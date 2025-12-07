<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - UMKM Sasuma</title>
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

<body class="bg-white font-sans text-slate-800 antialiased"
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
            <x-header-mobile title="Dashboard Admin" subtitle="Overview & Statistik" />

            {{-- CONTENT AREA --}}
            <main class="flex-1 p-6 md:p-10 lg:p-12 w-full max-w-7xl mx-auto">

                {{-- Welcome Section --}}
                <div class="mb-10 relative">
                    <div class="absolute -left-6 -top-6 w-32 h-32 bg-blue-100/50 rounded-full blur-3xl -z-10"></div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Hi, Admin! 👋</h2>
                    <p class="text-slate-500 mt-2 text-lg">Berikut adalah ringkasan aktivitas UMKM hari ini.</p>
                </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    
                    {{-- Card Total UMKM --}}
                    <div class="bg-white rounded-3xl p-8 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-110"></div>
                        
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                <x-icons.store class="w-6 h-6" />
                            </div>
                            <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Total UMKM</h3>
                            <p class="text-4xl font-extrabold text-slate-900">30</p>
                            <div class="mt-4 flex items-center gap-2 text-sm font-medium text-green-600 bg-green-50 w-fit px-2.5 py-1 rounded-full">
                                <x-icons.trending-up class="w-4 h-4" />
                                <span>+2 minggu ini</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Status User --}}
                    <div class="bg-white rounded-3xl p-8 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300 md:col-span-2 lg:col-span-2">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                        
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 text-orange-600 group-hover:scale-110 transition-transform duration-300">
                                        <x-icons.users-group class="w-6 h-6" />
                                    </div>
                                    <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Status Pendaftaran</h3>
                                    <p class="text-4xl font-extrabold text-slate-900">50 <span class="text-lg text-slate-400 font-medium">Total User</span></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Terverifikasi --}}
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                        <x-icons.check class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-slate-900">10</p>
                                        <p class="text-xs font-semibold text-slate-500">Terverifikasi</p>
                                    </div>
                                </div>

                                {{-- Menunggu --}}
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                                        <x-icons.clock class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-slate-900">20</p>
                                        <p class="text-xs font-semibold text-slate-500">Menunggu</p>
                                    </div>
                                </div>

                                {{-- Gagal --}}
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                                        <x-icons.x-mark class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-slate-900">20</p>
                                        <p class="text-xs font-semibold text-slate-500">Ditolak</p>
                                    </div>
                                </div>
                            </div>
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
