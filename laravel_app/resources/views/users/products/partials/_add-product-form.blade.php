<div class="flex flex-col max-h-[90vh] bg-white w-full rounded-2xl overflow-hidden">

        {{-- Header Modal --}}
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-slate-900">{{ translate('Tambah Produk Baru') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ translate('Isi detail produk dengan lengkap dan menarik') }}
                </p>
            </div>
            <x-ui.button @click="addProductModal = false" type="button" variant="ghost"
                class="text-slate-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-colors">
                <x-icons.ui-close class="w-6 h-6" />
            </x-ui.button>
        </div>

        {{-- Body Modal (Scrollable) --}}
        <div class="p-6 overflow-y-auto custom-scrollbar bg-white flex-1">
            <form id="add-product-form" action="{{ route('user.toko.produk.store') }}" method="POST"
                enctype="multipart/form-data" class="space-y-6 bg-white">
                @csrf

                {{-- Upload Foto (Main + Thumbnails) --}}
                <div class="space-y-4" x-data="{
                    previews: [null, null, null, null, null],
                    previewFile(event, index) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.previews[index] = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },
                    removeFile(index) {
                        this.previews[index] = null;
                        // Reset input file
                        const input = this.$refs['fileInput' + index];
                        if (input) input.value = '';
                    }
                }">
                    <label class="block text-sm font-bold text-slate-700">
                        {{ translate('Foto Produk') }} <span class="text-red-500">*</span>
                        <span class="font-normal text-slate-500 italic ml-1">({{ translate('Maks. 5 foto') }})</span>
                    </label>

                    <div class="flex flex-col gap-4">
                        {{-- 1. Main Image (Index 0) --}}
                        <div class="w-full aspect-square relative group">
                             <div class="absolute top-3 left-3 z-30 text-xs uppercase font-bold text-brand-blue-dark bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100 pointer-events-none">
                                {{ translate('Foto Utama') }}
                            </div>
                             
                             <div class="w-full h-full relative flex flex-col justify-center items-center border-2 border-dashed rounded-2xl transition-all overflow-hidden bg-gray-50 hover:bg-white"
                                 :class="previews[0] ? 'border-gray-200' : 'border-gray-300 hover:border-brand-blue-dark cursor-pointer'">
                                 
                                 <input type="file" name="images[0]" x-ref="fileInput0" 
                                        @change="previewFile($event, 0)"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" 
                                        accept="image/*">

                                 <div x-show="!previews[0]" class="flex flex-col items-center justify-center text-center p-6 pointer-events-none">
                                     <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                         <x-icons.ui-upload class="w-8 h-8 text-brand-blue-dark" />
                                     </div>
                                     <span class="text-sm font-bold text-slate-700">{{ translate('Klik untuk upload foto utama') }}</span>
                                     <span class="text-xs text-slate-400 mt-1">PNG, JPG up to 2MB</span>
                                 </div>

                                 <div x-show="previews[0]" class="absolute inset-0 z-10 w-full h-full bg-white">
                                     <img loading="lazy" :src="previews[0]" class="w-full h-full object-cover">
                                     <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-3">
                                         <button type="button" @click.prevent="$refs.fileInput0.click()" class="text-white hover:text-blue-200 font-bold text-sm pointer-events-auto flex items-center gap-1">
                                             <x-icons.ui-edit class="w-5 h-5" /> Ganti
                                         </button>
                                     </div>
                                 </div>
                             </div>
                        </div>

                        {{-- 2. Thumbnails (Index 1-4) --}}
                        <div class="grid grid-cols-4 gap-3">
                            <template x-for="i in 4" :key="i">
                                <div class="relative group aspect-square">
                                    {{-- Wrapper needed to access index correctly in loop (i is 1-based from x-for 4) --}}
                                    <div class="w-full h-full relative flex flex-col justify-center items-center border-2 border-dashed rounded-xl transition-all overflow-hidden bg-gray-50 hover:bg-white"
                                        :class="previews[i] ? 'border-gray-200' : 'border-gray-300 hover:border-brand-blue-dark cursor-pointer'">
                                        
                                        {{-- Input File --}}
                                        <input type="file" :name="'images[' + i + ']'" :x-ref="'fileInput' + i" 
                                               @change="previewFile($event, i)"
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" 
                                               accept="image/*">

                                        {{-- Empty State --}}
                                        <div x-show="!previews[i]" class="flex flex-col items-center justify-center text-center p-1 pointer-events-none">
                                            <x-icons.ui-plus class="w-5 h-5 text-slate-400 group-hover:text-brand-blue-dark" />
                                        </div>

                                        {{-- Preview State --}}
                                        <div x-show="previews[i]" class="absolute inset-0 z-10 w-full h-full bg-white">
                                            <img loading="lazy" :src="previews[i]" class="w-full h-full object-cover">
                                            
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                                <button type="button" @click.prevent="removeFile(i)" 
                                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 relative z-30 pointer-events-auto shadow-md">
                                                    <x-icons.ui-trash class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Form Inputs --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">{{ translate('Nama Produk') }} <span
                                class="text-red-500">*</span></label>
                        <x-ui.input variant="soft" type="text" name="name" placeholder="Contoh: Makaroni Kering"
                            value="{{ old('name') }}" class="text-sm md:text-base">
                        </x-ui.input>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5" x-data="{
                        displayPrice: '',
                        realPrice: '{{ old('price', '') }}',

                        init() {
                            if (this.realPrice) {
                                this.displayPrice = this.formatRupiah(this.realPrice);
                            }
                        },

                        formatRupiah(value) {
                            if (!value) {
                                this.realPrice = '';
                                return '';
                            }
                            let number = value.toString().replace(/[^0-9]/g, '');
                            this.realPrice = number;
                            return number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        }
                    }">
                        <label class="block text-sm font-bold text-slate-700">{{ translate('Harga') }} (Rp) <span
                                class="text-red-500">*</span></label>

                        <x-ui.input type="hidden" name="price" x-model="realPrice" />

                        <x-ui.input variant="soft" type="text" inputmode="numeric" x-model="displayPrice"
                            @input="displayPrice = formatRupiah($event.target.value)" placeholder="0"
                            class="text-sm md:text-base [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
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
                        <label class="block text-sm font-bold text-slate-700">{{ translate('Kategori Produk') }} <span
                                class="text-red-500">*</span></label>
                        <x-ui.input variant="soft" type="text" name="category" placeholder="Makanan"
                            value="{{ old('category') }}" class="text-sm md:text-base">
                        </x-ui.input>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">{{ translate('Varian') }} <span
                                class="text-slate-700">(Opsional)</span></label>
                        <x-ui.input variant="soft" type="text" name="variant" placeholder="Contoh: Pedas, Manis"
                            value="{{ old('variant') }}" class="text-sm md:text-base">
                        </x-ui.input>
                        @error('variant')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">{{ translate('Deskripsi Produk') }} <span
                            class="text-slate-700">(Opsional)</span></label>
                    <x-ui.textarea variant="soft" name="description" placeholder="Jelaskan detail produkmu..." rows="4"
                        class="text-sm md:text-base font-medium">{{ old('description') }}</x-ui.textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </form>
        </div>

        {{-- Footer Modal --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 shrink-0">
            <x-ui.button @click="addProductModal = false" type="button" variant="ghost"
                class="px-5 py-2.5 bg-white text-slate-700 border border-gray-300 rounded-xl font-bold text-sm hover:bg-gray-50 hover:text-slate-900 transition-colors shadow-sm">
                Batal
            </x-ui.button>
            <x-ui.button type="submit" form="add-product-form" 
                class="px-6 py-2.5 rounded-lg shadow-lg shadow-brand-blue-dark/30 transition-all transform active:scale-95 flex items-center gap-2">
                {{ translate('Simpan Produk') }}
            </x-ui.button>
        </div>

</div>
