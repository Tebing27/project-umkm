        {{-- === FAB EDIT TOKO (MOBILE ONLY) === --}}
        <div x-show="showFab" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-90" class="lg:hidden fixed bottom-6 right-6 z-40"
            x-cloak>

            <x-ui.button href="/users/edit-toko" variant="fab" size="fab"
                class="shadow-2xl shadow-blue-900/40">
                <x-icons.ui-edit class="w-6 h-6" />
            </x-ui.button>
        </div>
