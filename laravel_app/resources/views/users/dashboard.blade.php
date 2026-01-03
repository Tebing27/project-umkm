<x-layouts.guest :title="translate('Dashboard User - UMKM Sasuma')" :header-title="translate('Dashboard')" :header-subtitle="translate('Ringkasan Aktivitas')">
    {{-- Welcome Section --}}
    <div class="relative overflow-hidden text-slate-900">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">Hi, {{ Auth::user()->name }} 👋</h2>
            <p class="text-slate-900 text-lg font-medium max-w-2xl mb-4">{{translate('Selamat datang kembali! Berikut adalah ringkasan performa toko Anda hari ini.')}}</p>
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
                        {{translate('Terverifikasi')}}
                    </span>
                @else
                    <span
                        class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold uppercase tracking-wide border border-yellow-200">
                        {{translate('Belum Terverifikasi')}}
                    </span>
                @endif
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">{{translate('Status Toko')}}</p>
                <h3 class="text-xl font-bold text-slate-900">{{ $shop->name ?? translate('Belum ada toko') }}</h3>
                <p class="text-xs text-slate-400 mt-1">{{translate('Pemilik:')}} {{ Auth::user()->name }}</p>
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
                    {{-- <span class="flex items-center text-green-600 text-xs font-bold bg-green-50 px-2 py-1 rounded-lg">
                        <x-icons.trending-up class="w-3 h-3 mr-1" />
                        +15%
                    </span> --}}
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">{{translate('Total Dilihat')}}</p>
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ number_format($totalViews ?? 0) }}</h3>
                    <p class="text-xs text-slate-400 mt-1">{{translate('Dalam 30 hari terakhir')}}</p>
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
                    <p class="text-slate-500 text-sm font-medium mb-1">{{translate('Total Produk')}}</p>
                    <h3 class="text-3xl font-extrabold text-slate-900">{{ $activeProducts ?? 0 }} <span
                            class="text-lg text-slate-400 font-semibold">{{translate('Barang')}}</span></h3>
                    <p class="text-xs text-slate-400 mt-1">{{translate('Produk aktif di etalase')}}</p>
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
                    <p class="text-slate-500 text-sm font-medium mb-3">{{translate('Kategori Produk')}}</p>
                    <div class="space-y-3">
                        @php
                            $colors = ['bg-blue-500', 'bg-orange-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500'];
                        @endphp
                        @forelse($productCategories as $index => $cat)
                            <div class="flex justify-between items-center text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $colors[$index % count($colors)] }}"></span>
                                    <span class="text-slate-600 font-medium">{{ $cat->category }}</span>
                                </div>
                                <span class="font-bold text-slate-900">{{ $cat->total }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400">{{translate('Belum ada kategori')}}</p>
                        @endforelse
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
                                {{translate('UMKM Anda belum terverifikasi oleh Admin')}}
                            </p>
                            @if ($shop->rejection_reason)
                                <div
                                    class="mt-2 text-sm text-yellow-800 bg-yellow-100 p-3 rounded-lg border border-yellow-200">
                                    <p class="font-bold mb-1">{{translate('Alasan Penolakan')}}:</p>
                                    <p class="whitespace-pre-line">{{ $shop->rejection_reason }}</p>
                                    <p class="mt-2 text-xs italic">{{translate('Silakan perbaiki data Anda di menu "Kelola Lokasi" atau "Kelola Toko" dan hubungi Admin untuk verifikasi ulang.')}}</p>
                                </div>
                            @else
                                <p class="text-sm text-yellow-700">
                                    {{translate('UMKM Anda belum bisa terpublish. Mohon tunggu verifikasi dari Admin.')}}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-layouts.guest>
