<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - UMKM Sasuma</title>
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
        <x-navigation-users />

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out bg-slate-50"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-24'">

            {{-- MOBILE HEADER --}}
            <x-header-mobile title="Dashboard" subtitle="Ringkasan Aktivitas" />

            {{-- CONTENT AREA --}}
            <main class="flex-1 p-6 md:p-10 lg:p-12 w-full max-w-7xl mx-auto">

                {{-- Welcome Section --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary to-blue-600 p-8 md:p-12 mb-10 text-white shadow-xl shadow-blue-900/20">
                    <div class="relative z-10">
                        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">Hi, Tebing UMKM 👋</h2>
                        <p class="text-blue-100 text-lg font-medium max-w-2xl">Selamat datang kembali! Berikut adalah ringkasan performa toko Anda hari ini.</p>
                    </div>
                    
                    {{-- Decorative Circles --}}
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                    {{-- Status Card --}}
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-all duration-300 group">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wide border border-green-200">
                                Terverifikasi
                            </span>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-1">Status Toko</p>
                            <h3 class="text-xl font-bold text-slate-900">Tebing UMKM</h3>
                            <p class="text-xs text-slate-400 mt-1">Pemilik: Tebing</p>
                        </div>
                    </div>

                    {{-- Produk Klik --}}
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-all duration-300 group">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            <span class="flex items-center text-green-600 text-xs font-bold bg-green-50 px-2 py-1 rounded-lg">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                +15%
                            </span>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-1">Total Dilihat</p>
                            <h3 class="text-3xl font-extrabold text-slate-900">2,450</h3>
                            <p class="text-xs text-slate-400 mt-1">Dalam 30 hari terakhir</p>
                        </div>
                    </div>

                    {{-- Total Produk --}}
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-all duration-300 group">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-500 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-1">Total Produk</p>
                            <h3 class="text-3xl font-extrabold text-slate-900">30 <span class="text-lg text-slate-400 font-semibold">Item</span></h3>
                            <p class="text-xs text-slate-400 mt-1">Produk aktif di etalase</p>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-all duration-300 group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-500 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium mb-3">Kategori Produk</p>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                        <span class="text-slate-600 font-medium">Makanan</span>
                                    </div>
                                    <span class="font-bold text-slate-900">20</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                        <span class="text-slate-600 font-medium">Minuman</span>
                                    </div>
                                    <span class="font-bold text-slate-900">10</span>
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
