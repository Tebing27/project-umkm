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
