<div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center backdrop-blur-[2px]">
    @if ($item->value)
        <div class="absolute top-4 right-4 translate-y-[-10px] opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 delay-75">
            <form action="{{ route('admin.contents.delete_image', $item->id) }}" method="POST"
                onsubmit="return confirm('{{ translate('Apakah Anda yakin ingin menghapus gambar ini?') }}');">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500/80 hover:bg-red-600 text-white p-2 rounded-full backdrop-blur-md shadow-lg transition-transform hover:scale-110" title="{{ translate('Hapus Gambar') }}">
                    <x-icons.ui-delete class="w-5 h-5" />
                </button>
            </form>
        </div>
    @endif

    <button type="button"
        @click="$refs.photo_{{ $item->id }}.click()"
        class="bg-white text-slate-800 px-5 py-2.5 rounded-full font-bold text-base shadow-xl transform translate-y-4 group-hover:translate-y-0 duration-300">
        {{ $item->value ? translate('Ganti Gambar') : translate('Unggah Foto') }}
    </button>
</div>
