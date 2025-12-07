<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - UMKM Sasuma</title>
    {{-- Ganti @vite jika di local, ini CDN untuk demo --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

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
        [x-cloak] {
            display: none !important;
        }

        /* Style Input: Mengikuti request (Krem #F9F8F6) */
        .input-custom {
            background-color: #F9F8F6;
            border: 1.5px solid #e5e7eb;
            /* Slate-200 */
            transition: all 0.2s ease-in-out;
        }

        .input-custom:focus-within {
            background-color: #fff;
            border-color: #004a85;
            /* Primary color */
            box-shadow: 0 0 0 3px rgba(0, 74, 133, 0.1);
        }

        /* Input Reset */
        .input-reset {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            font-weight: 500;
            color: #111827;
            /* Slate-900 */
        }

        .input-reset::placeholder {
            color: #9ca3af;
            /* Slate-400 */
        }
    </style>
</head>

<body class="bg-slate-50 font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: false, sidebarExpanded: true }">

    <div class="flex min-h-screen relative">

        {{-- Sidebar --}}
        <x-navigation-users />

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out bg-slate-50"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-24'">

            {{-- Mobile Header --}}
            <x-header-mobile title="Pengaturan" subtitle="Kelola akun & keamanan" />

            {{-- Content Area --}}
            <main class="flex-1 p-6 md:p-10 lg:p-12 w-full max-w-6xl mx-auto">

                {{-- Header Page --}}
                <div class="mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Akun</h2>
                    <p class="text-slate-500 mt-2 text-base font-medium">Kelola informasi profil dan keamanan akun Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- LEFT COLUMN: PROFILE CARD --}}
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] text-center relative overflow-hidden sticky top-8">
                            {{-- Decor Background --}}
                            <div class="absolute top-0 left-0 w-full h-28 bg-gradient-to-br from-primary to-blue-600">
                            </div>

                            <div class="relative z-10 mt-6">
                                {{-- Avatar --}}
                                <div
                                    class="w-28 h-28 rounded-full bg-white p-1.5 mx-auto shadow-xl ring-4 ring-white/50 relative group cursor-pointer">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=300&q=80"
                                        class="w-full h-full rounded-full object-cover group-hover:opacity-90 transition-opacity">
                                </div>

                                <h3 class="text-xl font-bold text-slate-900 mt-4">Budi Santoso</h3>
                                <p class="text-sm font-medium text-slate-500">Pemilik Toko</p>
                                <span
                                    class="inline-block mt-3 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-wide">Akun
                                    Aktif</span>
                            </div>

                            <div class="mt-8 pt-6 border-t border-slate-100 space-y-3">
                                <button
                                    class="w-full py-2.5 px-4 bg-slate-50 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-100 transition-colors flex items-center justify-center gap-2">
                                    <x-icons.upload class="w-4 h-4" />
                                    Ganti Foto
                                </button>
                                <button
                                    class="w-full py-2.5 px-4 bg-red-50 text-red-600 font-bold text-sm rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                                    <x-icons.trash class="w-4 h-4" />
                                    Hapus Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: FORMS --}}
                    <div class="lg:col-span-2 space-y-8">

                        {{-- 1. FORM EDIT PROFIL --}}
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                            <h3
                                class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 pb-4 border-b border-slate-50">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-primary">
                                    <x-icons.user class="w-5 h-5" />
                                </div>
                                Informasi Pribadi
                            </h3>

                            <form action="#" method="POST" class="space-y-5">
                                {{-- Nama Lengkap --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                                    <div class="input-custom rounded-xl px-4 py-3 flex items-center">
                                        <x-icons.user class="w-5 h-5 text-slate-400 mr-3 shrink-0" />
                                        <input type="text" value="Budi Santoso" class="input-reset"
                                            placeholder="Nama Lengkap">
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Alamat Email</label>
                                    <div class="input-custom rounded-xl px-4 py-3 flex items-center">
                                        <x-icons.mail class="w-5 h-5 text-slate-400 mr-3 shrink-0" />
                                        <input type="email" value="budi@sasuma.com" class="input-reset"
                                            placeholder="Email Anda">
                                    </div>
                                </div>

                                {{-- No HP --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Nomor Handphone</label>
                                    <div class="input-custom rounded-xl px-4 py-3 flex items-center">
                                        <x-icons.phone class="w-5 h-5 text-slate-400 mr-3 shrink-0" />
                                        <input type="text" value="08123456789" class="input-reset"
                                            placeholder="Nomor HP">
                                    </div>
                                </div>

                                {{-- Tempat Tanggal Lahir (Merged) --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Tempat, Tanggal Lahir</label>
                                    <div class="input-custom rounded-xl px-4 py-3 flex items-center w-full">
                                        <x-icons.calendar class="w-5 h-5 text-slate-400 mr-3 shrink-0" />

                                        <input type="text" value="Jakarta" placeholder="Tempat Lahir"
                                            class="input-reset flex-1">

                                        <div class="w-px h-6 bg-slate-300 mx-4"></div>

                                        <input type="date" value="1990-01-01"
                                            class="input-reset flex-1 cursor-pointer">
                                    </div>
                                </div>

                                {{-- Alamat Domisili (Merged) --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Alamat Domisili</label>
                                    <div class="input-custom rounded-xl px-4 py-3 flex items-center">
                                        <x-icons.location class="w-5 h-5 text-slate-400 mr-3 shrink-0" />

                                        <input type="text" value="Jl. Kenanga No. 10" placeholder="Nama Jalan"
                                            class="input-reset flex-[3]">

                                        <div class="w-px h-6 bg-slate-300 mx-3"></div>
                                        <input type="text" value="001" placeholder="RT"
                                            class="input-reset flex-1 text-center">

                                        <div class="w-px h-6 bg-slate-300 mx-3"></div>
                                        <input type="text" value="002" placeholder="RW"
                                            class="input-reset flex-1 text-center">
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-blue-800 transition-all shadow-lg shadow-blue-900/20 active:scale-95 flex items-center gap-2">
                                        <x-icons.check class="w-5 h-5" />
                                        Simpan Profil
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- 2. FORM KEAMANAN (PASSWORD) --}}
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                            <h3
                                class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 pb-4 border-b border-slate-50">
                                <div
                                    class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-600">
                                    <x-icons.lock-closed class="w-5 h-5" />
                                </div>
                                Ganti Password
                            </h3>

                            <form action="#" class="space-y-5">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Password Saat Ini</label>
                                    <div class="input-custom rounded-xl px-4 py-3 flex items-center">
                                        <x-icons.key class="w-5 h-5 text-slate-400 mr-3 shrink-0" />
                                        <input type="password" placeholder="••••••••" class="input-reset">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Password Baru</label>
                                        <div class="input-custom rounded-xl px-4 py-3 flex items-center">
                                            <x-icons.lock-closed class="w-5 h-5 text-slate-400 mr-3 shrink-0" />
                                            <input type="password" placeholder="Minimal 8 karakter"
                                                class="input-reset">
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Konfirmasi
                                            Password</label>
                                        <div class="input-custom rounded-xl px-4 py-3 flex items-center">
                                            <x-icons.info-circle class="w-5 h-5 text-slate-400 mr-3 shrink-0" />
                                            <input type="password" placeholder="Ulangi password baru"
                                                class="input-reset">
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm active:scale-95">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </main>
        </div>

        {{-- Overlay Sidebar Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" x-cloak></div>

    </div>

</body>

</html>
