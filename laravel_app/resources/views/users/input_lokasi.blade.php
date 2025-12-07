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
                        <x-icons.info-circle class="w-5 h-5 mt-0.5 shrink-0" />
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
                                <span class="mr-3 text-gray-500 "><x-icons.shopping-bag class="w-5 h-5" /></span>
                                <input type="text" placeholder="Tebing"
                                    class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                            </div>
                        </div>

                        {{-- Jenis Produk --}}
                        <div class="space-y-2">
                            <label class="font-medium text-gray-700">Jenis Produk <span
                                    class="text-red-500">*</span></label>
                            <div class="relative mt-2 input-custom rounded-xl px-4 py-3 flex items-center">
                                <span class="mr-3 text-gray-500"><x-icons.shopping-cart class="w-5 h-5" /></span>
                                <input type="text" placeholder="Contoh: Makanan Ringan"
                                    class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                            </div>
                        </div>

                        {{-- Alamat Usaha Lengkap --}}
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700 text-lg">Alamat Usaha Lengkap <span
                                    class="text-red-500">*</span></label>
                            <div class="relative input-custom rounded-xl px-4 py-3 flex items-center mb-3">
                                <x-icons.location class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                                        <x-icons.trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </template>

                            <button type="button" @click="licenses.push({ type: '', number: '' })"
                                class="mt-2 text-sm text-[#004a85] font-medium hover:underline flex items-center gap-1 transition-colors">
                                <x-icons.plus class="w-4 h-4" />
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
                                <x-icons.text-description class="w-5 h-5" />
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
                                    <x-icons.loading x-show="geoStatus === 'locating'" class="animate-spin h-5 w-5 text-blue-700" />

                                    {{-- Icon Check --}}
                                    <x-icons.check x-show="geoStatus === 'success'" class="w-5 h-5" />

                                    {{-- Icon Error --}}
                                    <x-icons.exclamation-circle x-show="geoStatus === 'error'" class="w-5 h-5" />

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
                                        <span class="mr-3 text-gray-500"><x-icons.location class="w-5 h-5" /></span>
                                        <input type="text" id="lngInput" placeholder="Contoh: 106.85..."
                                            class="w-full bg-transparent border-none outline-none text-gray-800 placeholder-gray-400 focus:ring-0 p-0 text-sm md:text-base">
                                    </div>
                                </div>

                                {{-- Latitude --}}
                                <div class="space-y-2">
                                    <label class="font-medium text-gray-700">Latitude </label>
                                    <div class="relative mt-2 input-custom rounded-xl px-4 py-3 flex items-center">
                                        <span class="mr-3 text-gray-500"><x-icons.map-folded class="w-5 h-5" /></span>
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
