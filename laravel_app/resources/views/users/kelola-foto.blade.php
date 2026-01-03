<x-layouts.guest :title="translate('Kelola Foto - UMKM SASUMA')" :header-title="translate('Kelola Foto')" :header-subtitle="translate('Atur visualisasi toko Anda')">

    <div class="max-w-5xl mx-auto min-h-screen pb-32" x-data="photoManager({{ json_encode($photoArray) }})">

        {{-- PAGE HEADER --}}
        <div class="mb-10 border-b border-slate-200 pb-6">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ translate('Visualisasi Toko') }}</h1>
            <p class="text-slate-500 mt-2 text-lg">
                {{ translate('Foto yang Anda upload di sini akan tampil di Peta dan Popup Slider.') }}
            </p>
        </div>

        <form action="{{ route('user.toko.foto.store') }}" method="POST" enctype="multipart/form-data" @submit.prevent="saveChanges" x-ref="form">
            @csrf
            {{-- Hidden Inputs for Deleted IDs --}}
            <template x-for="id in deletedIds" :key="id">
                <input type="hidden" name="delete_ids[]" :value="id">
            </template>

            <div class="space-y-12">
                
                {{-- ALERTS --}}
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">{{ translate('Berhasil!') }}</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">{{ translate('Gagal!') }}</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">{{ translate('Ada Kesalahan!') }}</strong>
                        <ul class="list-disc pl-5 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- BAGIAN 1: FOTO UTAMA (COVER) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <div class="md:col-span-5">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <x-icons.photo class="w-6 h-6 text-[#004a85]" />
                            {{ translate('Foto Sampul (Cover)') }}
                        </h2>
                        <div class="prose prose-slate prose-sm mt-4 text-slate-500">
    <p class="text-md">
        {{ translate('Foto ini akan otomatis disesuaikan untuk tampilan Peta (Potrait) dan Popup (Landscape).') }}
    </p>
    <div class="bg-blue-50 p-3 mt-2 rounded-lg border border-blue-100 text-blue-800 text-sm">
        <strong>{{ translate('Tips Penting:') }}</strong> {{ translate('Pastikan objek utama (logo/produk) berada tepat di') }} <strong>{{ translate('TENGAH FOTO') }}</strong> {{ translate('agar tidak terpotong saat ditampilkan di berbagai ukuran layar.') }}
    </div>
    <ul class="list-disc pl-4 space-y-1 mt-2 text-sm">
        <li>{{ translate('Format: JPG, PNG, atau WEBP (Max 2MB)') }}</li>
        <li>{{ translate('Rasio Wajib: 4:3 (Landscape)') }}</li>
    </ul>
</div>
                    </div>

                    <div class="md:col-span-7">
                        {{-- Aspect Ratio disesuaikan dengan Popup (4:3) untuk konsistensi --}}
                        <div
                            class="relative w-full max-w-lg aspect-[4/3] rounded-2xl overflow-hidden group bg-slate-50 transition-all border-2 border-dashed border-slate-300 hover:border-[#004a85] hover:bg-blue-50/30 shadow-sm mx-auto md:mx-0">

                            <input type="file" name="photos[0]" class="hidden" x-ref="photo0" @change="handleFileSelect($event, 0)"
                                accept="image/*">

                            <div class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer p-6 text-center"
                                x-show="!photos[0].url" @click="$refs.photo0.click()">
                                <div
                                    class="w-16 h-16 rounded-full bg-white shadow-sm flex items-center justify-center mb-4 text-[#004a85] group-hover:scale-110 transition-transform">
                                    <x-icons.photo class="w-8 h-8" />
                                </div>
                                <h3 class="font-bold text-slate-700 text-lg">{{ translate('Upload Foto Sampul') }}</h3>
                                <p class="text-sm text-slate-400 mt-1">{{ translate('Klik untuk memilih foto') }}</p>
                            </div>

                            <template x-if="photos[0].url">
                                <div class="relative w-full h-full group">
                                    <img :src="photos[0].url" loading="lazy" class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-3 backdrop-blur-sm">
                                        <button type="button" @click="removePhoto(0)"
                                            class="p-2.5 bg-red-500 text-white rounded-full hover:scale-110 transition shadow-lg">
                                            <x-icons.trash class="w-5 h-5" />
                                        </button>
                                        <button type="button" @click="$refs.photo0.click()"
                                            class="p-2.5 bg-white text-slate-900 rounded-full hover:scale-110 transition shadow-lg">
                                            <x-icons.pencil class="w-5 h-5" />
                                        </button>
                                    </div>
                                    <div
                                        class="absolute top-4 left-4 bg-[#FFC107] text-black text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                        {{ translate('Tampilan Depan') }}
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-slate-200"></div>

                {{-- BAGIAN 2: SLIDER TAMBAHAN --}}
<div>
    <div class="mb-6">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
            <x-icons.photo class="w-5 h-5 text-[#004a85]" />
            {{ translate('Urutan Slider Berikutnya') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">
             {{ translate('Gunakan rasio mendatar (4:3) agar tampilan slider tidak melompat atau terpotong berlebihan.') }}
        </p>
        
        
        </div>
    </div>
    
                    {{-- Horizontal Scroll / Grid Sequence --}}
                   <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-for="i in 4" :key="i">
                            <div class="relative group">

                                {{-- Header Label (Slide Ke-X) --}}
                                <div class="mb-2 flex items-center justify-between px-1">
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        {{ translate('Slide Ke-') }}<span x-text="i"></span>
                                    </span>
                                </div>

                                <div class="aspect-[4/3] relative rounded-2xl overflow-hidden bg-slate-50 border-2 border-dashed border-slate-300 hover:border-[#004a85] transition-all shadow-sm">

                                    {{-- FORM INPUT --}}
                                    {{-- Teknik Overlay: Input menutupi area saat kosong (z-index tinggi & opacity 0) --}}
                                    {{-- Saat terisi, input disembunyikan (hidden) dan dipanggil via tombol Edit --}}
                                    <input type="file" 
                                           :name="'photos['+i+']'" 
                                           :id="'slider-input-' + i" 
                                           @change="handleFileSelect($event, i)" 
                                           accept="image/*"
                                           :class="!photos[i].url ? 'absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30' : 'hidden'">

                                    {{-- KONDISI 1: JIKA KOSONG (Visual Saja) --}}
                                    <div class="absolute inset-0 flex flex-col items-center justify-center transition-colors z-10"
                                         x-show="!photos[i].url">
                                        <x-icons.plus class="w-6 h-6 text-slate-300 group-hover:text-[#004a85] mb-1 transition-colors" />
                                        <span class="text-sm text-slate-400 group-hover:text-[#004a85]">{{ translate('Tambah') }}</span>
                                    </div>

                                    {{-- KONDISI 2: SUDAH ADA FOTO --}}
                                    <template x-if="photos[i].url">
                                        <div class="relative w-full h-full bg-white z-20">
                                            <img :src="photos[i].url" loading="lazy" class="w-full h-full object-cover">

                                            {{-- Action Buttons --}}
                                            <div class="absolute top-2 right-2 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                                
                                                {{-- Tombol Edit --}}
                                                <button type="button" 
                                                        @click="document.getElementById('slider-input-' + i).click()"
                                                        class="p-1.5 bg-white text-slate-700 rounded-md shadow-sm hover:bg-slate-50 hover:text-[#004a85] transition border border-slate-200"
                                                        title="{{ translate('Ganti Foto') }}">
                                                    <x-icons.pencil class="w-3.5 h-3.5" />
                                                </button>

                                                {{-- Tombol Hapus --}}
                                                <button type="button" @click="removePhoto(i)"
                                                        class="p-1.5 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 transition"
                                                        title="{{ translate('Hapus Foto') }}">
                                                    <x-icons.trash class="w-3.5 h-3.5" />
                                                </button>
                                            </div>

                                            {{-- Number Overlay --}}
                                            <div class="absolute bottom-2 left-2 bg-black/60 backdrop-blur px-2 py-0.5 rounded text-[10px] font-mono text-white">
                                                #<span x-text="i"></span>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </template>
                    </div>
                </div>



            {{-- FLOATING ACTION BAR --}}
            <div
                class="fixed bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-40 w-[90%] md:w-auto flex justify-center">
                <div
                    class="bg-white p-1.5 rounded-full shadow-2xl border border-slate-100 flex items-center justify-between md:justify-center gap-2 pr-2 pl-2 ring-1 ring-slate-900/5 w-full md:w-auto">

                    {{-- TOMBOL BATAL --}}
                    <button type="button" @click="cancelAction"
                        class="px-4 py-2 md:px-5 md:py-2.5 rounded-full text-slate-500 font-bold hover:bg-slate-50 transition-colors text-base tracking-wide flex-1 md:flex-none text-center">
                        {{ translate('Batal') }}
                    </button>

                    {{-- TOMBOL SIMPAN --}}
                    <x-ui.button type="submit"
                        class="px-5 py-2 md:px-6 md:py-2.5 text-slate-900 rounded-full font-medium text-base tracking-wide shadow-lg active:scale-95 flex items-center justify-center gap-2 flex-1 md:flex-none">
                        <x-icons.check class="w-4 h-4" />

                        {{-- Trik Text Responsif --}}
                        <span x-ref="submitText">
                            {{ translate('Simpan') }} <span class="hidden sm:inline">{{ translate('Perubahan') }}</span>
                        </span>
                    </x-ui.button>

                </div>
            </div>

        </form>
    </div>

    @push('scripts')
        <script>
            function photoManager(initialPhotos) {
                return {
                    photos: initialPhotos,
                    deletedIds: [],

                    handleFileSelect(event, index) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                // Keep ID if we are just replacing file? No, replacing means new file. 
                                // But if we delete old file by ID in controller, we need to track it?
                                // Controller deletes by ID if passed in delete_ids. 
                                // Replacing a photo with ID != null:
                                // If I replace it, the old logic in controller checks "if existing at order X, delete it".
                                // So I don't need to add it to deletedIds if I just overwrite the order.
                                // BUT, for preview purposes, I update the URL.
                                this.photos[index].url = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    removePhoto(index) {
                        // If it has an ID (existing in DB), add to deletedIds
                        if (this.photos[index].id) {
                            this.deletedIds.push(this.photos[index].id);
                        }
                        
                        this.photos[index].url = null;
                        this.photos[index].id = null; // Clear ID so we don't delete it again or confuse logic

                        if (index === 0) {
                            if (this.$refs.photo0) this.$refs.photo0.value = '';
                        } else {
                            const input = document.getElementById('slider-input-' + index);
                            if (input) input.value = '';
                        }
                    },

                    cancelAction() {
                        if (confirm('{{ translate("Batalkan perubahan?") }}')) window.location.reload();
                    },

                    saveChanges() {
                        const btnText = this.$refs.submitText;
                        
                        // --- VALIDATION LOGIC START ---
                        let totalSize = 0;
                        const maxTotalSize = 7.5 * 1024 * 1024; // 7.5MB (Lower than 8MB Limit)
                        const maxFileSize = 2 * 1024 * 1024; // 2MB
                        let errorMsg = null;

                        // Check Cover Photo (index 0)
                        if (this.$refs.photo0 && this.$refs.photo0.files[0]) {
                            const file = this.$refs.photo0.files[0];
                            
                            // Check Type
                            if (!file.type.match(/^image\//)) {
                                errorMsg = '{{ translate("File Foto Sampul harus berupa gambar!") }}';
                            }
                            
                            if (file.size > maxFileSize) {
                                errorMsg = '{{ translate("Foto Sampul terlalu besar! Maksimal 2MB.") }}';
                            }
                            totalSize += file.size;
                        }

                        // Check Slider Photos (index 1-4)
                        for (let i = 1; i <= 4; i++) {
                            const input = document.getElementById('slider-input-' + i);
                            if (input && input.files[0]) {
                                const file = input.files[0];
                                
                                // Check Type
                                if (!file.type.match(/^image\//)) {
                                    errorMsg = '{{ translate("File pada Slide ke-") }}' + i + ' {{ translate("bukan gambar valid!") }}';
                                }

                                // Check Size
                                if (file.size > maxFileSize) {
                                    errorMsg = '{{ translate("Foto pada Slide ke-") }}' + i + ' {{ translate("terlalu besar! Maksimal 2MB.") }}';
                                }
                                
                                totalSize += file.size;
                            }
                        }

                        if (errorMsg) {
                            alert(errorMsg);
                            return;
                        }

                        if (totalSize > maxTotalSize) {
                            alert('{{ translate("Total ukuran semua foto terlalu besar! Maksimal total upload 7.5MB. Silakan kurangi ukuran foto atau upload secara bertahap.") }}');
                            return;
                        }
                        // --- VALIDATION LOGIC END ---

                        if(btnText) btnText.innerText = '{{ translate("Menyimpan...") }}';
                        
                        // Submit the form
                        this.$refs.form.submit();
                    }
                }
            }
        </script>
    @endpush

</x-layouts.guest>
