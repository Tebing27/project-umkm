<x-layouts.auth>
    <x-slot:title>
        {{ translate('Daftar Usaha - UMKM Sasuma') }}
    </x-slot:title>

    <div class="container mx-auto max-w-7xl px-4 md:px-8 lg:px-16 pt-12">

        <h1 class="text-center text-4xl md:text-5xl font-bold mb-12 tracking-tight">{{ translate('Daftar Usaha') }}</h1>
        <p class="text-gray-600 mb-6 font-normal text-center">{{ translate('Sudah memiliki akun?') }} <a href="{{ route('login') }}"
                class="text-blue-600 hover:text-blue-700 font-medium p-0 h-auto underline-offset-4 hover:underline">{{ translate('Masuk') }}</a>.
        </p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                {{-- KOLOM KIRI --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-2 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <x-icons.data-store class="w-5 h-5" />
                            {{ translate('Data Usaha') }}
                        </h2>
                    </div>

                    {{-- Nama Usaha --}}
                    <div x-data="{ shopName: {{ json_encode(old('shop_name', '')) }} }">
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Nama Usaha') }}
                            <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="shop_name" x-model="shopName" maxlength="30"
                            placeholder="{{ translate('Warung Kopi Sejahtera') }}"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.shop-bag class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        
                        {{-- Character Counter Status --}}
                        <div class="flex justify-between mt-1 text-xs px-1">
                             <span x-show="shopName.length >= 25" x-transition class="text-amber-600 font-medium">
                                {{ translate('Mendekati batas (30 karakter)') }}
                             </span>
                             <span class="text-gray-500 ml-auto" x-text="shopName.length + '/30'"
                                :class="{'text-red-600 font-bold': shopName.length >= 30, 'text-amber-600': shopName.length >= 25}"></span>
                        </div>

                        @error('shop_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Izin Usaha (Dynamic) --}}
                    <div x-data="{ licenses: [{ type: '', number: '' }] }">
                        <label class="block font-medium text-gray-700 text-base mb-2">{{ translate('Izin Usaha') }}
                            <span>{{ translate('(Opsional)') }}</span></label>

                        <template x-for="(license, index) in licenses" :key="index">
                            <div class="flex flex-row gap-3 mb-3">
                                {{-- Tipe Izin --}}
                                <div class="flex-1">
                                    <x-ui.input type="text" x-model="license.type" name="license_type[]"
                                        placeholder="{{ translate('NIB, SIUP') }}"
                                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal" />
                                </div>

                                {{-- Nomor Izin --}}
                                <div class="flex-1">
                                    <x-ui.input type="text" x-model="license.number" name="license_number[]"
                                        placeholder="{{ translate('Nomor Izin') }}"
                                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal" />
                                </div>

                                {{-- Tombol Hapus --}}
                                <x-ui.button type="button" @click="licenses.splice(index, 1)"
                                    x-show="licenses.length > 1" variant="ghost"
                                    class="p-3 text-red-500 hover:bg-red-50 hover:text-red-600 border border-transparent hover:border-red-100 h-auto rounded-xl transition-all">
                                    <x-icons.ui-delete class="w-5 h-5" />
                                </x-ui.button>
                            </div>
                        </template>

                        <x-ui.button type="button" @click="licenses.push({ type: '', number: '' })" variant="ghost"
                            class="mt-1 text-sm text-blue-600 font-medium hover:text-blue-700 hover:bg-transparent p-0 h-auto justify-start gap-1 inline-flex items-center rounded-xl transition-all">
                            <x-icons.ui-plus class="w-4 h-4" />
                            {{ translate('Tambah Izin Lain') }}
                        </x-ui.button>
                        @if ($errors->has('license_type.*') || $errors->has('license_number.*'))
                            <div class="mt-2 text-sm text-red-500">
                                <p>{{ translate('Harap periksa kembali data izin usaha Anda.') }}</p>
                                @foreach ($errors->get('license_type.*') as $messages)
                                    @foreach ($messages as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                @endforeach
                                @foreach ($errors->get('license_number.*') as $messages)
                                    @foreach ($messages as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Jenis Produk --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Jenis Produk') }}
                            <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="product_type" value="{{ old('product_type') }}"
                            placeholder="{{ translate('Camilan, Pakaian Pria, Jasa Jahit') }}"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.shop-cart class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('product_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Usaha (Radio) --}}
                    <div>
                        <label class="block font-medium text-gray-700 text-base mb-2">{{ translate('Jenis Usaha') }} <span
                                class="text-red-500">*</span></label>
                        <div class="space-y-3 pl-1">
                            @foreach (\App\Models\Shop::getBusinessTypes() as $item)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="business_type" value="{{ $item }}"
                                        {{ old('business_type') == $item ? 'checked' : '' }}
                                        class="form-radio h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="text-gray-700 text-sm font-normal group-hover:text-black transition-colors">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('business_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 1. PILIH WILAYAH (PENTING UNTUK FILTER) --}}
                    {{-- TAMBAHKAN INI DI ATAS BAGIAN INPUT WILAYAH --}}


                    {{-- KEMUDIAN LANJUT KE INPUT SEPERTI SEBELUMNYA --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ translate('Wilayah / Kelurahan') }} <span class="text-red-500">*</span>
                        </label>

                        <div class="relative" x-data="{
                            open: false,
                            selectedId: '{{ old('region_id') }}',
                            selectedName: '{{ old('region_id') ? $regions->firstWhere('id', old('region_id'))->name ?? translate('Pilih Wilayah') : translate('Pilih Wilayah') }}',
                            select(id, name) {
                                this.selectedId = id;
                                this.selectedName = name;
                                this.open = false;
                                $dispatch('region-changed', { name: name });
                            }
                        }" @click.outside="open = false">
                            <input type="hidden" name="region_id" x-model="selectedId">

                            <button type="button" @click="open = !open"
                                class="group w-full bg-gray-50 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 py-2.5 px-4 flex items-center justify-between transition-all">

                                <div class="flex items-center gap-3">
                                    <x-icons.map-folded
                                        class="w-5 h-5 text-slate-500 transition-colors duration-200 group-focus:text-blue-600" />

                                    <span class="text-sm font-normal truncate"
                                        :class="selectedId ? 'text-gray-900' : 'text-gray-500'"
                                        x-text="selectedName"></span>
                                </div>

                                <x-icons.ui-chevron-down
                                    class="w-4 h-4 text-gray-400 transition-transform duration-200 group-focus:text-blue-600 "
                                    x-bind:class="open ? 'rotate-180' : ''" />
                            </button>

                            <div x-show="open" x-transition.origin.top x-cloak
                                class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden max-h-60 overflow-y-auto">
                                <div @click="select('', '{{ translate('Pilih Wilayah') }}')"
                                    class="px-5 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 cursor-pointer flex items-center justify-between transition-colors border-b border-slate-50">
                                    <span>{{ translate('Pilih Wilayah') }}</span>
                                </div>

                                @foreach ($regions as $region)
                                    <div @click="select('{{ $region->id }}', '{{ $region->name }}')"
                                        class="px-5 py-3 text-sm font-medium cursor-pointer flex items-center justify-between transition-colors hover:bg-slate-50"
                                        :class="selectedId == '{{ $region->id }}' ? 'text-blue-600 bg-blue-50/50' :
                                            'text-slate-600'">
                                        <span class="truncate">{{ $region->name }}</span>

                                        <x-icons.ui-check x-show="selectedId == '{{ $region->id }}'"
                                            class="w-4 h-4 text-blue-600" />
                                    </div>
                                @endforeach
                            </div>

                            @error('region_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- ALAMAT LENGKAP --}}
                    <div class="mt-4" x-data="addressSearch()">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ translate('Alamat Usaha') }} <span class="text-red-500">*</span>
                        </label>

                        {{-- WRAPPER UTAMA (Memberikan Border & Rounded Luar) --}}
                        <div
                            class="flex flex-col border border-gray-300 rounded-xl bg-gray-50 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-200 relative">
                            
                            <input type="hidden" name="latitude" x-model="lat">
                            <input type="hidden" name="longitude" x-model="lng">

                            <div class="relative w-full">
                                <div class="absolute top-3 left-4 text-slate-500 pointer-events-none">
                                    <x-icons.map-pin class="w-5 h-5" />
                                </div>
                                <textarea name="shop_address" rows="2" x-model="address" @input.debounce.500ms="searchAddress()"
                                    class="w-full bg-transparent border-none outline-none pl-11 pr-4 py-3 text-sm text-slate-900 focus:ring-0 resize-none"
                                    :class="{'border-red-300 ring-2 ring-red-100': regionError}"
                                    placeholder="{{ translate('Nama Jalan, Blok, No. Rumah') }}">{{ old('shop_address') }}</textarea>
                                
                                {{-- WARNING ICON / TOOLTIP --}}
                                <div x-show="regionError" class="absolute top-10 left-4 right-0 z-10">
                                    <span class="text-xs text-red-500 bg-red-50 px-2 py-1 rounded border border-red-200 shadow-sm animate-pulse">
                                        {{ translate('Silakan pilih Wilayah/Kelurahan terlebih dahulu.') }}
                                    </span>
                                </div>
                                
                                {{-- LOADING INDICATOR --}}
                                <div x-show="isLoading" class="absolute top-3 right-4 text-blue-600">
                                    <x-icons.status-loading class="w-5 h-5 animate-spin" />
                                </div>
                            </div>

                            {{-- DROPDOWN HASIL PENCARIAN --}}
                            <div x-show="searchResults.length > 0 && showSuggestions" 
                                 @click.outside="showSuggestions = false"
                                 x-transition.opacity
                                 class="absolute top-full left-0 right-0 z-50 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <ul>
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <li @click="selectAddress(result)" 
                                            class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0 transition-colors">
                                            <div class="font-bold text-gray-800 text-sm" x-text="result.title"></div>
                                            <div class="text-xs text-gray-500 mt-0.5" x-text="result.address"></div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                        </div>

                        {{-- Error Messages --}}
                        @if ($errors->has('shop_address'))
                            <p class="mt-1 text-sm text-red-500">{{ translate('Mohon lengkapi alamat usaha.') }}</p>
                        @endif
                        
                        <script>
                            function addressSearch() {
                                return {
                                    address: '{{ old('shop_address') }}',
                                    lat: '{{ old('latitude') }}',
                                    lng: '{{ old('longitude') }}',
                                    searchResults: [],
                                    showSuggestions: false,
                                    isLoading: false,
                                    regionName: '{{ old('region_id') ? $regions->firstWhere('id', old('region_id'))->name ?? '' : '' }}',

                                    regionError: false,
                                    
                                    init() {
                                        window.addEventListener('region-changed', (e) => {
                                            this.regionName = e.detail.name;
                                            this.regionError = false;
                                            // Reset address if region changes? Maybe optional, but likely good.
                                            // this.address = ''; 
                                        });
                                    },

                                    async searchAddress() {
                                        this.regionError = false;

                                        // 1. Cek apakah wilayah sudah dipilih
                                        if (!this.regionName || this.regionName === '{{ translate('Pilih Wilayah') }}') {
                                            this.searchResults = [];
                                            this.showSuggestions = false;
                                            this.regionError = true;
                                            return;
                                        }

                                        if (!this.address || this.address.length < 3) {
                                            this.searchResults = [];
                                            this.showSuggestions = false;
                                            return;
                                        }

                                        this.isLoading = true;
                                        
                                        try {
                                            // Format query: Nama Jalan, Nama Kelurahan, Depok
                                            let cleanQuery = this.address.replace(/(?:Kec\.|Kel\.|Kecamatan|Kelurahan|Kota|Depok|Indonesia)/gi, '').trim();
                                            let query = `${cleanQuery}, ${this.regionName}, Depok`;
                                            
                                            let url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=5&accept-language=id&addressdetails=1`;
                                            
                                            let res = await fetch(url);
                                            let data = await res.json();
                                            
                                            if (data && data.length > 0) {
                                                // Filter data secara Client-Side untuk memastikannya BENAR-BENAR ada di wilayah itu.
                                                // Nominatim kadang mengembalikan hasil "Near" atau di kecamatan yang sama tapi beda kelurahan.
                                                let filteredData = data.filter(item => {
                                                    let addr = item.address;
                                                    if (!addr) return false;
                                                    
                                                    // Field yang mungkin mengandung nama kelurahan
                                                    let relevantFields = [
                                                        addr.village, 
                                                        addr.suburb, 
                                                        addr.neighbourhood, 
                                                        addr.residential,
                                                        addr.city_district // Kadang muncul di sini
                                                    ];
                                                    
                                                    return relevantFields.some(f => f && f.toLowerCase().includes(this.regionName.toLowerCase()));
                                                });

                                                this.searchResults = filteredData.map(item => {
                                                    let parts = item.display_name.split(',');
                                                    let title = parts[0].trim();
                                                    
                                                    // Hapus bagian judul dari address agar lebih bersih
                                                    let addr = item.display_name.replace(parts[0] + ',', '').trim();
                                                    
                                                    return {
                                                        title: title,
                                                        address: addr,
                                                        full: item.display_name,
                                                        lat: item.lat,
                                                        lon: item.lon
                                                    };
                                                });
                                                
                                                this.showSuggestions = this.searchResults.length > 0;
                                            } else {
                                                this.searchResults = []; // Kosongkan jika tidak ketemu
                                                this.showSuggestions = false;
                                                
                                                // Optional: Bisa set message "Alamat tidak ditemukan di [RegionName]"
                                            }
                                        } catch (e) {
                                            console.error("Address search error:", e);
                                        } finally {
                                            this.isLoading = false;
                                        }
                                    },
                                    
                                    selectAddress(result) {
                                        // Set address hanya bagian nama tempat/jalan jika ingin singkat, atau full.
                                        // User request: "sesuai alamat nya dari field wilayah" -> Kita ambil full address dari hasil search yang sudah terfilter region.
                                        this.address = result.title + ', ' + result.address;
                                        this.lat = result.lat;
                                        this.lng = result.lon;
                                        this.showSuggestions = false;
                                    }
                                }
                            }
                        </script>
                    </div>

                </div>

                {{-- KOLOM KANAN --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-2 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <x-icons.data-user class="w-5 h-5" />
                            {{ translate('Data Pemilik') }}
                        </h2>
                    </div>

                    {{-- Nama Pemilik --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Nama Pemilik') }}
                            <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="name" value="{{ old('name') }}"
                            placeholder="John Rizky Hernandes"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.data-user class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor HP --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Nomor Handphone') }} <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="phone_number" value="{{ old('phone_number') }}"
                            placeholder="0812XXXXXX"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.contact-phone class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tempat, Tanggal Lahir --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Tempat, Tanggal Lahir') }} <span class="text-red-500">*</span></label>
                        <div class="flex gap-3">
                            <div class="w-1/2">
                                <x-ui.input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}"
                                    placeholder="Jakarta"
                                    class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                                    <x-slot:icon>
                                        <x-icons.data-cake class="w-5 h-5" stroke-width="1.5" />
                                    </x-slot:icon>
                                </x-ui.input>
                                @error('place_of_birth')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <x-ui.input type="text" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                    onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="2001/12/18"
                                    class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                                    <x-slot:icon>
                                        <x-icons.data-calendar class="w-5 h-5" stroke-width="1.5" />
                                    </x-slot:icon>
                                </x-ui.input>
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Alamat Domisili --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ translate('Alamat Domisili') }} <span class="text-red-500">*</span>
                        </label>

                        {{-- WRAPPER UTAMA (Memberikan Border & Rounded Luar) --}}
                        <div
                            class="flex flex-col border border-gray-300 rounded-xl bg-gray-50 overflow-hidden focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-200">

                            {{-- BAGIAN ATAS: TEXTAREA ALAMAT --}}
                            <div class="relative w-full">
                                <div class="absolute top-3 left-4 text-slate-500 pointer-events-none">
                                    <x-icons.map-pin class="w-5 h-5" />
                                </div>
                                <textarea name="domicile_address" rows="2"
                                    class="w-full bg-transparent border-none outline-none pl-11 pr-4 py-3 text-sm text-slate-900 focus:ring-0 resize-none"
                                    placeholder="{{ translate('Nama Jalan, Blok, No. Rumah') }}">{{ old('domicile_address') }}</textarea>
                            </div>
                    </div>
                    {{-- Error Messages --}}
                        @if ($errors->has('domicile_address'))
                            <p class="mt-1 text-sm text-red-500">{{ translate('Mohon lengkapi alamat domisili.') }}</p>
                        @endif

                {{-- Email --}}
                <div class="mt-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Email') }} <span
                            class="text-red-500">*</span></label>
                    <x-ui.input type="email" name="email" value="{{ old('email') }}"
                        placeholder="john@email.com"
                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                        <x-slot:icon>
                            <x-icons.contact-mail class="w-5 h-5" stroke-width="1.5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                </div>

                {{-- Kata Sandi with Strength Meter --}}
                <div class="mt-4" x-data="{
                    password: '',
                    confirmation: '',
                    show: false,
                    showConfirm: false,
                    strength: 0,
                    checks: {
                        length: false,
                        lower: false,
                        upper: false,
                        number: false
                    },
                    checkStrength() {
                        this.checks.length = this.password.length >= 8;
                        this.checks.lower = /[a-z]/.test(this.password);
                        this.checks.upper = /[A-Z]/.test(this.password);
                        this.checks.number = /[0-9]/.test(this.password);
                        
                        this.strength = Object.values(this.checks).filter(Boolean).length;
                    },
                    get strengthLabel() {
                        if(this.strength <= 2) return '{{ translate('Lemah') }}';
                        if(this.strength < 4) return '{{ translate('Sedang') }}';
                        return '{{ translate('Kuat') }}';
                    },
                    get strengthColor() {
                        if(this.strength <= 2) return 'bg-red-500';
                        if(this.strength < 4) return 'bg-amber-500';
                        return 'bg-green-500';
                    },
                    get strengthText() {
                         if(this.strength <= 2) return 'text-red-600';
                        if(this.strength < 4) return 'text-amber-600';
                        return 'text-green-600';
                    },
                    get confirmClass() {
                        if(this.confirmation && this.password !== this.confirmation) return 'border-red-500 focus:border-red-500';
                        if(this.confirmation && this.password === this.confirmation) return 'border-green-500 focus:border-green-500';
                        return '';
                    }
                }">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Kata Sandi') }}
                            <span class="text-red-500">*</span></label>
                        <x-ui.input ::type="show ? 'text' : 'password'" name="password" x-model="password" @input="checkStrength()" placeholder="{{ translate('Masukkan kata sandi') }}"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.auth-key class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                            <x-slot:suffix>
                                <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                                    <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                                </button>
                            </x-slot:suffix>
                        </x-ui.input>
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        {{-- Strength Meter --}}
                        <div class="mt-2 text-sm transition-all duration-300" x-show="password.length > 0" x-transition>
                            <div class="flex justify-between mb-1">
                                <span class="font-medium" :class="strengthText">{{ translate('Kekuatan Password:') }} <span x-text="strengthLabel"></span></span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full transition-all duration-500" :class="strengthColor" :style="'width: ' + (strength * 25) + '%'"></div>
                            </div>
                            
                            {{-- Recommendations --}}
                            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-1 gap-x-2">
                                <div class="flex items-center gap-1.5" :class="checks.length ? 'text-green-600' : 'text-slate-500'">
                                    <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.length" />
                                    <div class="w-3.5 h-3.5 rounded-full border border-slate-300" x-show="!checks.length"></div>
                                    <span>{{ translate('Min 8 karakter') }}</span>
                                </div>
                                 <div class="flex items-center gap-1.5" :class="checks.lower ? 'text-green-600' : 'text-slate-500'">
                                    <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.lower" />
                                    <div class="w-3.5 h-3.5 rounded-full border border-slate-300" x-show="!checks.lower"></div>
                                    <span>{{ translate('Huruf kecil (a-z)') }}</span>
                                </div>
                                <div class="flex items-center gap-1.5" :class="checks.upper ? 'text-green-600' : 'text-slate-500'">
                                    <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.upper" />
                                    <div class="w-3.5 h-3.5 rounded-full border border-slate-300" x-show="!checks.upper"></div>
                                    <span>{{ translate('Huruf besar (A-Z)') }}</span>
                                </div>
                                <div class="flex items-center gap-1.5" :class="checks.number ? 'text-green-600' : 'text-slate-500'">
                                    <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.number" />
                                    <div class="w-3.5 h-3.5 rounded-full border border-slate-300" x-show="!checks.number"></div>
                                    <span>{{ translate('Angka (0-9)') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Konfirmasi Kata Sandi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Konfirmasi Kata Sandi') }}
                            <span class="text-red-500">*</span></label>
                        <x-ui.input ::type="showConfirm ? 'text' : 'password'" name="password_confirmation" x-model="confirmation" placeholder="{{ translate('Ulangi kata sandi') }}"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal"
                            x-bind:class="confirmClass">
                            <x-slot:icon>
                                <x-icons.auth-key class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                             <x-slot:suffix>
                                <button type="button" @click="showConfirm = !showConfirm" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <x-icons.ui-eye x-show="!showConfirm" class="w-5 h-5" />
                                    <x-icons.ui-eye-off x-show="showConfirm" class="w-5 h-5" />
                                </button>
                            </x-slot:suffix>
                        </x-ui.input>
                        <p x-show="confirmation && password !== confirmation" class="text-red-500 text-xs mt-1">{{ translate('Kata sandi tidak cocok') }}</p>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Sosmed --}}
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">{{ translate('Alamat Sosial Media atau Platform Digital Usaha') }} <span>{{ translate('(Opsional)') }}</span></label>
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.input type="url" name="social_instagram" value="{{ old('social_instagram') }}"
                            placeholder="https://instagram.com/@umkm"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.social-instagram class="text-red-500" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_instagram')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <x-ui.input type="url" name="social_tiktok" value="{{ old('social_tiktok') }}"
                            placeholder="https://tiktok.com/@umkm"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.social-tiktok class="text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_tiktok')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <x-ui.input type="url" name="social_facebook" value="{{ old('social_facebook') }}"
                            placeholder="https://facebook.com/umkm"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.social-facebook class="text-[#1877F2]" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_facebook')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <x-ui.input type="url" name="social_website" value="{{ old('social_website') }}"
                            placeholder="https://google.com"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.map-globe class="text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_website')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                </div>
            </div>
    </div>

    <div class="mt-12 mb-8 text-center px-4">
        <div class="mt-12 mb-8 text-center px-4">
            <x-ui.button type="submit"
                class="w-full md:w-auto md:min-w-[200px] py-3 md:py-3.5 px-6 font-semibold text-sm md:text-base rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                {{ translate('Daftar Sekarang') }}
            </x-ui.button>
        </div>
    </div>
    </form>
    </div>

</x-layouts.auth>
