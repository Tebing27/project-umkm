<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Toko - UMKM Sasuma</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Style Input: Mengikuti style Input Lokasi (Krem #F9F8F6) */
        .input-custom {
            background-color: #F9F8F6;
            border: 1.5px solid #d1d5db;
            /* Border abu-abu tipis agar terlihat */
            transition: all 0.2s ease-in-out;
        }

        .input-custom:focus-within {
            background-color: #fff;
            /* Jadi putih saat diklik */
            border-color: #d1d5db;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-white font-sans text-gray-900 antialiased" x-data="{ sidebarOpen: false, sidebarExpanded: true }">

    <div class="flex min-h-screen bg-white">

        {{-- Sidebar --}}
        <x-navigation-users />

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
            :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-24'">

            {{-- Mobile Header --}}
            {{-- Mobile Header --}}
            <x-header-mobile title="Edit Toko" subtitle="Perbarui informasi toko" />

            {{-- Content --}}
            <main class="flex-1 p-6 md:p-10 lg:p-16 overflow-x-hidden">

                {{-- Header Page --}}
                <div class="mb-10 flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Edit Data Toko</h2>
                        <p class="text-gray-500 mt-1">Perbarui logo dan informasi usaha Anda.</p>
                    </div>
                </div>

                {{-- Form Start --}}
                <form action="#" method="POST" enctype="multipart/form-data">

                    {{-- SECTION UPLOAD LOGO --}}
                    <div class="mb-12" x-data="{ photoName: null, photoPreview: null }">
                        <label class="block font-bold text-lg text-gray-900 mb-4">Logo Toko</label>

                        <div class="flex items-center gap-6">
                            {{-- Input File Hidden --}}
                            <input type="file" class="hidden" x-ref="photo"
                                x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => { photoPreview = e.target.result; };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                    ">

                            {{-- Preview Area (Lingkaran) --}}
                            <div class="relative group cursor-pointer" x-on:click="$refs.photo.click()">

                                {{-- Default Placeholder (Lingkaran) --}}
                                <div class="w-32 h-32 rounded-full bg-[#F9F8F6] flex items-center justify-center border-2 border-dashed border-gray-300 group-hover:border-[#004a85] transition-colors"
                                    x-show="!photoPreview">
                                    <svg class="w-10 h-10 text-gray-400 group-hover:text-[#004a85]" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>

                                {{-- Image Preview (Lingkaran) --}}
                                <div class="w-32 h-32 rounded-full bg-cover bg-center bg-no-repeat border-2 border-gray-200 shadow-sm"
                                    x-show="photoPreview" :style="'background-image: url(\'' + photoPreview + '\');'"
                                    style="display: none;">
                                </div>

                                {{-- Icon Edit (Floating Badge) --}}
                                <div
                                    class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md border border-gray-200 text-gray-500 group-hover:text-[#004a85] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1">
                                <button type="button" x-on:click="$refs.photo.click()"
                                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-black transition-colors w-fit shadow-sm">
                                    Pilih Foto Baru
                                </button>
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
                                <label class="block font-medium text-gray-700 text-lg">Nama Usaha <span
                                        class="text-red-500">*</span></label>
                                <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <input type="text" value="Tebing UMKM"
                                        class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                </div>
                            </div>

                            {{-- Izin Usaha (Dynamic) --}}
                            <div class="space-y-2" x-data="{ licenses: [{ type: 'NIB', number: '1234567890' }] }">
                                <label class="block font-medium text-gray-700 text-lg">Izin Usaha</label>
                                
                                <template x-for="(license, index) in licenses" :key="index">
                                    <div class="flex flex-row gap-3 mb-3">
                                        {{-- Tipe Izin --}}
                                        <div class="relative input-custom rounded-xl px-4 py-3 flex items-center flex-1">
                                            <input type="text" x-model="license.type" name="license_type[]" placeholder="Nama Surat Izin"
                                                class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                        </div>

                                        {{-- Nomor Izin --}}
                                        <div class="relative input-custom rounded-xl px-4 py-3 flex items-center flex-1">
                                            <input type="text" x-model="license.number" name="license_number[]" placeholder="Nomor Surat Izin"
                                                class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                        </div>

                                        {{-- Tombol Hapus --}}
                                        <button type="button" @click="licenses.splice(index, 1)" x-show="licenses.length > 1"
                                            class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors shrink-0" title="Hapus Izin">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </template>

                                <button type="button" @click="licenses.push({ type: '', number: '' })"
                                    class="mt-2 text-sm text-[#004a85] font-medium hover:underline flex items-center gap-1 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Izin Lain
                                </button>
                            </div>

                            {{-- Deskripsi Toko --}}
                            <div class="space-y-2">
                                <label class="block font-medium text-gray-700 text-lg">Deskripsi Toko</label>
                                <div class="relative input-custom rounded-xl px-4 py-3 flex items-start">
                                    <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0 mt-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                    <textarea rows="4"
                                        class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium resize-none"
                                        placeholder="Ceritakan tentang tokomu..."></textarea>
                                </div>
                            </div>

                            {{-- Jenis Usaha (Radio) --}}
                            <div class="space-y-3">
                                <label class="block font-medium text-gray-700 text-lg">Jenis Usaha <span
                                        class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 gap-y-3 gap-x-4">
                                    @foreach (['Kuliner', 'Pakaian & Fashion', 'Kelontong', 'Agribisnis', 'Jasa', 'Kerajinan Tangan'] as $item)
                                        <label class="flex items-center space-x-3 cursor-pointer group">
                                            <input type="radio" name="jenis_usaha"
                                                class="form-radio h-5 w-5 text-[#004a85] border-gray-300 focus:ring-[#004a85]"
                                                {{ $item == 'Kuliner' ? 'checked' : '' }}>
                                            <span
                                                class="text-gray-700 font-normal group-hover:text-black transition-colors">{{ $item }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Alamat Usaha Lengkap --}}
                            <div class="space-y-2">
                                <label class="block font-medium text-gray-700 text-lg">Alamat Usaha Lengkap <span
                                        class="text-red-500">*</span></label>
                                <div class="relative input-custom rounded-xl px-4 py-3 flex items-center mb-3">
                                    <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <input type="text" value="Jl. Merpati No. 45"
                                        class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                </div>
                                <div class="flex gap-4">
                                    <div
                                        class="relative input-custom rounded-xl px-4 py-3 flex items-center w-1/2 justify-center">
                                        <input type="text" value="005" placeholder="RT"
                                            class="w-full bg-transparent border-none outline-none text-center text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                    </div>
                                    <div
                                        class="relative input-custom rounded-xl px-4 py-3 flex items-center w-1/2 justify-center">
                                        <input type="text" value="012" placeholder="RW"
                                            class="w-full bg-transparent border-none outline-none text-center text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-6">

                            {{-- Nama Pemilik --}}
                            <div class="space-y-2">
                                <label class="block font-medium text-gray-700 text-lg">Nama Pemilik <span
                                        class="text-red-500">*</span></label>
                                <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <input type="text" value="Budi Santoso"
                                        class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium">
                                </div>
                            </div>

                            {{-- Sosmed --}}
                            <div class="space-y-2">
                                <label class="block font-medium text-gray-700 text-lg">Sosial Media</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg"
                                            class="w-5 h-5 mr-3 flex-shrink-0" alt="IG">
                                        <input type="text" placeholder="@tebing_umkm"
                                            class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium text-sm">
                                    </div>
                                    <div class="relative input-custom rounded-xl px-4 py-3 flex items-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg"
                                            class="w-5 h-5 mr-3 flex-shrink-0" alt="FB">
                                        <input type="text" placeholder="Tebing UMKM"
                                            class="w-full bg-transparent border-none outline-none text-gray-900 placeholder-gray-500 focus:ring-0 p-0 font-medium text-sm">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="mt-12 flex justify-center pb-10">
                        <button type="submit"
                            class="w-full md:w-auto bg-[#FFC107] cursor-pointer text-lg font-medium py-3 px-6 rounded-xl transition shadow-md hover:shadow-lg transform active:scale-95 border border-yellow-400">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </main>
        </div>

        {{-- Overlay Sidebar Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 z-40 bg-[#001e36]/80 backdrop-blur-sm lg:hidden" x-cloak></div>

    </div>

</body>

</html>
