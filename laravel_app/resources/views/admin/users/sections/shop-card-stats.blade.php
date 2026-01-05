<div class="grid grid-cols-2 gap-3 pt-2">
    <div class="bg-indigo-50 p-2.5 rounded-lg border border-indigo-100">
        <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider mb-0.5">{{ translate('Produk') }}</p>
        <p class="text-sm font-bold text-indigo-900">{{ $shop->products_count ?? 0 }} Item</p>
    </div>
    <div class="bg-indigo-50 p-2.5 rounded-lg border border-indigo-100">
        <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider mb-0.5">{{ translate('Omset') }}</p>
        <p class="text-sm font-bold text-indigo-900 truncate">
            @if ($shop->omset_min)
                Rp {{ number_format($shop->omset_min, 0, ',', '.') }}
            @else
                -
            @endif
        </p>
    </div>
</div>
