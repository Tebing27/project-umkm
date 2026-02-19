<x-ui.card
    id="shop-card-{{ $shop->id }}"
    class="bg-white rounded-3xl border border-gray-100 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300 group flex flex-col overflow-hidden relative">
    
    <div id="shop-card-bar-{{ $shop->id }}" class="absolute top-0 left-0 w-full h-1.5 {{ $shop->is_verified ? 'bg-green-500' : ($shop->rejection_reason ? 'bg-red-500' : 'bg-yellow-500') }}">
    </div>

    <div class="p-6 pb-4 border-b border-gray-50 flex justify-between items-start gap-4 pt-8">
        <div>
            <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-1">
                {{ $shop->name }}</h3>
            <p class="text-xs font-semibold text-slate-500 mt-1">{{ translate($shop->business_type) }} </p>
            <p class="text-xs font-semibold text-slate-500 mt-1">{{ translate('Dibuat pada') }}
                {{ $shop->created_at->format('d F Y') }}</p>
        </div>
        <div id="shop-card-badge-{{ $shop->id }}">
            @if ($shop->is_verified)
                <span class="shrink-0 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-bold uppercase border border-green-100 tracking-wide ring-1 ring-green-500/20">
                    {{ translate('Terverifikasi') }}
                </span>
            @elseif($shop->rejection_reason)
                <span class="shrink-0 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-[10px] font-bold uppercase border border-red-100 tracking-wide ring-1 ring-red-500/20">
                    {{ translate('Ditolak') }}
                </span>
            @else
                <span class="shrink-0 px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[10px] font-bold uppercase border border-yellow-100 tracking-wide ring-1 ring-yellow-500/20">
                    {{ translate('Menunggu') }}
                </span>
            @endif
        </div>
    </div>

    <div class="p-6 flex-1 space-y-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-slate-500 font-bold text-sm border border-gray-200 ring-2 ring-white shadow-sm overflow-hidden">
                <img loading="lazy" src="{{ $shop->logo_url }}" alt="{{ $shop->name }}"
                    class="w-full h-full object-cover">
            </div>
            <div>
                <p class="text-sm font-bold text-slate-900">{{ $shop->user->name ?? 'N/A' }}</p>
                <p class="text-xs text-slate-500">{{ translate('Pemilik Usaha') }}</p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-start gap-3 text-sm text-slate-600 bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                <x-icons.contact-mail class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" />
                <span class="truncate font-medium">{{ $shop->user->email ?? '-' }}</span>
            </div>
            <div class="flex items-start gap-3 text-sm text-slate-600 bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                <x-icons.contact-phone class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" />
                <span class="truncate font-medium">{{ $shop->user->phone_number ?? '-' }}</span>
            </div>
        </div>
        
        {{-- Stats and CTA ignored to save space if needed less than 50 lines? No, file is ~90 lines. I must split it further. --}}
        @include('admin.users.partials._shop-card-stats')
        
    </div>

    <div class="p-4 bg-gray-50 border-t border-gray-100 grid grid-cols-1 mt-auto">
        <x-ui.button href="{{ url('/admin/users/detail/' . $shop->id) }}" variant="outline"
            class="w-full rounded-lg justify-center group/btn">
            {{ translate('Detail') }}
            <x-icons.ui-chevron-right class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" />
        </x-ui.button>
    </div>
</x-ui.card>

