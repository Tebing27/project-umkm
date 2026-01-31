<x-ui.card class="bg-white rounded-3xl p-8 border border-gray-100 relative overflow-hidden group transition-all duration-300">
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-110"></div>
    
    <div class="relative z-10">
        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600 group-hover:scale-110 transition-transform duration-300">
            <x-icons.data-store class="w-6 h-6" />
        </div>
        <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">{{ translate('Total UMKM') }}</h3>
        <p class="text-4xl font-extrabold text-slate-900">{{ $totalShops }}</p>
        <x-ui.badge variant="success" class="mt-4">
            <x-icons.data-trending class="w-4 h-4 mr-2" />
            <span>+{{ $newShopsThisWeek }} {{ translate('minggu ini') }}</span>
        </x-ui.badge>
    </div>
</x-ui.card>
