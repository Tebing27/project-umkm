<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Toko - UMKM Sasuma</title>

    {{-- Ganti @vite jika di local, ini CDN untuk demo --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts: Plus Jakarta Sans --}}
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
        [x-cloak] {
            display: none !important;
        }

        /* Smooth Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans text-slate-800 antialiased selection:bg-primary/20 selection:text-primary"
    x-data="{
        // STATE SIDEBAR
        sidebarOpen: false, // Kontrol Mobile (Overlay)
        sidebarExpanded: true, // Kontrol Desktop (Lebar/Kecil)
        addProductModal: false,
        editProductModal: false,
        activeTab: 'semua'
    }">

    <div class="flex min-h-screen relative">

        {{-- SIDEBAR PLACEHOLDER (Gunakan komponen sidebar Anda di sini) --}}
        <x-navigation-users />

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-8'">

            {{-- MOBILE HEADER --}}
            {{-- MOBILE HEADER --}}
            <x-header-mobile title="Kelola Toko" subtitle="Manajemen produk & stok" />

            {{-- CONTENT AREA --}}
            <main class="flex-1 p-6 md:p-8 lg:p-10 max-w-7xl mx-auto w-full">

                {{-- HEADER --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Toko</h2>
                        <p class="text-slate-500 mt-2 text-base font-medium">Atur produk, stok, dan etalase toko Anda.
                        </p>
                    </div>
                    {{-- TOMBOL TAMBAH (Mengarah ke Modal) --}}
                    {{-- TOMBOL EDIT DATA TOKO --}}
                    <a href="/users/edit-toko"
                        class="group bg-primary hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg shadow-primary/30 flex items-center justify-center gap-2.5 transition-all duration-300 hover:-translate-y-0.5 active:scale-95 active:shadow-none w-full md:w-auto">
                        <div class="bg-white/20 p-1 rounded-md group-hover:rotate-90 transition-transform duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </div>
                        <span>Edit Data Toko</span>
                    </a>
                </div>

                {{-- KARTU PROFIL TOKO --}}
                <div
                    class="bg-white rounded-3xl p-6 md:p-8 shadow-xl shadow-slate-200/60 border border-slate-100 mb-12 relative overflow-hidden group">
                    {{-- Decor --}}
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-yellow-100/50 to-orange-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
                    </div>

                    <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-8">
                        {{-- Foto Profil --}}
                        <div class="relative shrink-0 group-hover:scale-[1.02] transition-transform duration-500">
                            <div
                                class="w-28 h-28 md:w-36 md:h-36 rounded-full p-1 bg-white shadow-lg border border-slate-100 overflow-hidden">
                                {{-- GANTI GAMBAR DI SINI --}}
                                <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=300&q=80"
                                    class="w-full h-full rounded-full object-cover" alt="Foto Toko">
                            </div>

                        </div>

                        {{-- Info Text --}}
                        <div class="flex-1 text-left space-y-5">

                            {{-- Header Info --}}
                            <div>
                                <p class="text-slate-500 font-medium text-sm mb-1">Pemilik: <span
                                        class="text-slate-900 font-bold">Budi Santoso</span></p>
                                <div class="flex flex-row flex-wrap items-center gap-3 justify-start">
                                    <h3
                                        class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight break-words max-w-full">
                                        Tebing UMKM</h3>
                                    <div
                                        class="flex items-center gap-2 px-4 py-1.5 bg-[#FFC107] text-sm font-bold rounded-md shadow-sm">
                                        Kuliner
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat (Lokasi) --}}
                            <div class="flex items-start gap-1 md:gap-3 text-slate-600 justify-start">
                                <svg class="w-5 h-5 text-primary mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium">Jl. Merpati asasasasasasasasas No. 45, RT 005/RW 012</span>
                            </div>

                            {{-- Divider --}}
                            <div class="w-full h-px bg-slate-100"></div>

                            {{-- Detail Lainnya --}}
                            <div class="space-y-4">
                                {{-- Izin Usaha --}}
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 mb-1">Izin Usaha</h4>
                                    <p class="text-slate-600">NIB: 1234567890</p>
                                </div>

                                {{-- Kontak & Sosmed --}}
                                <div class="flex flex-wrap items-center gap-x-6 gap-y-3 justify-start">
                                    {{-- IG --}}
                                    <a href="#"
                                        class="flex items-center gap-2 text-slate-600 hover:text-[#E1306C] transition-colors group">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg"
                                            class="w-5 h-5" alt="IG">
                                        <span class="font-medium">@tebing_umkm</span>
                                    </a>
                                    {{-- FB --}}
                                    <a href="#"
                                        class="flex items-center gap-2 text-slate-600 hover:text-[#1877F2] transition-colors group">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
                                            class="w-5 h-5" alt="FB">
                                        <span class="font-medium">Tebing UMKM</span>
                                    </a>
                                    {{-- WA --}}
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        <span class="font-medium">081234567890</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="w-full h-px bg-slate-100"></div>

                            {{-- Deskripsi --}}
                            <div>
                                <p class="text-slate-500 leading-relaxed">
                                    Menyediakan berbagai macam makanan ringan dan berat khas daerah dengan cita rasa
                                    otentik
                                    dan harga terjangkau. Kami berkomitmen untuk memberikan produk terbaik bagi
                                    pelanggan setia kami.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 3. SECTION DAFTAR PRODUK --}}
                <div class="space-y-8">

                    {{-- Tabs & Search --}}
                    <div
                        class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
                        {{-- Tabs --}}
                        <div class="flex items-center gap-1 overflow-x-auto no-scrollbar p-1 flex-1">
                            @foreach (['semua' => 'Semua', 'aktif' => 'Aktif', 'tidak_aktif' => 'Tidak Aktif'] as $key => $label)
                                <button @click="activeTab = '{{ $key }}'"
                                    :class="activeTab === '{{ $key }}'
                                        ?
                                        'bg-slate-100 text-slate-900 shadow-sm font-bold ring-1 ring-slate-200' :
                                        'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                                    class="px-4 py-2 rounded-xl text-sm transition-all duration-200 whitespace-nowrap">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Search --}}
                        <div class="relative w-full lg:w-80 group">
                            <input type="text" placeholder="Cari nama produk..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400">
                            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5 group-focus-within:text-primary transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Grid Produk --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                        {{-- Item Produk 1 (Active) --}}
                        <div x-data="{ active: true }"
                            x-show="activeTab === 'semua' || (activeTab === 'aktif' && active) || (activeTab === 'tidak_aktif' && !active)"
                            :class="{ 'opacity-75': !active }"
                            class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group overflow-hidden flex flex-col hover:-translate-y-1">
                            <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=500&q=80"
                                    :class="{ 'grayscale': !active }"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    alt="Salad Buah">

                                {{-- Badge --}}
                                <span
                                    class="absolute top-3 left-3 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold shadow-sm ring-1 ring-white/50 uppercase tracking-wide"
                                    :class="active ? 'bg-white/90 text-slate-700' : 'bg-slate-200/90 text-slate-500'">
                                    Makanan
                                </span>
                            </div>

                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <h3
                                        class="font-bold text-slate-800 line-clamp-1 text-lg group-hover:text-primary transition-colors">
                                        Salad Buah Segar</h3>
                                    <span
                                        class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide border"
                                        :class="active ? 'text-green-700 bg-green-100 border-green-200' :
                                            'text-slate-500 bg-slate-100 border-slate-200'"
                                        x-text="active ? 'Aktif' : 'Tidak Aktif'">
                                    </span>
                                </div>
                                <p class="text-primary font-extrabold text-lg mb-4">Rp 25.000</p>

                                <div
                                    class="mt-auto pt-4 border-t border-slate-50 space-y-3">
                                    
                                    {{-- Status Toggle --}}
                                    <div class="flex items-center justify-between text-xs text-slate-500 font-semibold">
                                        <div class="flex items-center gap-2">
                                            <span class="text-slate-400">Status:</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="" class="sr-only peer"
                                                    x-model="active">
                                                <div
                                                    class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500">
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="grid grid-cols-2 gap-2">
                                        <button @click="editProductModal = true"
                                            class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold hover:bg-primary hover:text-white transition-all duration-200 group/btn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <button
                                            class="flex items-center justify-center gap-2 px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition-all duration-200 group/btn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Item Produk 2 (Active) --}}
                        <div x-data="{ active: true }"
                            x-show="activeTab === 'semua' || (activeTab === 'aktif' && active) || (activeTab === 'tidak_aktif' && !active)"
                            :class="{ 'opacity-75': !active }"
                            class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group overflow-hidden flex flex-col hover:-translate-y-1">
                            <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=500&q=80"
                                    :class="{ 'grayscale': !active }"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    alt="Es Krim">

                                {{-- Badge --}}
                                <span
                                    class="absolute top-3 left-3 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold shadow-sm ring-1 ring-white/50 uppercase tracking-wide"
                                    :class="active ? 'bg-white/90 text-slate-700' : 'bg-slate-200/90 text-slate-500'">
                                    Minuman
                                </span>
                            </div>

                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <h3
                                        class="font-bold text-slate-800 line-clamp-1 text-lg group-hover:text-primary transition-colors">
                                        Es Krim Vanilla</h3>
                                    <span
                                        class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide border"
                                        :class="active ? 'text-green-700 bg-green-100 border-green-200' :
                                            'text-slate-500 bg-slate-100 border-slate-200'"
                                        x-text="active ? 'Aktif' : 'Tidak Aktif'">
                                    </span>
                                </div>
                                <p class="text-primary font-extrabold text-lg mb-4">Rp 25.000</p>

                                <div
                                    class="mt-auto pt-4 border-t border-slate-50 space-y-3">
                                    
                                    {{-- Status Toggle --}}
                                    <div class="flex items-center justify-between text-xs text-slate-500 font-semibold">
                                        <div class="flex items-center gap-2">
                                            <span class="text-slate-400">Status:</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="" class="sr-only peer"
                                                    x-model="active">
                                                <div
                                                    class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500">
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="grid grid-cols-2 gap-2">
                                        <button @click="editProductModal = true"
                                            class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold hover:bg-primary hover:text-white transition-all duration-200 group/btn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <button
                                            class="flex items-center justify-center gap-2 px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition-all duration-200 group/btn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Tambah Produk (Shortcut) --}}
                        <button @click="addProductModal = true" type="button"
                            class="group relative bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center h-full min-h-[350px] hover:border-primary hover:bg-blue-50/30 transition-all duration-300 p-6 overflow-hidden">
                            <div
                                class="w-16 h-16 rounded-2xl bg-white shadow-sm border border-slate-200 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:shadow-md group-hover:border-primary/20 transition-all duration-300 z-10">
                                <svg class="w-8 h-8 text-slate-400 group-hover:text-primary transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <span
                                class="font-bold text-slate-500 group-hover:text-primary text-lg transition-colors z-10">Tambah
                                Produk</span>
                            <span class="text-xs text-slate-400 mt-1 z-10">Upload produk barumu sekarang</span>

                            {{-- Decor bg --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-transparent to-blue-50/50 opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                        </button>

                    </div>
                </div>

            </main>
        </div>

        {{-- FAB ADD PRODUCT (MOBILE ONLY) --}}
        <button @click="addProductModal = true"
            class="lg:hidden fixed bottom-6 right-6 z-40 bg-primary text-white p-4 rounded-full shadow-lg shadow-primary/40 hover:bg-blue-800 transition-all active:scale-95 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>

        {{-- OVERLAY SIDEBAR MOBILE --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" x-cloak>
        </div>

        {{-- MODAL TAMBAH PRODUK --}}
        <div x-show="addProductModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6"
            x-cloak>

            {{-- Backdrop --}}
            <div @click="addProductModal = false" x-transition.opacity class="absolute inset-0 bg-slate-900/60"></div>

            {{-- Modal Content --}}
            <div x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl relative z-10 overflow-hidden flex flex-col max-h-[90vh]">

                {{-- Header Modal --}}
                <div
                    class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Tambah Produk Baru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Isi detail produk dengan lengkap dan menarik.</p>
                    </div>
                    <button @click="addProductModal = false" type="button"
                        class="text-slate-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Body Modal (Scrollable) --}}
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form action="#" class="space-y-6">

                        {{-- Upload Foto --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Foto Produk</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-slate-300 border-dashed rounded-2xl hover:border-primary hover:bg-blue-50/50 transition-all cursor-pointer group relative overflow-hidden">
                                <input type="file"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="space-y-2 text-center relative z-0">
                                    <div
                                        class="mx-auto w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300">
                                        <svg class="h-6 w-6 text-slate-400 group-hover:text-primary"
                                            stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="text-sm text-slate-600">
                                        <span class="font-bold text-primary hover:underline">Klik upload</span> atau
                                        drag & drop
                                    </div>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wide">PNG, JPG up to 5MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Form Inputs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-slate-700">Nama Produk <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full rounded-xl border border-[#d1d5db] shadow-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all py-2.5 px-4 text-sm placeholder:text-slate-400 font-medium"
                                    placeholder="Contoh: Keripik Pisang">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-slate-700">Harga (Rp) <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-slate-500 text-sm font-bold">Rp</span>
                                    <input type="number"
                                        class="w-full pl-10 rounded-xl border border-[#d1d5db] shadow-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all py-2.5 px-4 text-sm font-medium"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-slate-700">Kategori Produk <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full rounded-xl border border-[#d1d5db] shadow-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all py-2.5 px-4 text-sm font-medium"
                                    placeholder="Contoh: Makanan Ringan">
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Footer Modal --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 shrink-0">
                    <button @click="addProductModal = false" type="button"
                        class="px-5 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-xl font-bold text-sm hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                        Batal
                    </button>
                    <button type="button"
                        class="px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-blue-800 shadow-lg shadow-primary/30 transition-all transform active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Simpan Produk
                    </button>
                </div>

            </div>
        </div>

        {{-- MODAL EDIT PRODUK --}}
        <div x-show="editProductModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6"
            x-cloak>

            {{-- Backdrop --}}
            <div @click="editProductModal = false" x-transition.opacity class="absolute inset-0 bg-slate-900/60">
            </div>

            {{-- Modal Content --}}
            <div x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl relative z-10 overflow-hidden flex flex-col max-h-[90vh]">

                {{-- Header Modal --}}
                <div
                    class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Edit Produk</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Perbarui detail produk kamu.</p>
                    </div>
                    <button @click="editProductModal = false" type="button"
                        class="text-slate-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Body Modal (Scrollable) --}}
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form action="#" class="space-y-6">

                        {{-- Upload Foto --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Foto Produk</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-slate-300 border-dashed rounded-2xl hover:border-primary hover:bg-blue-50/50 transition-all cursor-pointer group relative overflow-hidden">
                                <input type="file"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="space-y-2 text-center relative z-0">
                                    <div
                                        class="mx-auto w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300">
                                        <svg class="h-6 w-6 text-slate-400 group-hover:text-primary"
                                            stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="text-sm text-slate-600">
                                        <span class="font-bold text-primary hover:underline">Klik upload</span> atau
                                        drag & drop
                                    </div>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wide">PNG, JPG up to 5MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Form Inputs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-slate-700">Nama Produk <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full rounded-xl border border-[#d1d5db] shadow-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all py-2.5 px-4 text-sm placeholder:text-slate-400 font-medium"
                                    value="Salad Buah Segar">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-slate-700">Harga (Rp) <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-slate-500 text-sm font-bold">Rp</span>
                                    <input type="number"
                                        class="w-full pl-10 rounded-xl border border-[#d1d5db] shadow-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all py-2.5 px-4 text-sm font-medium"
                                        value="25000">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-slate-700">Kategori Produk <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full rounded-xl border border-[#d1d5db] shadow-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all py-2.5 px-4 text-sm font-medium"
                                    value="Makanan">
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Footer Modal --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 shrink-0">
                    <button @click="editProductModal = false" type="button"
                        class="px-5 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-xl font-bold text-sm hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                        Batal
                    </button>
                    <button type="button"
                        class="px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-blue-800 shadow-lg shadow-primary/30 transition-all transform active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>

    </div>

</body>

</html>
