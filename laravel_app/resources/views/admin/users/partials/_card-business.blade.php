<x-ui.card class="p-8">
    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
        <x-icons.data-store class="w-5 h-5 text-primary" />
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
