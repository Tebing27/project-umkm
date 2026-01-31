                {{-- KOLOM KIRI: MAP PREVIEW --}}
                <div class="space-y-4">
                    <div class="relative group">
                        <div class="mb-2 flex justify-between items-center" x-show="isMobile">
                            <label class="text-sm font-bold text-slate-700">{{ translate('Peta Lokasi') }}</label>
                            <span class="text-xs text-slate-600"
                                x-text="address && address !== '{{ translate('Memuat alamat...') }}' ? '{{ translate('Lokasi terpilih') }}' : '{{ translate('Belum diatur') }}'"></span>
                        </div>
                        <div
                            class="relative w-full h-64 lg:h-96 rounded-xl border border-gray-300 shadow-sm overflow-hidden bg-gray-100">
                            <div id="desktopMap" class="w-full h-full z-0"></div>
                            <div x-show="isLaptop" @click="triggerLockedAlert()"
                                class="absolute inset-0 z-[10] bg-transparent cursor-not-allowed">
                            </div>
                            <div x-show="isMobile"
                                class="absolute inset-0 z-[10] cursor-pointer flex items-center justify-center bg-black/2 hover:bg-black/10 transition-colors"
                                @click="openMobileModal()">
                                <div
                                    class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-md text-sm font-bold text-slate-800 flex items-center gap-2">
                                    <x-icons.map-folded class="w-4 h-4" />
                                    <span x-text="hasChanged ? '{{ translate('Ubah Lokasi') }}' : '{{ translate('Atur Lokasi') }}'"></span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500 text-center lg:text-left">
                            <span x-show="isLaptop">{{ translate('Peta ini hanya pratinjau. Masukkan koordinat di kolom kanan.') }}</span>
                            <span x-show="isMobile">{{ translate('Ketuk peta untuk mengubah lokasi lebih akurat.') }}</span>
                        </p>
                    </div>
                </div>
