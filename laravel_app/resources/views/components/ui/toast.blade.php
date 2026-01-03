<div x-show="toast.show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" {{-- Kelas Responsif Di Sini: --}}
    class="fixed z-[60] 
       top-4 left-4 right-4              {{-- Mobile: Nempel atas, lebar full minus margin --}}
       md:top-24 md:right-6 md:left-auto {{-- Desktop: Pojok kanan atas --}}
       md:w-full md:max-w-sm             {{-- Desktop: Lebar terbatas --}}
       bg-white shadow-2xl rounded-xl pointer-events-auto ring-1 ring-black/5 overflow-hidden border-l-[6px]"
    :class="{
        'border-green-500': toast.type === 'success',
        'border-blue-500': toast.type === 'info',
        'border-red-500': toast.type === 'error'
    }"
    style="display: none;">

    <div class="p-4 flex items-start gap-4">
        <div class="flex-shrink-0">
            <div x-show="toast.type === 'success'" class="p-2 bg-green-50 rounded-full text-green-500">
                <x-icons.check class="w-5 h-5" />
            </div>
            <div x-show="toast.type === 'info'" class="p-2 bg-blue-50 rounded-full text-blue-500">
                <x-icons.info-circle class="w-5 h-5" />
            </div>
            <div x-show="toast.type === 'error'" class="p-2 bg-red-50 rounded-full text-red-500">
                <x-icons.exclamation-circle class="w-5 h-5" />
            </div>
        </div>
        <div class="flex-1 pt-1">
            <p class="text-sm font-bold text-gray-900" x-text="toast.title"></p>
            <p class="mt-1 text-sm text-gray-600 leading-relaxed" x-text="toast.message"></p>
        </div>
        <button @click="toast.show = false" type="button"
            class="text-gray-400 hover:text-gray-600 transition-colors">
            <x-icons.cross class="w-5 h-5" />
        </button>
    </div>
</div>
