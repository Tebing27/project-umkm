<div class="flex items-start justify-between">
    <label class="font-bold text-slate-700 text-base">{{translate($item->label) }}</label>
    @if ($item->type !== 'image')
        <div class="h-8 w-8 rounded-full bg-gray-50 text-brand-blue-dark flex items-center justify-center">
            <x-icons.ui-edit class="w-4 h-4" />
        </div>
    @endif
</div>
