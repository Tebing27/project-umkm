        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ translate('Kelola Toko') }}</h2>
                <p class="text-slate-500 mt-2 text-base font-medium">
                    {{ translate('Atur produk, stok, dan etalase toko Anda.') }}</p>
            </div>

            {{-- Tombol Edit Toko (Desktop) --}}
            <x-ui.button href="/users/edit-toko" variant="shiny" size="xl"
                class="w-full md:w-auto flex items-center justify-center gap-2.5">
                <div class="bg-white/20 p-1 rounded-md group-hover:rotate-90 transition-transform duration-300">
                    <x-icons.ui-edit class="text-slate-900" />
                </div>
                <span class="text-slate-900 font-medium">{{ translate('Edit Data Toko') }}</span>
            </x-ui.button>
        </div>
