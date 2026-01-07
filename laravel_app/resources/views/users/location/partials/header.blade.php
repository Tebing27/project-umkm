        {{-- 1. HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">{{ translate('Titik Lokasi UMKM') }}</h2>

            <div x-show="isLaptop"
                class="bg-[#FFC107] text-black px-4 py-3 rounded-lg text-sm font-medium shadow-sm max-w-md flex items-start gap-2">
                <x-icons.status-info class="w-5 h-5 mt-0.5 shrink-0" />
                <span>{{ translate('Saat ini perangkat Anda menggunakan laptop sehingga masukkan koordinat manual. Peta akan menyesuaikan otomatis.') }}</span>
            </div>
        </div>
