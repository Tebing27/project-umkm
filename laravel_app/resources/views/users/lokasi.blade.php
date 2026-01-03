<x-layouts.guest :title="translate('Lokasi UMKM - UMKM Sasuma')" :header-title="translate('Lokasi UMKM')" :header-subtitle="translate('Tambahkan lokasi baru')">

    <div x-data="locationHybrid()" x-init="init()" class="relative">

        {{-- 1. HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">{{ translate('Titik Lokasi UMKM') }}</h2>

            <div x-show="isLaptop"
                class="bg-[#FFC107] text-black px-4 py-3 rounded-lg text-sm font-medium shadow-sm max-w-md flex items-start gap-2">
                <x-icons.info-circle class="w-5 h-5 mt-0.5 shrink-0" />
                <span>{{ translate('Saat ini perangkat Anda menggunakan laptop sehingga masukkan koordinat manual. Peta akan menyesuaikan otomatis.') }}</span>
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

        {{-- ALERT LOCKED (Desktop) --}}
        <div x-show="showLockedAlert" x-transition
            class="fixed top-4 left-4 right-4 z-[70] flex items-center gap-2 bg-red-50 text-red-600 px-4 py-3 rounded-lg border border-red-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;">
            <x-icons.lock-closed class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">{{ translate('Mode Desktop Terkunci: Silakan masukkan koordinat manual atau gunakan HP.') }}</span>
            <button type="button" @click="showLockedAlert = false"
                class="ml-auto text-red-400 hover:text-red-600 focus:outline-none p-1">
                <span class="text-xl font-bold leading-none">&times;</span>
            </button>
        </div>

        {{-- [BARU] ALERT INSTRUCTION (Saat klik field disabled di Mobile) --}}
        <div x-show="showInstructionAlert" x-transition
            class="fixed top-4 left-4 right-4 z-[80] flex items-start gap-2 bg-orange-50 text-orange-700 px-4 py-3 rounded-lg border border-orange-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;">
            <x-icons.info-circle class="w-5 h-5 shrink-0 mt-0.5" />
            <span class="text-sm font-medium">{{ translate('Maaf, untuk mencari lokasi silahkan pilih wilayah -> lalu atur lokasi') }}</span>
        </div>

        <div x-show="showNoChangeAlert"
            class="fixed top-4 left-4 right-4 z-[60] flex items-start gap-2 bg-blue-50 text-blue-600 px-4 py-3 rounded-lg border border-blue-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;" x-transition>
            <x-icons.info-circle class="w-5 h-5 shrink-0" />
            <span class="text-sm">{{ translate('Lokasi belum berubah. Silakan atur koordinat.') }}</span>
        </div>

        {{-- 3. FORM UTAMA --}}
        <form action="{{ url('/users/lokasi/store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="address" x-model="address">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- KOLOM KIRI: MAP PREVIEW --}}
                <div class="space-y-4">
                    <div class="relative group">
                        <div class="mb-2 flex justify-between items-center" x-show="isMobile">
                            <label class="text-sm font-bold text-gray-700">{{ translate('Peta Lokasi') }}</label>
                            <span class="text-xs text-blue-600"
                                x-text="address && address !== '{{ translate('Memuat alamat...') }}' ? '{{ translate('Lokasi terpilih') }}' : '{{ translate('Belum diatur') }}'"></span>
                        </div>
                        <div
                            class="relative w-full h-64 lg:h-96 rounded-xl border border-gray-300 shadow-sm overflow-hidden bg-gray-100">
                            <div id="desktopMap" class="w-full h-full z-0"></div>
                            <div x-show="isLaptop" @click="triggerLockedAlert()"
                                class="absolute inset-0 z-[10] bg-transparent cursor-not-allowed">
                            </div>
                            <div x-show="isMobile"
                                class="absolute inset-0 z-[10] cursor-pointer flex items-center justify-center bg-black/2 hover:bg-black/10 transition-colors"
                                @click="openMobileModal()">
                                <div
                                    class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-md text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <x-icons.map-folded class="w-4 h-4" />
                                    <span x-text="hasChanged ? '{{ translate('Ubah Lokasi') }}' : '{{ translate('Atur Lokasi') }}'"></span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 text-center lg:text-left">
                            <span x-show="isLaptop">{{ translate('Peta ini hanya pratinjau. Masukkan koordinat di kolom kanan.') }}</span>
                            <span x-show="isMobile">{{ translate('Ketuk peta untuk mengubah lokasi lebih akurat.') }}</span>
                        </p>
                    </div>
                </div>

                {{-- KOLOM KANAN: INPUT FIELDS --}}
                <div class="space-y-6 flex flex-col justify-center">

                    {{-- 1. WILAYAH --}}
                    <div class="order-1">
                        <label class="block text-base font-semibold text-gray-900 mb-2">
                            {{ translate('Wilayah / Kelurahan') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{
                            open: false,
                            selectedId: '{{ $initialId }}',
                            selectedName: '{{ $initialName }}',
                            select(id, name) {
                                this.selectedId = id;
                                this.selectedName = name;
                                this.open = false;
                                $dispatch('region-changed', { name: name });
                            }
                        }" @click.outside="open = false"
                            @region-changed.window="handleRegionChange($event.detail.name)">
                            <input type="hidden" name="region_id" x-model="selectedId">
                            <button type="button" @click="open = !open"
                                class="group w-full cursor-pointer bg-gray-50 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 py-2.5 px-4 flex items-center justify-between transition-all">
                                <div class="flex items-center gap-3">
                                    <x-icons.map-folded
                                        class="w-5 h-5 text-slate-500 transition-colors duration-200 group-focus:text-blue-600" />
                                    <span class="text-sm md:text-base font-normal truncate"
                                        :class="selectedId ? 'text-gray-900' : 'text-gray-500'"
                                        x-text="selectedName"></span>
                                </div>
                                <x-icons.chevron-down
                                    class="w-4 h-4 text-gray-400 transition-transform duration-200 group-focus:text-blue-600"
                                    x-bind:class="open ? 'rotate-180' : ''" />
                            </button>
                            <div x-show="open" x-transition.origin.top x-cloak
                                class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden max-h-60 overflow-y-auto">
                                <div @click="select('', '{{ translate('Pilih Wilayah') }}')"
                                    class="px-5 py-3 text-sm md:text-base font-medium text-slate-600 hover:bg-slate-50 cursor-pointer flex items-center justify-between transition-colors border-b border-slate-50">
                                    <span>{{ translate('Pilih Wilayah') }}</span>
                                </div>
                                @foreach ($regions as $region)
                                    <div @click="select('{{ $region->id }}', '{{ $region->name }}')"
                                        class="px-5 py-3 text-sm md:text-base font-medium cursor-pointer flex items-center justify-between transition-colors hover:bg-slate-50"
                                        :class="selectedId == '{{ $region->id }}' ? 'text-blue-600 bg-blue-50/50' :
                                            'text-slate-600'">
                                        <span class="truncate">{{ $region->name }}</span>
                                        <x-icons.check x-show="selectedId == '{{ $region->id }}'"
                                            class="w-4 h-4 text-blue-600" />
                                    </div>
                                @endforeach
                            </div>
                            @error('region_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- 2. ALAMAT --}}
                    <div class="order-2 lg:order-4">
                        <label class="block mb-2 text-base font-semibold text-gray-900">{{ translate('Alamat Usaha') }}</label>
                        <div class="relative">
                            <x-ui.textarea name="address" rows="3" variant="soft" x-model="address"
                                @input.debounce.500ms="updateAddressFromInput()" x-bind:readonly="isMobile"
                                {{-- [UBAH] Tambahkan trigger alert saat diklik di mode mobile --}} @click="if(isMobile) triggerInstructionAlert()"
                                placeholder="{{ translate('Ketik alamat manual (Contoh: Jl. Sudirman No. 1)...') }}" class="text-sm"
                                ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                            </x-ui.textarea>
                            
                            {{-- AUTOCOMPLETE DROPDOWN (DESKTOP) --}}
                            <div x-show="searchResults.length > 0 && showSuggestions && !isMobile" 
                                @click.outside="showSuggestions = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute top-full left-0 right-0 z-50 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <ul>
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <li @click="selectLocation(result)" 
                                            class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0 transition-colors">
                                            <div class="font-bold text-gray-800 text-sm" x-text="result.title"></div>
                                            <div class="text-xs text-gray-500 mt-0.5" x-text="result.address"></div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
                            <span x-show="isLoadingAddress" class="text-blue-600 flex items-center gap-1">
                                <x-icons.loading class="w-3 h-3 animate-spin" /> {{ translate('Mencari koordinat...') }}
                            </span>
                            <span x-show="!isLoadingAddress" class="hidden md:block">{{ translate('Ketik alamat untuk update lokasi otomatis.') }}</span>
                        </div>
                    </div>

                    {{-- 3. LATITUDE --}}
                    <div class="order-3 lg:order-2">
                        <label class="block mb-2 text-base font-semibold text-gray-900">{{ translate('Latitude') }}</label>
                        {{-- [UBAH] Tambahkan click event untuk alert --}}
                        <div @click="if(isMobile) triggerInstructionAlert()">
                            <x-ui.input variant="soft" type="text" name="latitude" x-model="lat"
                                x-bind:readonly="isMobile" @input.debounce.800ms="updateMapFromInput()"
                                placeholder="-6.xxxxx" ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                                <x-slot:icon><x-icons.map-folded class="w-5 h-5" /></x-slot:icon>
                            </x-ui.input>
                        </div>
                    </div>

                    {{-- 4. LONGITUDE --}}
                    <div class="order-4 lg:order-3">
                        <label class="block mb-2 text-base font-semibold text-gray-900">{{ translate('Longitude') }}</label>
                        {{-- [UBAH] Tambahkan click event untuk alert --}}
                        <div @click="if(isMobile) triggerInstructionAlert()">
                            <x-ui.input variant="soft" type="text" name="longitude" x-model="lng"
                                x-bind:readonly="isMobile" @input.debounce.800ms="updateMapFromInput()"
                                placeholder="106.xxxxx" ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                                <x-slot:icon><x-icons.location class="w-5 h-5" /></x-slot:icon>
                            </x-ui.input>
                        </div>
                    </div>

                    {{-- 5. BUTTON --}}
                    <div class="pt-4 flex justify-center lg:justify-start order-5">
                        <div class="w-full lg:w-auto relative" @click="if(!isLoadingAddress) triggerNoChangeAlert()">
                            <x-ui.button type="submit" variant="default"
                                class="w-full lg:w-auto px-8 py-3 rounded-lg shadow-md transition-all flex items-center justify-center gap-2"
                                ::class="(!hasChanged || isLoadingAddress) ?
                                'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:scale-105 active:scale-95'" x-bind:disabled="!hasChanged || isLoadingAddress">
                                <template x-if="isLoadingAddress">
                                    <div class="flex items-center gap-2">
                                        <x-icons.loading class="w-5 h-5 animate-spin" />
                                        <span>{{ translate('Mencari...') }}</span>
                                    </div>
                                </template>
                                <template x-if="!isLoadingAddress">
                                    <div class="flex items-center gap-2 text-base font-medium">
                                        {{ translate('Simpan Lokasi') }}
                                    </div>
                                </template>
                            </x-ui.button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        {{-- 4. MOBILE MODAL (MODAL TETAP SAMA) --}}
        <div x-show="isModalOpen" style="display: none;"
            class="fixed inset-0 z-[100] bg-white flex flex-col w-full h-[100dvh]"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-full">

            <div
                class="px-4 py-3 border-b border-gray-200 flex items-center justify-between bg-white shadow-sm z-10 shrink-0 h-16">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">{{ translate('Pilih Lokasi') }}</h3>
                    <p class="text-xs text-gray-500">{{ translate('Geser peta ke titik usaha Anda') }}</p>
                </div>
                <button type="button" @click="closeMobileModal()"
                    class="p-2 rounded-full hover:bg-gray-100 text-gray-500">
                    <x-icons.x-mark class="w-6 h-6" />
                </button>
            </div>

            <div class="relative flex-1 w-full bg-gray-100">
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[500] pointer-events-none pb-8">
                    <x-icons.location class="w-8 h-8 text-red-600 drop-shadow-md" />
                </div>
                <div class="absolute bottom-24 right-4 z-[400]">
                    <button type="button" @click="locateMeMobile()"
                        class="bg-white p-3 rounded-full shadow-lg border border-gray-200 text-gray-700 hover:text-blue-600 active:bg-gray-50">
                        <x-icons.loading x-show="geoLoading" class="w-6 h-6 animate-spin text-blue-600" />
                        <x-icons.location x-show="!geoLoading" class="w-6 h-6" />
                    </button>
                </div>
                <div id="mobileMap" class="w-full h-full z-0"></div>
                
                {{-- [BARU] Top Floating Search Bar (Mobile) --}}
                <div class="absolute top-4 left-4 right-4 z-[550]">
                     <div class="relative bg-white rounded-xl shadow-lg border border-gray-200">
                         <div class="flex items-center px-4 py-3">
                             <x-icons.location-search class="w-5 h-5 text-gray-400 shrink-0" />
                             {{-- Input Search --}}
                            <input type="text"
    x-model="tempAddress"
    @input.debounce.500ms="updateMobileAddressFromInput()"
    placeholder="{{ translate('Cari jalan, tempat, atau alamat...') }}"
    class="w-full ml-3 text-sm font-medium text-gray-700 placeholder-gray-400 bg-transparent border-none focus:border-none focus:ring-0 focus:outline-none p-0">
                             
                             {{-- Clear Button --}}
                             <button type="button" x-show="tempAddress" @click="tempAddress = ''; updateMobileAddressFromInput()" class="ml-2 text-gray-400 hover:text-gray-600">
                                 <x-icons.x-mark class="w-5 h-5" />
                             </button>
                         </div>
                         
                         {{-- Loading Indicator --}}
                         <div x-show="isLoadingAddress" class="h-1 bg-blue-100 rounded-b-xl overflow-hidden">
                             <div class="h-full bg-blue-500 animate-[progress_1s_ease-in-out_infinite] w-1/3"></div>
                         </div>
                     </div>

                    {{-- AUTOCOMPLETE DROPDOWN (MOBILE) --}}
                    <div x-show="searchResults.length > 0 && showSuggestions" 
                        @click.outside="showSuggestions = false"
                        x-transition.opacity
                        class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-xl max-h-60 overflow-y-auto w-full z-[600]">
                        <ul>
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <li @click="!result.isError && selectLocation(result, true)" 
                                            class="px-4 py-3 border-b border-gray-100 last:border-0 transition-colors bg-white flex flex-col items-start text-left"
                                            :class="result.isError ? 'cursor-default bg-gray-50' : 'cursor-pointer hover:bg-gray-50'">
                                            <div class="font-bold text-gray-800 text-sm" x-text="result.title"></div>
                                            <div class="text-xs text-gray-500 mt-0.5" x-text="result.address"></div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                    {{-- Region Error Alert (Mobile Top) --}}
                </div>

                {{-- Update Map Center Indicator (to differentiate from user pin if needed, or keep existing) --}}
                {{-- Existing center pin is fine --}}

            </div>

            {{-- Button Confirm Floating at Bottom --}}
            <div class="absolute bottom-6 left-4 right-4 z-[400] flex flex-col gap-3">

              <div x-show="showRegionErrorAlert " x-transition
            class="fixed bottom-16 left-4 right-4 md:left-1/2 md:-translate-x-1/2 md:max-w-xl z-[150] bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-2xl drop-shadow-lg"
            style="display: none;">
            <div class="flex items-start">
                <div>
                    <p class="font-bold text-red-800">{{ translate('Perhatian') }}</p>
                    <p class="text-sm mt-1 text-red-700 leading-snug" x-html="regionErrorMessage"></p>
                </div>
                <button type="button" @click="showRegionErrorAlert = false"
                    class="ml-auto text-red-400 hover:text-red-800 font-bold p-1">
                    <x-icons.x-mark />
                </button>
            </div>
        </div>
                 
                <x-ui.button type="button" @click="confirmMobileLocation()"
        class="w-full py-3.5 text-base rounded-lg font-medium active:scale-95 transition-transform shadow-xl"
        ::class="showRegionErrorAlert ? 'opacity-50 cursor-not-allowed' : ''"
        x-bind:disabled="showRegionErrorAlert"> 
        {{-- Disabled tombol jika ada error --}}
        {{ translate('Pilih Lokasi Ini') }}
    </x-ui.button>
            </div>
        </div>

    </div>

    @push('scripts')
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
    @endpush
</x-layouts.guest>
