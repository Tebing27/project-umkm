                {{-- KOLOM KANAN: INPUT FIELDS --}}
                <div class="space-y-6 flex flex-col justify-center">

                    {{-- 1. WILAYAH --}}
                    <div class="order-1">
                        <label class="block text-base font-semibold text-gray-900 mb-2">
                            {{ translate('Wilayah / Kelurahan') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{
                            open: false,
                            selectedId: '{{ $initialId }}',
                            selectedName: '{{ $initialName }}',
                            select(id, name) {
                                this.selectedId = id;
                                this.selectedName = name;
                                this.open = false;
                                $dispatch('region-changed', { name: name });
                            }
                        }" @click.outside="open = false"
                            @region-changed.window="handleRegionChange($event.detail.name)">
                            <input type="hidden" name="region_id" x-model="selectedId">
                            <button type="button" @click="open = !open"
                                class="group w-full cursor-pointer bg-gray-50 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 py-2.5 px-4 flex items-center justify-between transition-all">
                                <div class="flex items-center gap-3">
                                    <x-icons.map-folded
                                        class="w-5 h-5 text-slate-500 transition-colors duration-200 group-focus:text-blue-600" />
                                    <span class="text-sm md:text-base font-normal truncate"
                                        :class="selectedId ? 'text-gray-900' : 'text-gray-500'"
                                        x-text="selectedName"></span>
                                </div>
                                <x-icons.ui-chevron-down
                                    class="w-4 h-4 text-gray-400 transition-transform duration-200 group-focus:text-blue-600"
                                    x-bind:class="open ? 'rotate-180' : ''" />
                            </button>
                            <div x-show="open" x-transition.origin.top x-cloak
                                class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 z-50 overflow-hidden max-h-60 overflow-y-auto">
                                <div @click="select('', '{{ translate('Pilih Wilayah') }}')"
                                    class="px-5 py-3 text-sm md:text-base font-medium text-slate-600 hover:bg-slate-50 cursor-pointer flex items-center justify-between transition-colors border-b border-slate-50">
                                    <span>{{ translate('Pilih Wilayah') }}</span>
                                </div>
                                @foreach ($regions as $region)
                                    <div @click="select('{{ $region->id }}', '{{ $region->name }}')"
                                        class="px-5 py-3 text-sm md:text-base font-medium cursor-pointer flex items-center justify-between transition-colors hover:bg-slate-50"
                                        :class="selectedId == '{{ $region->id }}' ? 'text-blue-600 bg-blue-50/50' :
                                            'text-slate-600'">
                                        <span class="truncate">{{ $region->name }}</span>
                                        <x-icons.ui-check x-show="selectedId == '{{ $region->id }}'"
                                            class="w-4 h-4 text-blue-600" />
                                    </div>
                                @endforeach
                            </div>
                            @error('region_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- 2. ALAMAT --}}
                    <div class="order-2 lg:order-4">
                        <label class="block mb-2 text-base font-semibold text-gray-900">{{ translate('Alamat Usaha') }}</label>
                        <div class="relative">
                            <x-ui.textarea name="address" rows="3" variant="soft" x-model="address"
                                @input.debounce.500ms="updateAddressFromInput()" x-bind:readonly="isMobile"
                                {{-- [UBAH] Tambahkan trigger alert saat diklik di mode mobile --}} @click="if(isMobile) triggerInstructionAlert()"
                                placeholder="{{ translate('Ketik alamat manual (Contoh: Jl. Sudirman No. 1)...') }}" class="text-sm"
                                ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                            </x-ui.textarea>
                            
                            {{-- AUTOCOMPLETE DROPDOWN (DESKTOP) --}}
                            <div x-show="searchResults.length > 0 && showSuggestions && !isMobile" 
                                @click.outside="showSuggestions = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute top-full left-0 right-0 z-50 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <ul>
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <li @click="selectLocation(result)" 
                                            class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0 transition-colors">
                                            <div class="font-bold text-gray-800 text-sm" x-text="result.title"></div>
                                            <div class="text-xs text-gray-500 mt-0.5" x-text="result.address"></div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
                            <span x-show="isLoadingAddress" class="text-blue-600 flex items-center gap-1">
                                <x-icons.status-loading class="w-3 h-3 animate-spin" /> {{ translate('Mencari koordinat...') }}
                            </span>
                            <span x-show="!isLoadingAddress" class="hidden md:block">{{ translate('Ketik alamat untuk update lokasi otomatis.') }}</span>
                        </div>
                    </div>

                    {{-- 3. LATITUDE --}}
                    <div class="order-3 lg:order-2">
                        <label class="block mb-2 text-base font-semibold text-gray-900">{{ translate('Latitude') }}</label>
                        {{-- [UBAH] Tambahkan click event untuk alert --}}
                        <div @click="if(isMobile) triggerInstructionAlert()">
                            <x-ui.input variant="soft" type="text" name="latitude" x-model="lat"
                                x-bind:readonly="isMobile" @input.debounce.800ms="updateMapFromInput()"
                                placeholder="-6.xxxxx" ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                                <x-slot:icon><x-icons.map-folded class="w-5 h-5" /></x-slot:icon>
                            </x-ui.input>
                        </div>
                    </div>

                    {{-- 4. LONGITUDE --}}
                    <div class="order-4 lg:order-3">
                        <label class="block mb-2 text-base font-semibold text-gray-900">{{ translate('Longitude') }}</label>
                        {{-- [UBAH] Tambahkan click event untuk alert --}}
                        <div @click="if(isMobile) triggerInstructionAlert()">
                            <x-ui.input variant="soft" type="text" name="longitude" x-model="lng"
                                x-bind:readonly="isMobile" @input.debounce.800ms="updateMapFromInput()"
                                placeholder="106.xxxxx" ::class="isMobile ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'">
                                <x-slot:icon><x-icons.map-pin class="w-5 h-5" /></x-slot:icon>
                            </x-ui.input>
                        </div>
                    </div>

                    {{-- 5. BUTTON --}}
                    <div class="pt-4 flex justify-center lg:justify-start order-5">
                        <div class="w-full lg:w-auto relative" @click="if(!isLoadingAddress) triggerNoChangeAlert()">
                            <x-ui.button type="submit" variant="default"
                                class="w-full lg:w-auto px-8 py-3 rounded-lg shadow-md transition-all flex items-center justify-center gap-2"
                                ::class="(!hasChanged || isLoadingAddress) ?
                                'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:scale-105 active:scale-95'" x-bind:disabled="!hasChanged || isLoadingAddress">
                                <template x-if="isLoadingAddress">
                                    <div class="flex items-center gap-2">
                                        <x-icons.status-loading class="w-5 h-5 animate-spin" />
                                        <span>{{ translate('Mencari...') }}</span>
                                    </div>
                                </template>
                                <template x-if="!isLoadingAddress">
                                    <div class="flex items-center gap-2 text-base font-medium">
                                        {{ translate('Simpan Lokasi') }}
                                    </div>
                                </template>
                            </x-ui.button>
                        </div>
                    </div>

                </div>
