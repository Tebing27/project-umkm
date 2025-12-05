<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - UMKM Sasuma Admin</title>
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
        sidebarExpanded: true,
        rejectModalOpen: false
    }">

    <div class="flex min-h-screen relative">

        {{-- SIDEBAR --}}
        <x-navigation-admin />

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out bg-slate-50"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-24'">

            {{-- MOBILE HEADER --}}
            <x-header-mobile title="Detail User" subtitle="Verifikasi Data" />

            {{-- CONTENT AREA --}}
            <main class="flex-1 p-6 md:p-10 lg:p-12 w-full max-w-5xl mx-auto">

                {{-- Breadcrumb & Back --}}
                <div class="flex items-center gap-2 mb-8 text-sm font-medium text-slate-500">
                    <a href="/admin/users" class="hover:text-primary transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                    <span class="text-slate-300">/</span>
                    <span class="text-primary">Detail User</span>
                </div>

                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-2xl border-4 border-white shadow-lg">
                            SR
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Warung Sejahtera</h1>
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold uppercase border border-yellow-200 tracking-wide">
                                    Menunggu
                                </span>
                            </div>
                            <p class="text-slate-500 font-medium">Sembako • Terdaftar 12 Des 2024</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button @click="rejectModalOpen = true" class="px-6 py-2.5 bg-white border border-red-200 text-red-600 rounded-xl text-sm font-bold hover:bg-red-50 transition-all shadow-sm">
                            Tolak
                        </button>
                        <button class="px-6 py-2.5 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition-all active:scale-95">
                            Verifikasi Sekarang
                        </button>
                    </div>
                </div>

                {{-- Content Grid --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Left Column: Info --}}
                    <div class="lg:col-span-2 space-y-8">
                        
                        {{-- Informasi Pemilik --}}
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Pemilik
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                    <p class="text-slate-900 font-semibold text-lg">Siti Rahma</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Telepon</label>
                                    <p class="text-slate-900 font-semibold text-lg">085678901234</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</label>
                                    <p class="text-slate-900 font-semibold text-lg">siti.rahma@example.com</p>
                                </div>
                            </div>
                        </div>

                        {{-- Informasi Usaha --}}
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Informasi Usaha
                            </h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Usaha</label>
                                    <p class="text-slate-900 font-semibold text-lg">Warung Sejahtera</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori</label>
                                    <p class="text-slate-900 font-semibold text-lg">Sembako & Kebutuhan Harian</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                                    <p class="text-slate-900 font-semibold text-lg leading-relaxed">Jl. Merpati No. 5, RT 02/RW 05, Kelurahan Jagakarsa, Jakarta Selatan, DKI Jakarta 12620</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi</label>
                                    <p class="text-slate-600 leading-relaxed">Menyediakan berbagai macam kebutuhan pokok sehari-hari dengan harga terjangkau. Beras, minyak, gula, dan perlengkapan mandi tersedia lengkap.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Right Column: Documents --}}
                    <div class="space-y-8">

                        {{-- Foto Tempat Usaha --}}
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Foto Tempat Usaha
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1534723452862-4c874018d66d?auto=format&fit=crop&w=300&q=80" class="w-full h-full object-cover">
                                </div>
                                <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1578916171728-46686eac8d58?auto=format&fit=crop&w=300&q=80" class="w-full h-full object-cover">
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

        {{-- MODAL TOLAK --}}
        <div x-show="rejectModalOpen" class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                {{-- Backdrop --}}
                <div x-show="rejectModalOpen" 
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div x-show="rejectModalOpen" 
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">Tolak Verifikasi</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 mb-4">
                                        Apakah Anda yakin ingin menolak verifikasi user ini? Silakan berikan alasan penolakan.
                                    </p>
                                    <textarea rows="4" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm p-3 border" placeholder="Contoh: Dokumen NIB tidak valid atau buram..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Tolak User
                        </button>
                        <button @click="rejectModalOpen = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
