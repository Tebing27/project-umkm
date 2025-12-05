<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Admin - UMKM Sasuma Admin</title>
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
            <x-header-mobile title="Pengaturan" subtitle="Kelola Akun & Sistem" />

            {{-- CONTENT AREA --}}
            <main class="flex-1 p-6 md:p-10 lg:p-12 w-full max-w-5xl mx-auto">

                {{-- Header --}}
                <div class="mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan</h2>
                    <p class="text-slate-500 mt-2 text-base font-medium">Kelola profil admin dan konfigurasi sistem.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Left Column: Profile Card --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] text-center relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-primary to-blue-600"></div>
                            
                            <div class="relative z-10 -mt-4">
                                <div class="w-24 h-24 rounded-full bg-white p-1.5 mx-auto shadow-lg">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80" class="w-full h-full rounded-full object-cover">
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mt-4">Admin Pengasinan</h3>
                                <p class="text-sm font-medium text-slate-500">Super Admin</p>
                                <span class="inline-block mt-3 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Aktif</span>
                            </div>

                            <div class="mt-8 pt-8 border-t border-slate-100 space-y-4">
                                <button class="w-full py-2.5 px-4 bg-slate-50 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Ganti Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Forms --}}
                    <div class="lg:col-span-2 space-y-8">
                        
                        {{-- Edit Profile Form --}}
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Edit Profil
                            </h3>
                            <form class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Depan</label>
                                        <input type="text" value="Admin" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Belakang</label>
                                        <input type="text" value="Pengasinan" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                                    <input type="email" value="admin@sasuma.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Security Form --}}
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Keamanan
                            </h3>
                            <form class="space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Password Saat Ini</label>
                                    <input type="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                                        <input type="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password</label>
                                        <input type="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                                        Update Password
                                    </button>
                                </div>
                            </form>
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
