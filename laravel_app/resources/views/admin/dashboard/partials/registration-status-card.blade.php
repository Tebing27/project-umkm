<x-ui.card class="bg-white rounded-3xl p-8 border border-gray-100 relative overflow-hidden group transition-all duration-300 md:col-span-2 lg:col-span-2">
    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
    
    <div class="relative z-10 h-full flex flex-col justify-between">
        <div class="flex items-start justify-between mb-6">
            <div>
                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 text-orange-600 group-hover:scale-110 transition-transform duration-300">
                    <x-icons.data-users-group class="w-6 h-6" />
                </div>
                <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">{{ translate('Status Pendaftaran') }}</h3>
                <p class="text-4xl font-extrabold text-slate-900">{{ $totalShops }} <span class="text-lg text-slate-400 font-medium">{{ translate('Total Toko') }}</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Terverifikasi --}}
            <x-ui.card class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex items-center gap-3 shadow-none">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                    <x-icons.ui-check class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{$verifiedShopsCount}}</p>
                    <p class="text-xs font-semibold text-slate-500">{{ translate('Terverifikasi') }}</p>
                </div>
            </x-ui.card>

            {{-- Menunggu --}}
            <x-ui.card class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex items-center gap-3 shadow-none">
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                    <x-icons.data-clock class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $pendingShopsCount }}</p>
                    <p class="text-xs font-semibold text-slate-500">{{ translate('Menunggu') }}</p>
                </div>
            </x-ui.card>

            {{-- Gagal - Placeholder --}}
            <x-ui.card class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex items-center gap-3 shadow-none">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                    <x-icons.ui-close class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $rejectedShopsCount }}</p>
                    <p class="text-xs font-semibold text-slate-500">{{ translate('Ditolak') }}</p>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-ui.card>
