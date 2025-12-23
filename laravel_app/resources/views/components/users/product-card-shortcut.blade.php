<button @click="addProductModal = true" type="button"
    class="group relative bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center h-full min-h-[350px] hover:border-[#004a85] hover:bg-blue-50/30 transition-all duration-300 p-6 overflow-hidden">
    <div
        class="w-16 h-16 rounded-2xl bg-white shadow-sm border border-slate-200 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:shadow-md group-hover:border-[#004a85]/20 transition-all duration-300 z-10">
        <x-icons.plus class="w-8 h-8 text-slate-400 group-hover:text-[#004a85] transition-colors" />
    </div>
    <span
        class="font-bold text-slate-500 group-hover:text-[#004a85] text-lg transition-colors z-10">Tambah
        Produk</span>
    <span class="text-xs text-slate-400 mt-1 z-10">Upload produk barumu sekarang</span>

    {{-- Decor bg --}}
    <div
        class="absolute inset-0 bg-gradient-to-br from-transparent to-blue-50/50 opacity-0 group-hover:opacity-100 transition-opacity">
    </div>
</button>
