@if ($group === 'home_wilayah')
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach ($regions as $region)
            @include('admin.content.partials.cards.region-image-card')
        @endforeach
    </div>

    <div class="relative py-4">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-slate-50/50 px-6 text-sm text-slate-400 font-bold tracking-widest uppercase">
                {{translate('Konfigurasi Halaman')}}
            </span>
        </div>
    </div>
@endif

