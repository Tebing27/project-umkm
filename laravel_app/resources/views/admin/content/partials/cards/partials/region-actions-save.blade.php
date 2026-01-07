<div x-show="photoPreview" style="display: none;" class="w-full text-center animate-fade-in-up">
    <div class="mb-3 px-4 py-1.5 bg-black/40 rounded-full inline-block backdrop-blur-sm">
        <p class="text-white/90 text-base truncate max-w-[150px]" x-text="photoName"></p>
    </div>
    <x-ui.button type="submit"
        class="w-full font-medium py-3 px-6 rounded-lg shadow-lg active:scale-95 flex items-center justify-center gap-2 relative overflow-hidden group/save">
        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/save:animate-shimmer"></span>
        <x-icons.ui-check class="w-5 h-5 relative z-10" />
        <span class="relative z-10">{{translate('Simpan Foto')}}</span>
    </x-ui.button>
    <button type="button"
        @click="photoPreview = null; photoName = null; $refs.photo_{{ $region->id }}.value = null"
        class="cursor-pointer text-white/70 text-base mt-3 hover:text-white transition-colors underline underline-offset-2">
        {{translate('Batal')}}
    </button>
</div>
