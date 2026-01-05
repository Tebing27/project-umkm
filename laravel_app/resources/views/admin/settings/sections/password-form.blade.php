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
        <form action="{{ route('admin.setting.password') }}" method="POST">
            @csrf
            <div class="space-y-5 max-w-xl">
                {{-- Password Lama --}}
                <div class="space-y-1.5" x-data="{ show: false }">
                    <label class="block text-sm font-semibold text-slate-700">{{ translate('Password Saat Ini') }}</label>
                    <x-ui.input variant="soft" ::type="show ? 'text' : 'password'" name="current_password" placeholder="••••••••">
                        <x-slot:icon>
                            <x-icons.auth-key class="w-5 h-5" />
                        </x-slot:icon>
                        <x-slot:suffix>
                             <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                                <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                            </button>
                        </x-slot:suffix>
                    </x-ui.input>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Grid untuk Password Baru & Konfirmasi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5" x-data="{ show: false }">
                        <label class="block text-sm font-semibold text-slate-700">{{ translate('Password Baru') }}</label>
                        <x-ui.input variant="soft" ::type="show ? 'text' : 'password'" name="password" placeholder="{{ translate('Minimal 8 karakter') }}">
                            <x-slot:suffix>
                                <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                                    <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                                </button>
                            </x-slot:suffix>
                        </x-ui.input>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5" x-data="{ show: false }">
                        <label class="block text-sm font-semibold text-slate-700">{{ translate('Konfirmasi') }}</label>
                        <x-ui.input variant="soft" ::type="show ? 'text' : 'password'" name="password_confirmation" placeholder="{{ translate('Ulangi password') }}">
                            <x-slot:suffix>
                                <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <x-icons.ui-eye x-show="!show" class="w-5 h-5" />
                                    <x-icons.ui-eye-off x-show="show" class="w-5 h-5" />
                                </button>
                            </x-slot:suffix>
                        </x-ui.input>
                    </div>
                </div>

                {{-- Tombol Action --}}
                <div class="pt-2 flex justify-start">
                    <x-ui.button type="submit" class="rounded-lg font-medium">
                        {{ translate('Update Password') }}
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>
