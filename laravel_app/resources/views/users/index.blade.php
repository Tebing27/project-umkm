<x-layouts.guest title="Dashboard User - UMKM Sasuma" header-title="Dashboard" header-subtitle="Ringkasan Aktivitas">
    {{-- Welcome Section --}}
    <div class="relative overflow-hidden text-slate-900">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">Hi, {{ Auth::user()->name }} 👋</h2>
            <p class="text-slate-900 text-lg font-medium max-w-2xl mb-4">Selamat datang kembali! Berikut adalah ringkasan
                performa toko Anda hari ini.</p>
        </div>

        {{-- Decorative Circles --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Status Card --}}
        <x-ui.card class="p-6 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-6">
                <div
                    class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                    <x-icons.store class="w-6 h-6" />
                </div>
                @if ($shop && $shop->is_verified)
                    <span
                        class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wide border border-green-200">
                        Terverifikasi
                    </span>
                @else
                    <span
                        class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold uppercase tracking-wide border border-yellow-200">
                        Belum Terverifikasi
                    </span>
                @endif
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Status Toko</p>
                <h3 class="text-xl font-bold text-slate-900">{{ $shop->name ?? 'Belum ada toko' }}</h3>
                <p class="text-xs text-slate-400 mt-1">Pemilik: {{ Auth::user()->name }}</p>
            </div>
        </x-ui.card>

        @if ($shop && $shop->is_verified)
            {{-- Produk Klik --}}
            <x-ui.card class="p-6 transition-all duration-300 group">
                <div class="flex justify-between items-start mb-6">
                    <div
                        class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                        <x-icons.eye class="w-6 h-6" />
                    </div>
                    <span class="flex items-center text-green-600 text-xs font-bold bg-green-50 px-2 py-1 rounded-lg">
                        <x-icons.trending-up class="w-3 h-3 mr-1" />
                        +15%
                    </span>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Total Dilihat</p>
                    <h3 class="text-3xl font-extrabold text-slate-900">2,450</h3>
                    <p class="text-xs text-slate-400 mt-1">Dalam 30 hari terakhir</p>
                </div>
            </x-ui.card>

            {{-- Total Produk --}}
            <x-ui.card class="p-6 transition-all duration-300 group">
                <div class="flex justify-between items-start mb-6">
                    <div
                        class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-500 group-hover:scale-110 transition-transform">
                        <x-icons.cube class="w-6 h-6" />
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Total Produk</p>
                    <h3 class="text-3xl font-extrabold text-slate-900">30 <span
                            class="text-lg text-slate-400 font-semibold">Item</span></h3>
                    <p class="text-xs text-slate-400 mt-1">Produk aktif di etalase</p>
                </div>
            </x-ui.card>

            {{-- Kategori --}}
            <x-ui.card class="p-6 transition-all duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-500 group-hover:scale-110 transition-transform">
                        <x-icons.tag class="w-6 h-6" />
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-3">Kategori Produk</p>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span class="text-slate-600 font-medium">Makanan</span>
                            </div>
                            <span class="font-bold text-slate-900">20</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                <span class="text-slate-600 font-medium">Minuman</span>
                            </div>
                            <span class="font-bold text-slate-900">10</span>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        @else
            {{-- Notification for Unverified Shops --}}
            <div class="col-span-3">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-icons.exclamation-circle class="h-5 w-5 text-yellow-400" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 font-bold mb-1">
                                UMKM Anda belum terverifikasi oleh Admin.
                            </p>
                            @if ($shop->rejection_reason)
                                <div
                                    class="mt-2 text-sm text-yellow-800 bg-yellow-100 p-3 rounded-lg border border-yellow-200">
                                    <p class="font-bold mb-1">Alasan Penolakan:</p>
                                    <p>{{ $shop->rejection_reason }}</p>
                                    <p class="mt-2 text-xs italic">Silakan perbaiki data Anda di menu "Kelola Lokasi"
                                        atau "Kelola Toko" dan hubungi Admin untuk verifikasi ulang.</p>
                                </div>
                            @else
                                <p class="text-sm text-yellow-700">
                                    UMKM Anda belum bisa terpublish. Mohon tunggu verifikasi dari Admin.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-layouts.guest>
