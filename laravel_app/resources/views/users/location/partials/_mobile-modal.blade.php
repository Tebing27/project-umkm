        {{-- 4. MOBILE MODAL (MODAL TETAP SAMA) --}}
        <div x-show="isModalOpen" style="display: none;"
            class="fixed inset-0 z-[100] bg-white flex flex-col w-full h-[100dvh]"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-full">

            <div
                class="px-4 py-3 border-b border-gray-200 flex items-center justify-between bg-white shadow-sm z-10 shrink-0 h-16">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">{{ translate('Pilih Lokasi') }}</h3>
                    <p class="text-xs text-slate-500">{{ translate('Geser peta ke titik usaha Anda') }}</p>
                </div>
                <x-ui.button type="button" @click="closeMobileModal()"
                    variant="ghost-circle" size="compact" class="!p-2 text-slate-500">
                    <x-icons.ui-close class="w-6 h-6" />
                </x-ui.button>
            </div>

            <div class="relative flex-1 w-full bg-gray-100">
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[500] pointer-events-none pb-8">
                    <x-icons.map-pin class="w-8 h-8 text-red-600 drop-shadow-md" />
                </div>
                <div class="absolute bottom-24 right-4 z-[400]">
                    <x-ui.button type="button" @click="locateMeMobile()"
                        variant="circle-white-lg" size="compact" class="!p-3">
                        <x-icons.status-loading x-show="geoLoading" class="w-6 h-6 animate-spin text-blue-600" />
                        <x-icons.map-pin x-show="!geoLoading" class="w-6 h-6" />
                    </x-ui.button>
                </div>
                <div id="mobileMap" class="w-full h-full z-0"></div>
                
                {{-- [BARU] Top Floating Search Bar (Mobile) --}}
                <div class="absolute top-4 left-4 right-4 z-[550]">
                     <div class="relative bg-white rounded-xl shadow-lg border border-gray-200">
                         <div class="flex items-center px-4 py-3">
                             <x-icons.map-pin-search class="w-5 h-5 text-slate-400 shrink-0" />
                             {{-- Input Search --}}
                            <x-ui.input type="text"
                                variant="transparent"
                                x-model="tempAddress"
                                @input.debounce.500ms="updateMobileAddressFromInput()"
                                placeholder="{{ translate('Cari jalan, tempat, atau alamat...') }}"
                                class="text-sm font-medium text-slate-700 placeholder-gray-400 focus:outline-none truncate overflow-hidden whitespace-nowrap" />
                             
                             {{-- Clear Button --}}
                             <x-ui.button type="button" x-show="tempAddress" @click="tempAddress = ''; updateMobileAddressFromInput()" variant="link" size="icon-link" class="ml-2 text-slate-400 hover:text-slate-600 no-underline hover:no-underline border-none">
                                 <x-icons.ui-close class="w-5 h-5" />
                             </x-ui.button>
                         </div>
                         
                         {{-- Loading Indicator --}}
                         <div x-show="isLoadingAddress" class="h-1 bg-blue-100 rounded-b-xl overflow-hidden">
                             <div class="h-full bg-blue-500 animate-[progress_1s_ease-in-out_infinite] w-1/3"></div>
                         </div>
                     </div>

                    {{-- AUTOCOMPLETE DROPDOWN (MOBILE) --}}
                    <div x-show="searchResults.length > 0 && showSuggestions" 
                        @click.outside="showSuggestions = false"
                        x-transition.opacity
                        class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-xl max-h-60 overflow-y-auto w-full z-[600]">
                        <ul>
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <li @click="!result.isError && selectLocation(result, true)" 
                                            class="px-4 py-3 border-b border-gray-100 last:border-0 transition-colors bg-white flex flex-col items-start text-left"
                                            :class="result.isError ? 'cursor-default bg-gray-50' : 'cursor-pointer hover:bg-gray-50'">
                                            <div class="font-bold text-slate-800 text-sm" x-text="result.title"></div>
                                            <div class="text-xs text-slate-500 mt-0.5" x-text="result.address"></div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                    {{-- Region Error Alert (Mobile Top) --}}
                </div>

                {{-- Update Map Center Indicator (to differentiate from user pin if needed, or keep existing) --}}
                {{-- Existing center pin is fine --}}

            </div>

            {{-- Button Confirm Floating at Bottom --}}
            <div class="absolute bottom-6 left-4 right-4 z-[400] flex flex-col gap-3">

              <div x-show="showRegionErrorAlert " x-transition
            class="fixed bottom-16 left-4 right-4 md:left-1/2 md:-translate-x-1/2 md:max-w-xl z-[150] bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-2xl drop-shadow-lg"
            style="display: none;">
            <div class="flex items-start">
                <div>
                    <p class="font-bold text-red-800">{{ translate('Perhatian') }}</p>
                    <p class="text-sm mt-1 text-red-700 leading-snug" x-text="regionErrorMessage"></p>
                </div>
                <x-ui.button type="button" @click="showRegionErrorAlert = false" variant="ghost" size="icon-link"
                    class="ml-auto text-red-400 hover:text-red-800 font-bold p-1">
                    <x-icons.ui-close />
                </x-ui.button>
            </div>
        </div>
                 
                <x-ui.button type="button" @click="confirmMobileLocation()"
        class="w-full py-3.5 rounded-lg active:scale-95 transition-transform shadow-xl"
        ::class="showRegionErrorAlert ? 'opacity-50 cursor-not-allowed' : ''"
        x-bind:disabled="showRegionErrorAlert"> 
        {{-- Disabled tombol jika ada error --}}
        {{ translate('Pilih Lokasi Ini') }}
    </x-ui.button>
            </div>
        </div>
