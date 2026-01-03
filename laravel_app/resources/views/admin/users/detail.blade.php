<x-layouts.admin :title="translate('Detail User - UMKM Sasuma Admin')" :header-title="translate('Detail User')" :header-subtitle="translate('Verifikasi Data')">
    <div x-data="{ 
        rejectModalOpen: false,
        galleryOpen: false,
        activeImage: 0,
        images: [
            @foreach ($shop->photos as $photo)
                '{{ asset('storage/' . $photo->path) }}',
            @endforeach
        ],
        nextImage() {
            this.activeImage = (this.activeImage + 1) % this.images.length;
        },
        prevImage() {
            this.activeImage = (this.activeImage - 1 + this.images.length) % this.images.length;
        }
    }" 
    @keydown.escape.window="galleryOpen = false"
    @keydown.right.window="if(galleryOpen) nextImage()"
    @keydown.left.window="if(galleryOpen) prevImage()">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-6">
                <div
                    class="w-20 h-20 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-2xl border-4 border-white shadow-lg overflow-hidden">
                    <img src="{{ $shop->logo_url }}" alt="{{ $shop->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $shop->name }}</h1>
                        @if ($shop->is_verified)
                            <span
                                class="px-3 py-1 rounded-full bg-green-100 uppercase text-green-700 text-xs font-bold border border-green-200 tracking-wide">
                                {{ translate('Terverifikasi') }}
                            </span>
                        @elseif ($shop->rejection_reason)
                            <span
                                class="px-3 py-1 rounded-full bg-red-100 uppercase text-red-700 text-xs font-bold border border-red-200 tracking-wide">
                                {{ translate('Ditolak') }}
                            </span>
                        @else
                            <span
                                class="px-3 py-1 rounded-full bg-yellow-100 uppercase text-yellow-700 text-xs font-bold border border-yellow-200 tracking-wide">
                                {{ translate('Menunggu') }}
                            </span>
                        @endif
                    </div>
                    <p class="text-slate-500 font-medium">{{ translate('Terdaftar') }} {{ $shop->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-ui.button variant="destructive" @click="rejectModalOpen = true" class="rounded-lg font-semibold">
                    {{ translate('Tolak') }}
                </x-ui.button>

                @if (!$shop->is_verified)
                    @if ($shop->isComplete())
                        <form action="{{ route('admin.verify-shop', $shop->id) }}" method="POST">
                            @csrf
                            <x-ui.button type="submit"
                                class="bg-green-600 rounded-lg hover:bg-green-700 text-white font-semibold">
                                {{ translate('Verifikasi Sekarang') }}
                            </x-ui.button>
                        </form>
                    @else
                        <div class="group relative inline-block">
                            <x-ui.button type="button" disabled
                                class="bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed font-semibold w-full">
                                {{ translate('Verifikasi Sekarang') }}
                            </x-ui.button>
                            
                            {{-- Tooltip info belum lengkap --}}
                            <div class="absolute top-full right-0 mt-2 w-72 p-4 bg-white border border-red-200 text-slate-600 text-sm rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                                <div class="flex items-start gap-3 mb-2 text-red-600">
                                    <x-icons.exclamation-circle class="w-5 h-5 shrink-0" />
                                    <p class="font-bold text-md">{{ translate('Data Belum Lengkap') }}</p>
                                </div>
                                <p class="mb-2 text-slate-500">{{ translate('User belum melengkapi data berikut:') }}</p>
                                <ul class="list-disc pl-4 space-y-1 text-slate-700">
                                    @foreach($shop->getMissingFields() as $field)
                                        <li>{{ $field }}</li>
                                    @endforeach
                                </ul>
                                <div class="absolute -top-1 right-8 w-3 h-3 bg-white border-t border-l border-red-200 rotate-45"></div>
                            </div>
                        </div>
                    @endif
                @else
                    <x-ui.button variant="outline" disabled
                        class="text-slate-900 rounded-lg opacity-70 cursor-not-allowed">
                        {{ translate('Sudah Terverifikasi') }}
                    </x-ui.button>
                @endif
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- ================= KOLOM KIRI (Data Teks) ================= --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Informasi Pemilik --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.user class="w-5 h-5 text-primary" />
                        {{ translate('Informasi Pemilik') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Nama Lengkap') }}</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Nomor Telepon') }}</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->phone_number ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Email') }}</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->email ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Alamat Domisili') }}</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->domicile_address ?? '-' }}
                            </p>
                        </div>
                    </div>
                </x-ui.card>

                {{-- Informasi Usaha --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.store class="w-5 h-5 text-primary" />
                        {{ translate('Informasi Usaha') }}
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Nama Usaha') }}</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Jenis Produk') }}</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->product_type }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Kategori / Jenis Usaha') }}</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->business_type }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Alamat Usaha') }}</label>
                            <p class="text-slate-900 font-semibold text-lg leading-relaxed">{{ $shop->address }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">{{ translate('Deskripsi') }}</label>
                            <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $shop->description ?? '-' }}</p>
                        </div>
                    </div>
                </x-ui.card>

                {{-- Izin Usaha Check --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.document class="w-5 h-5 text-primary" />
                        {{ translate('Izin Usaha') }}
                    </h3>

                    @if (!empty($shop->licenses_array))
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($shop->licenses_array as $license)
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                                    <p class="text-xs font-bold text-slate-500 uppercase">
                                        {{ $license['type'] ?? 'Tipe Izin' }}</p>
                                    <p class="text-lg font-bold text-slate-900">{{ $license['number'] ?? '-' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 italic">{{ translate('Tidak ada data izin usaha.') }}</p>
                    @endif
                </x-ui.card>
            </div>

            {{-- ================= KOLOM KANAN (Social Media & Foto) ================= --}}
            <div class="space-y-8">
                {{-- Social Media --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.globe class="w-5 h-5 text-primary" />
                        {{ translate('Sosial Media') }}
                    </h3>
                    <div class="space-y-4">
                        @if ($shop->social_instagram)
                            <div class="flex items-center gap-3">
                                <x-icons.instagram class="w-5 h-5 text-[#E4405F]" />
                                <a href="{{ $shop->social_instagram }}" target="_blank"
                                    class="text-blue-600 hover:underline truncate">{{ $shop->social_instagram }}</a>
                            </div>
                        @endif
                        @if ($shop->social_facebook)
                            <div class="flex items-center gap-3">
                                <x-icons.facebook class="w-5 h-5 text-[#1877F2]" />
                                <a href="{{ $shop->social_facebook }}" target="_blank"
                                    class="text-blue-600 hover:underline truncate">{{ $shop->social_facebook }}</a>
                            </div>
                        @endif
                        @if ($shop->social_tiktok)
                            <div class="flex items-center gap-3">
                                <x-icons.tiktok class="w-5 h-5 text-black" />
                                <a href="{{ $shop->social_tiktok }}" target="_blank"
                                    class="text-blue-600 hover:underline truncate">{{ $shop->social_tiktok }}</a>
                            </div>
                        @endif
                        @if (!$shop->social_instagram && !$shop->social_facebook && !$shop->social_tiktok)
                            <p class="text-slate-500 text-sm">{{ translate('Tidak ada social media tercantum.') }}</p>
                        @endif
                    </div>
                </x-ui.card>

                {{-- Visualisasi Toko (SUDAH DIPINDAHKAN KE SINI) --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.photo class="w-5 h-5 text-primary" />
                        {{ translate('Visualisasi Toko') }}
                    </h3>

                    @if ($shop->photos->count() > 0)
                        {{-- Menggunakan Grid 2 Kolom untuk Thumbnail --}}
                        <div class="grid grid-cols-2 gap-3">
                            @foreach ($shop->photos as $index => $photo)
                                <div class="relative group aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200 cursor-pointer"
                                     @click="activeImage = {{ $index }}; galleryOpen = true">
                                    
                                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto Toko" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    
                                    {{-- Overlay Hover --}}
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-white text-xs font-bold border border-white px-3 py-1.5 rounded-full hover:bg-white hover:text-black transition-colors">
                                            {{ translate('Lihat') }}
                                        </span>
                                    </div>

                                    @if($loop->first)
                                        <div class="absolute top-2 left-2 bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">
                                            {{ translate('Cover') }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                            <x-icons.photo class="w-8 h-8 text-slate-300 mx-auto mb-2" />
                            <p class="text-slate-500 text-sm">{{ translate('Belum ada foto visualisasi toko yang diupload.') }}</p>
                        </div>
                    @endif
                </x-ui.card>
            </div>
        </div>

        {{-- MODAL TOLAK --}}
        <div x-show="rejectModalOpen" class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/75 backdrop-blur-sm"
            style="display: none;" x-cloak>
            <div class="flex min-h-full items-center justify-center p-4 text-center" @click="rejectModalOpen = false">
                <div @click.stop x-show="rejectModalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="w-full max-w-lg transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-xl transition-all">

                    <form action="{{ route('admin.reject-shop', $shop->id) }}" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <x-icons.exclamation-triangle class="h-6 w-6 text-red-600" />
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-bold text-slate-900">{{ translate('Tolak Verifikasi') }}</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-500 mb-4">
                                            {{ translate('Apakah Anda yakin ingin menolak verifikasi user ini? Silakan berikan alasan penolakan.') }}
                                        </p>

                                        {{-- NOTE: Disini kita gunakan whitespace-pre-line untuk textarea juga jika perlu preview, tapi utamanya nanti di dashboard user --}}
                                        <x-ui.textarea name="reason" rows="6"
                                            placeholder="Contoh: Tidak valid nomor surat izin nya"
                                            class="bg-gray-50 text-sm rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal whitespace-pre-line">
@if(!$shop->isComplete())
{{ translate('Data UMKM belum lengkap. Mohon lengkapi data berikut:') }}
@foreach($shop->getMissingFields() as $field)
- {{ $field }}
@endforeach
@endif
                                        </x-ui.textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-sm sm:w-auto sm:text-sm py-2 px-4 font-semibold">
                                {{ translate('Tolak Pengguna') }}
                            </button>
                            <button @click="rejectModalOpen = false" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-xl bg-white text-slate-700 hover:bg-slate-50 sm:mt-0 sm:w-auto sm:text-sm py-2 px-4 font-semibold border border-slate-300">
                                {{ translate('Batal') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div x-show="galleryOpen" 
             style="display: none;" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-sm flex items-center justify-center"
             x-cloak>

            {{-- Tombol Close (Pojok Kanan Atas) --}}
            <button @click="galleryOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white z-50 p-2 transition-colors">
                <x-icons.x-mark class="h-10 w-10" />
            </button>

            {{-- Tombol Prev (Kiri) --}}
            <button @click.stop="prevImage()" class="absolute left-4 md:left-8 text-white/70 hover:text-white hover:bg-white/10 p-3 rounded-full transition-all z-50">
                <x-icons.arrow-left class="h-10 w-10 md:h-12 md:w-12" />
            </button>

            {{-- Area Gambar Utama --}}
            <div class="relative w-full h-full flex flex-col items-center justify-center p-4 md:p-12" @click.outside="galleryOpen = false">
                
                {{-- Gambar --}}
                <img :src="images[activeImage]" 
                     class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-50 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                
                {{-- Indikator Halaman (Contoh: 1 / 4) --}}
                <div class="mt-4 text-white/90 font-medium bg-white/10 px-6 py-2 rounded-full text-sm backdrop-blur-md border border-white/10">
                    <span x-text="activeImage + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>

            {{-- Tombol Next (Kanan) --}}
            <button @click.stop="nextImage()" class="absolute right-4 md:right-8 text-white/70 hover:text-white hover:bg-white/10 p-3 rounded-full transition-all z-50">
                <x-icons.arrow-left class="h-10 w-10 md:h-12 md:w-12 rotate-180" />
            </button>
        </div>

    </div>
</x-layouts.admin>