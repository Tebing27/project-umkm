<x-layouts.admin title="Dashboard Admin - UMKM Sasuma" header-title="Dashboard Admin" header-subtitle="Overview & Statistik">
    {{-- Welcome Section --}}
    <div class="mb-10 relative">
        <div class="absolute -left-6 -top-6 w-32 h-32 bg-blue-100/50 rounded-full blur-3xl -z-10"></div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Hi, Admin! 👋</h2>
        <p class="text-slate-500 mt-2 text-lg">Berikut adalah ringkasan aktivitas UMKM hari ini.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        
        {{-- Card Total UMKM --}}
        <x-ui.card class="bg-white rounded-3xl p-8 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-110"></div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                    <x-icons.store class="w-6 h-6" />
                </div>
                <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Total UMKM</h3>
                <p class="text-4xl font-extrabold text-slate-900">{{ $shops->count() }}</p>
                <x-ui.badge variant="secondary" class="mt-4 flex items-center gap-2 w-fit px-2.5 py-1 rounded-full text-green-600">
                    <x-icons.trending-up class="w-4 h-4" />
                    <span>+{{ $shops->where('created_at', '>=', now()->subWeek())->count() }} minggu ini</span>
                </x-ui.badge>
            </div>
        </x-ui.card>

        {{-- Card Status User --}}
        <x-ui.card class="bg-white rounded-3xl p-8 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300 md:col-span-2 lg:col-span-2">
            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
            
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 text-orange-600 group-hover:scale-110 transition-transform duration-300">
                            <x-icons.users-group class="w-6 h-6" />
                        </div>
                        <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Status Pendaftaran</h3>
                        <p class="text-4xl font-extrabold text-slate-900">{{ $shops->count() }} <span class="text-lg text-slate-400 font-medium">Total Toko</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Terverifikasi --}}
                    <x-ui.card class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3 shadow-none">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                            <x-icons.check class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $shops->where('is_verified', true)->count() }}</p>
                            <p class="text-xs font-semibold text-slate-500">Terverifikasi</p>
                        </div>
                    </x-ui.card>

                    {{-- Menunggu --}}
                    <x-ui.card class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3 shadow-none">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                            <x-icons.clock class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $shops->where('is_verified', false)->count() }}</p>
                            <p class="text-xs font-semibold text-slate-500">Menunggu</p>
                        </div>
                    </x-ui.card>

                    {{-- Gagal - Placeholder --}}
                    <x-ui.card class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3 shadow-none">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                            <x-icons.x-mark class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">0</p>
                            <p class="text-xs font-semibold text-slate-500">Ditolak</p>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-layouts.admin>
