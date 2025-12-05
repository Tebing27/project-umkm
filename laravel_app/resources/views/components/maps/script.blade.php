@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {

            // 1. STORE GLOBAL (JEMBATAN KOMUNIKASI)
            Alpine.store('region', {
                selected: '',
                set(name) {
                    this.selected = name;
                },
                reset() {
                    this.selected = '';
                }
            });

            Alpine.data('umkmMap', () => ({
                sidebarOpen: true,
                search: '',
                showCatDropdown: false,
                showRegionDropdown: false,
                selectedCategory: 'Semua',
                minInput: '',
                maxInput: '',
                filterUnit: 1,
                currentPage: 1,
                itemsPerPage: window.innerWidth < 768 ? 1 : 4,
                map: null,
                activeId: null,
                markers: [],

                // --- DATA UMKM (DITAMBAHKAN FIELD 'REGION') ---
                // Pastikan ejaan 'region' SAMA PERSIS dengan title di slider wilayah
                umkms: [{
                        id: 1,
                        name: 'Warung Seblak',
                        region: 'Cinangka',
                        badge: 'Kuliner',
                        category: 'Kuliner',
                        iconType: 'food',
                        omset: 'Rp 10 Jt - Rp 100 Jt',
                        omsetVal: 10,
                        description: 'UMKM Ayam Geprek Tebingg...',
                        surat: 'SIUP, IUMK, NIB Berisiko',
                        // UBAH KOORDINAT AGAR MASUK BATAS
                        lat: -6.2800, // Masuk dalam range -6.25 s/d -6.35
                        lng: 106.8200, // Masuk dalam range 106.75 s/d 106.90
                        images: [
                            'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=400&q=80'
                        ],
                        img: 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?auto=format&fit=crop&w=200&q=80'
                    },
                    {
                        id: 2,
                        name: 'Tebing Craft',
                        region: 'Cinangka',
                        badge: 'Jasa',
                        category: 'Jasa',
                        iconType: 'work',
                        omset: 'Rp 5 Jt - Rp 50 Jt',
                        omsetVal: 5,
                        description: 'Kerajinan tangan lokal...',
                        lat: -6.3000, // Masuk
                        lng: 106.8500, // Masuk
                        img: 'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?auto=format&fit=crop&w=200&q=80'
                    },
                    {
                        id: 3,
                        name: 'Kopi Senja',
                        region: 'Cinangka',
                        badge: 'Kuliner',
                        category: 'Kuliner',
                        iconType: 'food',
                        omset: 'Rp 20 Jt - Rp 200 Jt',
                        omsetVal: 20,
                        description: 'Kopi nikmat senja hari...',
                        lat: -6.3200, // Masuk
                        lng: 106.7800, // Masuk
                        img: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=200&q=80'
                    },
                    {
                        id: 4,
                        name: 'Tebing Style',
                        region: 'Cinangka',
                        badge: 'Fashion',
                        category: 'Fashion',
                        iconType: 'fashion',
                        omset: 'Rp 15 Jt - Rp 150 Jt',
                        omsetVal: 15,
                        description: 'Fashion kekinian...',
                        lat: -6.2900, // Masuk
                        lng: 106.8800, // Masuk
                        img: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=200&q=80'
                    },
                    {
                        id: 5,
                        name: 'Sate Taichan',
                        region: 'Cinangka',
                        badge: 'Kuliner',
                        category: 'Kuliner',
                        iconType: 'food',
                        omset: 'Rp 50 Jt - Rp 150 Jt',
                        omsetVal: 50,
                        description: 'Sate pedas mantap...',
                        lat: -6.3400, // Masuk (Hampir batas bawah)
                        lng: 106.7600, // Masuk
                        img: 'https://images.unsplash.com/photo-1529566657458-9adc180d2d9d?auto=format&fit=crop&w=200&q=80'
                    },
                ],

                svgIcons: {
                    grid: document.getElementById('icon-grid')?.innerHTML || '',
                    food: document.getElementById('icon-food')?.innerHTML || '',
                    fashion: document.getElementById('icon-fashion')?.innerHTML || '',
                    work: document.getElementById('icon-work')?.innerHTML || '',
                },

                // --- COMPUTED PROPERTIES ---
                get paginatedList() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredList.slice(start, start + this.itemsPerPage);
                },
                get totalPages() {
                    return Math.ceil(this.filteredList.length / this.itemsPerPage);
                },
                get categories() {
                    return ['Semua', ...new Set(this.umkms.map(item => item.category))];
                },
                get regions() {
                    return [...new Set(this.umkms.map(item => item.region))];
                },
                get filteredList() {
                    return this.umkms.filter(item => {
                        // 1. FILTER NAMA
                        const searchMatch = item.name.toLowerCase().includes(this.search
                            .toLowerCase());

                        // 2. FILTER KATEGORI
                        const catMatch = this.selectedCategory === 'Semua' || item
                            .category === this.selectedCategory;

                        // 3. FILTER HARGA
                        const realOmset = (item.omsetVal || 0) * 1000000;
                        let minVal = this.parseRupiah(this.minInput);
                        let maxVal = this.maxInput === '' ? Infinity : this.parseRupiah(this
                            .maxInput);
                        const priceMatch = realOmset >= minVal && realOmset <= maxVal;

                        // 4. FILTER WILAYAH (DARI STORE) - INI KUNCINYA
                        // Jika store kosong, tampilkan semua. Jika ada isinya, harus cocok persis.
                        const currentRegion = this.$store.region.selected;
                        const regionMatch = currentRegion === '' || item.region ===
                            currentRegion;

                        return searchMatch && catMatch && priceMatch && regionMatch;
                    });
                },

                // --- INIT ---
                init() {
                    // WATCHER UNTUK STORE WILAYAH
                    // Ketika tombol di slide atas diklik, ini akan jalan otomatis
                    this.$watch('$store.region.selected', (val) => {
                        this.currentPage = 1;
                        this.search = ''; // Optional: Reset search text biar hasil lebih jelas
                        this.selectedCategory = 'Semua'; // Optional: Reset kategori
                        this.updateMarkers();

                        // Optional: Pindahkan peta ke marker pertama yang ketemu di wilayah itu
                        setTimeout(() => {
                            if (this.filteredList.length > 0) {
                                // Fokus ke item pertama di wilayah itu
                                this.focusLocation(this.filteredList[0], true, false);
                            } else {
                                // Jika wilayah kosong, kembalikan zoom ke default
                                this.map.flyTo([-6.3900, 106.7600], 13);
                            }
                        }, 300);
                    });

                    // Watcher standar
                    this.$watch('minInput', (value) => {
                        this.minInput = this.formatRupiah(value);
                        this.currentPage = 1;
                        this.updateMarkers();
                    });
                    this.$watch('maxInput', (value) => {
                        this.maxInput = this.formatRupiah(value);
                        this.currentPage = 1;
                        this.updateMarkers();
                    });
                    this.$watch('search', () => {
                        this.currentPage = 1;
                        this.updateMarkers();
                    });
                    this.$watch('selectedCategory', () => {
                        this.currentPage = 1;
                        this.updateMarkers();
                    });

                    // Animasi & Resize
                    this.$watch('sidebarOpen', () => {
                        setTimeout(() => {
                            if (this.map) this.map.invalidateSize();
                        }, 300);
                    });
                    window.addEventListener('resize', () => {
                        this.itemsPerPage = window.innerWidth < 768 ? 1 : 4;
                        if (this.currentPage > this.totalPages) this.currentPage = 1;
                        if (this.map) this.map.invalidateSize();
                    });
                },

                // --- FORMATTER ---
                formatRupiah(angka) {
                    if (!angka) return '';
                    let number_string = angka.toString().replace(/[^,\d]/g, '').toString();
                    let split = number_string.split(',');
                    let sisa = split[0].length % 3;
                    let rupiah = split[0].substr(0, sisa);
                    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    return rupiah;
                },
                parseRupiah(angkaString) {
                    if (!angkaString) return 0;
                    return parseInt(angkaString.replace(/\./g, '')) || 0;
                },

                // --- MAP LOGIC ---
                initMap() {
                    if (this.map) {
                        this.map.off();
                        this.map.remove();
                    }
                    let centerLat = -6.3900; // Default jika data kosong
                    let centerLng = 106.7600;

                    // Cek apakah ada data UMKM?
                    if (this.umkms.length > 0) {
                        // Ambil koordinat item pertama
                        centerLat = this.umkms[0].lat;
                        centerLng = this.umkms[0].lng;

                        // Opsi Tambahan: Jika ingin marker agak ke bawah (supaya space atas lega)
                        centerLat = this.umkms[0].lat + 0.005;
                    }

                    // 1. KOORDINAT ASLI
                    const latMin = -6.350;
                    const latMax = -6.250;
                    const lngMin = 106.750;
                    const lngMax = 106.900;

                    // 2. PERBAIKAN BUFFER (Jauh lebih longgar)
                    // Buffer Vertical (Atas/Bawah)
                    const vBuffer = 0.05;
                    const topBuffer = 0.15; // Tetap besar untuk Popup

                    // Buffer Horizontal (Kiri/Kanan) -> DIPERBESAR
                    // Agar di layar sempit tablet, user bisa geser jauh ke kanan/kiri
                    const hBuffer = 0.15;

                    const southWest = L.latLng(latMin - vBuffer, lngMin - hBuffer);
                    const northEast = L.latLng(latMax + topBuffer, lngMax + hBuffer);
                    const myBounds = L.latLngBounds(southWest, northEast);

                    // 3. INISIALISASI
                    this.map = L.map(this.$refs.mapContainer, {
                        zoomControl: false,
                        maxBounds: myBounds,

                        // UBAH JADI 0.2 (Sangat Kenyal)
                        // Ini kuncinya! Peta tidak akan "mentok" keras seperti tembok.
                        // User bisa tarik peta keluar batas, dan peta akan membal pelan.
                        maxBoundsViscosity: 0.2,

                        minZoom: 12, // Izinkan zoom out sedikit lebih jauh biar lega
                        maxZoom: 18
                    }).setView([centerLat, centerLng], 13);

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(this.map);

                    if (window.ResizeObserver && this.$refs.mapContainer) {
                        new ResizeObserver(() => {
                            if (this.map) this.map.invalidateSize();
                        }).observe(this.$refs.mapContainer);
                    }

                    this.updateMarkers();
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
                            popupAnchor: [0, -20]
                        });
                        const popupContent = this.getPopupContent(item);
                        const marker = L.marker([item.lat, item.lng], {
                                icon: customIcon
                            }).addTo(this.map)
                            .bindPopup(popupContent, {
                                maxWidth: window.innerWidth < 640 ? 300 : (window
                                    .innerWidth < 1024 ? 320 : 400),
                                minWidth: window.innerWidth < 640 ? 260 : (window
                                    .innerWidth < 1024 ? 280 : 350),
                                className: 'custom-popup-clean',
                                closeButton: true,
                                autoPan: true,
                                autoPanPadding: window.innerWidth < 640 ? [10, 10] : [50,
                                    50
                                ]
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

                // --- HELPER LAINNYA ---
                getPopupContent(item) {
                    let template = document.getElementById('umkm-popup-template').innerHTML;
                    const imagesArray = item.images && item.images.length > 0 ? item.images : [item
                        .img
                    ];
                    const imagesJson = JSON.stringify(imagesArray).replace(/"/g, '&quot;');
                    return template
                        .replaceAll('[[ID]]', item.id)
                        .replaceAll('[[NAME]]', item.name)
                        .replaceAll('[[IMAGE_SRC]]', imagesArray[0])
                        .replaceAll('[[IMAGES_JSON]]', imagesJson)
                        .replaceAll('[[BADGE]]', item.badge)
                        .replaceAll('[[DESCRIPTION]]', item.description || '-')
                        .replaceAll('[[OMSET]]', item.omset)
                        .replaceAll('[[SURAT]]', item.surat || '-');
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
                // Update fungsi ini
                focusLocation(item, animate = true, shouldOpenPopup = true) {
                    this.activeId = item.id;

                    // Logic Offset (Biar tidak ketutup region atas)
                    const latOffset = 0.012;

                    this.map.flyTo([item.lat + latOffset, item.lng], 15, {
                        animate: animate,
                        duration: 1.5
                    });

                    // LOGIC BARU: Cek parameter shouldOpenPopup
                    if (shouldOpenPopup) {
                        const targetObj = this.markers.find(m => m.id === item.id);
                        if (targetObj) {
                            setTimeout(() => {
                                targetObj.marker.openPopup();
                            }, animate ? 1000 : 100);
                        }
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },
                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },
            }));
        });

        window.changePopupImage = function(id, direction) {
            const imgElement = document.getElementById(`popup-img-${id}`);
            if (!imgElement) return;
            const images = JSON.parse(imgElement.getAttribute('data-images'));
            let currentIndex = parseInt(imgElement.getAttribute('data-index'));
            let newIndex = currentIndex + direction;
            if (newIndex >= images.length) newIndex = 0;
            else if (newIndex < 0) newIndex = images.length - 1;
            imgElement.src = images[newIndex];
            imgElement.setAttribute('data-index', newIndex);
        }
    </script>
@endpush
