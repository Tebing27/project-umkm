<x-layouts.guest title="Kelola Foto - UMKM SASUMA" header-title="Kelola Foto" header-subtitle="Atur visualisasi toko Anda">

    <div class="max-w-5xl mx-auto min-h-screen pb-32" x-data="photoManager()">

        {{-- PAGE HEADER --}}
        <div class="mb-10 border-b border-slate-200 pb-6">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Visualisasi Toko</h1>
            <p class="text-slate-500 mt-2 text-lg">
                Foto yang Anda upload di sini akan tampil di Peta dan Popup Slider.
            </p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" @submit.prevent="saveChanges">

            <div class="space-y-12">

                {{-- BAGIAN 1: FOTO UTAMA (COVER) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <div class="md:col-span-5">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <x-icons.photo class="w-6 h-6 text-[#004a85]" />
                            Foto Sampul (Cover)
                        </h2>
                        <div class="prose prose-slate prose-sm mt-4 text-slate-500">
    <p class="text-md">
        Foto ini akan otomatis disesuaikan untuk tampilan Peta (Potrait) dan Popup (Landscape).
    </p>
    <div class="bg-blue-50 p-3 mt-2 rounded-lg border border-blue-100 text-blue-800 text-xs">
        <strong>Tips Penting:</strong> Pastikan objek utama (logo/produk) berada tepat di <strong>TENGAH FOTO</strong> agar tidak terpotong saat ditampilkan di berbagai ukuran layar.
    </div>
    <ul class="list-disc pl-4 space-y-1 mt-2 text-md">
        <li>Format: JPG, PNG, atau WEBP (Max 2MB)</li>
        <li>Rasio Wajib: 4:3 (Landscape)</li>
    </ul>
</div>
                    </div>

                    <div class="md:col-span-7">
                        {{-- Aspect Ratio disesuaikan dengan Popup (4:3) untuk konsistensi --}}
                        <div
                            class="relative w-full max-w-lg aspect-[4/3] rounded-2xl overflow-hidden group bg-slate-50 transition-all border-2 border-dashed border-slate-300 hover:border-[#004a85] hover:bg-blue-50/30 shadow-sm mx-auto md:mx-0">

                            <input type="file" class="hidden" x-ref="photo0" @change="handleFileSelect($event, 0)"
                                accept="image/*">

                            <div class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer p-6 text-center"
                                x-show="!photos[0].url" @click="$refs.photo0.click()">
                                <div
                                    class="w-16 h-16 rounded-full bg-white shadow-sm flex items-center justify-center mb-4 text-[#004a85] group-hover:scale-110 transition-transform">
                                    <x-icons.photo class="w-8 h-8" />
                                </div>
                                <h3 class="font-bold text-slate-700 text-lg">Upload Foto Sampul</h3>
                                <p class="text-sm text-slate-400 mt-1">Klik untuk memilih foto</p>
                            </div>

                            <template x-if="photos[0].url">
                                <div class="relative w-full h-full group">
                                    <img :src="photos[0].url" class="w-full h-full object-cover">
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
                                        Tampilan Depan
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
            Urutan Slider Berikutnya
        </h2>
        <p class="text-sm text-slate-500 mt-1">
             Gunakan rasio mendatar (4:3) agar tampilan slider tidak melompat atau terpotong berlebihan.
        </p>
        
        
        </div>
    </div>
    
    </div>

                    {{-- Horizontal Scroll / Grid Sequence --}}
                    {{-- Kita buat berjejer 4 kolom agar terlihat seperti "Urutan Film" --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-for="i in 4">
                            <div class="relative group">

                                {{-- Label Urutan --}}
                                <div class="mb-2 flex items-center justify-between px-1">
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Slide Ke-<span x-text="i+1"></span>
                                    </span>
                                </div>

                                {{-- Kotak Upload --}}
                                <div
                                    class="aspect-[4/3] relative rounded-2xl overflow-hidden bg-slate-50 border-2 border-dashed border-slate-300 hover:border-[#004a85] transition-all shadow-sm">

                                    <input type="file" class="hidden" 
                   :id="'slider-input-' + i" 
                   @change="handleFileSelect($event, i)" 
                   accept="image/*">

                                    {{-- Empty State --}}
                                    <div class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition-colors"
                x-show="!photos[i].url" 
                @click="document.getElementById('slider-input-' + i).click()">
                
                <x-icons.plus class="w-6 h-6 text-slate-300 group-hover:text-[#004a85] mb-1 transition-colors" />
                <span class="text-[10px] text-slate-400 group-hover:text-[#004a85]">Tambah</span>
            </div>

                                    {{-- Filled State --}}
                                    {{-- Filled State --}}
<template x-if="photos[i].url">
    <div class="relative w-full h-full">
        <img :src="photos[i].url" class="w-full h-full object-cover">

        {{-- Action Buttons Group (Edit & Delete) --}}
        <div class="absolute top-2 right-2 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity z-10">
            
            {{-- TOMBOL EDIT (BARU) --}}
            {{-- Menggunakan ID dinamis agar trigger input file bekerja --}}
            <button type="button" 
                @click="document.getElementById('slider-input-' + i).click()"
                class="p-1.5 bg-white text-slate-700 rounded-md shadow-sm hover:bg-slate-50 hover:text-[#004a85] transition border border-slate-200"
                title="Ganti Foto">
                <x-icons.pencil class="w-3.5 h-3.5" />
            </button>

            {{-- TOMBOL HAPUS --}}
            <button type="button" @click="removePhoto(i)"
                class="p-1.5 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 transition"
                title="Hapus Foto">
                <x-icons.trash class="w-3.5 h-3.5" />
            </button>
        </div>

        {{-- Number Overlay --}}
        <div class="absolute bottom-2 left-2 bg-black/60 backdrop-blur px-2 py-0.5 rounded text-[10px] font-mono text-white">
            #<span x-text="i+1"></span>
        </div>
    </div>
</template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            {{-- FLOATING ACTION BAR --}}
            <div
                class="fixed bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-40 w-[90%] md:w-auto flex justify-center">
                <div
                    class="bg-white p-1.5 rounded-full shadow-2xl border border-slate-100 flex items-center justify-between md:justify-center gap-2 pr-2 pl-2 ring-1 ring-slate-900/5 w-full md:w-auto">

                    {{-- TOMBOL BATAL --}}
                    <button type="button" @click="cancelAction"
                        class="px-4 py-2 md:px-5 md:py-2.5 rounded-full text-slate-500 font-bold hover:bg-slate-50 transition-colors text-xs tracking-wide flex-1 md:flex-none text-center">
                        Batal
                    </button>

                    {{-- TOMBOL SIMPAN --}}
                    <x-ui.button type="submit"
                        class="px-5 py-2 md:px-6 md:py-2.5 text-slate-900 rounded-full font-medium text-xs tracking-wide shadow-lg active:scale-95 flex items-center justify-center gap-2 flex-1 md:flex-none">
                        <x-icons.check class="w-4 h-4" />

                        {{-- Trik Text Responsif --}}
                        <span>
                            Simpan <span class="hidden sm:inline">Perubahan</span>
                        </span>
                    </x-ui.button>

                </div>
            </div>

        </form>
    </div>

    @push('scripts')
        <script>
            function photoManager() {
                return {
                    photos: [{
                            url: null
                        }, // Index 0 (Cover)
                        {
                            url: null
                        }, // Slide 2
                        {
                            url: null
                        }, // Slide 3
                        {
                            url: null
                        }, // Slide 4
                        {
                            url: null
                        } // Slide 5
                    ],

                    handleFileSelect(event, index) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.photos[index].url = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    removePhoto(index) {
                        this.photos[index].url = null;
                        if (index === 0) {
        // Cover masih pakai x-ref static
        if (this.$refs.photo0) this.$refs.photo0.value = '';
    } else {
        // Slider pakai ID dinamis
        const input = document.getElementById('slider-input-' + index);
        if (input) input.value = '';
    }
                    },

                    cancelAction() {
                        if (confirm('Batalkan perubahan?')) window.location.reload();
                    },

                    saveChanges() {
                        const btn = this.$el.querySelector('button[type="submit"] span');
                        const originalText = btn.innerText;
                        btn.innerText = 'Menyimpan...';
                        setTimeout(() => {
                            btn.innerText = originalText;
                            alert('Foto berhasil disimpan!');
                        }, 1000);
                    }
                }
            }
        </script>
    @endpush

</x-layouts.guest>
