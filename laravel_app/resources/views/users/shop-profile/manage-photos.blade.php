<x-layouts.guest :title="translate('Kelola Foto - UMKM SASUMA')" :header-title="translate('Kelola Foto')" :header-subtitle="translate('Atur visualisasi toko Anda')">

    <div class="max-w-5xl mx-auto min-h-screen pb-32" x-data="photoManager({{ json_encode($photoArray) }})">

        {{-- PAGE HEADER --}}
        <div class="mb-10 border-b border-gray-200 pb-6">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ translate('Visualisasi Toko') }}</h1>
            <p class="text-slate-500 mt-2 text-lg">
                {{ translate('Foto yang Anda upload di sini akan tampil di Peta dan Popup Slider.') }}
            </p>
        </div>

        <form action="{{ route('user.toko.foto.store') }}" method="POST" enctype="multipart/form-data" @submit.prevent="saveChanges" x-ref="form">
            @csrf
            {{-- Hidden Inputs for Deleted IDs --}}
            <template x-for="id in deletedIds" :key="id">
                <x-ui.input type="hidden" name="delete_ids[]" ::value="id" />
            </template>

            <div class="space-y-12">
                
                {{-- ALERTS --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition.opacity
                        class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 p-2 rounded-full">
                                <x-icons.ui-check class="w-5 h-5 text-green-600" />
                            </div>
                            <div>
                                <h4 class="font-bold text-green-800">{{ translate('Berhasil!') }}</h4>
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:bg-green-100 p-2 rounded-lg transition-colors">
                            <x-icons.ui-close class="w-5 h-5" />
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition.opacity
                        class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-100 p-2 rounded-full">
                                <x-icons.ui-close class="w-5 h-5 text-red-600" />
                            </div>
                            <div>
                                <h4 class="font-bold text-red-800">{{ translate('Gagal!') }}</h4>
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:bg-red-100 p-2 rounded-lg transition-colors">
                            <x-icons.ui-close class="w-5 h-5" />
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition.opacity
                        class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 p-2 rounded-full shrink-0">
                                <x-icons.ui-close class="w-5 h-5 text-red-600" />
                            </div>
                            <div>
                                <h4 class="font-bold text-red-800">{{ translate('Ada Kesalahan!') }}</h4>
                                <ul class="list-disc pl-5 mt-1 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:bg-red-100 p-2 rounded-lg transition-colors">
                            <x-icons.ui-close class="w-5 h-5" />
                        </button>
                    </div>
                @endif

                {{-- BAGIAN 1: FOTO UTAMA (COVER) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <div class="md:col-span-5">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <x-icons.data-photo class="w-6 h-6 text-brand-blue-dark" />
                            {{ translate('Foto Sampul (Cover)') }}
                        </h2>
                        <div class="prose prose-gray prose-sm mt-4 text-slate-500">
    <p class="text-base text-slate-600 leading-relaxed">
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
                            class="relative w-full max-w-lg aspect-[4/3] rounded-2xl overflow-hidden group bg-gray-50 transition-all border-2 border-dashed border-gray-300 hover:border-brand-blue-dark hover:bg-blue-50/30 shadow-sm mx-auto md:mx-0">

                            <input type="file" name="photos[0]" class="hidden" x-ref="photo0" @change="handleFileSelect($event, 0)"
                                accept="image/*">

                            <div class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer p-6 text-center"
                                x-show="!photos[0].url" @click="$refs.photo0.click()">
                                <div
                                    class="w-16 h-16 rounded-full bg-white shadow-sm flex items-center justify-center mb-4 text-brand-blue-dark group-hover:scale-110 transition-transform">
                                    <x-icons.data-photo class="w-8 h-8" />
                                </div>
                                <h3 class="font-bold text-slate-700 text-lg">{{ translate('Upload Foto Sampul') }}</h3>
                                <p class="text-sm text-slate-400 mt-1">{{ translate('Klik untuk memilih foto') }}</p>
                            </div>

                            <template x-if="photos[0].url">
                                <div class="relative w-full h-full group">
                                    <img :src="photos[0].url" loading="lazy" class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-3 backdrop-blur-sm">
                                        <x-ui.button type="button" @click="confirmDeletePhoto(0)"
                                            variant="circle-red" size="icon-lg" class="rounded-lg">
                                            <x-icons.ui-delete class="w-5 h-5" />
                                        </x-ui.button>
                                        <x-ui.button type="button" @click="$refs.photo0.click()"
                                            variant="circle-white-action" size="icon-lg" class="rounded-lg">
                                            <x-icons.ui-edit class="w-5 h-5" />
                                        </x-ui.button>
                                    </div>
                                    <div
                                        class="absolute top-4 left-4 bg-brand-yellow text-black text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                        {{ translate('Tampilan Depan') }}
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-gray-200"></div>

                {{-- BAGIAN 2: SLIDER TAMBAHAN --}}
<div>
    <div class="mb-6">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
            <x-icons.data-photo class="w-5 h-5 text-brand-blue-dark" />
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

                                <div class="aspect-[4/3] relative rounded-2xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-300 hover:border-brand-blue-dark transition-all shadow-sm">
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
                                        <x-icons.ui-plus class="w-6 h-6 text-slate-300 group-hover:text-brand-blue-dark mb-1 transition-colors" />
                                        <span class="text-sm text-slate-400 group-hover:text-brand-blue-dark">{{ translate('Tambah') }}</span>
                                    </div>

                                    {{-- KONDISI 2: SUDAH ADA FOTO --}}
                                    <template x-if="photos[i].url">
                                        <div class="relative w-full h-full bg-white z-20">
                                            <img :src="photos[i].url" loading="lazy" class="w-full h-full object-cover">

                                            {{-- Action Buttons --}}
                                            <div class="absolute top-2 right-2 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                                
                                                {{-- Tombol Edit --}}
                                                <x-ui.button type="button" 
                                                        @click="document.getElementById('slider-input-' + i).click()"
                                                        variant="icon-box"
                                                        size="icon"
                                                        title="{{ translate('Ganti Foto') }}">
                                                    <x-icons.ui-edit class="w-3.5 h-3.5" />
                                                </x-ui.button>

                                                {{-- Tombol Hapus --}}
                                                <x-ui.button type="button" @click="confirmDeletePhoto(i)"
                                                        variant="icon-box-danger"
                                                        size="icon"
                                                        title="{{ translate('Hapus Foto') }}">
                                                    <x-icons.ui-delete class="w-3.5 h-3.5" />
                                                </x-ui.button>
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
            <div x-show="isDirty"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-10"
                 class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 w-auto max-w-md"
                 style="display: none;">

                <div class="bg-white/90 backdrop-blur-md p-1.5 sm:p-2 rounded-full shadow-2xl border border-gray-200/80 flex items-center justify-center sm:justify-start gap-3 ring-1 ring-black/5">

                    <div class="pl-2 text-sm font-medium text-slate-700 whitespace-nowrap">
                        {{ translate('Perubahan belum disimpan') }}
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <x-ui.button type="submit"
                        class="px-6 py-2.5 rounded-full shadow-lg active:scale-95 flex items-center justify-center transition-all hover:-translate-y-0.5 text-sm sm:text-base">
                        
                        <x-icons.ui-check class="w-5 h-5 shrink-0" />

                        <span x-ref="submitText" class="whitespace-nowrap font-bold">
                            <span class="sm:hidden">{{ translate('Simpan') }}</span>
                            <span class="hidden sm:inline">{{ translate('Simpan Perubahan') }}</span>
                        </span>
                    </x-ui.button>

                </div>
            </div>

        </form>

        {{-- DELETE CONFIRMATION MODAL --}}
        <x-ui.modal show="deleteModalOpen" max-width="sm">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-icons.ui-delete class="w-8 h-8 text-red-600" />
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ translate('Hapus Foto?') }}</h3>
                <p class="text-slate-500 mb-6">
                    {{ translate('Tandai foto ini untuk dihapus? Foto akan hilang sepenuhnya setelah Anda menyimpan perubahan.') }}
                </p>
                <div class="flex gap-3 justify-center">
                    <x-ui.button type="button" variant="ghost" @click="deleteModalOpen = false" class="px-6 rounded-lg">
                        {{ translate('Batal') }}
                    </x-ui.button>
                    <x-ui.button type="button" variant="destructive" @click="executeDelete()" class="px-6 rounded-lg">
                        {{ translate('Ya, Hapus') }}
                    </x-ui.button>
                </div>
            </div>
        </x-ui.modal>
    </div>

    @push('scripts')
        <script>
            function photoManager(initialPhotos) {
                return {
                    photos: initialPhotos,
                    deletedIds: [],
                    isDirty: false,
                    deleteModalOpen: false,
                    photoIndexToDelete: null,

                    init() {
                        // Apply Cloudinary transformations to initial URLs in JS side if any
                        this.photos.forEach(p => {
                            if (p.url && p.url.includes('res.cloudinary.com')) {
                                p.url = this.resizeCloudinary(p.url, 800);
                            }
                        });

                        this.$watch('deletedIds', () => { this.isDirty = true });
                        window.onbeforeunload = (e) => {
                            if (this.isDirty) {
                                e.preventDefault();
                                e.returnValue = '{{ translate("Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?") }}';
                            }
                        };
                    },


                    resizeCloudinary(url, width) {
                        if (!url || !url.includes('res.cloudinary.com') || !url.includes('/upload/')) return url;
                        if (url.includes('/upload/f_auto,q_auto')) {
                            if (url.includes('w_')) {
                                return url.replace(/w_\d+/, 'w_' + width);
                            }
                            return url.replace('/upload/f_auto,q_auto', '/upload/f_auto,q_auto,w_' + width + ',c_limit');
                        }
                        return url.replace('/upload/', '/upload/w_' + width + ',c_limit/');
                    },

                    handleFileSelect(event, index) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.photos[index].url = e.target.result;
                                this.isDirty = true;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    confirmDeletePhoto(index) {
                        this.photoIndexToDelete = index;
                        this.deleteModalOpen = true;
                    },

                    executeDelete() {
                        const index = this.photoIndexToDelete;
                        if (index === null) return;

                        // If it has an ID (existing in DB), add to deletedIds
                        if (this.photos[index].id) {
                            this.deletedIds.push(this.photos[index].id);
                        }
                        
                        this.photos[index].url = null;
                        this.photos[index].id = null;
                        this.isDirty = true;

                        if (index === 0) {
                            if (this.$refs.photo0) this.$refs.photo0.value = '';
                        } else {
                            const input = document.getElementById('slider-input-' + index);
                            if (input) input.value = '';
                        }

                        this.deleteModalOpen = false;
                        this.photoIndexToDelete = null;
                    },

                    removePhoto(index) {
                        // Keep for legacy/internal but we use confirmDeletePhoto and executeDelete
                        this.confirmDeletePhoto(index);
                    },

                    cancelAction() {
                        if (this.isDirty) {
                             if (confirm('{{ translate("Batalkan semua perubahan?") }}')) {
                                 this.isDirty = false; // Prevent alert
                                 window.location.reload();
                             }
                        } else {
                            window.history.back();
                        }
                    },

                    saveChanges() {
                        const btnText = this.$refs.submitText;
                        
                        // --- VALIDATION LOGIC START ---
                        let totalSize = 0;
                        const maxTotalSize = 7.5 * 1024 * 1024; // 7.5MB
                        const maxFileSize = 2 * 1024 * 1024; // 2MB
                        let errorMsg = null;

                        // Check Cover Photo (index 0)
                        if (this.$refs.photo0 && this.$refs.photo0.files[0]) {
                            const file = this.$refs.photo0.files[0];
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
                                if (!file.type.match(/^image\//)) {
                                    errorMsg = '{{ translate("File pada Slide ke-") }}' + i + ' {{ translate("bukan gambar valid!") }}';
                                }
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
                            alert('{{ translate("Total ukuran semua foto terlalu besar! Maksimal total upload 7.5MB.") }}');
                            return;
                        }
                        // --- VALIDATION LOGIC END ---

                        if(btnText) btnText.innerText = '{{ translate("Menyimpan...") }}';
                        
                        // Disable dirty check to allow submit
                        this.isDirty = false;
                        
                        // Submit the form
                        this.$refs.form.submit();
                    }
                }
            }
        </script>
    @endpush

</x-layouts.guest>
