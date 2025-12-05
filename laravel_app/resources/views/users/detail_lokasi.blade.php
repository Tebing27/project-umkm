<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lokasi - UMKM Sasuma</title>
    @vite('resources/css/app.css')

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white font-sans text-gray-900 antialiased" x-data="{
    sidebarOpen: false,
    sidebarExpanded: true,
    checkDevice() {
        this.isLaptop = window.innerWidth >= 1024;
    }
}" x-on:resize.window="checkDevice()">

    <div class="flex min-h-screen bg-white">

        {{-- Sidebar --}}
        <x-navigation-users />

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
            :class="sidebarExpanded ? 'lg:ml-64' : 'lg:ml-20'">

            {{-- Mobile Header --}}
            {{-- Mobile Header --}}
            <x-header-mobile title="Detail Lokasi" subtitle="Informasi lokasi usaha" />

            {{-- Content --}}
            <main class="flex-1 p-6 md:p-10 lg:p-16 overflow-x-hidden">

                

                {{-- Header Title --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Detail Lokasi Usaha</h2>
                    <div class="flex gap-3">
                        <a href="/users/lokasi/edit"
                            class="px-5 py-2.5 rounded-xl border border-gray-300 text-white font-medium bg-[#004a85] transition-colors">
                            Edit Data
                        </a>
                      
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Kolom Kiri: Informasi Text --}}
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 p-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-[#004a85]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Informasi Usaha
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Nama Usaha</p>
                                    <p class="text-lg font-semibold text-gray-900">Tebing UMKM</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Jenis Produk</p>
                                    <p class="text-lg font-semibold text-gray-900">Makanan Ringan</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Jenis Usaha</p>
                                    <span
                                        class="inline-block bg-yellow-400 px-2 py-1 rounded-md text-sm font-medium">
                                        Kuliner
                                    </span>
                                    
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Izin Usaha</p>
                                    <p class="text-lg font-semibold text-gray-900">NIB: 1234567890</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm text-gray-500 mb-1">Alamat Lengkap</p>
                                    <p class="text-lg font-semibold text-gray-900 leading-relaxed">Jl. Jagakarsa No.
                                        12, Jakarta Selatan, DKI Jakarta</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm text-gray-500 mb-1">Omset Penjualan</p>
                                    <p class="text-lg font-bold text-gray-900">Rp 1.000.000 - Rp 5.000.000</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
                                    <p class="text-gray-700 leading-relaxed">
                                        Usaha yang bergerak di bidang kuliner khususnya makanan ringan khas daerah
                                        dengan kemasan modern.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Peta & Koordinat --}}
                    <div class="space-y-8">
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-[#004a85]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Titik Lokasi
                            </h3>

                            {{-- Peta --}}
                            <div class="rounded-2xl overflow-hidden h-64 border border-gray-200 shadow-inner mb-6 relative z-0">
                                <div id="detailMap" class="w-full h-full z-0"></div>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Latitude
                                    </p>
                                    <p class="font-mono text-gray-900 font-bold text-lg">-6.320000</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Longitude
                                    </p>
                                    <p class="font-mono text-gray-900 font-bold text-lg">106.850000</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>

        {{-- Overlay Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 z-40 bg-[#001e36]/80 backdrop-blur-sm lg:hidden" x-cloak></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi Peta Read-Only
            const lat = -6.32;
            const lng = 106.85;

            const map = L.map('detailMap', {
                zoomControl: false, // Hide zoom control for cleaner look
                dragging: false, // Disable dragging
                scrollWheelZoom: false // Disable scroll zoom
            }).setView([lat, lng], 15);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map);
        });
    </script>
</body>

</html>
