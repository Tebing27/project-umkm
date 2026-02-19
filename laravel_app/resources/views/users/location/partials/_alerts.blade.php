        {{-- 2. ALERTS --}}
        <div x-show="showSuccessAlert"
            class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2 border border-green-200">
            <x-icons.ui-check class="w-6 h-6 shrink-0" />
            <span x-text="successMessage"></span>
            <button @click="showSuccessAlert = false"
                class="ml-auto text-green-500 hover:text-green-700"><x-icons.ui-close class="w-5 h-5" /></button>
        </div>

        {{-- ALERT LOCKED (Desktop) --}}
        <div x-show="showLockedAlert" x-transition
            class="fixed top-4 left-4 right-4 z-[70] flex items-center gap-2 bg-red-50 text-red-600 px-4 py-3 rounded-lg border border-red-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;">
            <x-icons.auth-lock class="w-5 h-5 shrink-0" />
            <span class="text-sm font-medium">{{ translate('Mode Desktop Terkunci: Silakan masukkan koordinat manual atau gunakan HP.') }}</span>
            <button type="button" @click="showLockedAlert = false"
                class="ml-auto text-red-400 hover:text-red-600 focus:outline-none p-1">
                <x-icons.ui-close class="w-5 h-5" />
            </button>
        </div>

        {{-- [BARU] ALERT INSTRUCTION (Saat klik field disabled di Mobile) --}}
        <div x-show="showInstructionAlert" x-transition
            class="fixed top-4 left-4 right-4 z-[80] flex items-start gap-2 bg-orange-50 text-orange-700 px-4 py-3 rounded-lg border border-orange-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;">
            <x-icons.status-info class="w-5 h-5 shrink-0 mt-0.5" />
            <span class="text-sm font-medium">{{ translate('Maaf, untuk mencari lokasi silahkan pilih wilayah -> lalu atur lokasi') }}</span>
        </div>

        <div x-show="showNoChangeAlert"
            class="fixed top-4 left-4 right-4 z-[60] flex items-start gap-2 bg-blue-50 text-blue-600 px-4 py-3 rounded-lg border border-blue-200 shadow-lg md:static md:shadow-none md:mb-6 md:mx-0"
            style="display: none;" x-transition>
            <x-icons.status-info class="w-5 h-5 shrink-0" />
            <span class="text-sm">{{ translate('Lokasi belum berubah. Silakan atur koordinat.') }}</span>
        </div>
