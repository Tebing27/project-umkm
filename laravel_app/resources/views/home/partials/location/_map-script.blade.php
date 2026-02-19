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
                sidebarOpen: window.innerWidth >= 768,
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

                // Warna fill unik per kelurahan Sawangan (NAMOBJ -> fillColor)
                // Mapping juga dari nama region DB ke NAMOBJ depok.json
                sawanganColors: {
                    'Sawangan': '#E74C3C',
                    'Sawangan Baru': '#3498DB',
                    'Pengasinan': '#2ECC71',
                    'Cinangka': '#F39C12',
                    'Kedaung': '#9B59B6',
                    'Pasir Putih': '#1ABC9C',
                    'Bedahan': '#E67E22'
                },
                // Alias: nama region di DB -> NAMOBJ di depok.json
                regionAlias: {
                    'Sawangan Lama': 'Sawangan'
                },

                // --- DATA UMKM (DITAMBAHKAN FIELD 'REGION') ---
                // MODIFIED: Read from DOM for Real-time Updates support
                umkms: [],
                regionList: [],

                initData() {
                    const dataEl = document.getElementById('map-data');
                    if (dataEl) {
                        try {
                            const data = JSON.parse(dataEl.textContent);
                            this.umkms = data.umkms || [];
                            this.regionList = data.regionList || [];
                        } catch (e) {
                            this.umkms = [];
                            this.regionList = [];
                        }
                    }
                },

                /**
                 * SECURITY NOTE: These SVG icons are safe for x-html usage because:
                 * 1. They are sourced from server-rendered Blade templates (trusted content)
                 * 2. The DOM elements are hardcoded, not user-generated
                 * 3. Categories are from a fixed whitelist, not user input
                 */
                svgIcons: {
                    grid: document.getElementById('icon-grid')?.innerHTML || '',
                    food: document.getElementById('icon-food')?.innerHTML || '',
                    fashion: document.getElementById('icon-fashion')?.innerHTML || '',
                    work: document.getElementById('icon-work')?.innerHTML || '',
                    kelontong: document.getElementById('icon-kelontong')?.innerHTML || '',
                    agribisnis: document.getElementById('icon-agribisnis')?.innerHTML || '',
                    kerajinan: document.getElementById('icon-kerajinan')?.innerHTML || '',
                },

                // Map: Category Name -> {iconUrl: string|null, fallbackIcon: string}
                categoryIconsMap: @json($businessTypesWithIcons ?? []).reduce((acc, item) => {
                    acc[item.name] = {
                        iconUrl: item.icon_url,
                        fallbackIcon: item.fallback_icon
                    };
                    return acc;
                }, {}),

                // --- COMPUTED PROPERTIES ---
                get paginatedList() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredList.slice(start, start + this.itemsPerPage);
                },
                get totalPages() {
                    return Math.ceil(this.filteredList.length / this.itemsPerPage);
                },
                get categories() {
                    // Use Dynamic Categories from Backend
                    return ['Semua', ...@json($categories)];
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

                        // 3. FILTER HARGA (Range Overlap Logic)
                        // Check if shop's omset range overlaps with user's filter range
                        const shopMinOmset = item.omset_min || 0;
                        const shopMaxOmset = item.omset_max || 0;
                        let minVal = this.parseRupiah(this.minInput);
                        let maxVal = this.maxInput === '' ? Infinity : this.parseRupiah(this
                            .maxInput);
                        // Range overlap: shop_min <= user_max AND shop_max >= user_min
                        const priceMatch = shopMinOmset <= maxVal && shopMaxOmset >= minVal;

                        // 4. FILTER WILAYAH (DARI STORE) - INI KUNCINYA
                        // Jika store kosong, tampilkan semua. Jika ada isinya, harus cocok persis.
                        const currentRegion = this.$store.region.selected;
                        
                        // FIX: Resolve Alias (Sawangan Lama <-> Sawangan) agar data tetap muncul
                        const selectedResolved = this.regionAlias[currentRegion] || currentRegion;
                        const itemResolved = this.regionAlias[item.region] || item.region;
                        
                        const regionMatch = currentRegion === '' || itemResolved === selectedResolved;

                        return searchMatch && catMatch && priceMatch && regionMatch;
                    });
                },

                // --- INIT ---
                init() {
                    this.initData();
                    
                    // --- REALTIME UPDATE LISTENER ---
                    window.addEventListener('map-data-updated', () => {
                        console.log("Map: Refreshing data from server...");
                        this.refreshData();
                    });
                    
                    // WATCHER UNTUK STORE WILAYAH
                    this.$watch('$store.region.selected', (val) => {
                        this.currentPage = 1;
                        this.search = ''; 
                        this.selectedCategory = 'Semua'; 

                            // 1. CLEANUP PRE-ANIMATION
                            // Hapus markers existing
                            this.markers.forEach(m => this.map.removeLayer(m.marker));
                            this.markers = [];
                            
                            // FIX: Hanya close tooltip, JANGAN remove GeoJSON layer agar warna wilayah tetap terlihat
                            if (this.geoJsonLayer) {
                                this.geoJsonLayer.eachLayer(layer => {
                                    if (layer.closeTooltip) layer.closeTooltip();
                                    if (layer.unbindTooltip) layer.unbindTooltip();
                                });
                            }

                            // Update fill wilayah: hanya region terpilih yang berwarna
                            this.updateGeoJsonStyle(val);

                            // 2. CALLBACK POST-ANIMATION
                            const restoreMapState = () => {
                                // Rebind tooltip setelah animasi selesai
                                if (this.geoJsonLayer) {
                                    this.geoJsonLayer.eachLayer(layer => {
                                        const name = layer.feature?.properties?.NAMOBJ;
                                        if (name && !layer.getTooltip()) {
                                            layer.bindTooltip(name, {
                                                permanent: false,
                                                direction: 'center'
                                            });
                                        }
                                    });
                                }
                                // Restore/Update Markers
                                this.updateMarkers();
                            };

                            // 3. DETERMINE FLIGHT LOGIC
                            // FIX: Wrap in setTimeout to ensure call stack clear after layer removal
                            setTimeout(() => {
                                // Guard flag: prevent restoreMapState from being called twice
                                // (once by moveend, once by safety timeout)
                                let restored = false;
                                const safeRestore = () => {
                                    if (restored) return;
                                    restored = true;
                                    this.map.off('moveend', safeRestore);
                                    restoreMapState();
                                };

                                if (val) {
                                    // FIX: Gunakan fitBounds ke boundary GeoJSON wilayah
                                    // agar zoom otomatis menyesuaikan luas wilayah (tidak ngezoom terlalu dekat)
                                    const resolvedName = this.regionAlias[val] || val;
                                    let regionBounds = null;

                                    if (this.geoJsonLayer) {
                                        this.geoJsonLayer.eachLayer(layer => {
                                            const name = layer.feature?.properties?.NAMOBJ || '';
                                            if (name === resolvedName) {
                                                regionBounds = layer.getBounds();
                                            }
                                        });
                                    }

                                    if (regionBounds && regionBounds.isValid()) {
                                        // fitBounds otomatis menentukan zoom level yang pas
                                        const mobilePadding = window.innerWidth < 768 ? [30, 30] : [50, 50];
                                        this.map.flyToBounds(regionBounds, {
                                            padding: mobilePadding,
                                            maxZoom: 15,
                                            animate: true,
                                            duration: 1.5
                                        });
                                    } else {
                                        // Fallback: gunakan koordinat dari regionList jika GeoJSON belum dimuat
                                        const selectedRegionData = this.regionList.find(r => r.name === val);
                                        if (selectedRegionData && selectedRegionData.lat && selectedRegionData.lng &&
                                            selectedRegionData.lat !== 0 && selectedRegionData.lng !== 0) {
                                            this.map.flyTo([selectedRegionData.lat, selectedRegionData.lng], window.innerWidth < 768 ? 13 : 14, {
                                                animate: true,
                                                duration: 1.5
                                            });
                                        } else {
                                            restoreMapState();
                                            if (this.filteredList.length > 0) {
                                                this.focusLocation(this.filteredList[0], true, false);
                                            }
                                            return; // skip moveend listener
                                        }
                                    }
                                    this.map.once('moveend', safeRestore);
                                    // Safety timeout: if moveend doesn't fire within 2.5s, restore anyway
                                    setTimeout(safeRestore, 2500);
                                } else {
                                    // Reset to default view (Semua Wilayah)
                                    // RESPONSIVE: Zoom lebih kecil di mobile agar semua wilayah terlihat
                                    const resetZoom = window.innerWidth < 768 ? 12 : 14;
                                    this.map.flyTo([-6.4003, 106.7680], resetZoom, {
                                        animate: true,
                                        duration: 1.5
                                    });
                                    this.map.once('moveend', safeRestore);
                                    // Safety timeout: if moveend doesn't fire within 2.5s, restore anyway
                                    setTimeout(safeRestore, 2500);
                                }
                            }, 10); // Small delay for safety
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
                    // FIX: Simpan center sebelum resize, lalu re-center setelah invalidateSize
                    this.$watch('sidebarOpen', () => {
                        if (!this.map) return;
                        const savedCenter = this.map.getCenter();
                        const savedZoom = this.map.getZoom();
                        setTimeout(() => {
                            this.map.invalidateSize({animate: false});
                            this.map.setView(savedCenter, savedZoom, {animate: false});
                        }, 350);
                    });
                    window.addEventListener('resize', () => {
                        this.itemsPerPage = window.innerWidth < 768 ? 1 : 4;
                        if (this.currentPage > this.totalPages) this.currentPage = 1;
                        if (this.map) this.map.invalidateSize();
                    });
                },

                refreshData() {
                    // Fetch latest data from server
                    const timestamp = new Date().getTime();
                    fetch(`/umkm?json=true&_t=${timestamp}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        let newItems = [];
                        if (Array.isArray(data)) {
                            newItems = data;
                        } else if (data.data && Array.isArray(data.data)) {
                            newItems = data.data;
                        }
                        
                        if (newItems.length > 0) {
                            // FIX: Filter & Map Data agar sesuai format markers Leaflet
                            // Mencegah error "Invalid LatLng object: (undefined, undefined)"
                            this.umkms = newItems
                                .filter(item => {
                                    // Pastikan lat/lng ada dan bukan null
                                    const lat = item.lat || item.latitude;
                                    const lng = item.lng || item.longitude;
                                    return lat && lng; 
                                })
                                .map(item => {
                                    // Normalize properties jika perlu
                                    return {
                                        ...item,
                                        lat: parseFloat(item.lat || item.latitude),
                                        lng: parseFloat(item.lng || item.longitude)
                                    };
                                });
                                
                            this.updateMarkers();
                            console.log("Map: Data updated successfully via Realtime. Items:", this.umkms.length);
                        }
                    })
                    .catch(e => console.error("Map: Failed to refresh data", e));
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
                formatOmset(val) {
                    let num = 0;
                    if (typeof val === 'number') {
                        num = val; // Assuming raw number (e.g. 5000000)
                    } else if (typeof val === 'string') {
                        // "Rp 5.000.000" -> 5000000
                        num = parseInt(val.replace(/[^0-9]/g, '')) || 0;
                    }

                    if (num >= 1000000) {
                        let inMillions = num / 1000000;
                        // 5.0 -> 5, 5.5 -> 5.5
                        return "Rp " + inMillions.toFixed(1).replace(/\.0$/, '') + "JT";
                    }
                    if (num >= 1000) {
                         return "Rp " + (num / 1000).toFixed(0) + "RB";
                    }
                    return "Rp " + num;
                },
                formatOmsetRange(min, max) {
                    if (!min && !max) return '-';
                    if (min && !max) return this.formatOmset(min);
                    if (!min && max) return this.formatOmset(max);
                    
                    // If both exist
                    return `${this.formatOmset(min)} - ${this.formatOmset(max)}`;
                },

                // --- MAP LOGIC ---
                // --- MAP LOGIC ---
                initMap() {
                    if (this.map) {
                        this.map.off();
                        this.map.remove();
                    }
                    // Default Focus (Kecamatan Sawangan Tengah)
                    let centerLat = -6.4003;
                    let centerLng = 106.7680;

                    const latMin = -6.4700; // Selatan (seluruh Depok)
                    const latMax = -6.3100; // Utara (seluruh Depok)
                    const lngMin = 106.7100; // Barat (seluruh Depok)
                    const lngMax = 106.9300; // Timur (seluruh Depok)

                    const southWest = L.latLng(latMin, lngMin);
                    const northEast = L.latLng(latMax, lngMax);
                    const myBounds = L.latLngBounds(southWest, northEast);

                    // 3. INISIALISASI
                    // FIX: Menggunakan this.$refs.mapContainer karena tidak ada id='map'
                    // RESPONSIVE ZOOM: Mobile lebih kecil agar terlihat seluruh wilayah Sawangan
                    const isMobile = window.innerWidth < 768;
                    const defaultZoom = isMobile ? 12 : 14;

                    this.map = L.map(this.$refs.mapContainer, {
                        zoomControl: false,
                        maxBounds: myBounds,
                        maxBoundsViscosity: 1.0, 
                        minZoom: 12,
                        maxZoom: 18,
                        center: [centerLat, centerLng],
                        zoom: defaultZoom,
                        scrollWheelZoom: false,       // Disable scroll zoom agar user bisa scroll halaman
                        tap: true
                    });

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(this.map);

                    this.addLegend();

                    // 4. GARIS BATAS WILAYAH (BOUNDARY LINES)
                    // Menggunakan GeoJSON Asset
                    const geoJsonUrl = "{{ asset('maps/depok.json') }}";

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
                                style: (feature) => {
                                    const name = feature.properties?.NAMOBJ || '';
                                    const isSawangan = this.sawanganColors.hasOwnProperty(name);
                                    return {
                                        color: isSawangan ? '#000000' : 'transparent',
                                        weight: isSawangan ? 2 : 0,
                                        opacity: isSawangan ? 0.4 : 0,
                                        fillColor: isSawangan ? this.sawanganColors[name] : 'transparent',
                                        fillOpacity: isSawangan ? 0.5 : 0
                                    };
                                },
                                // Optional: Menambahkan label saat mouse di atas wilayah
                                onEachFeature: (feature, layer) => {
                                    if (feature.properties && feature.properties
                                        .NAMOBJ) {
                                        layer.bindTooltip(feature.properties.NAMOBJ, {
                                            permanent: false,
                                            direction: 'center'
                                        });
                                    }
                                }
                            }).addTo(this.map);

                            // FIT BOUNDS: Pada mobile, auto-fit semua region Sawangan agar terlihat semua
                            if (window.innerWidth < 768) {
                                const sawanganBounds = L.latLngBounds([]);
                                this.geoJsonLayer.eachLayer(layer => {
                                    const name = layer.feature?.properties?.NAMOBJ || '';
                                    if (this.sawanganColors.hasOwnProperty(name)) {
                                        sawanganBounds.extend(layer.getBounds());
                                    }
                                });
                                if (sawanganBounds.isValid()) {
                                    this.map.fitBounds(sawanganBounds, { padding: [20, 20], maxZoom: 13 });
                                }
                            }
                        })
                        .catch(error => {});
                    
                    // 5. RESIZE OBSERVER (PENTING AGAR MAP TIDAK GREY/BLANK SAAT RESIZE)
                    // OPTIMIZED: Debounce agar invalidateSize hanya dipanggil sekali setelah resize selesai
                    if (window.ResizeObserver && this.$refs.mapContainer) {
                        let resizeTimer;
                        new ResizeObserver(() => {
                            clearTimeout(resizeTimer);
                            resizeTimer = setTimeout(() => {
                                if (this.map) this.map.invalidateSize();
                            }, 150);
                        }).observe(this.$refs.mapContainer);
                    }

                    this.updateMarkers();
                },

                addLegend() {
                    // FIX: Pindah ke bottomleft agar tidak tertiban oleh tombol +/- zoom di bottomright
                    const legend = L.control({ position: 'bottomleft' });
                    
                    legend.onAdd = (map) => {
                        const div = L.DomUtil.create('div', 'map-legend');
                        // Prevent map scroll/drag saat interaksi di legend
                        L.DomEvent.disableClickPropagation(div);
                        L.DomEvent.disableScrollPropagation(div);

                        div.innerHTML = `
                            <div style="background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); font-size: 12px; max-height: 260px; overflow-y: auto;">
                                <div style="font-weight: 600; margin-bottom: 8px; color: #374151;">Wilayah Sawangan</div>
                                <div class="legend-item" data-region="" style="display: flex; align-items: center; margin-bottom: 4px; padding: 3px 6px; border-radius: 4px; cursor: pointer; transition: background 0.2s; background: #EBF5FF;">
                                    <span style="width: 16px; height: 16px; background: linear-gradient(135deg, #E74C3C, #3498DB, #2ECC71); border-radius: 3px; margin-right: 8px; display: inline-block;"></span>
                                    <span style="color: #1D4ED8; font-weight: 600;">Semua Wilayah</span>
                                </div>
                                ${Object.entries(this.sawanganColors).map(([name, color]) => `
                                    <div class="legend-item" data-region="${name}" style="display: flex; align-items: center; margin-bottom: 4px; padding: 3px 6px; border-radius: 4px; cursor: pointer; transition: background 0.2s;">
                                        <span style="width: 16px; height: 16px; background: ${color}; border-radius: 3px; margin-right: 8px; display: inline-block; flex-shrink: 0;"></span>
                                        <span style="color: #4B5563;">${name}</span>
                                    </div>
                                `).join('')}
                            </div>
                        `;

                        // Event listener: klik legend item untuk filter wilayah
                        div.querySelectorAll('.legend-item').forEach(el => {
                            el.addEventListener('mouseenter', () => {
                                el.style.background = '#F3F4F6';
                            });
                            el.addEventListener('mouseleave', () => {
                                const currentRegion = Alpine.store('region').selected;
                                const itemRegion = el.getAttribute('data-region');
                                if ((currentRegion === '' && itemRegion === '') || currentRegion === itemRegion) {
                                    el.style.background = '#EBF5FF';
                                } else {
                                    el.style.background = 'transparent';
                                }
                            });
                            el.addEventListener('click', (e) => {
                                e.stopPropagation();
                                const regionName = el.getAttribute('data-region');
                                // Toggle: klik yang sudah aktif = reset ke semua
                                if (Alpine.store('region').selected === regionName && regionName !== '') {
                                    Alpine.store('region').set('');
                                } else {
                                    Alpine.store('region').set(regionName);
                                }
                                // Update highlight style semua item
                                this.updateLegendHighlight(div);
                            });
                        });

                        return div;
                    };
                    
                    legend.addTo(this.map);
                },

                updateLegendHighlight(legendDiv) {
                    if (!legendDiv) return;
                    const currentRegion = Alpine.store('region').selected;
                    legendDiv.querySelectorAll('.legend-item').forEach(el => {
                        const itemRegion = el.getAttribute('data-region');
                        if ((currentRegion === '' && itemRegion === '') || currentRegion === itemRegion) {
                            el.style.background = '#EBF5FF';
                            const textSpan = el.querySelector('span:last-child');
                            if (textSpan) {
                                textSpan.style.color = '#1D4ED8';
                                textSpan.style.fontWeight = '600';
                            }
                        } else {
                            el.style.background = 'transparent';
                            const textSpan = el.querySelector('span:last-child');
                            if (textSpan) {
                                textSpan.style.color = '#4B5563';
                                textSpan.style.fontWeight = '400';
                            }
                        }
                    });
                },

                updateGeoJsonStyle(selectedRegion) {
                    if (!this.geoJsonLayer) return;

                    // Resolve alias: e.g. "Sawangan Lama" (DB) -> "Sawangan" (NAMOBJ)
                    const resolvedName = this.regionAlias[selectedRegion] || selectedRegion;

                    this.geoJsonLayer.eachLayer(layer => {
                        const name = layer.feature?.properties?.NAMOBJ || '';
                        const isSawangan = this.sawanganColors.hasOwnProperty(name);

                        if (!isSawangan) {
                            // Non-Sawangan kelurahan: always invisible
                            return;
                        }

                        // Determine fill visibility
                        let showFill;
                        if (!selectedRegion || selectedRegion === '') {
                            // "Semua Wilayah" -> all 7 kelurahan show fill
                            showFill = true;
                        } else {
                            // Specific region selected -> only that one gets fill
                            showFill = (name === resolvedName);
                        }

                        layer.setStyle({
                            fillColor: this.sawanganColors[name],
                            fillOpacity: showFill ? 0.5 : 0
                        });
                    });
                },

                updateMarkers() {
                    this.markers.forEach(m => this.map.removeLayer(m.marker));
                    this.markers = [];
                    this.filteredList.forEach(item => {
                        // Adding marker

                        
                        const customIcon = L.divIcon({
                            className: 'custom-leaflet-icon',
                            html: this.getIconHtml(item.iconType, item.customIcon),
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
                        // If srcset is empty, we remove the attribute entirely to prevent broken images
                        .replace(/\s?srcset="\[\[IMAGE_SRCSET\]\]"/, item.srcset ? ` srcset="${item.srcset}"` : '')
                        .replaceAll('[[IMAGES_JSON]]', imagesJson)
                        .replaceAll('[[BADGE]]', item.badge)
                        .replaceAll('[[DESCRIPTION]]', item.description || '-')
                        .replaceAll('[[OMSET]]', item.omset)
                        .replaceAll('[[SURAT]]', item.surat || '-');
                },
                getIconHtml(type, customIconUrl = null) {
                    if (customIconUrl) {
                        return `<div style='background-color: white; width: 44px; height: 44px; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; overflow: hidden;'><img loading="lazy" src="${customIconUrl}" style="width: 24px; height: 24px; object-fit: contain;"></div>`;
                    }
                    
                    let color = '#FFC107'; // brand-yellow
                    let svgContent = this.svgIcons.grid;
                    let iconColor = 'black'; // Default yellow -> text black

                    if (type === 'food') {
                        color = '#e31700ff';
                        svgContent = this.svgIcons.food;
                        iconColor = 'white';
                    } else if (type === 'work') {
                        color = '#3498DB';
                        svgContent = this.svgIcons.work;
                        iconColor = 'white';
                    } else if (type === 'fashion') {
                        color = '#F1C40F';
                        svgContent = this.svgIcons.fashion;
                        iconColor = 'black';
                    } else if (type === 'kelontong') {
                        color = '#1ABC9C';
                        svgContent = this.svgIcons.kelontong;
                        iconColor = 'black';
                    } else if (type === 'agribisnis') {
                        color = '#2ECC71';
                        svgContent = this.svgIcons.agribisnis;
                        iconColor = 'black';
                    } else if (type === 'kerajinan') {
                        color = '#9B59B6';
                        svgContent = this.svgIcons.kerajinan;
                        iconColor = 'white';
                    }
                    return `<div style='background-color: ${color}; width: 36px; height: 36px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 8px rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; color: ${iconColor};'><div style="width: 16px; height: 16px;">${svgContent}</div></div>`;
                },
                getCategoryIcon(categoryName) {
                    if (!categoryName || categoryName === 'Semua') return this.svgIcons.grid;
                    
                    // Priority 1: Check if we have custom icon from database
                    if (this.categoryIconsMap[categoryName]) {
                        const iconData = this.categoryIconsMap[categoryName];
                        
                        // If custom icon URL exists, return as img tag
                        if (iconData.iconUrl) {
                            return `<img src="${iconData.iconUrl}" alt="${categoryName}" class="w-full h-full object-contain" loading="lazy">`;
                        }
                        
                        // Use fallback icon from database
                        if (iconData.fallbackIcon) {
                            const fallbackId = this.getFallbackIconId(iconData.fallbackIcon);
                            const fallbackEl = document.getElementById(fallbackId);
                            if (fallbackEl?.innerHTML) {
                                return fallbackEl.innerHTML;
                            }
                        }
                    }
                    
                    // Priority 2: Legacy static icon matching (fallback)
                    const lower = categoryName.toLowerCase();
                    if (lower.includes('kuliner')) return this.svgIcons.food;
                    if (lower.includes('kelontong')) return this.svgIcons.kelontong;
                    if (lower.includes('fashion') || lower.includes('pakaian')) return this.svgIcons.fashion;
                    if (lower.includes('kerajinan')) return this.svgIcons.kerajinan;
                    if (lower.includes('jasa')) return this.svgIcons.work;
                    if (lower.includes('agribisnis')) return this.svgIcons.agribisnis;
                    
                    return this.svgIcons.grid;
                },
                
                // Helper: Map fallback icon name to DOM element ID
                getFallbackIconId(fallbackIcon) {
                    const map = {
                        'map-pin-food': 'icon-food',
                        'map-pin-fashion': 'icon-fashion',
                        'map-pin-work': 'icon-work',
                        'map-pin-shop': 'icon-kelontong',
                        'map-pin-plants': 'icon-agribisnis',
                        'map-pin-craft': 'icon-kerajinan',
                        'map-pin': 'icon-grid'
                    };
                    return map[fallbackIcon] || 'icon-grid';
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

        window.changePopupImage = function(event, id, direction) {
            // FIX: Stop propagation agar klik tidak tembus ke map
            if (event) {
                event.stopPropagation();
                event.preventDefault();
            }

            const imgElement = document.getElementById(`popup-img-${id}`);
            if (!imgElement) return;

            try {
                // Parse Data
                const rawImages = imgElement.getAttribute('data-images');
                const images = JSON.parse(rawImages);
                
                if (!Array.isArray(images) || images.length === 0) return;

                let currentIndex = parseInt(imgElement.getAttribute('data-index'));
                if (isNaN(currentIndex)) currentIndex = 0;

                // Calculate New Index
                let newIndex = currentIndex + direction;
                if (newIndex >= images.length) newIndex = 0;
                else if (newIndex < 0) newIndex = images.length - 1;

                // FIX 1: OPTIMIZE CLOUDINARY URL (BANDWIDTH SAVER)
                let newSrc = images[newIndex];
                if (newSrc.includes('cloudinary.com') && !newSrc.includes('w_')) {
                     // Case A: Parameter f_auto,q_auto sudah ada (bawaan upload)
                     if (newSrc.includes('/upload/f_auto,q_auto')) {
                          newSrc = newSrc.replace('/upload/f_auto,q_auto', '/upload/f_auto,q_auto,w_500,c_limit');
                     } 
                     // Case B: Belum ada parameter sama sekali
                     else {
                          newSrc = newSrc.replace('/upload/', '/upload/w_500,q_auto,f_auto,c_limit/');
                     }
                }

                // FIX 2: HAPUS SRCSET
                imgElement.removeAttribute('srcset');

                // Update DOM
                imgElement.src = newSrc;
                imgElement.setAttribute('data-index', newIndex);

            } catch (e) {
                console.error("Error changing popup image:", e);
            }
        }
    </script>
@endpush
