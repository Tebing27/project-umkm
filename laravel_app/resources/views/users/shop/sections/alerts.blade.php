        {{-- Success Message --}}
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
                <button @click="show = false"
                    class="text-green-600 hover:bg-green-100 p-2 rounded-lg transition-colors">
                    <x-icons.ui-close class="w-5 h-5" />
                </button>
            </div>
        @endif

        {{-- Error Message --}}
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
