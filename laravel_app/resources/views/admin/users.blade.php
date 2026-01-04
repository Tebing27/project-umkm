<x-layouts.admin :title="translate('Kelola User - UMKM Sasuma Admin')" :header-title="translate('Kelola User')" :header-subtitle="translate('Verifikasi & Data UMKM')">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ translate('Kelola User') }}</h2>
            <p class="text-slate-500 mt-2 text-base font-medium">
                {{ translate('Verifikasi dan kelola data UMKM yang terdaftar.') }}</p>
        </div>

        {{-- Filters & Search --}}
        <div class="flex flex-col md:flex-row md:items-center gap-4 w-full md:w-auto">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2 md:pb-0">
                @foreach ($tabs as $tab)
                    <a href="{{ request()->fullUrlWithQuery(['status' => $tab['id'] == 'all' ? null : $tab['id']]) }}"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border whitespace-nowrap
                        {{ $currentStatus == $tab['id'] || ($tab['id'] == 'all' && !$currentStatus)
                            ? 'bg-[#004a85] text-white border-[#004a85] shadow-md'
                            : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
                        {{ translate($tab['label']) }}
                    </a>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="w-full md:w-72">
                <form action="{{ url('/admin/users') }}" method="GET">
                    {{-- Keep status when searching --}}
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <x-ui.input variant="search" name="search" value="{{ $search ?? '' }}"
                        placeholder="{{ translate('Cari user atau UMKM...') }}">
                        <x-slot:icon>
                            <x-icons.map-pin-search class="w-5 h-5" />
                        </x-slot:icon>
                    </x-ui.input>
                </form>
            </div>
        </div>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($shops as $shop)
            <x-ui.card
                class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group flex flex-col overflow-hidden relative">
                {{-- Status Indicator Strip --}}
                {{-- Status Indicator Strip --}}
                <div
                    class="absolute top-0 left-0 w-full h-1.5 {{ $shop->is_verified ? 'bg-green-500' : ($shop->rejection_reason ? 'bg-red-500' : 'bg-yellow-500') }}">
                </div>

                {{-- Card Header --}}
                <div class="p-6 pb-4 border-b border-slate-50 flex justify-between items-start gap-4 pt-8">
                    <div>
                        <h3
                            class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-1">
                            {{ $shop->name }}</h3>
                        <p class="text-xs font-semibold text-slate-500 mt-1">{{ translate($shop->business_type) }} </p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">{{ translate('Dibuat pada') }}
                            {{ $shop->created_at->format('d F Y') }}</p>
                    </div>
                    @if ($shop->is_verified)
                        <span
                            class="shrink-0 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-bold uppercase border border-green-100 tracking-wide ring-1 ring-green-500/20">
                            {{ translate('Terverifikasi') }}
                        </span>
                    @elseif($shop->rejection_reason)
                        <span
                            class="shrink-0 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-[10px] font-bold uppercase border border-red-100 tracking-wide ring-1 ring-red-500/20">
                            {{ translate('Ditolak') }}
                        </span>
                    @else
                        <span
                            class="shrink-0 px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[10px] font-bold uppercase border border-yellow-100 tracking-wide ring-1 ring-yellow-500/20">
                            {{ translate('Menunggu') }}
                        </span>
                    @endif
                </div>

                {{-- Card Body --}}
                <div class="p-6 flex-1 space-y-5">
                    {{-- Owner Info --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm border border-slate-200 ring-2 ring-white shadow-sm overflow-hidden">
                            <img src="{{ $shop->logo_url }}" alt="{{ $shop->name }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $shop->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500">{{ translate('Pemilik Usaha') }}</p>
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="space-y-3">
                        <div
                            class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <x-icons.contact-mail class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" />
                            <span class="truncate font-medium">{{ $shop->user->email ?? '-' }}</span>
                        </div>
                        <div
                            class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <x-icons.contact-phone class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" />
                            <span class="truncate font-medium">{{ $shop->user->phone_number ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Statistik Ringkas --}}
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
                </div>

                {{-- Card Footer --}}
                <div class="p-4 bg-slate-50 border-t border-slate-100 grid grid-cols-1 mt-auto">
                    <x-ui.button href="{{ url('/admin/users/detail/' . $shop->id) }}" variant="outline"
                        class="w-full rounded-lg justify-center group/btn">
                        {{ translate('Detail') }}
                        <x-icons.ui-chevron-right class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" />
                    </x-ui.button>
                </div>
            </x-ui.card>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-slate-500">{{ translate('Belum ada data UMKM.') }}</p>
            </div>
        @endforelse

    </div>
</x-layouts.admin>
