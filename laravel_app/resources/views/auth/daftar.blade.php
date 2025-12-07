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
                            <x-icons.store class="w-5 h-5" />
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
                            <x-icons.shopping-bag class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                                    <x-icons.trash class="w-5 h-5" />
                                </button>
                            </div>
                        </template>

                        <button type="button" @click="licenses.push({ type: '', number: '' })"
                            class="mt-1 text-sm text-blue-600 font-medium hover:underline flex items-center gap-1 transition-colors">
                            <x-icons.plus class="w-4 h-4" />
                            Tambah Izin Lain
                        </button>
                    </div>

                    {{-- Jenis Produk --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Jenis Produk <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <x-icons.shopping-cart class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                            <x-icons.store class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                            <x-icons.user class="w-5 h-5" />
                            Data Pemilik
                        </h2>
                    </div>

                    {{-- Nama Pemilik --}}
                    <div>
                        <label class="block mb-2 font-medium text-gray-700 text-base">Nama Pemilik <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                            <x-icons.user class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                            <x-icons.phone class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                                <x-icons.cake class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
                                <input type="text" placeholder="Masukkan tempat lahir"
                                    class="w-full bg-transparent outline-none text-gray-900 placeholder-gray-400 font-normal">
                            </div>
                            <div
                                class="flex items-center bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all duration-200">
                                <x-icons.calendar class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                            <x-icons.location class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                            <x-icons.mail class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                            <x-icons.key class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" stroke-width="1.5" />
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
                                <x-icons.globe class="w-5 h-5 text-gray-900 mr-3 flex-shrink-0" />
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
