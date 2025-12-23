<x-layouts.admin title="Detail User - UMKM Sasuma Admin" header-title="Detail User" header-subtitle="Verifikasi Data">
    <div x-data="{ rejectModalOpen: false }">

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
                    class="w-20 h-20 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-2xl border-4 border-white shadow-lg">
                    {{ substr($shop->name ?? 'UMKM', 0, 2) }}
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $shop->name }}</h1>
                        @if ($shop->is_verified)
                            <span
                                class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold border border-green-200 tracking-wide">
                                Terverifikasi
                            </span>
                        @else
                            <span
                                class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold border border-yellow-200 tracking-wide">
                                Menunggu
                            </span>
                        @endif
                    </div>
                    <p class="text-slate-500 font-medium">Terdaftar {{ $shop->created_at->translatedFormat('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-ui.button variant="destructive" @click="rejectModalOpen = true" class="rounded-lg font-semibold">
                    Tolak
                </x-ui.button>

                @if (!$shop->is_verified)
                    <form action="{{ route('admin.verify-shop', $shop->id) }}" method="POST">
                        @csrf
                        <x-ui.button type="submit"
                            class="bg-green-600 rounded-lg hover:bg-green-700 text-white font-semibold">
                            Verifikasi Sekarang
                        </x-ui.button>
                    </form>
                @else
                    <x-ui.button variant="outline" disabled
                        class="text-slate-900 rounded-lg opacity-70 cursor-not-allowed">
                        Sudah Terverifikasi
                    </x-ui.button>
                @endif
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Info --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Informasi Pemilik --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.user class="w-5 h-5 text-primary" />
                        Informasi Pemilik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama
                                Lengkap</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor
                                Telepon</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->phone_number ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->email ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat
                                Domisili</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->domicile_address ?? '-' }}
                            </p>
                        </div>
                    </div>
                </x-ui.card>

                {{-- Informasi Usaha --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.store class="w-5 h-5 text-primary" />
                        Informasi Usaha
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama
                                Usaha</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis
                                Produk</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->product_type }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori
                                / Jenis Usaha</label>
                            <p class="text-slate-900 font-semibold text-lg">{{ $shop->business_type }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat
                                Lengkap</label>
                            <p class="text-slate-900 font-semibold text-lg leading-relaxed">{{ $shop->address }}, RT
                                {{ $shop->rt }}/RW {{ $shop->rw }}</p>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi</label>
                            <p class="text-slate-600 leading-relaxed">{{ $shop->description ?? '-' }}</p>
                        </div>
                    </div>
                </x-ui.card>

                {{-- Izin Usaha Check --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.document class="w-5 h-5 text-primary" />
                        Izin Usaha
                    </h3>

                    @php
                        $licenses = [];
                        if ($shop && $shop->licenses) {
                            $licenses = is_string($shop->licenses)
                                ? json_decode($shop->licenses, true)
                                : $shop->licenses;
                        }
                    @endphp

                    @if (!empty($licenses))
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($licenses as $license)
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                                    <p class="text-xs font-bold text-slate-500 uppercase">
                                        {{ $license['type'] ?? 'Tipe Izin' }}</p>
                                    <p class="text-lg font-bold text-slate-900">{{ $license['number'] ?? '-' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 italic">Tidak ada data izin usaha.</p>
                    @endif
                </x-ui.card>
            </div>

            {{-- Right Column: Documents --}}
            <div class="space-y-8">
                {{-- Social Media --}}
                <x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <x-icons.globe class="w-5 h-5 text-primary" />
                        Social Media
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
                            <p class="text-slate-500 text-sm">Tidak ada social media tercantum.</p>
                        @endif
                    </div>
                </x-ui.card>
            </div>
        </div>

        {{-- MODAL TOLAK (REVISI STABIL) --}}
        <div x-show="rejectModalOpen" class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/75 backdrop-blur-sm"
            style="display: none;" x-cloak>

            {{-- 
        WRAPPER UTAMA:
        1. Menangani layout tengah (flex center).
        2. Menangani klik background untuk menutup (@click="rejectModalOpen = false").
    --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center" @click="rejectModalOpen = false">

                {{-- 
            PANEL MODAL:
            1. @click.stop adalah KUNCI AGAR TIDAK MENUTUP saat panel diklik.
        --}}
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
                                    <h3 class="text-lg leading-6 font-bold text-slate-900">Tolak Verifikasi</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-500 mb-4">
                                            Apakah Anda yakin ingin menolak verifikasi user ini? Silakan berikan alasan
                                            penolakan.
                                        </p>

                                        <x-ui.textarea name="reason" rows="4"
                                            placeholder="Contoh: Tidak valid nomor surat izin nya"
                                            class="bg-gray-50 text-sm rounded-lg border-gray-300 focus:ring-blue-500/20 focus:border-blue-500 font-normal">
                                        </x-ui.textarea>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-sm sm:w-auto sm:text-sm py-2 px-4 font-semibold">
                                Tolak User
                            </button>
                            {{-- Tombol Batal --}}
                            <button @click="rejectModalOpen = false" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-xl bg-white text-slate-700 hover:bg-slate-50 sm:mt-0 sm:w-auto sm:text-sm py-2 px-4 font-semibold border border-slate-300">
                                Batal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-layouts.admin>
