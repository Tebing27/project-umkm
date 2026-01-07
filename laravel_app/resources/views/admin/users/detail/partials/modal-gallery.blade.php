<div x-show="galleryOpen" 
     style="display: none;" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-sm flex items-center justify-center"
     x-cloak>

    {{-- Tombol Close (Pojok Kanan Atas) --}}
    <button @click="galleryOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white z-50 p-2 transition-colors">
        <x-icons.ui-close class="h-10 w-10" />
    </button>

    {{-- Tombol Prev (Kiri) --}}
    <button @click.stop="prevImage()" class="absolute left-4 md:left-8 text-white/70 hover:text-white hover:bg-white/10 p-3 rounded-full transition-all z-50">
        <x-icons.ui-arrow-left class="h-10 w-10 md:h-12 md:w-12" />
    </button>

    {{-- Area Gambar Utama --}}
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 md:p-12" @click.outside="galleryOpen = false">
        
        {{-- Gambar --}}
        <img :src="images[activeImage]" 
             class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-50 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
        
        {{-- Indikator Halaman (Contoh: 1 / 4) --}}
        <div class="mt-4 text-white/90 font-medium bg-white/10 px-6 py-2 rounded-full text-sm backdrop-blur-md border border-white/10">
            <span x-text="activeImage + 1"></span> / <span x-text="images.length"></span>
        </div>
    </div>

    {{-- Tombol Next (Kanan) --}}
    <button @click.stop="nextImage()" class="absolute right-4 md:right-8 text-white/70 hover:text-white hover:bg-white/10 p-3 rounded-full transition-all z-50">
        <x-icons.ui-arrow-left class="h-10 w-10 md:h-12 md:w-12 rotate-180" />
    </button>
</div>
