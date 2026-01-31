        {{-- SECTION 2: KEAMANAN --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-8 mb-12">

            {{-- Kolom Kiri --}}
            <div class="md:col-span-1">
                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ translate('Password & Keamanan') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ translate('Pastikan akun Anda tetap aman dengan menggunakan password yang kuat. Jangan bagikan password kepada orang lain.') }}
                </p>
            </div>

            {{-- Kolom Kanan --}}
            <div class="md:col-span-2">
                <form action="{{ route('users.setting.password') }}" method="POST">
                    @csrf
                    <div class="space-y-5 max-w-xl">

                        {{-- Password Lama --}}
                        <div class="space-y-1.5" x-data="{ showCurrent: false }">
                            <label class="block text-sm md:text-base font-semibold text-slate-700">{{ translate('Password Saat Ini') }}</label>
                            <x-ui.input variant="soft" ::type="showCurrent ? 'text' : 'password'" name="current_password" placeholder="••••••••" required>
                                <x-slot:icon>
                                    <x-icons.auth-key class="w-5 h-5" />
                                </x-slot:icon>
                                <x-slot:suffix>
                                    <button type="button" @click="showCurrent = !showCurrent" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                        <x-icons.ui-eye x-show="!showCurrent" class="w-5 h-5" />
                                        <x-icons.ui-eye-off x-show="showCurrent" class="w-5 h-5" />
                                    </button>
                                </x-slot:suffix>
                            </x-ui.input>
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-5" x-data="{
                            password: '',
                            confirmation: '',
                            show: false,
                            showConfirm: false,
                            strength: 0,
                            checks: {
                                length: false,
                                lower: false,
                                upper: false,
                                number: false
                            },
                            checkStrength() {
                                this.checks.length = this.password.length >= 8;
                                this.checks.lower = /[a-z]/.test(this.password);
                                this.checks.upper = /[A-Z]/.test(this.password);
                                this.checks.number = /[0-9]/.test(this.password);
                                
                                this.strength = Object.values(this.checks).filter(Boolean).length;
                            },
                            get strengthLabel() {
                                if(this.strength <= 2) return '{{ translate('Lemah') }}';
                                if(this.strength < 4) return '{{ translate('Sedang') }}';
                                return '{{ translate('Kuat') }}';
                            },
                            get strengthColor() {
                                if(this.strength <= 2) return 'bg-red-500';
                                if(this.strength < 4) return 'bg-amber-500';
                                return 'bg-green-500';
                            },
                            get strengthText() {
                                 if(this.strength <= 2) return 'text-red-600';
                                if(this.strength < 4) return 'text-amber-600';
                                return 'text-green-600';
                            },
                            get confirmClass() {
                                if(this.confirmation && this.password !== this.confirmation) return 'border-red-500 focus:border-red-500';
                                if(this.confirmation && this.password === this.confirmation) return 'border-green-500 focus:border-green-500';
                                return '';
                            }
                        }">
                            <div class="space-y-1.5">
                                <label class="block text-sm md:text-base font-semibold text-slate-700">{{ translate('Password Baru') }}</label>
                                <div class="relative">
                                     <x-ui.input variant="soft" ::type="show ? 'text' : 'password'" name="password" x-model="password" @input="checkStrength()" placeholder="{{ translate('Minimal 8 karakter') }}">
                                         <x-slot:suffix>
                                            <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                                <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                                                <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                                            </button>
                                        </x-slot:suffix>
                                     </x-ui.input>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                {{-- Strength Meter --}}
                                <div class="mt-2 text-sm transition-all duration-300 bg-gray-50 p-3 rounded-lg border border-gray-200" x-show="password.length > 0" x-transition>
                                    <div class="flex justify-between mb-1">
                                        <span class="font-medium" :class="strengthText">{{ translate('Kekuatan:') }} <span x-text="strengthLabel"></span></span>
                                    </div>
                                    <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden mb-3">
                                        <div class="h-full transition-all duration-500" :class="strengthColor" :style="'width: ' + (strength * 25) + '%'"></div>
                                    </div>
                                    
                                    {{-- Recommendations Checklist --}}
                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-1 gap-x-2">
                                        <div class="flex items-center gap-1.5" :class="checks.length ? 'text-green-600' : 'text-slate-500'">
                                            <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.length" />
                                            <div class="w-3.5 h-3.5 rounded-full border border-gray-300" x-show="!checks.length"></div>
                                            <span>{{ translate('Min 8 karakter') }}</span>
                                        </div>
                                         <div class="flex items-center gap-1.5" :class="checks.lower ? 'text-green-600' : 'text-slate-500'">
                                            <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.lower" />
                                            <div class="w-3.5 h-3.5 rounded-full border border-gray-300" x-show="!checks.lower"></div>
                                            <span>{{ translate('Huruf kecil (a-z)') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5" :class="checks.upper ? 'text-green-600' : 'text-slate-500'">
                                            <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.upper" />
                                            <div class="w-3.5 h-3.5 rounded-full border border-gray-300" x-show="!checks.upper"></div>
                                            <span>{{ translate('Huruf besar (A-Z)') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5" :class="checks.number ? 'text-green-600' : 'text-slate-500'">
                                            <x-icons.ui-check class="w-3.5 h-3.5" x-show="checks.number" />
                                            <div class="w-3.5 h-3.5 rounded-full border border-gray-300" x-show="!checks.number"></div>
                                            <span>{{ translate('Angka (0-9)') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-sm md:text-base font-semibold text-slate-700">{{ translate('Konfirmasi') }}</label>
                                <x-ui.input variant="soft" ::type="showConfirm ? 'text' : 'password'" name="password_confirmation" x-model="confirmation" placeholder="{{ translate('Ulangi password') }}" 
                                    x-bind:class="confirmClass">
                                     <x-slot:suffix>
                                        <button type="button" @click="showConfirm = !showConfirm" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                            <x-icons.ui-eye x-show="!showConfirm" class="w-5 h-5" />
                                            <x-icons.ui-eye-off x-show="showConfirm" class="w-5 h-5" />
                                        </button>
                                    </x-slot:suffix>
                                </x-ui.input>
                                <p x-show="confirmation && password !== confirmation" class="text-red-500 text-xs mt-1">{{ translate('Password tidak cocok') }}</p>
                            </div>
                        </div>

                        {{-- Tombol Action --}}
                        <div class="pt-2 flex justify-start">
                            <x-ui.button type="submit" class="rounded-lg">
                                {{ translate('Update Password') }}
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
