<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Foto - UMKM SASUMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false, sidebarExpanded: true }">

    {{-- NAVIGATION --}}
    <x-navigation-users />

    {{-- MAIN CONTENT --}}
    <main class="transition-all duration-300 ease-in-out"
        :class="sidebarExpanded ? 'lg:ml-72' : 'lg:ml-24'">

        {{-- HEADER MOBILE --}}
        <x-header-mobile title="Kelola Foto" subtitle="Atur foto tempat usaha" />

        <div class="p-6 md:p-8 max-w-7xl mx-auto">
            {{-- PAGE HEADER --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Kelola Foto Tempat Usaha</h1>
                <p class="text-gray-500 mt-1">Unggah hingga 5 foto tempat usaha Anda dan atur urutan tampilannya.</p>
            </div>

            {{-- FORM --}}
            <form action="#" method="POST" enctype="multipart/form-data">
                
                {{-- PHOTO GRID --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    
                    {{-- Loop for 5 Photo Slots --}}
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col gap-4"
                            x-data="{ photoName: null, photoPreview: null }">
                            
                            {{-- Header Card --}}
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-700">Foto #{{ $i }}</span>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="is_banner" value="{{ $i }}" id="banner_{{ $i }}" {{ $i === 1 ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#004a85] focus:ring-[#004a85] border-gray-300">
                                    <label for="banner_{{ $i }}" class="text-xs font-medium text-gray-500 cursor-pointer select-none">Jadikan Banner</label>
                                </div>
                            </div>

                            {{-- Upload Area --}}
                            <div class="relative group cursor-pointer w-full aspect-[4/3] rounded-xl overflow-hidden bg-[#F9F8F6] border-2 border-dashed border-gray-300 hover:border-[#004a85] transition-colors"
                                x-on:click="$refs.photo_{{ $i }}.click()">
                                
                                <input type="file" name="photos[{{ $i }}]" class="hidden" x-ref="photo_{{ $i }}"
                                    x-on:change="
                                        photoName = $refs.photo_{{ $i }}.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => { photoPreview = e.target.result; };
                                        reader.readAsDataURL($refs.photo_{{ $i }}.files[0]);
                                    ">

                                {{-- Placeholder --}}
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#004a85] transition-colors"
                                    x-show="!photoPreview">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-medium">Upload</span>
                                </div>

                                {{-- Preview --}}
                                <div class="absolute inset-0 bg-cover bg-center"
                                    x-show="photoPreview" :style="'background-image: url(\'' + photoPreview + '\');'"
                                    style="display: none;">
                                </div>

                                {{-- Edit Icon --}}
                                <div class="absolute bottom-2 right-2 bg-white p-1.5 rounded-full shadow-md border border-gray-200 text-gray-500 group-hover:text-[#004a85] transition-colors"
                                    x-show="photoPreview">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Order Input --}}
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-gray-600">Urutan Tampil:</label>
                                <input type="number" name="order[{{ $i }}]" value="{{ $i }}" min="1" max="5"
                                    class="w-16 px-2 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium text-center focus:ring-1 focus:ring-[#004a85] focus:border-[#004a85] outline-none">
                            </div>

                        </div>
                    @endfor
                </div>

                {{-- ACTION BUTTONS --}}
                {{-- ACTION BUTTONS --}}
                <div class="flex justify-end sticky bottom-6 z-30 pointer-events-none">
                    <div class="flex gap-4 bg-white/90 backdrop-blur-md p-2 pr-2 pl-6 rounded-full shadow-2xl border border-gray-200/50 pointer-events-auto items-center">
                        <button type="button" class="px-5 py-2 rounded-full text-gray-600 font-medium hover:bg-gray-100 hover:text-gray-900 transition-colors text-sm">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 rounded-full bg-[#004a85] text-white font-medium hover:bg-[#003366] shadow-lg shadow-blue-900/20 transition-all hover:scale-[1.02] text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </main>

</body>

</html>
