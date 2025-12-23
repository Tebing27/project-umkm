<div x-show="zoomImage" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-md p-4 md:p-8"
    style="display: none;" @click="closeZoom()">

    <div class="relative w-full h-full flex items-center justify-center" @click.stop>
        <img :src="zoomImage"
            class="max-w-full max-h-full object-contain rounded-lg shadow-2xl animate-in zoom-in-95 duration-300">

        <button type="button"
            class="absolute top-4 right-4 p-3 bg-white/10 hover:bg-white/20 text-white rounded-full transition-all backdrop-blur-sm"
            @click="closeZoom()">
            <x-icons.cross class="w-6 h-6" />
        </button>
    </div>
</div>
