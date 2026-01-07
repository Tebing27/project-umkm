@if ($group === 'home_hero')
    <div class="relative py-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-slate-50/50 px-6 text-sm text-slate-400 font-bold tracking-widest uppercase">
                {{ translate('Konfigurasi Slider Region') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 pb-24">
        @foreach ($regions as $region)
            @include('admin.content.partials.cards.featured-region-card')
        @endforeach
    </div>
@endif

