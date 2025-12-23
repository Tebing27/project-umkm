<div x-show="editProductModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6" x-cloak>

    {{-- Backdrop --}}
    <div @click="editProductModal = false" x-transition.opacity class="absolute inset-0 bg-slate-900/60">
    </div>

    {{-- Modal Content --}}
    <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl relative z-10 overflow-hidden flex flex-col max-h-[90vh]">

        {{-- Header Modal --}}
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Edit Produk</h3>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui detail produk kamu.</p>
            </div>
            <button @click="editProductModal = false" type="button"
                class="text-slate-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-colors">
                <x-icons.x-mark class="w-6 h-6" />
            </button>
        </div>

        {{-- Body Modal (Scrollable) --}}
        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form action="#" class="space-y-6">

                {{-- Upload Foto --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Foto Produk</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-slate-300 border-dashed rounded-2xl hover:border-[#004a85] hover:bg-blue-50/50 transition-all cursor-pointer group relative overflow-hidden">
                        <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-2 text-center relative z-0">
                            <div
                                class="mx-auto w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300">
                                <x-icons.upload class="h-6 w-6 text-slate-400 group-hover:text-[#004a85]" />
                            </div>
                            <div class="text-sm text-slate-600">
                                <span class="font-bold text-[#004a85] hover:underline">Klik upload</span> atau
                                drag & drop
                            </div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide">PNG, JPG up to 5MB
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Inputs --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <x-ui.input variant="soft" type="text" value="Salad Buah Segar" class="text-sm md:text-base">
                        </x-ui.input>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Harga (Rp) <span
                                class="text-red-500">*</span></label>

                        <x-ui.input variant="soft" type="number" value="25.000" class="text-sm md:text-base">
                            <x-slot:icon>
                                <span class="text-slate-500 font-bold text-sm not-italic">Rp</span>
                            </x-slot:icon>
                        </x-ui.input>
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Kategori Produk <span
                                class="text-red-500">*</span></label>
                        <x-ui.input variant="soft" type="text" value="Minuman" class="text-sm md:text-base">
                        </x-ui.input>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer Modal --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 shrink-0">
            <button @click="editProductModal = false" type="button"
                class="px-5 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-xl font-bold text-sm hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                Batal
            </button>
            <button type="button"
                class="px-6 py-2.5 bg-[#004a85] text-white rounded-xl font-bold text-sm hover:bg-blue-800 shadow-lg shadow-[#004a85]/30 transition-all transform active:scale-95 flex items-center gap-2">
                <x-icons.check class="w-4 h-4" />
                Simpan Perubahan
            </button>
        </div>

    </div>
</div>
