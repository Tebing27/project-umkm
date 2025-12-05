<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Usaha - UMKM Sasuma</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>

    <div class="container mx-auto max-w-7xl px-4 md:px-8 lg:px-16 pt-12">

        <h1 class="text-center text-4xl md:text-5xl font-bold mb-12 tracking-tight">Daftar Usaha</h1>
        <p class="text-gray-600 mb-6 font-normal text-center">Sudah memiliki akun? <a href="#"
                class="text-blue-600 hover:text-blue-700 hover:underline font-medium">Masuk</a>.</p>

        <form action="#" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                {{-- KOLOM KIRI --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-2 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            Data Usaha
                        </h2>
                    </div>

                    {{-- Nama Usaha --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Nama Usaha <span
                                class="text-red-500">*</span></label>
                        {{-- Perubahan Style di Sini --}}
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <input type="text" placeholder="Masukkan nama usaha"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                    </div>

                    {{-- Izin Usaha (Dynamic) --}}
                    <div x-data="{ licenses: [{ type: '', number: '' }] }">
                        <label class="block mb-2 font-medium text-gray-700 text-base">Izin Usaha</label>
                        
                        <template x-for="(license, index) in licenses" :key="index">
                            <div class="flex flex-row gap-3 mb-3">
                                {{-- Tipe Izin --}}
                                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200 flex-1">
                                    <input type="text" x-model="license.type" name="license_type[]" placeholder="Nama Surat Izin"
                                        class="w-full bg-transparent outline-none text-gray-900 font-normal">
                                </div>

                                {{-- Nomor Izin --}}
                                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200 flex-1">
                                    <input type="text" x-model="license.number" name="license_number[]" placeholder="Nomor Surat Izin"
                                        class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                                </div>

                                {{-- Tombol Hapus --}}
                                <button type="button" @click="licenses.splice(index, 1)" x-show="licenses.length > 1"
                                    class="p-3 text-red-500 hover:bg-red-50 rounded-lg transition-colors shrink-0 border border-transparent hover:border-red-100" title="Hapus Izin">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <button type="button" @click="licenses.push({ type: '', number: '' })"
                            class="mt-1 text-sm text-blue-600 font-medium hover:underline flex items-center gap-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Izin Lain
                        </button>
                    </div>

                    {{-- Jenis Produk --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Jenis Produk <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <input type="text" placeholder="Contoh: Makanan Ringan, Baju Anak"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                    </div>

                    {{-- Jenis Usaha (Radio) --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Jenis Usaha <span
                                class="text-red-500">*</span></label>
                        <div class="space-y-3 pl-1">
                            @foreach (['Kuliner', 'Pakaian & Fashion', 'Kelontong', 'Agribisnis', 'Jasa', 'Kerajinan Tangan'] as $item)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="jenis_usaha"
                                        class="form-radio h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span
                                        class="text-gray-700 font-normal group-hover:text-black transition-colors">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Alamat Usaha Lengkap --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Alamat Usaha Lengkap <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 mb-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <input type="text" placeholder="Masukkan jalan usaha"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 w-1/2 justify-center focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <input type="text" placeholder="RT"
                                    class="w-full bg-transparent outline-none text-center text-gray-900 placeholder-gray-400 font-normal">
                            </div>
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 w-1/2 justify-center focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <input type="text" placeholder="RW"
                                    class="w-full bg-transparent outline-none text-center text-gray-900 placeholder-gray-400 font-normal">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-2 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Data Pemilik
                        </h2>
                    </div>

                    {{-- Nama Pemilik --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Nama Pemilik <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <input type="text" placeholder="Masukkan nama pemilik"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                    </div>

                    {{-- Nomor HP --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Nomor Handphone <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <input type="text" placeholder="Contoh: 08123456789"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                    </div>

                    {{-- Tempat, Tanggal Lahir --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Tempat, Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <div class="flex flex-col gap-3">
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <input type="text" placeholder="Masukkan tempat lahir"
                                    class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                            </div>
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                    placeholder="Tanggal/Bulan/Tahun"
                                    class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                            </div>
                        </div>
                    </div>

                    {{-- Alamat Domisili Lengkap --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Alamat Domisili Lengkap <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 mb-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <input type="text" placeholder="Masukkan jalan rumah"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 w-1/2 justify-center focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <input type="text" placeholder="RT"
                                    class="w-full bg-transparent outline-none text-center text-gray-900 placeholder-gray-400 font-normal">
                            </div>
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 w-1/2 justify-center focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <input type="text" placeholder="RW"
                                    class="w-full bg-transparent outline-none text-center text-gray-900 placeholder-gray-400 font-normal">
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Email <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <input type="email" placeholder="Masukkan email"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                    </div>

                    {{-- Kata Sandi --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Kata Sandi <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                </path>
                            </svg>
                            <input type="password" placeholder="Masukkan kata sandi"
                                class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                        </div>
                    </div>

                    {{-- Sosmed --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Alamat Sosial Media atau Platform
                            Digital Usaha</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg"
                                    class="w-5 h-5 mr-3 flex-shrink-0" alt="IG">
                                <input type="text" placeholder="LINK"
                                    class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal text-sm">
                            </div>
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
                                    class="w-5 h-5 mr-3 flex-shrink-0" alt="FB">
                                <input type="text" placeholder="LINK"
                                    class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal text-sm">
                            </div>
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-900 mr-3 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10s10-4.48 10-10c0-5.52-4.48-10-10-10zm-1 16.41V12.9h-2.5v-2.5H11v-1.79c0-2.31 1.25-3.56 3.56-3.56 1.11 0 2.22.18 2.22.18v2.44h-1.25c-1.13 0-1.48.71-1.48 1.44v1.29h2.72l-.44 2.5H14v5.51C13.36 18.33 12.69 18.41 12 18.41z">
                                    </path>
                                </svg>
                                <input type="text" placeholder="LINK"
                                    class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal text-sm">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-16 mb-8 text-center">
                <button type="submit"
                    class="bg-[#FFC107] text-lg font-medium cursor-pointer py-3 px-16 rounded-lg transition transform active:scale-95 shadow-md">
                    Daftar
                </button>
            </div>
        </form>
    </div>

</body>

</html>
