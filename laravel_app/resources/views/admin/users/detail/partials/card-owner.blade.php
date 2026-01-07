<x-ui.card class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
        <x-icons.data-user class="w-5 h-5 text-primary" />
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
            <p class="text-slate-900 font-semibold text-lg">{{ $shop->user->domicile_address ?? '-' }}</p>
        </div>
    </div>
</x-ui.card>
