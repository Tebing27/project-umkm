<div x-show="addProductModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6" x-cloak>

    {{-- Backdrop --}}
    <div @click="addProductModal = false" x-transition.opacity class="absolute inset-0 bg-slate-900/60"></div>

    {{-- Modal Content --}}
    <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl relative z-10 overflow-hidden flex flex-col max-h-[90vh]">

        {{-- Header Modal --}}
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-slate-900">{{translate('Tambah Produk Baru')}}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{translate('Isi detail produk dengan lengkap dan menarik')}}</p>
            </div>
            <button @click="addProductModal = false" type="button"
                class="text-slate-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-colors">
                <x-icons.x-mark class="w-6 h-6" />
            </button>
        </div>

        {{-- Body Modal (Scrollable) --}}
        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="add-product-form" action="{{ route('user.toko.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Upload Foto dengan Preview --}}
<div class="space-y-2" x-data="{ 
    imagePreview: null,
    previewFile(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}">
    <div class="flex justify-between items-center">
        <label class="block text-sm font-bold text-slate-700">{{translate('Foto Produk')}}</label>
        
        {{-- Helper Text: Muncul hanya jika gambar sudah dipilih --}}
        <button x-show="imagePreview" 
                @click="imagePreview = null; $refs.fileInput.value = ''"
                type="button"
                class="text-xs text-red-500 font-bold hover:underline" 
                style="display: none;">
            {{translate('Hapus & Ganti Foto')}}
        </button>
    </div>

    <div class="mt-1 w-full max-w-sm mx-auto aspect-[4/3] relative flex flex-col justify-center items-center border-2 border-dashed rounded-2xl transition-all overflow-hidden group"
         :class="imagePreview ? 'border-slate-200 bg-slate-50' : 'border-slate-300 hover:border-[#004a85] hover:bg-blue-50/50 cursor-pointer'">
        
        {{-- Input File (Hidden) --}}
        <input type="file" 
               name="image" 
               x-ref="fileInput"
               @change="previewFile($event)"
               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" 
               accept="image/*">

        {{-- STATE 1: Belum ada gambar (Tampilan Upload Awal) --}}
        <div x-show="!imagePreview" class="space-y-2 text-center relative z-10 pointer-events-none px-6">
            <div class="mx-auto w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300">
                <x-icons.upload class="h-6 w-6 text-slate-400 group-hover:text-[#004a85]" />
            </div>
            <div class="text-sm text-slate-600">
                <span class="font-bold text-[#004a85] hover:underline">{{translate('Klik upload')}}</span> atau drag & drop
            </div>
            <p class="text-xs text-slate-400 uppercase tracking-wide">PNG, JPG up to 5MB</p>
        </div>

        {{-- STATE 2: Sudah ada gambar (Preview Mode) --}}
        <template x-if="imagePreview">
            <div class="absolute inset-0 z-10 w-full h-full bg-slate-100">
                <img :src="imagePreview" class="w-full h-full object-cover">
                
                {{-- Overlay Helper saat hover di gambar --}}
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white">
                    <x-icons.pencil class="w-8 h-8 mb-2" />
                    <span class="font-bold text-sm">Klik untuk ganti</span>
                </div>
            </div>
        </template>
    </div>
    @error('image')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                {{-- Form Inputs --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">{{translate('Nama Produk')}} <span
                                class="text-red-500">*</span></label>
                        <x-ui.input variant="soft" type="text" name="name" placeholder="Contoh: Makaroni Kering" value="{{ old('name') }}"
                            class="text-sm md:text-base">
                        </x-ui.input>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">{{translate('Harga')}} (Rp) <span
                                class="text-red-500">*</span></label>

                        <x-ui.input variant="soft" type="number" name="price" placeholder="25.000" value="{{ old('price') }}" class="text-sm md:text-base">
                            <x-slot:icon>
                                <span class="text-slate-500 font-bold text-sm not-italic">Rp</span>
                            </x-slot:icon>
                        </x-ui.input>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">{{translate('Kategori Produk')}} <span
                                class="text-red-500">*</span></label>
                        <x-ui.input variant="soft" type="text" name="category" placeholder="Makanan" value="{{ old('category') }}" class="text-sm md:text-base">
                        </x-ui.input>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer Modal --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 shrink-0">
            <button @click="addProductModal = false" type="button"
                class="px-5 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-xl font-bold text-sm hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                Batal
            </button>
            <button type="submit" form="add-product-form"
                class="px-6 py-2.5 bg-[#004a85] text-white rounded-xl font-bold text-sm hover:bg-blue-800 shadow-lg shadow-[#004a85]/30 transition-all transform active:scale-95 flex items-center gap-2">
                <x-icons.check class="w-4 h-4" />
                {{translate('Simpan Produk')}}
            </button>
        </div>

    </div>
</div>
