<div class="hidden lg:block relative h-[400px] lg:h-[500px] w-full rounded-3xl overflow-hidden shadow-2xl shadow-primary/20 order-1 lg:order-2 group">
    <img loading="lazy" src="{{ ($contents['umkm_index_banner']->value ?? null) ? asset('storage/' . str_replace('\\', '/', $contents['umkm_index_banner']->value)) : 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2574&auto=format&fit=crop' }}"
        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
        alt="Supermarket Shelf">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent"></div>

    <div class="absolute bottom-0 left-0 p-8">
        <div class="bg-white/90 backdrop-blur-sm p-4 rounded-2xl inline-block shadow-lg">
            <p class="text-primary font-bold text-lg">{{ $contents['umkm_banner_stat_number']->value ?? '100+ UMKM' }}</p>
            <p class="text-slate-600 text-sm">{{ translate($contents['umkm_banner_stat_text']->value ?? 'Terdaftar di Sasuma') }}</p>
        </div>
    </div>
</div>
