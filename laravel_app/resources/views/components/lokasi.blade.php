<style>
    [x-cloak] {
        display: none !important;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 4px;
    }

    .leaflet-div-icon {
        background: transparent;
        border: none;
    }

    /* Hide Spinners for Number Input */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Style Khusus Popup Clean */
    .custom-popup-clean .leaflet-popup-content-wrapper {
        padding: 0 !important;
        /* Hapus padding putih bawaan */
        border-radius: 12px !important;
        /* Rounded corner card */
        overflow: hidden;
    }

    .custom-popup-clean .leaflet-popup-content {
        margin: 0 !important;
        /* MOBILE FIRST: Gunakan lebar layar HP (misal 85% dari lebar layar) */
        width: 85vw !important;
        max-width: 350px !important;
        /* Batasi maksimal lebar seperti desain awal */
    }

    @media (max-width: 640px) {
        .custom-popup-clean .leaflet-popup-content {
            /* Opsional: Sedikit penyesuaian margin jika perlu */
        }
    }

    /* Style Tombol Close (X) agar terlihat bagus di atas gambar */
    .custom-popup-clean .leaflet-popup-close-button {
        color: white !important;
        font-size: 24px !important;
        top: 8px !important;
        right: 8px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        /* Shadow agar terlihat di gambar terang */
        transition: all 0.2s;
    }

    .custom-popup-clean .leaflet-popup-close-button:hover {
        color: #FFC107 !important;
        /* Warna kuning saat hover */
    }

    /* Agar ujung panah popup menyatu warnanya */
    .custom-popup-clean .leaflet-popup-tip {
        background: white;
    }
</style>

<div class="hidden">
    <div id="icon-grid"><x-icons.svg name="arrow-down" class="w-full h-full" /></div>
    <div id="icon-food"><x-icons.svg name="location-food" class="w-full h-full" /></div>
    <div id="icon-fashion"><x-icons.svg name="location-fashion" class="w-full h-full" /></div>
    <div id="icon-work"><x-icons.svg name="location-work" class="w-full h-full" /></div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('umkmMap', () => ({
            sidebarOpen: true,
            search: '',
            showCatDropdown: false,
            showUnitDropdown: false,
            showUnitMenu: false,
            selectedCategory: 'Semua',
            minInput: '',
            maxInput: '',
            filterUnit: 1,
            currentPage: 1,
            itemsPerPage: window.innerWidth < 768 ? 1 : 4,
            map: null,
            activeId: null,
            markers: [],

            // DATA UMKM
            umkms: [{
                    id: 1,
                    name: 'Warung Seblak',
                    badge: 'Kuliner',
                    category: 'Kuliner',
                    iconType: 'food',
                    omset: 'Rp 10 Jt - Rp 100 Jt',
                    description: 'UMKM Ayam Geprek Tebingg adalah usaha kuliner yang menyajikan menu utama ayam geprek dengan cita rasa khas Nusantara. Kami mengutamakan kualitas bahan baku segar, bumbu rempah pilihan, serta tingkat kepedasan yang bisa disesuaikan dengan selera pelanggan.',
                    surat: 'SIUP, IUMK, NIB Berisiko',
                    omsetVal: 10,
                    lat: -6.300,
                    lng: 106.820,
                    images: [
                        'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=400&q=80',
                        'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?auto=format&fit=crop&w=400&q=80',
                        'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=400&q=80'
                    ],
                    img: 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=200&q=80'
                },
                {
                    id: 2,
                    name: 'Tebing Craft',
                    badge: 'Jasa',
                    category: 'Jasa',
                    iconType: 'work',
                    omset: 'Rp 5 Jt - Rp 50 Jt',
                    omsetVal: 5,
                    lat: -6.290,
                    lng: 106.810,
                    img: 'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?auto=format&fit=crop&w=200&q=80'
                },
                {
                    id: 3,
                    name: 'Kopi Senja',
                    badge: 'Kuliner',
                    category: 'Kuliner',
                    iconType: 'food',
                    omset: 'Rp 20 Jt - Rp 200 Jt',
                    omsetVal: 20,
                    lat: -6.310,
                    lng: 106.830,
                    img: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=200&q=80'
                },
                {
                    id: 4,
                    name: 'Tebing Style',
                    badge: 'Fashion',
                    category: 'Fashion',
                    iconType: 'fashion',
                    omset: 'Rp 15 Jt - Rp 150 Jt',
                    omsetVal: 15,
                    lat: -6.295,
                    lng: 106.840,
                    img: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=200&q=80'
                },
                {
                    id: 5,
                    name: 'Sate Taichan',
                    badge: 'Kuliner',
                    category: 'Kuliner',
                    iconType: 'food',
                    omset: 'Rp 50 Jt - Rp 150 Jt',
                    omsetVal: 50,
                    lat: -6.305,
                    lng: 106.850,
                    img: 'https://images.unsplash.com/photo-1529566657458-9adc180d2d9d?auto=format&fit=crop&w=200&q=80'
                },
                {
                    id: 6,
                    name: 'Jahit Rapi',
                    badge: 'Jasa',
                    category: 'Jasa',
                    iconType: 'work',
                    omset: 'Rp 5 Miliar - Rp 20 Miliar',
                    omsetVal: 5,
                    lat: -6.315,
                    lng: 106.815,
                    img: 'https://images.unsplash.com/photo-1517524008697-84bbe3c3fd98?auto=format&fit=crop&w=200&q=80'
                },
            ],

            svgIcons: {
                grid: document.getElementById('icon-grid').innerHTML,
                food: document.getElementById('icon-food').innerHTML,
                fashion: document.getElementById('icon-fashion').innerHTML,
                work: document.getElementById('icon-work').innerHTML,
            },
            setUnit(value) {
                this.filterUnit = value;
                this.showUnitMenu = false; // Tutup menu setelah memilih
            },

            get paginatedList() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                return this.filteredList.slice(start, start + this.itemsPerPage);
            },
            get totalPages() {
                return Math.ceil(this.filteredList.length / this.itemsPerPage);
            },
            nextPage() {
                if (this.currentPage < this.totalPages) this.currentPage++;
            },
            prevPage() {
                if (this.currentPage > 1) this.currentPage--;
            },
            get categories() {
                return ['Semua', ...new Set(this.umkms.map(item => item.category))];
            },
            get filteredList() {
                return this.umkms.filter(item => {
                    const searchMatch = item.name.toLowerCase().includes(this.search
                        .toLowerCase());
                    const catMatch = this.selectedCategory === 'Semua' || item
                        .category === this.selectedCategory;
                    const currentOmset = item.omsetVal; // misal 10 (artinya 10 juta)
                    let minVal = this.minInput === '' ? 0 : parseFloat(this.minInput) *
                        this.filterUnit;
                    let maxVal = this.maxInput === '' ? Infinity : parseFloat(this
                        .maxInput) * this.filterUnit;
                    const minMatch = currentOmset >= minVal;
                    const maxMatch = currentOmset <= maxVal;
                    return searchMatch && catMatch && minMatch && maxMatch;
                });
            },

            init() {
                // Watcher standar untuk filter
                this.$watch('search', () => {
                    this.currentPage = 1;
                    this.updateMarkers();
                });
                this.$watch('selectedCategory', () => {
                    this.currentPage = 1;
                    this.updateMarkers();
                });
                this.$watch('filterUnit', () => {
                    this.currentPage = 1;
                    this.updateMarkers();
                });
                this.$watch('minInput', () => {
                    this.currentPage = 1;
                    this.updateMarkers();
                });
                this.$watch('maxInput', () => {
                    this.currentPage = 1;
                    this.updateMarkers();
                });

                // --- KUNCI PERBAIKAN DI SINI ---
                // Menggunakan requestAnimationFrame untuk sinkronisasi animasi CSS
                // ... di dalam init() ...
                this.$watch('sidebarOpen', () => {
                    const duration = 400;
                    const start = performance.now();

                    const animateMap = (currentTime) => {
                        if (this.map) {
                            this.map.invalidateSize();
                        }

                        if (currentTime - start < duration) {
                            requestAnimationFrame(animateMap);
                        } else {
                            // FORCE UPDATE TERAKHIR:
                            // Kadang CSS selesai 1ms setelah frame terakhir JS.
                            // Kita paksa update lagi sedikit setelah durasi habis.
                            if (this.map) {
                                this.map.invalidateSize();
                                setTimeout(() => {
                                    if (this.map) this.map
                                        .invalidateSize(); // Double tap untuk memastikan
                                }, 100);
                            }
                        }
                    };
                    requestAnimationFrame(animateMap);
                });
                // ----------------------------------

                window.addEventListener('resize', () => {
                    this.itemsPerPage = window.innerWidth < 768 ? 1 : 4;
                    if (this.currentPage > this.totalPages) this.currentPage = 1;
                    if (this.map) this.map.invalidateSize();
                });
            },

            initMap() {
                if (this.map) {
                    this.map.off();
                    this.map.remove();
                }

                // Inisialisasi Map
                this.map = L.map(this.$refs.mapContainer, {
                    zoomControl: false
                }).setView([-6.300, 106.820], 13);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(this.map);

                // ResizeObserver tetap kita pasang untuk memantau perubahan ukuran window browser
                if (window.ResizeObserver && this.$refs.mapContainer) {
                    this.resizeObserver = new ResizeObserver(() => {
                        if (this.map) this.map.invalidateSize();
                    });
                    this.resizeObserver.observe(this.$refs.mapContainer);
                }

                this.updateMarkers();

                setTimeout(() => {
                    if (this.umkms.length > 0) this.focusLocation(this.umkms[0], false);
                }, 500);
            },

            updateMarkers() {
                this.markers.forEach(m => this.map.removeLayer(m.marker));
                this.markers = [];
                this.filteredList.forEach(item => {
                    const customIcon = L.divIcon({
                        className: 'custom-leaflet-icon',
                        html: this.getIconHtml(item.iconType),
                        iconSize: [36, 36],
                        iconAnchor: [18, 18],
                        popupAnchor: [0, -
                            20
                        ] // Sesuaikan posisi popup agar pas di atas pin
                    });

                    const imagesArray = item.images && item.images.length > 0 ? item
                        .images : [item.img];
                    // Kita ubah array jadi string JSON agar bisa disimpan di HTML attribute (escape quotes)
                    const imagesJson = JSON.stringify(imagesArray).replace(/"/g, '&quot;');
                    const popupContent = `
<div class="font-sans w-full bg-white overflow-hidden text-left pb-2">
    
    <div class="relative w-full h-40 md:h-56 overflow-hidden group">
        <img 
            id="popup-img-${item.id}" 
            src="${imagesArray[0]}" 
            data-index="0"
            data-images="${imagesJson}"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
            alt="${item.name}"
        >
        <button onclick="window.changePopupImage(${item.id}, -1)" 
            class="absolute top-1/2 left-2 md:left-4 -translate-y-1/2 bg-[#003366]/80 backdrop-blur-sm text-white p-1.5 md:p-2 rounded-full hover:bg-[#003366] transition shadow-lg z-10 cursor-pointer flex items-center justify-center">
            <svg class="w-3 h-3 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>

        <button onclick="window.changePopupImage(${item.id}, 1)" 
            class="absolute top-1/2 right-2 md:right-4 -translate-y-1/2 bg-[#003366]/80 backdrop-blur-sm text-white p-1.5 md:p-2 rounded-full hover:bg-[#003366] transition shadow-lg z-10 cursor-pointer flex items-center justify-center">
            <svg class="w-3 h-3 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    <div class="px-4 pt-3 pb-3 md:px-6 md:pt-5 md:pb-4"> 
        
        <div class="flex justify-between items-center gap-3">
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight line-clamp-2">${item.name}</h3>
            <span class="bg-[#FFC107] text-black text-[10px] md:text-sm font-medium px-2 py-1 rounded-md shrink-0 mt-1 shadow-sm tracking-wide">
                ${item.badge}
            </span>
        </div>

        <div class="flex items-start gap-1 mt-2 text-gray-600">
    <svg class="w-4 h-4 md:w-5 md:h-5 shrink-0 text-black mt-[12px]"
        fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>

    <p class="text-[12px] md:text-sm leading-snug font-reguler">
        Jl. Podang 14 No 113 RT 03/12 blok H2 BSI 2 pengasinan sawangan Depok
    </p>
</div>



        <div class="mt-1 max-h-24 md:max-h-32 overflow-y-auto custom-scrollbar pr-2">
            <p class="text-xs md:text-[16px] text-gray-700 leading-relaxed md:leading-7">
                ${item.description}
            </p>
        </div>
        
        <div class="h-px bg-gray-200 w-full mt-3 mb-3 md:mt-5 md:mb-5"></div>

        <div class="space-y-2 md:space-y-3">
            <div class="flex items-center gap-2 md:gap-3">
                <svg class="w-4 h-4 md:w-6 md:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-xs md:text-base font-medium text-gray-900">${item.omset}</span>
            </div>
            <div class="flex items-center gap-2 md:gap-3">
                <svg class="w-4 h-4 md:w-6 md:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="text-xs md:text-base font-medium text-gray-900 truncate max-w-[240px] md:max-w-none">${item.surat || 'SIUP, IUMK, NIB Berisiko'}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-x-2 gap-y-2 md:gap-y-3 mt-4 md:mt-6 text-[10px] md:text-sm font-medium text-gray-600">
            
            <div class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer">
                <a 
  href="https://www.instagram.com/" 
  target="_blank" 
  rel="noopener noreferrer"
  class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal"
>
    <svg class="w-3.5 h-3.5 md:w-5 md:h-5 text-[#E4405F] shrink-0 transition-transform" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
    </svg>

    @tebingtsaaa
</a>

            </div>

            <div class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                <a 
  href="https://www.instagram.com/" 
  target="_blank" 
  rel="noopener noreferrer"
  class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal"
>
                <svg class="w-3.5 h-3.5 md:w-5 md:h-5 text-gray-800 shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                google.com
                </a>
            </div>

            <div class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                <a 
  href="https://www.instagram.com/" 
  target="_blank" 
  rel="noopener noreferrer"
  class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal"
>
                <svg class="w-3.5 h-3.5 md:w-5 md:h-5 text-[#1877F2] shrink-0 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                tebingtsaaa
                </a>
            </div>

            <div class="flex text-[12px] md:text-[14px] items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                <a 
  href="https://www.instagram.com/" 
  target="_blank" 
  rel="noopener noreferrer"
  class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal"
>
                <svg class="w-3.5 h-3.5 md:w-5 md:h-5 text-black shrink-0 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                @tebing_tiktok
                </a>
            </div>

            <div class="col-span-2 text-[12px] md:text-[14px] flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer transition">
                <a 
  href="https://www.instagram.com/" 
  target="_blank" 
  rel="noopener noreferrer"
  class="flex items-center gap-1.5 md:gap-2.5 overflow-hidden group cursor-pointer !text-black !font-normal"
>
                <svg class="w-3.5 h-3.5 md:w-5 md:h-5 text-[#25D366] shrink-0 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                081292209345</a>
            </div>
        </div>

        <div class="mt-4 md:mt-8 mb-1 md:mb-2 flex justify-end">
            <button class="bg-[#FFC107] hover:bg-yellow-500 font-reguler py-2.5 px-4 md:py-2 md:px-4 rounded-lg text-xs md:text-base w-auto md:w-auto flex items-center justify-center gap-2 transform active:scale-95">
                <span class="text-[12px] md:text-[14px]">Lihat Toko</span>
                <x-icons.svg name="area-right" class="w-4 h-4" />
            </button>
        </div>

    </div> 
</div>`;

                    const marker = L.marker([item.lat, item.lng], {
                            icon: customIcon
                        })
                        .addTo(this.map)
                        .bindPopup(popupContent, {
                            maxWidth: window.innerWidth < 640 ? 300 : 400,
                            minWidth: window.innerWidth < 640 ? 260 : 350,
                            className: 'custom-popup-clean', // Pastikan class ini sama dengan CSS diatas
                            closeButton: true,
                            autoPan: true,
                            autoPanPadding: [20,
                                20
                            ] // Memberi jarak agar popup tidak mentok layar HP
                        });

                    marker.on('click', () => {
                        this.activeId = item.id;
                    });
                    this.markers.push({
                        id: item.id,
                        marker: marker
                    });
                });
            },

            getIconHtml(type) {
                let color = '#FFC107';
                let svgContent = this.svgIcons.grid;
                if (type === 'food') {
                    color = '#E74C3C';
                    svgContent = this.svgIcons.food;
                } else if (type === 'work') {
                    color = '#3498DB';
                    svgContent = this.svgIcons.work;
                } else if (type === 'fashion') {
                    color = '#F1C40F';
                    svgContent = this.svgIcons.fashion;
                }
                return `<div style='background-color: ${color}; width: 36px; height: 36px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 8px rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; color: white;'><div style="width: 16px; height: 16px;">${svgContent}</div></div>`;
            },
            getCategoryIcon(categoryName) {
                if (categoryName === 'Semua') return this.svgIcons.grid;
                if (categoryName === 'Kuliner') return this.svgIcons.food;
                if (categoryName === 'Fashion') return this.svgIcons.fashion;
                if (categoryName === 'Jasa') return this.svgIcons.work;
                return this.svgIcons.grid;
            },
            focusLocation(item, animate = true) {
                this.activeId = item.id;
                this.map.flyTo([item.lat, item.lng], 15, {
                    animate: animate,
                    duration: 1.5
                });
                const targetObj = this.markers.find(m => m.id === item.id);
                if (targetObj) targetObj.marker.openPopup();
            }
        }));
    });
    window.changePopupImage = function(id, direction) {
        // 1. Ambil elemen gambar berdasarkan ID unik
        const imgElement = document.getElementById(`popup-img-${id}`);

        if (!imgElement) return;

        // 2. Ambil data images dan index saat ini dari atribut HTML
        // Kita parse kembali string JSON menjadi Array
        const images = JSON.parse(imgElement.getAttribute('data-images'));
        let currentIndex = parseInt(imgElement.getAttribute('data-index'));

        // 3. Hitung index baru
        let newIndex = currentIndex + direction;

        // Logic Loop (jika di akhir kembali ke awal, dan sebaliknya)
        if (newIndex >= images.length) {
            newIndex = 0;
        } else if (newIndex < 0) {
            newIndex = images.length - 1;
        }

        // 4. Update src gambar dan atribut index
        imgElement.src = images[newIndex];
        imgElement.setAttribute('data-index', newIndex);
    }
</script>

<section id="lokasi" class="py-0 md:py-12 bg-white overflow-hidden" x-data="umkmMap" x-init="initMap()">
    <div class="container mx-auto max-w-7xl">
        <h1
            class="text-center lg:text-center text-3xl md:text-4xl lg:text-5xl font-medium text-black mb-4 md:mb-8 lg:mb-16 tracking-tight pt-4 md:pt-0">
            Lokasi
        </h1>

        <div
            class="relative flex flex-col md:flex-row h-[90vh] md:h-[1002px] w-full md:w-[1281px] rounded-b-3xl overflow-hidden shadow-2xl bg-white border border-gray-200">

            <div class="absolute top-0 left-0 md:relative z-30 bg-[#003366] transition-all duration-500 ease-in-out flex-shrink-0
                        w-full md:h-full shadow-2xl md:shadow-none"
                :class="sidebarOpen ? 'translate-y-0 md:translate-y-0 md:w-[430px]' :
                    '-translate-y-full md:translate-y-0 md:w-0 md:overflow-hidden'">

                <div class="w-full h-auto md:h-full flex flex-col gap-3 p-4 md:p-6"
                    :class="!sidebarOpen && window.innerWidth >= 768 ? 'opacity-0' : 'opacity-100'"
                    style="transition: opacity 0.2s ease-in-out;">

                    <div class="relative shadow-lg md:shadow-none rounded-lg flex-shrink-0">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <x-icons.svg name="location-search" class="w-5 h-5" />
                        </span>
                        <input type="text" x-model="search" placeholder="Cari..."
                            class="w-full py-3 pl-10 pr-10 bg-white rounded-lg text-sm focus:outline-none text-gray-700 font-medium shadow-sm">
                        <button x-show="search.length > 0" @click="search = ''"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <x-icons.svg name="location-search" class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="flex flex-row gap-1.5 overflow-visible z-50 relative flex-shrink-0 w-full">

                        <div class="relative w-[28%] md:w-[30%] flex-shrink-0 z-20"
                            @click.outside="showCatDropdown = false">
                            <button @click="showCatDropdown = !showCatDropdown"
                                :class="selectedCategory !== 'Semua' ? 'bg-blue-50 text-[#003366]' : ''"
                                class="w-full h-[36px] bg-white text-gray-700 text-[12px] font-medium px-2.5 rounded-lg hover:bg-gray-50 transition whitespace-nowrap flex items-center justify-center gap-2 shadow-md md:shadow-sm border border-transparent group">

                                <div class="flex items-center gap-1 overflow-hidden">
                                    <div class="w-4 h-4 flex-shrink-0" x-show="cat !== 'Semua'"
                                        :class="selectedCategory !== 'Semua' ? 'text-[#003366]' : 'text-gray-800'"
                                        x-html="getCategoryIcon(selectedCategory)">
                                    </div>
                                    <span class="truncate"
                                        x-text="selectedCategory === 'Semua' ? 'Semua' : selectedCategory"></span>
                                </div>

                                <x-icons.svg name="arrow-down"
                                    class="w-4 h-4 text-gray-400 group-hover:text-[#003366] transition-transform duration-200 flex-shrink-0"
                                    ::class="showCatDropdown ? 'rotate-180 text-[#003366]' : ''" />
                            </button>

                            <div x-show="showCatDropdown"
                                class="absolute top-full left-0 mt-1 w-[140px] bg-white rounded-lg shadow-xl z-[100] overflow-hidden border border-gray-100">
                                <div class="py-1">
                                    <template x-for="cat in categories" :key="cat">
                                        <a href="#"
                                            @click.prevent="selectedCategory = cat; showCatDropdown = false"
                                            class="group flex items-center gap-2 px-3 py-1.5 text-[12px] text-gray-700 hover:bg-blue-50 hover:text-[#003366] transition"
                                            :class="selectedCategory === cat ? 'bg-blue-50 font-reguler text-[#003366]' : ''">
                                            <div class="w-3.5 h-3.5" x-show="cat !== 'Semua'"
                                                x-html="getCategoryIcon(cat)"></div>
                                            <span x-text="cat"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-1 items-center flex-1 min-w-0 relative z-10">

                            <div
                                class="relative flex-1 min-w-0 shadow-md md:shadow-none rounded-lg bg-white group hover:border-blue-300 border border-transparent transition h-[36px]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <span class="text-[11px] font-bold text-gray-400">Rp</span>
                                </div>
                                <input type="number" x-model="minInput" placeholder="Min"
                                    class="w-full h-full py-1 pl-6 pr-1 rounded-lg text-[12px] focus:outline-none font-medium bg-transparent"
                                    :class="minInput !== '' ? 'text-black' : 'text-gray-700'">
                            </div>

                            <div class="text-gray-400 font-bold px-0.5 text-xs flex-shrink-0">-</div>

                            <div class="relative flex-[1.4] min-w-0 shadow-md md:shadow-none rounded-lg bg-white group hover:border-blue-300 border border-transparent transition h-[36px]"
                                @click.outside="showUnitMenu = false">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <span class="text-[11px] font-bold text-gray-400">Rp</span>
                                </div>

                                <input type="number" x-model="maxInput" placeholder="Max"
                                    class="w-full h-full py-1 pl-6 pr-14 rounded-lg text-[12px] focus:outline-none font-medium bg-transparent"
                                    :class="maxInput !== '' ? 'text-black' : 'text-gray-700'">

                                <div class="absolute inset-y-0 right-0 flex items-center pr-1">
                                    <button @click="showUnitMenu = !showUnitMenu"
                                        class="h-7 px-1 bg-gray-100 hover:bg-blue-50 text-[#003366] rounded flex items-center gap-0.5 transition border border-gray-200 max-w-[50px]">
                                        <span class="text-[12px] font-reguler truncate"
                                            x-text="getUnitLabel(filterUnit)"></span>
                                        <x-icons.svg name="arrow-down"
                                            class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                                            ::class="showUnitMenu ? 'rotate-180' : ''" />
                                    </button>
                                </div>

                                <div x-show="showUnitMenu" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    class="absolute top-full right-0 mt-1 w-20 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden z-[100]">
                                    <div class="py-1 flex flex-col">
                                        <button @click="setUnit(0.001)"
                                            class="px-3 py-1.5 text-[12px] text-left hover:bg-blue-50 hover:text-[#003366]"
                                            :class="filterUnit === 0.001 ? 'bg-blue-50 font-medium text-[#003366]' :
                                                'text-gray-700'">
                                            Ribu
                                        </button>
                                        <button @click="setUnit(1)"
                                            class="px-3 py-1.5 text-[12px] text-left hover:bg-blue-50 hover:text-[#003366]"
                                            :class="filterUnit === 1 ? 'bg-blue-50 font-medium text-[#003366]' : 'text-gray-700'">
                                            Juta
                                        </button>
                                        <button @click="setUnit(1000)"
                                            class="px-3 py-1.5 text-[12px] text-left hover:bg-blue-50 hover:text-[#003366]"
                                            :class="filterUnit === 1000 ? 'bg-blue-50 font-medium text-[#003366]' :
                                                'text-gray-700'">
                                            Miliar
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="md:hidden flex items-center gap-2 mt-2 w-full">

                        <div class="flex-1 min-w-0">
                            <template x-for="item in paginatedList" :key="item.id">
                                <div class="bg-white rounded-xl p-3 h-[150px] shadow-sm animate-fade-in flex gap-3">
                                    <div
                                        class="w-[90px] h-full rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                                        <img :src="item.img"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <div class="flex-1 flex flex-col justify-between h-full py-0.5 min-w-0">
                                        <div>
                                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                <h3 class="text-base font-bold text-gray-800 leading-tight line-clamp-2"
                                                    x-text="item.name"></h3>
                                                <span class="text-[10px] bg-yellow-400 px-2 py-0.5 rounded font-bold"
                                                    x-text="item.badge"></span>
                                            </div>
                                            <div class="text-[11px]">
                                                <p class="font-medium">Omset: </p>
                                                <p class="font-reguler" x-text="item.omset"></p>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-center mt-2">
                                            <button @click="focusLocation(item)"
                                                class="text-[11px] flex items-center gap-1 group transition cursor-pointer hover:text-[#003366] px-3 py-1 rounded-md font-reguler w-fit">
                                                Lokasi <x-icons.svg name="area-right" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="filteredList.length === 0"
                                class="text-center text-white/70 mt-4 text-sm w-full">Tidak ada data.</div>
                        </div>
                        <button @click="prevPage()" :disabled="currentPage === 1"
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] shadow-lg border border-gray-100 active:scale-95 transition disabled:opacity-50 flex-shrink-0">
                            <x-icons.svg name="arrow-left" class="w-5 h-5" />
                        </button>
                        <button @click="nextPage()" :disabled="currentPage === totalPages"
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] shadow-lg border border-gray-100 active:scale-95 transition disabled:opacity-50 flex-shrink-0">
                            <x-icons.svg name="arrow-right" class="w-5 h-5" />
                        </button>
                    </div>

                    <div
                        class="hidden md:flex flex-1 w-full flex-col items-stretch gap-4 overflow-y-auto custom-scrollbar pr-2 -mr-2 pl-1 py-2 min-h-[150px]">
                        <div class="flex-1 min-w-0 w-full flex flex-col gap-4">
                            <template x-for="item in paginatedList" :key="item.id">
                                <div
                                    class="bg-white rounded-xl p-3 md:p-4 h-[140px] md:h-[180px] hover:shadow-lg w-full shadow-sm animate-fade-in flex gap-3">
                                    <div
                                        class="w-[90px] md:w-[120px] h-full rounded-lg overflow-hidden flex-shrink-0 bg-gray-200 relative group">
                                        <img :src="item.img"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <div class="flex-1 flex flex-col justify-between h-full py-0.5 min-w-0">
                                        <div>
                                            <div class="flex items-center gap-2 mb-2 flex-wrap md:mb-6">
                                                <h3 class="text-base md:text-lg font-bold text-gray-800 leading-tight line-clamp-2"
                                                    x-text="item.name"></h3>
                                                <span class="text-xs bg-yellow-400 px-2 py-1 rounded-md font-medium"
                                                    x-text="item.badge"></span>
                                            </div>
                                            <div class="text-[12px] md:text-[16px]">
                                                <p class="font-medium">Omset: </p>
                                                <p class="font-reguler" x-text="item.omset"></p>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-center mt-2">
                                            <button @click="focusLocation(item)"
                                                class="text-[11px] md:text-[14px] flex items-center gap-1 group transition cursor-pointer hover:text-[#003366] text-black bg-gray-100 px-3 py-1 rounded-md md:bg-transparent md:p-0 font-semibold md:font-normal w-fit">
                                                Lokasi <x-icons.svg name="area-right" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="filteredList.length === 0"
                                class="text-center text-white/70 mt-4 text-sm w-full">Tidak ada data.</div>
                        </div>
                    </div>

                    <div class="hidden md:flex justify-center gap-4 items-center pb-0 pt-2 mt-auto">
                        <button @click="prevPage()" :disabled="currentPage === 1"
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] transition border border-gray-100 shadow-md disabled:opacity-50">
                            <x-icons.svg name="arrow-down" class="w-6 h-6 -rotate-180" />
                        </button>
                        <span class="text-white text-xs font-bold tracking-wider"><span x-text="currentPage"></span> /
                            <span x-text="totalPages"></span></span>
                        <button @click="nextPage()" :disabled="currentPage === totalPages"
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#003366] transition border border-gray-100 shadow-md disabled:opacity-50">
                            <x-icons.svg name="arrow-down" class="w-6 h-6" />
                        </button>
                    </div>
                    <div x-show="sidebarOpen" x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="md:hidden absolute -bottom-6.5 left-1/2 transform -translate-x-1/2 z-50 flex gap-2 items-center">

                        <button @click="sidebarOpen = false"
                            class="w-10 h-10 bg-[#FFC107] rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-yellow-400 text-[#003366] transition-transform hover:scale-105">
                            <x-icons.svg name="arrow-down" class="w-5 h-5 -rotate-180" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="relative flex-1 bg-gray-200 h-full w-full min-w-0">

                <div class="hidden md:flex absolute top-32 -left-4 z-50 transition-all duration-300"
                    x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-x-5"
                    x-transition:enter-end="opacity-100 translate-x-0">

                    <button @click="sidebarOpen = false"
                        class="w-8 h-8 bg-[#FFC107] rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-yellow-400 text-[#003366] transition-transform hover:scale-110">
                        <x-icons.svg name="arrow-left" class="w-4 h-4" />
                    </button>
                </div>

            </div>

            <div class="absolute top-4 md:top-6 left-1/2 transform -translate-x-1/2 z-[400]" x-show="!sidebarOpen"
                x-cloak x-transition:enter="transition ease-out duration-500 delay-200"
                x-transition:enter-start="opacity-0 -translate-y-8 scale-90"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-8 scale-90">

                <button @click="sidebarOpen = true"
                    class="group flex items-center gap-2 md:gap-3 bg-white pl-2 pr-4 py-1.5 md:pl-4 md:pr-5 md:py-2.5 rounded-full shadow-xl border border-gray-200/80 cursor-pointer hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:-translate-y-0.5 transition-all duration-300 w-max max-w-[90vw]">

                    <div
                        class="w-7 h-7 md:w-8 md:h-8 bg-[#003366] rounded-full flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300 shrink-0">
                        <x-icons.svg name="location-search" class="w-3.5 h-3.5 md:w-4 md:h-4" />
                    </div>

                    <div class="flex flex-col text-left">
                        <span
                            class="text-[#003366] text-[11px] md:text-xs font-bold uppercase tracking-wider whitespace-nowrap">Cari
                            Lokasi</span>
                        <span class="text-gray-500 text-[10px] font-medium leading-none md:block">Filter
                            Kategori & Harga</span>
                    </div>

                    <div
                        class="ml-1 pl-2 md:ml-2 md:pl-3 border-l border-gray-200 text-gray-300 group-hover:text-[#FFC107] transition-colors">
                        <x-icons.svg name="arrow-right" class="w-3.5 h-3.5 md:w-4 md:h-4" />
                    </div>
                </button>
            </div>

            <div x-ref="mapContainer" class="w-full h-full outline-none z-10"></div>

            <div
                class="absolute bottom-8 right-8 flex flex-col bg-white rounded-md shadow-lg z-[400] overflow-hidden border border-gray-200">
                <button @click="map.zoomIn()"
                    class="w-10 h-10 flex items-center justify-center text-gray-600 border-b hover:bg-gray-50 text-xl font-bold">+</button>
                <button @click="map.zoomOut()"
                    class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xl font-bold">-</button>
            </div>
        </div>
    </div>
    </div>
</section>
