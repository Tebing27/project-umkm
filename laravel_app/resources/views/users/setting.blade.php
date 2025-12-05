<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - UMKM Sasuma</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Style Input: Mengikuti request (Krem #F9F8F6) */
        .input-custom {
            background-color: #F9F8F6;
            border: 1.5px solid #d1d5db;
            /* Border abu-abu tipis */
            transition: all 0.2s ease-in-out;
        }

        .input-custom:focus-within {
            background-color: #fff;
            /* Putih saat fokus */
            border-color: #d1d5db;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-white font-sans text-gray-900 antialiased" x-data="{ sidebarOpen: false, sidebarExpanded: true }">

    <div class="flex min-h-screen bg-white">

        {{-- Sidebar --}}
        <x-navigation-users />

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-24'">

            {{-- Mobile Header --}}
            {{-- Mobile Header --}}
            <x-header-mobile title="Pengaturan" subtitle="Kelola akun & keamanan" />

            {{-- Content --}}
            <main class="flex-1 p-6 md:p-10 lg:p-16 overflow-x-hidden">

                {{-- WRAPPER CENTERED (Agar konten di tengah & tidak terlalu lebar) --}}
                <div class="max-w-2xl mx-auto w-full">

                    {{-- Header Page --}}
                    <div class="mb-10 text-center md:text-left">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Pengaturan Akun</h2>
                        <p class="text-gray-500 mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
                    </div>

                    {{-- Form Start --}}
                    <form action="#" method="POST">
                        {{-- Nama Pemilik --}}
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700 text-lg">Nama Lengkap</label>
                            <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                                <input type="text" value="Budi Santoso"
                                    class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700 text-lg">Email</label>
                            <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <input type="email" value="budi@example.com"
                                    class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                            </div>
                        </div>

                        {{-- Nomor HP --}}
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700 text-lg">Nomor Handphone</label>
                            <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <input type="text" value="08123456789"
                                    class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                            </div>
                        </div>

                        {{-- Tempat, Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700 text-lg">Tempat, Tanggal Lahir</label>
                            <div class="relative input-custom rounded-xl px-4 py-3 flex items-center w-full">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <input type="text" value="Jakarta" placeholder="Tempat Lahir"
                                    class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">

                                {{-- Divider --}}
                                <div class="w-px h-6 bg-gray-300 mx-4"></div>

                                <input type="date" value="1990-01-01"
                                    class="bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium cursor-pointer">
                            </div>
                        </div>

                        {{-- Alamat Domisili --}}
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700 text-lg">Alamat Domisili</label>
                            <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <input type="text" value="Jl. Kenanga No. 10" placeholder="Nama Jalan"
                                    class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">

                                {{-- Divider --}}
                                <div class="w-px h-6 bg-gray-300 mx-3"></div>
                                <input type="text" value="001" placeholder="RT"
                                    class="w-12 bg-transparent border-none outline-none text-center text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">

                                {{-- Divider --}}
                                <div class="w-px h-6 bg-gray-300 mx-3"></div>
                                <input type="text" value="002" placeholder="RW"
                                    class="w-12 bg-transparent border-none outline-none text-center text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                            </div>
                        </div>

                </div>

                {{-- Tombol Simpan --}}
                <div class="mt-12 flex justify-center pb-10">
                    <button type="submit"
                        class="w-full md:w-auto bg-[#FFC107] cursor-pointer text-lg font-medium py-3 px-6 rounded-xl transition shadow-md hover:shadow-lg transform active:scale-95 border border-yellow-400">
                        Simpan Perubahan
                    </button>
                </div>
                </form>

        </div>

        </main>
    </div>

    {{-- Overlay Sidebar Mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
        class="fixed inset-0 z-40 bg-[#001e36]/80 backdrop-blur-sm lg:hidden" x-cloak></div>

    </div>

</body>

</html>
