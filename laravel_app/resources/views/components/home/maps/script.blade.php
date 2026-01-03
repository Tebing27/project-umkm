@props(['mapShops', 'regionsMap'])

@php
    // Data passed directly from controller, already transformed.
    $umkmData = $mapShops;
    $regionsData = $regionsMap;
@endphp

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
                geoJsonLayer: null,

                // --- DATA UMKM (DITAMBAHKAN FIELD 'REGION') ---
                // Pastikan ejaan 'region' SAMA PERSIS dengan title di slider wilayah
                umkms: @json($umkmData),
                regionList: @json($regionsData),

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
                    return ['Semua', 'Kuliner', 'Pakaian & Aksesoris', 'Kelontong', 'Agribisnis', 'Jasa', 'Kerajinan Tangan'];
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
                    this.$watch('$store.region.selected', (val) => {
                        this.currentPage = 1;
                        this.search = ''; 
                        this.selectedCategory = 'Semua'; 

                        // 1. CLEANUP PRE-ANIMATION (Mencegah crash & glitch)
                        // Hapus markers existing
                        this.markers.forEach(m => this.map.removeLayer(m.marker));
                        this.markers = [];
                        
                        // Hapus sementara GeoJSON Layer agar tooltips tidak error "latLngToLayerPoint" saat animasi flyTo
                        if (this.geoJsonLayer) {
                            this.map.removeLayer(this.geoJsonLayer);
                        }

                        // 2. CALLBACK POST-ANIMATION
                        const restoreMapState = () => {
                            // Restore GeoJSON
                            if (this.geoJsonLayer) {
                                if (!this.map.hasLayer(this.geoJsonLayer)) {
                                    this.map.addLayer(this.geoJsonLayer);
                                }
                            }
                            // Restore/Update Markers
                            this.updateMarkers();
                        };

                        // 3. DETERMINE FLIGHT LOGIC
                        let isFlying = false;

                        if (val) {
                            const selectedRegionData = this.regionList.find(r => r.name === val);
                            
                            // VALIDASI STRICT
                            if (selectedRegionData && selectedRegionData.lat && selectedRegionData.lng && 
                                selectedRegionData.lat !== 0 && selectedRegionData.lng !== 0) {
                                
                                isFlying = true;
                                this.map.flyTo([selectedRegionData.lat, selectedRegionData.lng], 14, {
                                    animate: true,
                                    duration: 1.5
                                });
                                this.map.once('moveend', restoreMapState);
                            } else {
                                // Fallback jika koordinat region tidak valid
                                restoreMapState(); // Update markers immediately
                                if (this.filteredList.length > 0) {
                                    this.focusLocation(this.filteredList[0], true, false);
                                }
                            }
                        } else {
                            // Reset to default view (Semua Wilayah)
                            isFlying = true;
                            this.map.flyTo([-6.4025, 106.7720], 13, {
                                animate: true,
                                duration: 1.5
                            });
                            this.map.once('moveend', restoreMapState);
                        }
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
                // --- MAP LOGIC ---
                initMap() {
                    if (this.map) {
                        this.map.off();
                        this.map.remove();
                    }
                    // Default Focus (Kecamatan Sawangan Tengah)
                    let centerLat = -6.3970;
                    let centerLng = 106.7600;

                    const latMin = -6.4500; // Selatan (Before: -6.44)
                    const latMax = -6.3300; // Utara (Before: -6.35) -> Buffer buat Kedaung
                    const lngMin = 106.7200; // Barat (Before: 106.73)
                    const lngMax = 106.8100; // Timur (Before: 106.795)

                    const southWest = L.latLng(latMin, lngMin);
                    const northEast = L.latLng(latMax, lngMax);
                    const myBounds = L.latLngBounds(southWest, northEast);

                    // 3. INISIALISASI
                    // FIX: Menggunakan this.$refs.mapContainer karena tidak ada id='map'
                    this.map = L.map(this.$refs.mapContainer, {
                        zoomControl: false,
                        maxBounds: myBounds,
                        maxBoundsViscosity: 1.0, 
                        minZoom: 13,
                        maxZoom: 18,
                        center: [centerLat, centerLng],
                        zoom: 13
                    });

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(this.map);

                    // 4. GARIS BATAS WILAYAH (BOUNDARY LINES)
                    // Menggunakan GeoJSON Asset
                    const geoJsonUrl = "{{ asset('maps/sawangan.geojson') }}";

                    fetch(geoJsonUrl)
                        .then(response => {
                            if (!response.ok) throw new Error("Gagal memuat GeoJSON");
                            return response.json();
                        })
                        .then(data => {
                            if (this.geoJsonLayer) {
                                this.map.removeLayer(this.geoJsonLayer);
                            }
                            this.geoJsonLayer = L.geoJSON(data, {
                                // Style untuk garis batas (melingkari wilayah)
                                style: function(feature) {
                                    return {
                                        color: '#FF0000', // Warna Garis Merah
                                        weight: 2, // Tebal Garis
                                        opacity: 0.8, // Transparansi Garis
                                        dashArray: '10, 10', // Garis Putus-putus
                                        fillColor: 'red', // Warna Isi
                                        fillOpacity: 0.03 // Transparansi Isi (0.05 = sangat transparan)
                                    };
                                },
                                // Optional: Menambahkan label saat mouse di atas wilayah
                                onEachFeature: (feature, layer) => {
                                    if (feature.properties && feature.properties
                                        .village) {
                                        layer.bindTooltip(feature.properties.village, {
                                            permanent: false,
                                            direction: 'center'
                                        });
                                    }
                                }
                            }).addTo(this.map);
                        })
                        .catch(error => console.error('Error loading GeoJSON:', error));
                    
                    // 5. RESIZE OBSERVER (PENTING AGAR MAP TIDAK GREY/BLANK SAAT RESIZE)
                    if (window.ResizeObserver && this.$refs.mapContainer) {
                        new ResizeObserver(() => {
                            if (this.map) {
                                this.map.invalidateSize();
                            }
                        }).observe(this.$refs.mapContainer);
                    }

                    this.updateMarkers();
                },

                updateMarkers() {
                    this.markers.forEach(m => this.map.removeLayer(m.marker));
                    this.markers = [];
                    this.filteredList.forEach(item => {
                        // Adding marker

                        
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
                            // TEMP DEBUG:
                            // console.log(`DEBUG: ${item.name} | Region: ${item.region} | Lat: ${item.lat} | Lng: ${item.lng}`);
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
                    if (!categoryName) return this.svgIcons.grid;
                    const lower = categoryName.toLowerCase();
                    if (lower === 'semua') return this.svgIcons.grid;
                    if (lower.includes('kuliner')) return this.svgIcons.food;
                    if (lower.includes('kelontong')) return this.svgIcons.food;
                    if (lower.includes('fashion') || lower.includes('pakaian')) return this.svgIcons.fashion;
                    if (lower.includes('kerajinan')) return this.svgIcons.fashion;
                    if (lower.includes('jasa')) return this.svgIcons.work;
                    if (lower.includes('agribisnis')) return this.svgIcons.work;
                    return this.svgIcons.grid;
                },
                // Update fungsi ini
                focusLocation(item, animate = true, shouldOpenPopup = true) {
                    this.activeId = item.id;

                    // Logic Offset (Biar tidak ketutup region atas)
                    // REVISI: Offset dihapus (0) agar map benar-benar centering di titik marker
                    // User report: "popup tidak sesuai dengan titik marker" -> kemungkinan karena offset kejauhan
                    const latOffset = 0;

                    this.map.flyTo([item.lat + latOffset, item.lng], 16, { // Zoom sedikit lebih dekat (16)
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
