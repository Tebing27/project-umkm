        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('locationHybrid', () => window.locationHybrid({
                    lat: '{{ $shop->latitude ?? -6.4025 }}',
                    lng: '{{ $shop->longitude ?? 106.7720 }}',
                    address: {!! json_encode($shop->address ?? '') !!},
                    initialId: '{{ $initialId }}',
                    initialName: '{{ $initialName }}',
                    showSuccessAlert: {{ session('success') ? 'true' : 'false' }},
                    successMessage: '{{ session('success') }}',
                    regionsData: @json($regions),
                    text: {
                        regionErrorMessage: '{{ translate('Lokasi berada di luar jangkauan.') }}',
                        searchingAddress: '{{ translate('Mencari alamat...') }}',
                        addressNotFound: '{{ translate('Alamat tidak ditemukan') }}',
                        locationOutOfRange: '{{ translate('Lokasi ini berada di luar area layanan kami.') }}',
                        failedToLoadAddress: '{{ translate('Gagal memuat alamat.') }}',
                        selectRegion: '{{ translate('Pilih Wilayah') }}',
                        notFound: '{{ translate('Tidak ditemukan') }}',
                        tryAdjusting: '{{ translate('Coba kurangi kata kunci atau geser peta manual.') }}',
                        locationSelectedOutOfRange: '{{ translate('Lokasi terpilih berada di luar area layanan (7 Kelurahan Sawangan).') }}',
                        loadingAddress: '{{ translate('Memuat alamat...') }}',
                        browserNoGps: '{{ translate('Browser tidak support GPS') }}',
                        gpsOutOfRange: '{{ translate('Posisi GPS Anda berada di luar area layanan kami.') }}',
                        gpsFailed: '{{ translate('Gagal mendapatkan lokasi GPS') }}'
                    }
                }));
            });
        </script>
