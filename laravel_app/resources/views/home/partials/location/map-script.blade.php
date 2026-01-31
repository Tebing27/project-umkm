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
                        const regionMatch = currentRegion === '' || item.region ===
                            currentRegion;

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
                            
                            // Hapus sementara GeoJSON Layer agar tooltips tidak error "latLngToLayerPoint" saat animasi flyTo
                            if (this.geoJsonLayer) {
                                // FIX REVISI: Close tooltip per-layer secara manual (aman dari error undefined)
                                this.geoJsonLayer.eachLayer(layer => {
                                    if (layer.closeTooltip) layer.closeTooltip();
                                });
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
                            // FIX: Wrap in setTimeout to ensure call stack clear after layer removal
                            setTimeout(() => {
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
                        .catch(error => {});
                    
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
