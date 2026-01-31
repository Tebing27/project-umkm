<x-ui.button @click="addProductModal = true" variant="dashed-card" size="compact" class="w-full h-full min-h-[350px] p-6 !gap-0 group relative text-left whitespace-normal block">
    <div
        class="w-16 h-16 rounded-2xl bg-white shadow-sm border border-gray-200 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:shadow-md group-hover:border-brand-blue-dark/20 transition-all duration-300 z-10 mx-auto">
        <x-icons.ui-plus class="w-8 h-8 text-slate-400 group-hover:text-brand-blue-dark transition-colors" />
    </div>
    <span
        class="font-bold text-slate-500 group-hover:text-brand-blue-dark text-lg transition-colors z-10 block text-center">{{translate('Tambah Produk')}}</span>
    <span class="text-xs text-slate-400 mt-1 z-10 block text-center font-normal">{{translate('Upload produk barumu sekarang')}}</span>

    {{-- Decor bg --}}
    <div
        class="absolute inset-0 bg-gradient-to-br from-transparent to-blue-50/50 opacity-0 group-hover:opacity-100 transition-opacity">
    </div>
</x-ui.button>
