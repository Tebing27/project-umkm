<x-layouts.admin title="Kelola User - UMKM Sasuma Admin" header-title="Kelola User"
    header-subtitle="Verifikasi & Data UMKM">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kelola User</h2>
            <p class="text-slate-500 mt-2 text-base font-medium">Verifikasi dan kelola data UMKM yang terdaftar.</p>
        </div>

        {{-- Search / Filter --}}
        <div class="w-full md:w-72">
            <form action="{{ url('/admin/users') }}" method="GET">
                <x-ui.input variant="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari user atau usaha...">
                    <x-slot:icon>
                        <x-icons.location-search
                            class="w-5 h-5" />
                    </x-slot:icon>
                </x-ui.input>
            </form>
        </div>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($shops as $shop)
            <x-ui.card
                class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group flex flex-col overflow-hidden relative">
                {{-- Status Indicator Strip --}}
                <div
                    class="absolute top-0 left-0 w-full h-1.5 {{ $shop->is_verified ? 'bg-green-500' : 'bg-yellow-500' }}">
                </div>

                {{-- Card Header --}}
                <div class="p-6 pb-4 border-b border-slate-50 flex justify-between items-start gap-4 pt-8">
                    <div>
                        <h3
                            class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-1">
                            {{ $shop->name }}</h3>
                        <p class="text-xs font-semibold text-slate-500 mt-1">{{ $shop->business_type }} •
                            {{ $shop->created_at->format('M Y') }}</p>
                    </div>
                    @if ($shop->is_verified)
                        <span
                            class="shrink-0 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-bold uppercase border border-green-100 tracking-wide ring-1 ring-green-500/20">
                            Terverifikasi
                        </span>
                    @else
                        <span
                            class="shrink-0 px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[10px] font-bold uppercase border border-yellow-100 tracking-wide ring-1 ring-yellow-500/20">
                            Menunggu
                        </span>
                    @endif
                </div>

                {{-- Card Body --}}
                <div class="p-6 flex-1 space-y-5">
                    {{-- Owner Info --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm border border-slate-200 ring-2 ring-white shadow-sm">
                            {{ substr($shop->user->name ?? 'User', 0, 2) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $shop->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500">Pemilik Usaha</p>
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="space-y-3">
                        <div
                            class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <x-icons.mail class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" />
                            <span class="truncate font-medium">{{ $shop->user->email ?? '-' }}</span>
                        </div>
                        <div
                            class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <x-icons.phone class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" />
                            <span class="truncate font-medium">{{ $shop->user->phone_number ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="p-4 bg-slate-50 border-t border-slate-100 grid grid-cols-1 mt-auto">
                    <x-ui.button href="{{ url('/admin/users/detail/' . $shop->id) }}" variant="outline"
                        class="w-full rounded-lg justify-center group/btn">
                        Detail
                        <x-icons.chevron-right class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" />
                    </x-ui.button>
                </div>
            </x-ui.card>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-slate-500">Belum ada data UMKM.</p>
            </div>
        @endforelse

    </div>
</x-layouts.admin>
