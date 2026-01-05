<x-layouts.guest :title="translate('Edit Toko - UMKM Sasuma')" :header-title="translate('Edit Toko')" :header-subtitle="translate('Perbarui informasi toko')">

    {{-- Header Page --}}
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ translate('Edit Data Toko') }}</h2>
            <p class="text-gray-500 mt-1">{{ translate('Perbarui logo dan informasi usaha Anda.') }}</p>
        </div>
    </div>

    {{-- Form Start --}}
    <form action="{{ route('users.update-toko') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- SECTION UPLOAD LOGO --}}
        <div class="mb-12" x-data="{ 
            photoName: null, 
            photoPreview: '{{ $shop->logo ? asset('storage/' . $shop->logo) : null }}', 
            fallbackPreview: '{{ $shop->logo_url }}',
            isDeleted: false,
            businessType: '{{ strtolower($shop->business_type ?? 'kuliner') }}',
            
            getFallbackUrl() {
                const map = {
                    'kuliner': 'kuliner.svg',
                    'pakaian & aksesoris': 'pakaian.svg',
                    'pakaian & fashion': 'pakaian.svg', // Fallback
                    'kerajinan tangan': 'kerajinan.svg',
                    'kelontong': 'kelontong.svg',
                    'jasa': 'jasa.svg',
                    'agribisnis': 'agribisnis.svg',
                };
                return '/images/' + (map[this.businessType] || 'kuliner.svg');
            },

            updateBusinessType(type) {
                this.businessType = type.toLowerCase();
                if (!this.photoPreview && !this.isDeleted) {
                    this.fallbackPreview = this.getFallbackUrl();
                } else if (this.isDeleted) {
                    this.fallbackPreview = this.getFallbackUrl();
                }
            }
        }">
            <label class="block font-bold text-lg text-gray-900 mb-4">{{ translate('Logo Toko') }}</label>
            <div class="flex items-center gap-6">
                <!-- Hidden Input for File -->
                <input type="file" class="hidden" x-ref="photo" name="logo" accept="image/png, image/jpeg, image/jpg"
                    x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { 
                                photoPreview = e.target.result; 
                                isDeleted = false;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);
                        ">
                
                <!-- Hidden Input for Delete Flag -->
                <input type="hidden" name="delete_logo" :value="isDeleted ? 1 : 0">

                <div class="relative group cursor-pointer" x-on:click="$refs.photo.click()">
                    <!-- State 1: No Custom Logo (Show Fallback) -->
                    <div class="w-32 h-32 rounded-full bg-cover bg-center bg-no-repeat border-2 border-gray-200 shadow-sm"
                         x-show="!photoPreview && !isDeleted"
                         :style="'background-image: url(\'' + (fallbackPreview || getFallbackUrl()) + '\');'">
                    </div>
                    
                    <!-- State 2: Custom Logo Preview -->
                    <div class="w-32 h-32 rounded-full bg-cover bg-center bg-no-repeat border-2 border-gray-200 shadow-sm"
                        x-show="photoPreview && !isDeleted" 
                        :style="'background-image: url(\'' + photoPreview + '\');'">
                    </div>

                    <!-- State 3: Deleted (sama kayak fallback karena deleted berarti balik ke default) -->
                    <div class="w-32 h-32 rounded-full bg-cover bg-center bg-no-repeat border-2 border-dashed border-gray-400 shadow-inner opacity-70"
                         x-show="isDeleted"
                         :style="'background-image: url(\'' + getFallbackUrl() + '\');'">
                         <div class="absolute inset-0 flex items-center justify-center bg-black/10 rounded-full">
                            <span class="text-xs font-medium bg-white px-2 py-1 rounded shadow text-gray-700">{{ translate('Default') }}</span>
                         </div>
                    </div>

                    <div class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md border border-gray-200 text-gray-500 group-hover:text-[#004a85] transition-colors">
                        <x-icons.ui-edit class="w-4 h-4" />
                    </div>
                    <div x-show="(photoPreview || '{{ $shop->logo }}') && !isDeleted" 
         x-on:click.stop="isDeleted = true; photoPreview = null; $refs.photo.value = null;"
         class="absolute top-0 right-0 -mt-1 -mr-1 bg-white p-2 rounded-full shadow-md border border-gray-200 text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors z-20"
         title="{{ translate('Hapus Logo') }}">
        <x-icons.ui-delete class="w-4 h-4" />
    </div>
                </div>

                <div class="flex flex-col space-y-2">
                    <div class="flex gap-2">
                        <x-ui.button type="button" x-on:click="$refs.photo.click()" variant="outline"
                            class="bg-white rounded-lg border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-black w-fit shadow-sm">
                            {{ translate('Upload Foto') }}
                        </x-ui.button>
                    </div>
                    <span class="text-xs text-gray-500">{{ translate('Maksimal 2MB (JPG, PNG)') }}</span>
                    @error('logo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- GRID INPUT FIELDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

            {{-- KOLOM KIRI --}}
            <div class="space-y-6">

                {{-- Nama Usaha --}}
                <div class="space-y-2">
                    <label class="block mb-2 font-medium text-gray-700">{{ translate('Nama Usaha') }} <span
                            class="text-red-500">*</span></label>
                    <x-ui.input variant="soft" type="text" name="shop_name"
                        value="{{ old('shop_name', $shop->name ?? '') }}" placeholder="{{ translate('Tebing') }}"
                        class="text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.data-store class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('shop_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Produk --}}
                <div class="space-y-2">
                    <label class="block mb-2 font-medium text-gray-700">{{ translate('Jenis Produk') }} <span
                            class="text-red-500">*</span></label>
                    <x-ui.input variant="soft" type="text" name="product_type"
                        value="{{ old('product_type', $shop->product_type ?? '') }}"
                        placeholder="{{ translate('Contoh: Makanan Ringan') }}" class="text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.shop-cart class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('product_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi Toko --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">{{ translate('Deskripsi Toko') }} <span
                            class="text-red-500">*</span></label>
                    <x-ui.textarea rows="4" variant="soft" name="description"
                        placeholder="{{ translate('Ceritakan tentang tokomu...') }}" class="text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.data-description class="w-5 h-5" />
                        </x-slot:icon>
                        {{ translate(old('description', $shop->description ?? '')) }}
                    </x-ui.textarea>
                </div>

                {{-- Izin Usaha (Dynamic List) --}}

                <div class="space-y-2" x-data="{ licenses: {{ json_encode($licenses) }} }">
                    <label class="block mb-2 font-medium text-gray-700">{{ translate('Izin Usaha') }}</label>

                    <template x-for="(license, index) in licenses" :key="index">
                        <div class="flex flex-row gap-3 mb-3">
                            <div class="flex-1">
                                <x-ui.input variant="soft" type="text" x-model="license.type" name="license_type[]"
                                    placeholder="{{ translate('Nama Surat Izin') }}" class="text-sm md:text-base" />
                            </div>
                            <div class="flex-1">
                                <x-ui.input variant="soft" type="text" x-model="license.number"
                                    name="license_number[]" placeholder="{{ translate('Nomor Surat Izin') }}" class="text-sm md:text-base" />
                            </div>
                            <x-ui.button type="button" @click="licenses.splice(index, 1)" x-show="licenses.length > 1"
                                variant="ghost"
                                class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors shrink-0"
                                title="{{ translate('Hapus Izin') }}">
                                <x-icons.ui-delete class="w-5 h-5" />
                            </x-ui.button>
                        </div>
                    </template>

                    <x-ui.button type="button" @click="licenses.push({ type: '', number: '' })" variant="ghost"
                        class="mt-2 text-sm text-[#004a85] rounded-lg font-medium flex items-center gap-1 transition-colors">
                        <x-icons.ui-plus class="w-4 h-4" />
                        {{ translate('Tambah Izin Lain') }}
                    </x-ui.button>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-6">

                {{-- Nama Pemilik --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">{{ translate('Nama Pemilik') }} <span
                            class="text-red-500">*</span></label>
                    <x-ui.input variant="soft" type="text" value="{{ Auth::user()->name }}" readonly
                        class="bg-gray-100 text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.data-user class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>

                {{-- Jenis Usaha (Radio) --}}
                <div class="space-y-2">
                    <label class="font-medium text-gray-700">{{ translate('Jenis Usaha') }} <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-2 gap-x-4 text-sm md:text-base text-gray-600 mt-1">
                        @foreach (\App\Models\Shop::BUSINESS_TYPES as $item)
                            <label
                                class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                <input type="radio" name="business_type" value="{{ $item }}"
                                    class="text-[#004a85] focus:ring-[#004a85] cursor-pointer"
                                    {{ old('business_type', $shop->business_type ?? '') == $item ? 'checked' : '' }}
                                    x-on:change="updateBusinessType('{{ $item }}')">
                                <span>{{ $item }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('business_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Omset Penjualan --}}
                <div class="space-y-2" x-data="{
                    minOmset: '{{ old('omset_min', $shop->omset_min ?? '') }}',
                    maxOmset: '{{ old('omset_max', $shop->omset_max ?? '') }}',
                    formatRupiah(value) {
                        let number_string = value.replace(/[^,\d]/g, '').toString();
                        let split = number_string.split(',');
                        let sisa = split[0].length % 3;
                        let rupiah = split[0].substr(0, sisa);
                        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                        if (ribuan) {
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }
                        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    }
                }" x-init="minOmset = formatRupiah(minOmset);
                maxOmset = formatRupiah(maxOmset);">
                    <label class="block mb-2 font-medium text-gray-700">{{ translate('Omset Penjualan') }} <span
                            class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <x-ui.input variant="soft" type="text" name="omset_min" x-model="minOmset"
                            @input="minOmset = formatRupiah($el.value)" placeholder="{{ translate('Minimal') }}"
                            class="text-sm md:text-base font-medium">
                            <x-slot:icon>
                                <span
                                    class="mr-2 text-gray-500 font-medium group-focus-within:text-blue-600 transition-colors">Rp</span>
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="omset_max" x-model="maxOmset"
                            @input="maxOmset = formatRupiah($el.value)" placeholder="{{ translate('Maksimal') }}"
                            class="text-sm md:text-base font-medium">
                            <x-slot:icon>
                                <span
                                    class="text-gray-500 font-medium group-focus-within:text-blue-600 transition-colors">Rp</span>
                            </x-slot:icon>
                        </x-ui.input>
                    </div>
                    @error('omset_min')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @error('omset_max')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sosmed --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">{{ translate('Sosial Media') }}</label>
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.input variant="soft" type="text" name="social_instagram"
                            value="{{ old('social_instagram', $shop->social_instagram ?? '') }}"
                            placeholder="{{ translate('Username instagram') }}" class="text-sm md:text-base">
                            <x-slot:icon>
                                <x-icons.social-instagram class="w-5 h-5 text-[#E4405F]" />
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="social_tiktok"
                            value="{{ old('social_tiktok', $shop->social_tiktok ?? '') }}"
                            placeholder="{{ translate('Username Tiktok') }}" class="text-sm md:text-base">
                            <x-slot:icon>
                                <x-icons.social-tiktok class="w-5 h-5 text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="social_facebook"
                            value="{{ old('social_facebook', $shop->social_facebook ?? '') }}"
                            placeholder="{{ translate('Username Facebook') }}" class="text-sm md:text-base">
                            <x-slot:icon>
                                <x-icons.social-facebook class="w-5 h-5 text-[#1877F2]" />
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="social_website"
                            value="{{ old('social_website', $shop->social_website ?? '') }}" placeholder="Website"
                            class="text-sm md:text-base">
                            <x-slot:icon>
                                <x-icons.map-globe class="w-5 h-5 text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>
                    </div>
                </div>

            </div>
        </div>

        {{-- Button Simpan --}}
        <div class="pt-6 flex justify-center">
            <x-ui.button type="submit" variant="default" class="w-full md:w-auto px-12 py-3 rounded-xl shadow-md">
                {{ translate('Simpan Perubahan') }}
            </x-ui.button>
        </div>

    </form>
</x-layouts.guest>
