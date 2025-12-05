<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Lokasi - UMKM Sasuma</title>
    @vite('resources/css/app.css')

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Leaflet CSS & JS (Untuk Peta) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .input-custom {
            background-color: #F9F8F6;
            border: 1.5px solid #d1d5db;
            transition: all 0.2s ease-in-out;
        }

        .input-custom:focus-within {
            background-color: #fff;
            border-color: #d1d5db;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-white font-sans text-gray-900 antialiased" x-data="{
    sidebarOpen: false,
    sidebarExpanded: true,
    minOmset: '',
    maxOmset: '',
    isLaptop: window.innerWidth >= 1024,

    // STATUS LOKASI UNTUK PEMBERITAHUAN
    geoStatus: 'idle', // idle, locating, success, error
    geoMessage: '',

    checkDevice() {
        this.isLaptop = window.innerWidth >= 1024;
    },

    formatRupiah(value) {
        let number_string = value.replace(/[^,\d]/g, '').toString();
        let split = number_string.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
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
            <x-header-mobile title="Input Lokasi" subtitle="Tambahkan lokasi baru" />

            {{-- Content --}}
            <main class="flex-1 p-6 md:p-10 lg:p-16 overflow-x-hidden">

                {{-- Header Title & Banner --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Input Titik Lokasi</h2>

                    {{-- Yellow Notification Banner (Hanya muncul jika isLaptop = true) --}}
                    <div x-show="isLaptop" x-transition
                        class="bg-[#FFC107] text-black px-4 py-3 rounded-lg text-sm font-medium shadow-sm max-w-md flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Perangkat Anda sedang menggunakan laptop, lokasi akurat dapat diisi dengan titik
                            koordinat.</span>
                    </div>
                </div>

                <form action="#" method="POST" class="space-y-8">
                    {{-- Grid Input Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                        {{-- Nama Usaha --}}
                        <div class="space-y-2">
                            <label class="font-medium text-gray-700">Nama Usaha <span
                                    class="text-red-500">*</span></label>
                            <div class="relative input-custom rounded-xl mt-2 px-4 py-3 flex items-center">
                                <span class="mr-3 text-gray-500 "><svg class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg></span>
                                <input type="text" placeholder="Tebing"
                                    class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                            </div>
                        </div>

                        {{-- Jenis Produk --}}
                        <div class="space-y-2">
                            <label class="font-medium text-gray-700">Jenis Produk <span
                                    class="text-red-500">*</span></label>
                            <div class="relative mt-2 input-custom rounded-xl px-4 py-3 flex items-center">
                                <span class="mr-3 text-gray-500"><svg class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg></span>
                                <input type="text" placeholder="Contoh: Makanan Ringan"
                                    class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                            </div>
                        </div>

                        {{-- Alamat Usaha Lengkap --}}
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700 text-lg">Alamat Usaha Lengkap <span
                                    class="text-red-500">*</span></label>
                            <div class="relative input-custom rounded-xl px-4 py-3 flex items-center mb-3">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                <input type="text" value="Jl. Merpati No. 45"
                                    class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="relative input-custom rounded-xl px-4 py-3 flex items-center w-1/2 justify-center">
                                    <input type="text" value="005" placeholder="RT"
                                        class="w-full bg-transparent border-none outline-none text-center text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                </div>
                                <div
                                    class="relative input-custom rounded-xl px-4 py-3 flex items-center w-1/2 justify-center">
                                    <input type="text" value="012" placeholder="RW"
                                        class="w-full bg-transparent border-none outline-none text-center text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                </div>
                            </div>
                        </div>

                        {{-- Izin Usaha (Dynamic) --}}
                        <div class="flex flex-col gap-2" x-data="{ licenses: [{ type: '', number: '' }] }">
                            <label class="font-medium text-gray-700">Izin Usaha</label>

                            <template x-for="(license, index) in licenses" :key="index">
                                <div class="flex flex-row gap-3 mb-3">
                                    {{-- Tipe Izin --}}
                                    <div class="relative input-custom rounded-xl px-4 py-3 flex items-center flex-1">
                                        <input type="text" x-model="license.type" name="license_type[]"
                                            placeholder="Nama Surat Izin"
                                            class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                                    </div>

                                    {{-- Nomor Izin --}}
                                    <div class="relative input-custom rounded-xl px-4 py-3 flex items-center flex-1">
                                        <input type="text" x-model="license.number" name="license_number[]"
                                            placeholder="Nomor Surat Izin"
                                            class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                                    </div>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" @click="licenses.splice(index, 1)"
                                        x-show="licenses.length > 1"
                                        class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors shrink-0"
                                        title="Hapus Izin">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <button type="button" @click="licenses.push({ type: '', number: '' })"
                                class="mt-2 text-sm text-[#004a85] font-medium hover:underline flex items-center gap-1 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Izin Lain
                            </button>
                        </div>

                        {{-- Jenis Usaha (Radio Grid) --}}

                        <div class="space-y-2">
                            <label class="font-medium text-gray-700">Jenis Usaha <span
                                    class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-y-2 gap-x-4 text-sm text-gray-600 mt-1">

                                <label
                                    class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                    <input type="radio" name="jenis_usaha"
                                        class="text-[#004a85] focus:ring-[#004a85] cursor-pointer" checked>
                                    <span>Kuliner</span>
                                </label>

                                <label
                                    class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                    <input type="radio" name="jenis_usaha"
                                        class="text-[#004a85] focus:ring-[#004a85] cursor-pointer">
                                    <span>Pakaian & Fashion</span>
                                </label>

                                <label
                                    class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                    <input type="radio" name="jenis_usaha"
                                        class="text-[#004a85] focus:ring-[#004a85] cursor-pointer">
                                    <span>Agribisnis</span>
                                </label>

                                <label
                                    class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                    <input type="radio" name="jenis_usaha"
                                        class="text-[#004a85] focus:ring-[#004a85] cursor-pointer">
                                    <span>Kelontong</span>
                                </label>

                                <label
                                    class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                    <input type="radio" name="jenis_usaha"
                                        class="text-[#004a85] focus:ring-[#004a85] cursor-pointer">
                                    <span>Kerajinan Tangan</span>
                                </label>

                                <label
                                    class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                    <input type="radio" name="jenis_usaha"
                                        class="text-[#004a85] focus:ring-[#004a85] cursor-pointer">
                                    <span>Jasa</span>
                                </label>

                            </div>
                        </div>

                        {{-- Omset Penjualan --}}
                        <div class="space-y-2">
                            <label class="font-medium text-gray-700">Omset Penjualan <span
                                    class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div class="relative input-custom rounded-xl px-4 py-3 flex items-center group">
                                    <span
                                        class="mr-2 text-gray-500 font-medium group-focus-within:text-blue-600 transition-colors">Rp</span>
                                    <input type="text" x-model="minOmset"
                                        @input="minOmset = formatRupiah($el.value)" placeholder="Minimal"
                                        class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base font-medium">
                                </div>
                                <div class="relative input-custom rounded-xl px-4 py-3 flex items-center group">
                                    <span
                                        class="mr-2 text-gray-500 font-medium group-focus-within:text-blue-600 transition-colors">Rp</span>
                                    <input type="text" x-model="maxOmset"
                                        @input="maxOmset = formatRupiah($el.value)" placeholder="Maksimal"
                                        class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base font-medium">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 ml-1">Contoh: Min <span class="font-bold">1.000.000</span>
                                - Max <span class="font-bold">5.000.000</span></p>
                        </div>
                    </div>

                    {{-- Deskripsi Usaha --}}
                    <div class="space-y-2 w-full md:w-1/2">
                        <label class="font-medium text-gray-700">Deskripsi Usaha <span
                                class="text-red-500">*</span></label>
                        <div class="relative mt-2 input-custom rounded-xl px-4 py-3 flex items-start h-full">
                            <span class="mr-3 text-gray-500 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                            </span>
                            {{-- Rows ditambah biar agak tinggi dikit proporsional --}}
                            <textarea rows="4" placeholder="Masukkan deskripsi yang sangat menarik"
                                class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base resize-none"></textarea>
                        </div>
                    </div>

                    {{-- Detail Titik Lokasi (Langsung muncul tanpa dropdown) --}}
                    <div class="pt-2">
                        <h3 class="font-medium text-gray-700 mb-1">Detail Titik Lokasi <span
                                class="text-red-500">*</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            {{-- MOBILE ONLY: MAP AREA --}}
                            <div x-show="!isLaptop" class="space-y-3">

                                {{-- NOTIFIKASI STATUS GEOLOCATION (MOBILE) --}}
                                <div x-show="geoStatus !== 'idle'"
                                    class="px-4 py-3 rounded-lg text-sm font-medium flex items-center gap-2 transition-all duration-300"
                                    :class="{
                                        'bg-blue-50 text-blue-700': geoStatus === 'locating',
                                        'bg-green-50 text-green-700': geoStatus === 'success',
                                        'bg-red-50 text-red-700': geoStatus === 'error'
                                    }">

                                    {{-- Icon Loading --}}
                                    <svg x-show="geoStatus === 'locating'" class="animate-spin h-5 w-5 text-blue-700"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>

                                    {{-- Icon Check --}}
                                    <svg x-show="geoStatus === 'success'" class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>

                                    {{-- Icon Error --}}
                                    <svg x-show="geoStatus === 'error'" class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>

                                    <span x-text="geoMessage"></span>
                                </div>

                                {{-- PETA --}}
                                <div
                                    class="rounded-xl overflow-hidden h-72 border border-gray-300 shadow-sm relative z-0">
                                    <div id="inputMap" class="w-full h-full z-0"></div>
                                </div>
                                <p class="text-xs text-gray-500 text-center">Geser peta untuk menyesuaikan titik lokasi
                                    lebih presisi.</p>
                            </div>

                            {{-- 
                                COORDINATE INPUTS:
                                - Logic: Tampil HANYA jika laptop (isLaptop)
                            --}}
                            <div class="space-y-6" x-show="isLaptop">
                                {{-- Longitude --}}
                                <div class="space-y-2">
                                    <label class="font-medium text-gray-700">Longitude </label>
                                    <div class="relative mt-2 input-custom rounded-xl px-4 py-3 flex items-center">
                                        <span class="mr-3 text-gray-500"><svg class="w-5 h-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg></span>
                                        <input type="text" id="lngInput" placeholder="Contoh: 106.85..."
                                            class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                                    </div>
                                </div>

                                {{-- Latitude --}}
                                <div class="space-y-2">
                                    <label class="font-medium text-gray-700">Latitude </label>
                                    <div class="relative mt-2 input-custom rounded-xl px-4 py-3 flex items-center">
                                        <span class="mr-3 text-gray-500"><svg class="w-5 h-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                                </path>
                                            </svg></span>
                                        <input type="text" id="latInput" placeholder="Contoh: -6.32..."
                                            class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                                    </div>
                                </div>

                                {{-- Button Simpan untuk Laptop (Di dalam kolom kanan) --}}
                                <div class="pt-4 flex justify-end">
                                    <button type="submit"
                                        class="w-full md:w-auto bg-[#FFC107] cursor-pointer font-medium py-3 px-12 rounded-xl transition-transform active:scale-95 shadow-md">
                                        Simpan
                                    </button>
                                </div>
                            </div>

                            {{-- Button Simpan untuk Mobile (Di bawah peta) --}}
                            <div x-show="!isLaptop" class="pt-4 flex justify-end md:hidden">
                                <button type="submit"
                                    class="w-full bg-[#FFC107] cursor-pointer font-medium py-3 px-12 rounded-xl transition-transform active:scale-95 shadow-md">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </main>
        </div>

        {{-- Overlay Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 z-40 bg-[#001e36]/80 backdrop-blur-sm lg:hidden" x-cloak></div>
    </div>

    {{-- Script Peta --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                setTimeout(() => {
                    const mapContainer = document.getElementById('inputMap');
                    // Inisialisasi peta hanya jika kontainer ditemukan (bukan laptop/mode desktop)
                    if (mapContainer && !mapContainer._leaflet_id) {

                        // Default Lokasi (Sementara)
                        const defaultLat = -6.32;
                        const defaultLng = 106.85;

                        const map = L.map('inputMap').setView([defaultLat, defaultLng], 13);
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);

                        const marker = L.marker([defaultLat, defaultLng], {
                            draggable: true
                        }).addTo(map);

                        const updateInputs = (latlng) => {
                            const latIn = document.getElementById('latInput');
                            const lngIn = document.getElementById('lngInput');
                            if (latIn) latIn.value = latlng.lat.toFixed(6);
                            if (lngIn) lngIn.value = latlng.lng.toFixed(6);
                        };

                        // Event Marker
                        marker.on('dragend', function(e) {
                            updateInputs(marker.getLatLng());
                        });
                        map.on('click', function(e) {
                            marker.setLatLng(e.latlng);
                            updateInputs(e.latlng);
                        });

                        // --- LOGIC GEOLOCATION / DETEKSI LOKASI ---
                        // Ambil komponen Alpine untuk update status text
                        const alpineData = Alpine.$data(document.querySelector('body'));

                        if (navigator.geolocation) {
                            // Update Status: Sedang mencari...
                            alpineData.geoStatus = 'locating';
                            alpineData.geoMessage = 'Sedang mendeteksi lokasi Anda...';

                            navigator.geolocation.getCurrentPosition(
                                // SUKSES
                                (position) => {
                                    const {
                                        latitude,
                                        longitude
                                    } = position.coords;

                                    // Pindahkan Peta & Marker ke lokasi User
                                    map.setView([latitude, longitude], 16); // Zoom lebih dekat
                                    marker.setLatLng([latitude, longitude]);

                                    // Update Input Hidden
                                    updateInputs({
                                        lat: latitude,
                                        lng: longitude
                                    });

                                    // Update Status: Berhasil
                                    alpineData.geoStatus = 'success';
                                    alpineData.geoMessage =
                                        'Lokasi ditemukan! Sesuaikan titik jika perlu.';
                                },
                                // ERROR / DITOLAK
                                (error) => {
                                    console.error("Geo Error:", error);
                                    alpineData.geoStatus = 'error';
                                    alpineData.geoMessage =
                                        'Gagal mengambil lokasi. Pastikan GPS aktif.';
                                },
                                // OPSI AKURASI TINGGI (PENTING UNTUK HP)
                                {
                                    enableHighAccuracy: true, // Paksa pakai GPS Hardware
                                    timeout: 10000, // Batas waktu 10 detik
                                    maximumAge: 0 // Jangan pakai cache lokasi lama
                                }
                            );
                        } else {
                            alpineData.geoStatus = 'error';
                            alpineData.geoMessage = 'Browser Anda tidak mendukung Geolocation.';
                        }

                        // Resize observer
                        const observer = new ResizeObserver(() => {
                            map.invalidateSize();
                        });
                        observer.observe(mapContainer);
                    }
                }, 100);
            });
        });
    </script>

</body>

</html>
