@if ($item->type !== 'image')
    <div class="pt-2 flex justify-center">
        <x-ui.button type="submit"
            class="rounded-lg text-base font-medium">{{translate('Simpan Data')}}</x-ui.button>
    </div>
@else
    <div x-show="photoPreview" style="display: none;" class="animate-fade-in-up">
        <x-ui.button type="submit" class="w-full py-3 rounded-lg font-medium">
            {{translate('Simpan Foto Baru')}}
        </x-ui.button>
        <button type="button"
            @click="photoPreview = null; photoName = null; $refs.photo_{{ $item->id }}.value = null"
            class="cursor-pointer w-full font-medium text-slate-900 text-sm mt-3 transition-colors underline underline-offset-2">
            {{translate('Batal')}}
        </button>
    </div>
@endif
