window.locationHybrid = function (config) {
    return {
        lat: config.lat || -6.4025,
        lng: config.lng || 106.7720,
        initialLat: config.lat || -6.4025,
        initialLng: config.lng || 106.7720,
        tempLat: '',
        tempLng: '',
        address: config.address || '',
        selectedId: config.initialId,
        selectedName: config.initialName,
        regionName: config.initialName,
        tempAddress: '',
        isLoadingAddress: false,
        debounceTimer: null,
        geoLoading: false,
        isMobile: false,
        isLaptop: false,
        isModalOpen: false,
        showSuccessAlert: config.showSuccessAlert,
        showLockedAlert: false,
        showNoChangeAlert: false,
        showRegionErrorAlert: false,
        showInstructionAlert: false,
        regionErrorMessage: config.text.regionErrorMessage || 'Lokasi berada di luar jangkauan.',
        successMessage: config.successMessage,
        ignoreMoveEvent: false,
        desktopMap: null,
        desktopMarker: null,
        mobileMap: null,
        mobileMarker: null,
        allowedRegions: ['cinangka', 'kedaung', 'sawangan baru', 'sawangan lama', 'pengasinan', 'pasir putih', 'bedahan'],
        regionsData: config.regionsData,
        sawanganCenter: [-6.4025, 106.7720],
        searchResults: [],
        showSuggestions: false,
        isProgrammaticUpdate: false,

        triggerInstructionAlert() {
            this.showInstructionAlert = true;
            setTimeout(() => this.showInstructionAlert = false, 3000);
        },

        async reverseGeocode(lat, lng, isTemp = false) {
            if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
                this.isLoadingAddress = false;
                return;
            }
            let placeholder = config.text.searchingAddress || "Mencari alamat...";
            if (isTemp) this.tempAddress = placeholder;
            else this.address = placeholder;

            try {
                let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
                let res = await fetch(url, { headers: { 'Accept-Language': 'id-ID,id;q=0.9' } });
                if (!res.ok) throw new Error("Gagal koneksi");
                let data = await res.json();
                let result = data.display_name || config.text.addressNotFound || "Alamat tidak ditemukan";

                if (isTemp) this.tempAddress = result;
                else this.address = result;

                if (data.address) {
                    let detectedRegion = [
                        data.address.village, data.address.suburb,
                        data.address.residential, data.address.neighbourhood
                    ].filter(Boolean).map(s => s.toLowerCase());

                    let isValid = detectedRegion.some(dr => this.allowedRegions.some(ar => dr.includes(ar)));

                    if (!isValid) {
                        this.regionErrorMessage = config.text.locationOutOfRange || "Lokasi ini berada di luar area layanan kami.";
                        this.showRegionErrorAlert = true;
                    } else {
                        this.showRegionErrorAlert = false;
                    }
                }
            } catch (e) {
                console.error(e);
                this.regionErrorMessage = config.text.failedToLoadAddress || "Gagal memuat alamat.";
                this.showRegionErrorAlert = true;
                let failMsg = config.text.failedToLoadAddress || "Gagal memuat alamat";
                if (isTemp) this.tempAddress = failMsg;
                else this.address = failMsg;
            } finally {
                setTimeout(() => { this.isLoadingAddress = false; }, 2000);
            }
        },

        async forwardGeocode(query, isTemp = false) {
            if (!query || query.length < 3) {
                this.isLoadingAddress = false;
                this.showSuggestions = false;
                this.searchResults = [];
                return;
            }

            try {
                let cleanQuery = query.replace(/(?:Kec\.|Kel\.|Kecamatan|Kelurahan|Kota|Depok|Indonesia)/gi, '').trim();
                let searchQuery = '';

                if (this.regionName && this.regionName !== config.text.selectRegion) {
                    searchQuery = `${cleanQuery}, ${this.regionName}, Depok`;
                } else {
                    searchQuery = `${cleanQuery}, Sawangan, Depok`;
                }

                let url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(searchQuery)}&format=json&limit=5&accept-language=id&addressdetails=1`;
                let res = await fetch(url);
                let data = [];

                if (res.ok) {
                    data = await res.json();
                }

                if (data && data.length > 0) {
                    this.searchResults = data.map(item => {
                        let parts = item.display_name.split(',');
                        let title = parts[0].trim();
                        let address = item.display_name.replace(parts[0] + ',', '').trim();

                        return {
                            title: title,
                            address: address,
                            full_address: item.display_name,
                            lat: parseFloat(item.lat),
                            lon: parseFloat(item.lon),
                            raw: item,
                            isError: false
                        };
                    });
                    this.showSuggestions = true;
                } else {
                    this.searchResults = [{
                        title: config.text.notFound || 'Tidak ditemukan',
                        address: config.text.tryAdjusting || 'Coba kurangi kata kunci atau geser peta manual.',
                        isError: true
                    }];
                    this.showSuggestions = true;
                }
            } catch (e) {
                console.error(e);
            } finally {
                this.isLoadingAddress = false;
            }
        },

        selectLocation(result, isTemp = false) {
            this.isProgrammaticUpdate = true;
            this.showSuggestions = false;

            if (isTemp) {
                this.tempAddress = result.full_address;
                this.tempLat = result.lat.toFixed(6);
                this.tempLng = result.lon.toFixed(6);
                this.ignoreMoveEvent = true;
                this.updateMobileMap(result.lat, result.lon);
            } else {
                this.address = result.full_address;
                this.lat = result.lat.toFixed(6);
                this.lng = result.lon.toFixed(6);
                this.updateDesktopMapView(result.lat, result.lon);
            }

            let detectedAddress = result.raw.address || {};
            let detectedRegion = [
                detectedAddress.village, detectedAddress.suburb,
                detectedAddress.residential, detectedAddress.neighbourhood,
                detectedAddress.city_district
            ].filter(Boolean).map(s => s.toLowerCase());

            let isValid = detectedRegion.some(dr => this.allowedRegions.some(ar => dr.includes(ar)));

            if (!isValid) {
                if (detectedAddress.city_district && detectedAddress.city_district.toLowerCase().includes('sawangan')) {
                    isValid = true;
                }
            }

            if (!isValid) {
                this.regionErrorMessage = config.text.locationSelectedOutOfRange || 'Lokasi terpilih berada di luar area layanan (7 Kelurahan Sawangan).';
                this.showRegionErrorAlert = true;
            } else {
                this.showRegionErrorAlert = false;
            }
        },

        handleRegionChange(name) {
            if (this.debounceTimer) clearTimeout(this.debounceTimer);
            this.isProgrammaticUpdate = true;
            this.regionName = name;
            this.selectedName = name;
            this.showRegionErrorAlert = false;

            if (!name || name === config.text.selectRegion) {
                const centerLat = this.sawanganCenter[0];
                const centerLng = this.sawanganCenter[1];
                this.lat = centerLat.toFixed(6);
                this.lng = centerLng.toFixed(6);
                this.updateDesktopMapView(centerLat, centerLng);
                this.address = '';
                if (this.mobileMap) {
                    this.tempLat = this.lat;
                    this.tempLng = this.lng;
                    this.tempAddress = '';
                    this.updateMobileMap(centerLat, centerLng);
                }
                console.log("Reset ke Center Sawangan:", centerLat, centerLng);
                return;
            }

            if (name) {
                this.isLoadingAddress = true;
                let selectedRegion = this.regionsData.find(r => r.name === name);

                if (selectedRegion && selectedRegion.latitude && selectedRegion.longitude) {
                    let lat = parseFloat(selectedRegion.latitude);
                    let lon = parseFloat(selectedRegion.longitude);
                    this.lat = lat.toFixed(6);
                    this.lng = lon.toFixed(6);
                    this.updateDesktopMapView(lat, lon);
                    if (this.mobileMap) {
                        this.tempLat = this.lat;
                        this.tempLng = this.lng;
                        this.updateMobileMap(lat, lon);
                    }
                    this.address = '';
                    this.isLoadingAddress = false;
                } else {
                    console.warn("Koordinat tidak ditemukan di database untuk:", name);
                    let regionQuery = `Kelurahan ${name}, Kecamatan Sawangan, Depok, Indonesia`;
                    fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(regionQuery)}&format=json&limit=1&accept-language=id`)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                let lat = parseFloat(data[0].lat);
                                let lon = parseFloat(data[0].lon);
                                this.lat = lat.toFixed(6);
                                this.lng = lon.toFixed(6);
                                this.updateDesktopMapView(lat, lon);
                                if (this.mobileMap) {
                                    this.tempLat = this.lat;
                                    this.tempLng = this.lng;
                                    this.updateMobileMap(lat, lon);
                                }
                                this.address = '';
                            }
                        })
                        .catch(e => console.error("Gagal cari wilayah", e))
                        .finally(() => this.isLoadingAddress = false);
                }
            }
        },

        updateMapFromInput() {
            const latVal = parseFloat(this.lat);
            const lngVal = parseFloat(this.lng);
            if (isNaN(latVal) || isNaN(lngVal)) return;
            this.updateDesktopMapView(latVal, lngVal);
            this.isLoadingAddress = true;
            if (this.debounceTimer) clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => this.reverseGeocode(latVal, lngVal, false), 1000);
        },

        updateAddressFromInput() {
            if (this.isProgrammaticUpdate) {
                this.isProgrammaticUpdate = false;
                return;
            }
            this.isLoadingAddress = true;
            if (this.debounceTimer) clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => this.forwardGeocode(this.address, false), 1500);
        },

        updateDesktopMapView(lat, lng) {
            if (this.desktopMap && this.desktopMarker) {
                const newLatLng = new L.LatLng(lat, lng);
                this.desktopMarker.setLatLng(newLatLng);
                this.desktopMap.setView(newLatLng, 16);
                this.desktopMap.invalidateSize();
            }
        },

        openMobileModal() {
            this.isModalOpen = true;
            let currentLat = parseFloat(this.lat);
            let currentLng = parseFloat(this.lng);
            let isDefault = (currentLat === -6.2 && currentLng === 106.816666) || isNaN(currentLat);
            let cLat = isDefault ? -6.4025 : currentLat;
            let cLng = isDefault ? 106.7720 : currentLng;

            this.tempLat = cLat.toFixed(6);
            this.tempLng = cLng.toFixed(6);
            this.tempAddress = this.address && this.address !== config.text.loadingAddress ? this.address : '';
            if (!this.tempAddress || this.tempAddress.includes('Memuat')) {
                this.reverseGeocode(cLat, cLng, true);
            }
            this.$nextTick(() => {
                this.initMobileMap(cLat, cLng);
            });
        },

        initMobileMap(lat, lng) {
            if (!this.mobileMap) {
                this.mobileMap = L.map('mobileMap', {
                    center: [lat, lng],
                    zoom: 18,
                    zoomControl: false,
                    maxBounds: [
                        [-6.3500, 106.7000],
                        [-6.4500, 106.8500]
                    ],
                    maxBoundsViscosity: 1.0
                });
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OSM'
                }).addTo(this.mobileMap);
                this.mobileMap.on('moveend', () => {
                    if (this.ignoreMoveEvent) {
                        this.ignoreMoveEvent = false;
                        return;
                    }
                    const c = this.mobileMap.getCenter();
                    this.tempLat = c.lat.toFixed(6);
                    this.tempLng = c.lng.toFixed(6);
                    if (this.debounceTimer) clearTimeout(this.debounceTimer);
                    this.debounceTimer = setTimeout(() => this.reverseGeocode(c.lat, c.lng, true), 800);
                });
            } else {
                setTimeout(() => {
                    this.mobileMap.invalidateSize();
                    this.updateMobileMap(lat, lng);
                }, 300);
            }
        },

        updateMobileAddressFromInput() {
            if (this.isProgrammaticUpdate) {
                this.isProgrammaticUpdate = false;
                return;
            }
            this.isLoadingAddress = true;
            this.forwardGeocode(this.tempAddress, true);
        },

        updateMobileMap(lat, lng) {
            if (this.mobileMap) {
                this.mobileMap.setView([lat, lng], 18);
            }
        },

        closeMobileModal() {
            this.isModalOpen = false;
        },

        confirmMobileLocation() {
            if (this.showRegionErrorAlert) return;
            this.lat = this.tempLat;
            this.lng = this.tempLng;
            this.address = this.tempAddress;
            this.updateMapFromInput();
            this.closeMobileModal();
        },

        async checkRegionValidity(lat, lng) {
            try {
                let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
                let res = await fetch(url, { headers: { 'Accept-Language': 'id-ID,id;q=0.9' } });
                if (!res.ok) throw new Error("Gagal koneksi");
                let data = await res.json();
                if (data.address) {
                    let detectedRegion = [
                        data.address.village, data.address.suburb,
                        data.address.residential, data.address.neighbourhood
                    ].filter(Boolean).map(s => s.toLowerCase());
                    let isValid = detectedRegion.some(dr => this.allowedRegions.some(ar => dr.includes(ar)));
                    return { isValid, address: data.display_name };
                }
                return { isValid: false, address: null };
            } catch (e) {
                console.error("Check validity error", e);
                return { isValid: false, address: null };
            }
        },

        locateMeMobile() {
            if (!navigator.geolocation) return alert(config.text.browserNoGps || "Browser tidak support GPS");
            this.geoLoading = true;
            this.showRegionErrorAlert = false;
            navigator.geolocation.getCurrentPosition(async (pos) => {
                let lat = pos.coords.latitude;
                let lng = pos.coords.longitude;
                let check = await this.checkRegionValidity(lat, lng);
                if (check.isValid) {
                    this.updateMobileMap(lat, lng);
                    this.tempLat = lat.toFixed(6);
                    this.tempLng = lng.toFixed(6);
                    this.tempAddress = check.address;
                } else {
                    this.regionErrorMessage = config.text.gpsOutOfRange || "Posisi GPS Anda berada di luar area layanan kami.";
                    this.showRegionErrorAlert = true;
                }
                this.geoLoading = false;
            }, () => {
                alert(config.text.gpsFailed || "Gagal mendapatkan lokasi GPS");
                this.geoLoading = false;
            }, {
                enableHighAccuracy: true
            });
        },

        initDesktopMap() {
            setTimeout(() => {
                const el = document.getElementById('desktopMap');
                if (el && !this.desktopMap) {
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
                    this.desktopMarker = L.marker([this.lat, this.lng], {
                        draggable: false
                    }).addTo(this.desktopMap);
                    if (this.address === config.text.loadingAddress || this.address === 'Memuat alamat...') {
                        this.reverseGeocode(this.lat, this.lng, false);
                    }
                }
            }, 500);
        },

        triggerLockedAlert() {
            if (this.isLaptop) this.showLockedAlert = true;
        },

        get hasChanged() {
            return String(this.lat) !== String(this.initialLat) ||
                String(this.lng) !== String(this.initialLng) ||
                this.address !== (config.address || ''); // Caution with object/string comparison if config.address isn't string
        },

        triggerNoChangeAlert() {
            if (!this.hasChanged) {
                this.showNoChangeAlert = true;
                setTimeout(() => this.showNoChangeAlert = false, 3000);
            }
        },

        init() {
            this.detectDeviceType();
            if (!this.lat) this.lat = -6.200000;
            if (!this.lng) this.lng = 106.816666;
            this.initDesktopMap();
            window.addEventListener('resize', () => {
                this.detectDeviceType();
            });
        },

        detectDeviceType() {
            const width = window.innerWidth;
            const isTouchDevice = (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0);
            this.isMobile = width < 1024 || isTouchDevice;
            this.isLaptop = width >= 1024 && !isTouchDevice;
        }
    }
}
