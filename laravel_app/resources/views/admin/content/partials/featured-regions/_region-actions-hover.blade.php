<div x-show="!photoPreview"
    class="text-center transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 delay-100 relative">
    
    @if ($region->image)
        <div class="absolute -top-12 -right-12">
            <form action="{{ route('admin.regions.delete_image', $region->id) }}" method="POST" 
                onsubmit="return confirm('{{ translate('Apakah Anda yakin ingin menghapus gambar ini?') }}');">
                @csrf @method('DELETE')
                <button type="submit" class="p-2 bg-red-500 rounded-full text-white hover:bg-red-600 transition-colors shadow-lg" title="{{ translate('Hapus Gambar') }}">
                    <x-icons.ui-delete class="w-4 h-4" />
                </button>
            </form>
        </div>
    @endif

    <button type="button"
        @click="$refs.photo_{{ $region->id }}.click()"
        class="group/btn bg-white text-slate-900 rounded-full p-3 mb-3 hover:bg-brand-blue-dark hover:text-white transition-all shadow-lg hover:scale-110 hover:rotate-6">
        <x-icons.data-photo
            class="w-6 h-6 transition-transform group-hover/btn:scale-90" />
    </button>
    <p class="text-white font-bold text-sm tracking-wide drop-shadow-sm">
        {{translate('Ubah Foto')}}</p>
</div>
