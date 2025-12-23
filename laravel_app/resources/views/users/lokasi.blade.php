<x-layouts.guest title="Lokasi UMKM - UMKM Sasuma" header-title="Lokasi UMKM" header-subtitle="Tambahkan lokasi baru">

    <div x-data="locationHybrid()" x-init="init()" class="relative">

        {{-- 1. HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Titik Lokasi UMKM</h2>

            <div x-show="isLaptop"
                class="bg-[#FFC107] text-black px-4 py-3 rounded-lg text-sm font-medium shadow-sm max-w-md flex items-start gap-2">
                <x-icons.info-circle class="w-5 h-5 mt-0.5 shrink-0" />
                <span>Saat ini perangkat Anda menggunakan laptop sehingga masukkan koordinat manual. Peta akan
                    menyesuaikan otomatis.</span>
            </div>
        </div>

        {{-- 2. ALERTS --}}
        <div x-show="showSuccessAlert"
            class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2 border border-green-200">
            <x-icons.check class="w-6 h-6 shrink-0" />
            <span x-text="successMessage"></span>
            <button @click="showSuccessAlert = false"
                class="ml-auto text-green-500 hover:text-green-700">&times;</button>
        </div>

        {{-- ALERT LOCKED (SESUAI REQUEST) --}}
        <div x-show="showLockedAlert" x-transition
            class="fixed top-4 left-4 right-4 z-[70] flex items-center gap-2 bg-red-50 text-red-600 px-4 py-3 rounded-lg border border-red-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;">
            <x-icons.lock-closed class="w-5 h-5 shrink-0" />

            <span class="text-sm font-medium">
                Mode Desktop Terkunci: Silakan masukkan koordinat manual atau gunakan HP.
            </span>

            <button type="button" @click="showLockedAlert = false"
                class="ml-auto text-red-400 hover:text-red-600 focus:outline-none p-1">
                <span class="text-xl font-bold leading-none">&times;</span>
            </button>
        </div>

        <div x-show="showNoChangeAlert"
            class="fixed top-4 left-4 right-4 z-[60] flex items-start gap-2 bg-blue-50 text-blue-600 px-4 py-3 rounded-lg border border-blue-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;" x-transition>
            <x-icons.info-circle class="w-5 h-5 shrink-0" />
            <span class="text-sm">Lokasi belum berubah. Silakan atur koordinat.</span>
        </div>

        {{-- 3. FORM UTAMA --}}
        <form action="{{ url('/users/lokasi/store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Hidden Input untuk Address agar ikut tersubmit (Opsional tapi disarankan) --}}
            <input type="hidden" name="address" x-model="address">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- KOLOM KIRI: MAP PREVIEW --}}
                <div class="space-y-4">
                    <div class="relative group">
                        <div class="lg:hidden mb-2 flex justify-between items-center">
                            <label class="text-sm font-bold text-gray-700">Peta Lokasi</label>
                            <span class="text-xs text-blue-600"
                                x-text="address && address !== 'Memuat alamat...' ? 'Lokasi terpilih' : 'Belum diatur'"></span>
                        </div>

                        {{-- CONTAINER PETA --}}
                        <div
                            class="relative w-full h-64 lg:h-96 rounded-xl border border-gray-300 shadow-sm overflow-hidden bg-gray-100">

                            {{-- Peta Leaflet --}}
                            <div id="desktopMap" class="w-full h-full z-0"></div>

                            {{-- OVERLAY DESKTOP (Agar tidak bisa diklik/geser & Trigger Alert) --}}
                            <div x-show="isLaptop" @click="triggerLockedAlert()"
                                class="absolute inset-0 z-[10] bg-transparent cursor-not-allowed">
                            </div>

                            {{-- OVERLAY MOBILE (Tombol Buka Modal) --}}
                            <div class="lg:hidden absolute inset-0 z-[20] cursor-pointer flex items-center justify-center bg-black/2 hover:bg-black/10 transition-colors"
                                @click="openMobileModal()">
                                <div
                                    class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-md text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <x-icons.map-folded class="w-4 h-4" />
                                    <span x-text="hasChanged ? 'Ubah Lokasi' : 'Atur Lokasi'"></span>
                                </div>
                            </div>
                        </div>

                        <p class="mt-2 text-xs text-gray-500 text-center lg:text-left">
                            <span class="hidden lg:inline">Peta ini hanya pratinjau. Masukkan koordinat di kolom
                                kanan.</span>
                            <span class="lg:hidden">Ketuk peta untuk mengubah lokasi lebih akurat.</span>
                        </p>
                    </div>
                </div>

                {{-- KOLOM KANAN: INPUT FIELDS --}}
                <div class="space-y-6 flex flex-col justify-center">

                    {{-- Input LATITUDE --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">Latitude</label>
                        {{-- Desktop: Editable, Mobile: Readonly --}}
                        <x-ui.input variant="soft" type="text" name="latitude" x-model="lat"
                            x-bind:readonly="isMobile" @input.debounce.800ms="updateMapFromInput()"
                            placeholder="-6.xxxxx" ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                            <x-slot:icon><x-icons.map-folded class="w-5 h-5" /></x-slot:icon>
                        </x-ui.input>
                    </div>

                    {{-- Input LONGITUDE --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">Longitude</label>
                        {{-- Desktop: Editable, Mobile: Readonly --}}
                        <x-ui.input variant="soft" type="text" name="longitude" x-model="lng"
                            x-bind:readonly="isMobile" @input.debounce.800ms="updateMapFromInput()"
                            placeholder="106.xxxxx" ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                            <x-slot:icon><x-icons.location class="w-5 h-5" /></x-slot:icon>
                        </x-ui.input>
                    </div>

                    {{-- Menampilkan Alamat --}}
                    <div x-show="address"
                        class="p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm text-gray-600">
                        <span class="font-bold block text-gray-800 mb-1">Alamat Terdeteksi:</span>
                        <div class="flex items-start gap-2">
                            <x-icons.loading x-show="isLoadingAddress" class="w-4 h-4 animate-spin mt-0.5 shrink-0" />
                            <span x-text="address"></span>
                        </div>
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div class="pt-4 flex justify-center lg:justify-start">
                        <div class="w-full lg:w-auto relative" @click="triggerNoChangeAlert()">
                            <x-ui.button type="submit" variant="default"
                                class="w-full lg:w-auto px-8 py-3 rounded-xl shadow-md transition-all flex items-center justify-center gap-2"
                                ::class="!hasChanged ? 'opacity-50 cursor-not-allowed pointer-events-none' :
                                    'hover:scale-105 active:scale-95'" x-bind:disabled="!hasChanged">
                                <x-icons.check class="w-5 h-5" />
                                Simpan Lokasi
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- 4. MOBILE MODAL (FULLSCREEN) --}}
        <div x-show="isModalOpen" style="display: none;"
            class="fixed inset-0 z-[100] bg-white flex flex-col w-full h-[100dvh]"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-full">

            {{-- Header Modal --}}
            <div
                class="px-4 py-3 border-b border-gray-200 flex items-center justify-between bg-white shadow-sm z-10 shrink-0 h-16">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Pilih Lokasi</h3>
                    <p class="text-xs text-gray-500">Geser peta ke titik usaha Anda</p>
                </div>
                <button type="button" @click="closeMobileModal()"
                    class="p-2 rounded-full hover:bg-gray-100 text-gray-500">
                    <x-icons.x-mark class="w-6 h-6" />
                </button>
            </div>

            {{-- Map Area --}}
            <div class="relative flex-1 w-full bg-gray-100">
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[500] pointer-events-none pb-8">
                    <x-icons.location class="w-8 h-8 text-red-600 drop-shadow-md" />
                </div>

                <div class="absolute bottom-6 right-4 z-[400]">
                    <button type="button" @click="locateMeMobile()"
                        class="bg-white p-3 rounded-full shadow-lg border border-gray-200 text-gray-700 hover:text-blue-600 active:bg-gray-50">
                        <x-icons.loading x-show="geoLoading" class="w-6 h-6 animate-spin text-blue-600" />
                        <x-icons.location x-show="!geoLoading" class="w-6 h-6" />
                    </button>
                </div>

                <div id="mobileMap" class="w-full h-full z-0"></div>
            </div>

            {{-- Footer Modal --}}
            <div class="p-4 bg-white border-t border-gray-200 shrink-0 pb-8">
                <div class="mb-4 px-2">
                    <p class="text-sm font-bold text-gray-900 mb-1">Alamat:</p>
                    <div class="flex items-start gap-2">
                        <x-icons.loading x-show="isLoadingAddress" class="w-4 h-4 animate-spin mt-0.5 shrink-0" />
                        <p class="text-sm text-gray-600 leading-snug" x-text="address"></p>
                    </div>
                </div>
                <x-ui.button type="button" @click="confirmMobileLocation()"
                    class="w-full py-3 text-base rounded-xl font-bold shadow-lg">
                    Pilih Lokasi Ini
                </x-ui.button>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            function locationHybrid() {
                return {
                    // --- DATA ---
                    lat: '{{ $shop->latitude ?? -6.2 }}',
                    lng: '{{ $shop->longitude ?? 106.816666 }}',
                    initialLat: '{{ $shop->latitude ?? -6.2 }}',
                    initialLng: '{{ $shop->longitude ?? 106.816666 }}',

                    tempLat: '',
                    tempLng: '',
                    address: 'Memuat alamat...',

                    isLoadingAddress: false,
                    debounceTimer: null,
                    geoLoading: false,

                    // --- UI STATE ---
                    isMobile: window.innerWidth < 1024,
                    isLaptop: window.innerWidth >= 1024,
                    isModalOpen: false,
                    showSuccessAlert: {{ session('success') ? 'true' : 'false' }},
                    showLockedAlert: false,
                    showNoChangeAlert: false,
                    successMessage: '{{ session('success') }}',

                    // --- MAPS ---
                    desktopMap: null,
                    desktopMarker: null,
                    mobileMap: null,

                    // --- CORE: GET ADDRESS ---
                    async getAddress(lat, lng) {
                        if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
                            this.address = "Koordinat belum lengkap/valid";
                            return;
                        }

                        this.isLoadingAddress = true;
                        this.address = "Mencari alamat...";

                        try {
                            let url =
                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
                            let res = await fetch(url, {
                                headers: {
                                    'Accept-Language': 'id-ID,id;q=0.9'
                                }
                            });

                            if (!res.ok) throw new Error("Gagal koneksi");

                            let data = await res.json();
                            this.address = data.display_name || "Alamat tidak ditemukan";
                        } catch (e) {
                            console.error(e);
                            this.address = "Gagal memuat alamat";
                        } finally {
                            this.isLoadingAddress = false;
                        }
                    },

                    // --- MANUAL INPUT HANDLER (DESKTOP) ---
                    updateMapFromInput() {
                        // 1. Validasi Input
                        const latVal = parseFloat(this.lat);
                        const lngVal = parseFloat(this.lng);

                        if (isNaN(latVal) || isNaN(lngVal)) return;

                        // 2. Update Marker & View Peta Desktop
                        if (this.desktopMap && this.desktopMarker) {
                            const newLatLng = new L.LatLng(latVal, lngVal);
                            this.desktopMarker.setLatLng(newLatLng);
                            this.desktopMap.setView(newLatLng, 16);
                        }

                        // 3. PANGGIL ALAMAT (Ini perbaikan untuk pertanyaan ke-2 Anda)
                        this.getAddress(latVal, lngVal);
                    },

                    // --- MOBILE MODAL LOGIC ---
                    openMobileModal() {
                        this.isModalOpen = true;
                        let cLat = parseFloat(this.lat) || -6.2;
                        let cLng = parseFloat(this.lng) || 106.816666;

                        this.tempLat = cLat.toFixed(6);
                        this.tempLng = cLng.toFixed(6);

                        // Load alamat awal modal
                        this.getAddress(cLat, cLng);

                        this.$nextTick(() => {
                            if (!this.mobileMap) {
                                this.mobileMap = L.map('mobileMap', {
                                    center: [cLat, cLng],
                                    zoom: 18,
                                    zoomControl: false
                                });
                                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 19,
                                    attribution: '© OSM'
                                }).addTo(this.mobileMap);

                                this.mobileMap.on('move', () => {
                                    this.address = "Lepas pin untuk memuat alamat...";
                                });
                                this.mobileMap.on('moveend', () => {
                                    const c = this.mobileMap.getCenter();
                                    this.tempLat = c.lat.toFixed(6);
                                    this.tempLng = c.lng.toFixed(6);
                                    if (this.debounceTimer) clearTimeout(this.debounceTimer);
                                    this.debounceTimer = setTimeout(() => this.getAddress(c.lat, c.lng), 800);
                                });
                            } else {
                                setTimeout(() => {
                                    this.mobileMap.invalidateSize();
                                    this.mobileMap.setView([cLat, cLng], 18);
                                }, 300);
                            }
                        });
                    },

                    closeMobileModal() {
                        this.isModalOpen = false;
                    },

                    confirmMobileLocation() {
                        this.lat = this.tempLat;
                        this.lng = this.tempLng;

                        // Update tampilan peta desktop setelah pilih dari mobile
                        this.updateMapFromInput();

                        this.closeMobileModal();
                    },

                    locateMeMobile() {
                        if (!navigator.geolocation) return alert("Browser tidak support GPS");
                        this.geoLoading = true;
                        navigator.geolocation.getCurrentPosition((pos) => {
                            this.mobileMap.setView([pos.coords.latitude, pos.coords.longitude], 18);
                            this.getAddress(pos.coords.latitude, pos.coords.longitude);
                            this.geoLoading = false;
                        }, () => {
                            alert("Gagal GPS");
                            this.geoLoading = false;
                        }, {
                            enableHighAccuracy: true
                        });
                    },

                    // --- DESKTOP MAP INIT ---
                    initDesktopMap() {
                        setTimeout(() => {
                            const el = document.getElementById('desktopMap');
                            if (el && !this.desktopMap) {
                                // Peta Desktop STATIS (Tidak bisa drag/zoom)
                                this.desktopMap = L.map('desktopMap', {
                                    dragging: false,
                                    scrollWheelZoom: false,
                                    doubleClickZoom: false,
                                    boxZoom: false,
                                    keyboard: false,
                                    zoomControl: false
                                }).setView([this.lat, this.lng], 16);

                                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 19,
                                    attribution: '© OSM'
                                }).addTo(this.desktopMap);

                                // Marker Desktop (Statis)
                                this.desktopMarker = L.marker([this.lat, this.lng], {
                                    draggable: false
                                }).addTo(this.desktopMap);

                                // Panggil alamat saat load pertama
                                this.getAddress(this.lat, this.lng);
                            }
                        }, 500);
                    },

                    triggerLockedAlert() {
                        if (this.isLaptop) this.showLockedAlert = true;
                    },

                    // --- UTILS ---
                    get hasChanged() {
                        return String(this.lat) !== String(this.initialLat) ||
                            String(this.lng) !== String(this.initialLng);
                    },

                    triggerNoChangeAlert() {
                        if (!this.hasChanged) {
                            this.showNoChangeAlert = true;
                            setTimeout(() => this.showNoChangeAlert = false, 3000);
                        }
                    },

                    init() {
                        // Pastikan ada nilai default agar tidak error
                        if (!this.lat) this.lat = -6.200000;
                        if (!this.lng) this.lng = 106.816666;

                        this.initDesktopMap();

                        window.addEventListener('resize', () => {
                            this.isMobile = window.innerWidth < 1024;
                            this.isLaptop = window.innerWidth >= 1024;
                        });
                    }
                }
            }
        </script>
    @endpush
</x-layouts.guest>
