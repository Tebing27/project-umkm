<button type="submit" 
        :disabled="isLoading"
        class="rounded-lg cursor-pointer px-3 h-[40px] flex items-center justify-center shrink-0 border border-transparent bg-[#FFC107] hover:bg-[#ffcd38] shadow-sm text-slate-900 disabled:opacity-75 disabled:cursor-not-allowed active:scale-95"
        title="{{ translate('Simpan') }}">
    
    <template x-if="!isLoading">
        <x-icons.ui-check class="w-5 h-5" />
    </template>
    <template x-if="isLoading">
        <x-icons.status-loading class="w-5 h-5" />
    </template>
</button>
