<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Usaha - UMKM Sasuma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>

    <div class="container mx-auto max-w-7xl px-4 md:px-8 lg:px-16 pt-12">

        <h1 class="text-center text-4xl md:text-5xl font-bold mb-12 tracking-tight">Daftar Usaha</h1>
        <p class="text-gray-600 mb-6 font-normal text-center">Sudah memiliki akun? <a href="{{ route('login') }}"
                class="text-blue-600 hover:text-blue-700 font-medium p-0 h-auto underline-offset-4 hover:underline">Masuk</a>.
        </p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                {{-- KOLOM KIRI --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-2 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <x-icons.store class="w-5 h-5" />
                            Data Usaha
                        </h2>
                    </div>

                    {{-- Nama Usaha --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Nama Usaha
                            <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="shop_name" value="{{ old('shop_name') }}"
                            placeholder="Warung Kopi Sejahtera"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.shopping-bag class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('shop_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Izin Usaha (Dynamic) --}}
                    <div x-data="{ licenses: [{ type: '', number: '' }] }">
                        <label class="block font-medium text-gray-700 text-base mb-2">Izin Usaha
                            <span>(Opsional)</span></label>

                        <template x-for="(license, index) in licenses" :key="index">
                            <div class="flex flex-row gap-3 mb-3">
                                {{-- Tipe Izin --}}
                                <div class="flex-1">
                                    <x-ui.input type="text" x-model="license.type" name="license_type[]"
                                        placeholder="NIB, SIUP"
                                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal" />
                                </div>

                                {{-- Nomor Izin --}}
                                <div class="flex-1">
                                    <x-ui.input type="text" x-model="license.number" name="license_number[]"
                                        placeholder="Nomor Izin"
                                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal" />
                                </div>

                                {{-- Tombol Hapus --}}
                                <x-ui.button type="button" @click="licenses.splice(index, 1)"
                                    x-show="licenses.length > 1" variant="ghost"
                                    class="p-3 text-red-500 hover:bg-red-50 hover:text-red-600 border border-transparent hover:border-red-100 h-auto rounded-xl transition-all">
                                    <x-icons.trash class="w-5 h-5" />
                                </x-ui.button>
                            </div>
                        </template>

                        <x-ui.button type="button" @click="licenses.push({ type: '', number: '' })" variant="ghost"
                            class="mt-1 text-sm text-blue-600 font-medium hover:text-blue-700 hover:bg-transparent p-0 h-auto justify-start gap-1 inline-flex items-center rounded-xl transition-all">
                            <x-icons.plus class="w-4 h-4" />
                            Tambah Izin Lain
                        </x-ui.button>
                        @if ($errors->has('license_type.*') || $errors->has('license_number.*'))
                            <div class="mt-2 text-sm text-red-500">
                                <p>Harap periksa kembali data izin usaha Anda.</p>
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
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Jenis Produk
                            <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="product_type" value="{{ old('product_type') }}"
                            placeholder="Camilan, Pakaian Pria, Jasa Jahit"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.shopping-cart class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('product_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Usaha (Radio) --}}
                    <div>
                        <label class="block font-medium text-gray-700 text-base mb-2">Jenis Usaha <span
                                class="text-red-500">*</span></label>
                        <div class="space-y-3 pl-1">
                            @foreach (['Kuliner', 'Pakaian & Fashion', 'Kelontong', 'Agribisnis', 'Jasa', 'Kerajinan Tangan'] as $item)
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
                                    class="w-4 h-4 text-gray-400 transition-transform duration-200 group-focus:text-blue-600 "
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
                    {{-- ALAMAT LENGKAP --}}
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

                </div>

                {{-- KOLOM KANAN --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-2 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <x-icons.user class="w-5 h-5" />
                            Data Pemilik
                        </h2>
                    </div>

                    {{-- Nama Pemilik --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Nama
                            Pemilik
                            <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="name" value="{{ old('name') }}"
                            placeholder="John Rizky Hernandes"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.user class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor HP --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Nomor
                            Handphone <span class="text-red-500">*</span></label>
                        <x-ui.input type="text" name="phone_number" value="{{ old('phone_number') }}"
                            placeholder="0812XXXXXX"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.phone class="w-5 h-5" stroke-width="1.5" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tempat, Tanggal Lahir --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Tempat,
                            Tanggal Lahir <span class="text-red-500">*</span></label>
                        <div class="flex gap-3">
                            <div class="w-1/2">
                                <x-ui.input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}"
                                    placeholder="Jakarta"
                                    class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                                    <x-slot:icon>
                                        <x-icons.cake class="w-5 h-5" stroke-width="1.5" />
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
                                        <x-icons.calendar class="w-5 h-5" stroke-width="1.5" />
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
                            Alamat Domisili <span class="text-red-500">*</span>
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

                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Email <span
                            class="text-red-500">*</span></label>
                    <x-ui.input type="email" name="email" value="{{ old('email') }}"
                        placeholder="john@email.com"
                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                        <x-slot:icon>
                            <x-icons.mail class="w-5 h-5" stroke-width="1.5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kata Sandi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Kata Sandi
                        <span class="text-red-500">*</span></label>
                    <x-ui.input type="password" name="password" placeholder="Masukkan kata sandi"
                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                        <x-slot:icon>
                            <x-icons.key class="w-5 h-5" stroke-width="1.5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Kata Sandi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Konfirmasi
                        Kata Sandi
                        <span class="text-red-500">*</span></label>
                    <x-ui.input type="password" name="password_confirmation" placeholder="Ulangi kata sandi"
                        class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                        <x-slot:icon>
                            <x-icons.key class="w-5 h-5" stroke-width="1.5" />
                        </x-slot:icon>
                    </x-ui.input>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sosmed --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 font-medium text-base mb-2">Alamat
                        Sosial Media atau Platform Digital Usaha <span>(Opsional)</span></label>
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.input type="url" name="social_instagram" value="{{ old('social_instagram') }}"
                            placeholder="https://instagram.com/@umkm"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.instagram class="text-red-500" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_instagram')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <x-ui.input type="url" name="social_tiktok" value="{{ old('social_tiktok') }}"
                            placeholder="https://tiktok.com/@umkm"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.tiktok class="text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_tiktok')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <x-ui.input type="url" name="social_facebook" value="{{ old('social_facebook') }}"
                            placeholder="https://facebook.com/umkm"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.facebook class="text-[#1877F2]" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_facebook')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <x-ui.input type="url" name="social_website" value="{{ old('social_website') }}"
                            placeholder="https://google.com"
                            class="bg-gray-50 rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                            <x-slot:icon>
                                <x-icons.globe class="text-slate-900" />
                            </x-slot:icon>
                        </x-ui.input>
                        @error('social_website')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
    </div>

    <div class="mt-12 mb-8 text-center px-4">
        <div class="mt-12 mb-8 text-center px-4">
            <x-ui.button type="submit"
                class="w-full md:w-auto md:min-w-[200px] py-3 md:py-3.5 px-6 font-semibold text-sm md:text-base rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                Daftar Sekarang
            </x-ui.button>
        </div>
    </div>
    </form>
    </div>

</body>

</html>
