@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
    <div class="flex items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-slate-500 font-bold text-2xl border-4 border-white shadow-lg overflow-hidden">
            <img loading="lazy" src="{{ $shop->logo_url }}" alt="{{ $shop->name }}" class="w-full h-full object-cover">
        </div>
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $shop->name }}</h1>
                @if ($shop->is_verified)
                    <span class="px-3 py-1 rounded-full bg-green-100 uppercase text-green-700 text-xs font-bold border border-green-200 tracking-wide">
                        {{ translate('Terverifikasi') }}
                    </span>
                @elseif ($shop->rejection_reason)
                    <span class="px-3 py-1 rounded-full bg-red-100 uppercase text-red-700 text-xs font-bold border border-red-200 tracking-wide">
                        {{ translate('Ditolak') }}
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-yellow-100 uppercase text-yellow-700 text-xs font-bold border border-yellow-200 tracking-wide">
                        {{ translate('Menunggu') }}
                    </span>
                @endif
            </div>
            <p class="text-slate-500 font-medium">{{ translate('Terdaftar') }} {{ $shop->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <x-ui.button variant="destructive" @click="rejectModalOpen = true" class="rounded-lg font-semibold">
            {{ translate('Tolak') }}
        </x-ui.button>

        @if (!$shop->is_verified)
            @if ($shop->isComplete())
                <form action="{{ route('admin.verify-shop', $shop->id) }}" method="POST">
                    @csrf
                    <x-ui.button type="submit" class="bg-green-600 rounded-lg hover:bg-green-700 text-white font-semibold">
                        {{ translate('Verifikasi Sekarang') }}
                    </x-ui.button>
                </form>
            @else
                <div class="group relative inline-block">
                    <x-ui.button type="button" disabled class="bg-gray-200 text-slate-500 rounded-lg cursor-not-allowed font-semibold w-full">
                        {{ translate('Verifikasi Sekarang') }}
                    </x-ui.button>
                    
                    <div class="absolute top-full right-0 mt-2 w-72 p-4 bg-white border border-red-200 text-slate-600 text-sm rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="flex items-start gap-3 mb-2 text-red-600">
                            <x-icons.status-error-circle class="w-5 h-5 shrink-0" />
                            <p class="font-bold text-sm">{{ translate('Data Belum Lengkap') }}</p>
                        </div>
                        <p class="mb-2 text-slate-500">{{ translate('User belum melengkapi data berikut:') }}</p>
                        <ul class="list-disc pl-4 space-y-1 text-slate-700">
                            @foreach($shop->getMissingFields() as $field)
                                <li>{{ $field }}</li>
                            @endforeach
                        </ul>
                        <div class="absolute -top-1 right-8 w-3 h-3 bg-white border-t border-l border-red-200 rotate-45"></div>
                    </div>
                </div>
            @endif
        @else
            <x-ui.button variant="outline" disabled class="text-slate-900 rounded-lg opacity-70 cursor-not-allowed">
                {{ translate('Sudah Terverifikasi') }}
            </x-ui.button>
        @endif
    </div>
</div>
