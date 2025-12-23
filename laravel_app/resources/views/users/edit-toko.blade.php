<x-layouts.guest title="Edit Toko - UMKM Sasuma" header-title="Edit Toko" header-subtitle="Perbarui informasi toko">

    {{-- Header Page --}}
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Edit Data Toko</h2>
            <p class="text-gray-500 mt-1">Perbarui logo dan informasi usaha Anda.</p>
        </div>
    </div>

    {{-- Form Start --}}
    <form action="{{ route('users.update-toko') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- SECTION UPLOAD LOGO --}}
        <div class="mb-12" x-data="{ photoName: null, photoPreview: null }">
            <label class="block font-bold text-lg text-gray-900 mb-4">Logo Toko</label>
            <div class="flex items-center gap-6">
                <input type="file" class="hidden" x-ref="photo" name="logo"
                    x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL($refs.photo.files[0]);
                        ">
                <div class="relative group cursor-pointer" x-on:click="$refs.photo.click()">
                    <div class="w-32 h-32 rounded-full bg-[#F9F8F6] flex items-center justify-center border-2 border-dashed border-gray-300 group-hover:border-[#004a85] transition-colors"
                        x-show="!photoPreview">
                        <x-icons.photo class="w-10 h-10 text-gray-400 group-hover:text-[#004a85]" />
                    </div>
                    <div class="w-32 h-32 rounded-full bg-cover bg-center bg-no-repeat border-2 border-gray-200 shadow-sm"
                        x-show="photoPreview" :style="'background-image: url(\'' + photoPreview + '\');'"
                        style="display: none;">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md border border-gray-200 text-gray-500 group-hover:text-[#004a85] transition-colors">
                        <x-icons.pencil class="w-4 h-4" />
                    </div>
                </div>
                <div class="flex flex-col space-y-1">
                    <x-ui.button type="button" x-on:click="$refs.photo.click()" variant="outline"
                        class="bg-white rounded-lg border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-black w-fit shadow-sm">
                        Upload Foto
                    </x-ui.button>
                    <span class="text-xs text-gray-500">Maksimal 2MB (JPG, PNG)</span>
                </div>
            </div>
        </div>

        {{-- GRID INPUT FIELDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

            {{-- KOLOM KIRI --}}
            <div class="space-y-6">

                {{-- Nama Usaha --}}
                <div class="space-y-2">
                    <label class="block mb-2 font-medium text-gray-700">Nama Usaha <span
                            class="text-red-500">*</span></label>
                    <x-ui.input variant="soft" type="text" name="shop_name"
                        value="{{ old('shop_name', $shop->name ?? '') }}" placeholder="Tebing"
                        class="text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.store class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>

                {{-- Jenis Produk --}}
                <div class="space-y-2">
                    <label class="block mb-2 font-medium text-gray-700">Jenis Produk <span
                            class="text-red-500">*</span></label>
                    <x-ui.input variant="soft" type="text" name="product_type"
                        value="{{ old('product_type', $shop->product_type ?? '') }}"
                        placeholder="Contoh: Makanan Ringan" class="text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.shopping-cart class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>

                {{-- Deskripsi Toko --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Deskripsi Toko</label>
                    <x-ui.textarea rows="4" variant="soft" name="description"
                        placeholder="Ceritakan tentang tokomu..." class="text-sm md:text-base">
                        <x-slot:icon>
                            <x-icons.text-description class="w-5 h-5" />
                        </x-slot:icon>
                        {{ old('description', $shop->description ?? '') }}
                    </x-ui.textarea>
                </div>

                {{-- Izin Usaha (Dynamic List) --}}
                @php
                    $licenses = [];
                    if ($shop && $shop->licenses) {
                        $licenses = is_string($shop->licenses) ? json_decode($shop->licenses, true) : $shop->licenses;
                    }
                    if (empty($licenses)) {
                        $licenses = [['type' => '', 'number' => '']];
                    }
                @endphp
                <div class="space-y-2" x-data="{ licenses: {{ json_encode($licenses) }} }">
                    <label class="block mb-2 font-medium text-gray-700">Izin Usaha</label>

                    <template x-for="(license, index) in licenses" :key="index">
                        <div class="flex flex-row gap-3 mb-3">
                            <div class="flex-1">
                                <x-ui.input variant="soft" type="text" x-model="license.type" name="license_type[]"
                                    placeholder="Nama Surat Izin" />
                            </div>
                            <div class="flex-1">
                                <x-ui.input variant="soft" type="text" x-model="license.number"
                                    name="license_number[]" placeholder="Nomor Surat Izin" />
                            </div>
                            <x-ui.button type="button" @click="licenses.splice(index, 1)" x-show="licenses.length > 1"
                                variant="ghost"
                                class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors shrink-0"
                                title="Hapus Izin">
                                <x-icons.trash class="w-5 h-5" />
                            </x-ui.button>
                        </div>
                    </template>

                    <x-ui.button type="button" @click="licenses.push({ type: '', number: '' })" variant="ghost"
                        class="mt-2 text-sm text-[#004a85] rounded-lg font-medium flex items-center gap-1 transition-colors">
                        <x-icons.plus class="w-4 h-4" />
                        Tambah Izin Lain
                    </x-ui.button>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-6">

                {{-- Nama Pemilik --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Nama Pemilik <span
                            class="text-red-500">*</span></label>
                    <x-ui.input variant="soft" type="text" value="{{ Auth::user()->name }}" readonly
                        class="bg-gray-100">
                        <x-slot:icon>
                            <x-icons.user class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                </div>

                {{-- Jenis Usaha (Radio) --}}
                <div class="space-y-2">
                    <label class="font-medium text-gray-700">Jenis Usaha <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-2 gap-x-4 text-sm md:text-md text-gray-600 mt-1">
                        @foreach (['Kuliner', 'Pakaian & Fashion', 'Agribisnis', 'Kelontong', 'Kerajinan Tangan', 'Jasa'] as $item)
                            <label
                                class="flex items-center space-x-2 cursor-pointer group hover:text-gray-900 transition-colors">
                                <input type="radio" name="business_type" value="{{ $item }}"
                                    class="text-[#004a85] focus:ring-[#004a85] cursor-pointer"
                                    {{ old('business_type', $shop->business_type ?? '') == $item ? 'checked' : '' }}>
                                <span>{{ $item }}</span>
                            </label>
                        @endforeach
                    </div>
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
                    <label class="block mb-2 font-medium text-gray-700">Omset Penjualan <span
                            class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <x-ui.input variant="soft" type="text" name="omset_min" x-model="minOmset"
                            @input="minOmset = formatRupiah($el.value)" placeholder="Minimal"
                            class="text-sm md:text-base font-medium">
                            <x-slot:icon>
                                <span
                                    class="mr-2 text-gray-500 font-medium group-focus-within:text-blue-600 transition-colors">Rp</span>
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="omset_max" x-model="maxOmset"
                            @input="maxOmset = formatRupiah($el.value)" placeholder="Maksimal"
                            class="text-sm md:text-base font-medium">
                            <x-slot:icon>
                                <span
                                    class="text-gray-500 font-medium group-focus-within:text-blue-600 transition-colors">Rp</span>
                            </x-slot:icon>
                        </x-ui.input>
                    </div>
                </div>

                @php
                    // Data dummy sementara agar tidak error "Undefined variable"
                    $regions = [
                        (object) ['id' => 1, 'name' => 'Cinangka'],
                        (object) ['id' => 2, 'name' => 'Kedaung'],
                        (object) ['id' => 3, 'name' => 'Sawangan'],
                        (object) ['id' => 4, 'name' => 'Pengasinan'],
                        (object) ['id' => 5, 'name' => 'Bojongsari'],
                        (object) ['id' => 6, 'name' => 'Pasir Putih'],
                        (object) ['id' => 7, 'name' => 'Bedahan'],
                    ];
                @endphp

                {{-- KEMUDIAN LANJUT KE INPUT SEPERTI SEBELUMNYA --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Wilayah / Kelurahan <span class="text-red-500">*</span>
                    </label>

                    <div class="relative" x-data="{
                        open: false,
                        selectedId: '{{ old('region_id') }}',
                        selectedName: '{{ old('region_id') ? $regions->firstWhere('id', old('region_id'))->name ?? 'Pilih Wilayah' : 'Pilih Wilayah' }}',
                        select(id, name) {
                            this.selectedId = id;
                            this.selectedName = name;
                            this.open = false;
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

                            <x-icons.chevron-down
                                class="w-4 h-4 text-gray-400 transition-transform duration-200 group-focus:text-blue-600"
                                x-bind:class="open ? 'rotate-180' : ''" />
                        </button>

                        <div x-show="open" x-transition.origin.top x-cloak
                            class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden max-h-60 overflow-y-auto">
                            <div @click="select('', 'Pilih Wilayah')"
                                class="px-5 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50 cursor-pointer flex items-center justify-between transition-colors border-b border-slate-50">
                                <span>Pilih Wilayah</span>
                            </div>

                            @foreach ($regions as $region)
                                <div @click="select('{{ $region->id }}', '{{ $region->name }}')"
                                    class="px-5 py-3 text-sm font-medium cursor-pointer flex items-center justify-between transition-colors hover:bg-slate-50"
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

                {{-- Alamat --}}
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Usaha <span class="text-red-500">*</span>
                    </label>

                    {{-- WRAPPER UTAMA (Memberikan Border & Rounded Luar) --}}
                    <div
                        class="flex flex-col border border-gray-300 rounded-xl bg-gray-50 overflow-hidden focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-200">

                        {{-- BAGIAN ATAS: TEXTAREA ALAMAT --}}
                        <div class="relative w-full">
                            <div class="absolute top-3 left-4 text-slate-500 pointer-events-none">
                                <x-icons.location class="w-5 h-5" />
                            </div>
                            <textarea name="address" rows="2"
                                class="w-full bg-transparent border-none outline-none pl-11 pr-4 py-3 text-sm text-slate-900 focus:ring-0 resize-none"
                                placeholder="Nama Jalan, Blok, No. Rumah">{{ old('address') }}</textarea>
                        </div>

                        {{-- GARIS PEMBATAS HORIZONTAL --}}
                        <div class="h-px bg-gray-200 w-full"></div>

                        {{-- BAGIAN BAWAH: RT & RW (Grid Sebelahan) --}}
                        <div class="flex divide-x divide-gray-200 bg-gray-100/50">

                            {{-- Input RT --}}
                            <div class="relative w-1/2 group">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 group-focus-within:text-blue-600">RT</span>
                                <input type="number" name="rt" value="{{ old('rt') }}"
                                    class="w-full bg-transparent border-none outline-none pl-10 pr-2 py-2.5 text-sm text-slate-900 focus:ring-0 placeholder-slate-300 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    placeholder="000">
                            </div>

                            {{-- Input RW --}}
                            <div class="relative w-1/2 group">
                                <span
                                    class="absolute left-2 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 group-focus-within:text-blue-600">RW</span>
                                <input type="number" name="rw" value="{{ old('rw') }}"
                                    class="w-full bg-transparent outline-none border-none pl-10 pr-2 py-2.5 text-sm text-slate-900 focus:ring-0 placeholder-slate-300 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    placeholder="000">
                            </div>
                        </div>
                    </div>

                    {{-- Error Messages --}}
                    @if ($errors->has('address') || $errors->has('rt') || $errors->has('rw'))
                        <p class="mt-1 text-sm text-red-500">Mohon lengkapi alamat, RT, dan RW.</p>
                    @endif
                </div>

                {{-- Sosmed --}}
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">Sosial Media</label>
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.input variant="soft" type="text" name="social_instagram"
                            value="{{ old('social_instagram', $shop->social_instagram ?? '') }}"
                            placeholder="Username instagram" class="text-sm">
                            <x-slot:icon>
                                <x-icons.instagram class="w-5 h-5 text-[#E4405F]" />
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="social_tiktok"
                            value="{{ old('social_tiktok', $shop->social_tiktok ?? '') }}"
                            placeholder="Username Tiktok" class="text-sm">
                            <x-slot:icon>
                                <x-icons.tiktok class="w-5 h-5 text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="social_facebook"
                            value="{{ old('social_facebook', $shop->social_facebook ?? '') }}"
                            placeholder="Username Facebook" class="text-sm">
                            <x-slot:icon>
                                <x-icons.facebook class="w-5 h-5 text-[#1877F2]" />
                            </x-slot:icon>
                        </x-ui.input>

                        <x-ui.input variant="soft" type="text" name="social_website"
                            value="{{ old('social_website', $shop->social_website ?? '') }}" placeholder="Website"
                            class="text-sm">
                            <x-slot:icon>
                                <x-icons.globe class="w-5 h-5 text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>
                    </div>
                </div>

            </div>
        </div>

        {{-- Button Simpan --}}
        <div class="pt-6 flex justify-center">
            <x-ui.button type="submit" variant="default" class="w-full md:w-auto px-12 py-3 rounded-xl shadow-md">
                Simpan Perubahan
            </x-ui.button>
        </div>

    </form>
</x-layouts.guest>
