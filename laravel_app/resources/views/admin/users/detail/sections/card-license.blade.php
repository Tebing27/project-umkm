<x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
        <x-icons.data-document class="w-5 h-5 text-primary" />
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
