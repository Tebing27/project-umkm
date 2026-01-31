<x-ui.card class="p-8">
    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
        <x-icons.data-photo class="w-5 h-5 text-primary" />
        {{ translate('Visualisasi Toko') }}
    </h3>

    @if ($shop->photos->count() > 0)
        <div class="grid grid-cols-2 gap-3">
            @foreach ($shop->photos as $index => $photo)
                <div class="relative group aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200 cursor-pointer"
                     @click="activeImage = {{ $index }}; galleryOpen = true">
                    
                    <img loading="lazy" src="{{ $photo->path }}" alt="{{ $shop->name }} - Foto {{ $index + 1 }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-white text-xs font-bold border border-white px-3 py-1.5 rounded-full hover:bg-white hover:text-black transition-colors">
                            {{ translate('Lihat') }}
                        </span>
                    </div>

                    @if($loop->first)
                        <div class="absolute top-2 left-2 bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">
                            {{ translate('Cover') }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-300">
            <x-icons.data-photo class="w-8 h-8 text-slate-300 mx-auto mb-2" />
            <p class="text-slate-500 text-sm">{{ translate('Belum ada foto visualisasi toko yang diupload.') }}</p>
        </div>
    @endif
</x-ui.card>
