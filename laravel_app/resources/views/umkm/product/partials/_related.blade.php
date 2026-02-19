{{-- Related Products --}}
@if ($otherProducts->count() > 0)
    <div class="mt-12 pt-12 border-t border-slate-200">
        <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-6">
            {{ translate('Lainnya di toko ini') }}
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-5 gap-3 sm:gap-4">
            @foreach ($otherProducts as $other)
                <a href="{{ route('umkm.product', $other->id) }}" class="block h-full group">
                    <div class="h-full flex flex-col bg-white">
                         <div class="aspect-square relative overflow-hidden rounded-lg mb-2">
                            <img src="{{ storage_url($other->image) }}" srcset="{{ cloudinary_srcset(storage_url($other->image)) }}" sizes="(max-width: 640px) 50vw, 200px" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Jual {{ $other->name }} di {{ $shop->name }} - Sasuma" loading="lazy">
                            @if($other->is_best_seller)
                            <div class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-br-lg shadow-sm">
                                Terlaris
                            </div>
                            @endif
                        </div>
                        <div class="flex flex-col flex-1 p-2">
                            <h3 class="font-medium text-slate-900 text-sm line-clamp-2 leading-snug mb-1 transition-colors">
                                {{ $other->name }}
                            </h3>
                            <div class="mt-auto flex items-end justify-between">
                                <span class="font-bold text-slate-900 text-base">
                                    Rp {{ number_format($other->price, 0, ',', '.') }}
                                </span>
                                <button class="text-slate-400 hover:text-slate-600 p-1">
                                    <x-icons.ui-share class="w-4 h-4 rotate-90" />
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
