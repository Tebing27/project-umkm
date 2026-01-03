<x-layouts.guest :title="translate('Pengaturan - UMKM Sasuma')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola akun & keamanan')">

    <div class="max-w-5xl mx-auto">

        {{-- Header Page --}}
        <div class="mb-12 pb-6 border-b border-slate-200">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ translate('Pengaturan Akun') }}</h2>
            <p class="text-slate-500 mt-2 text-lg">{{ translate('Kelola informasi profil dan keamanan akun Anda.') }}</p>
        </div>

        {{-- SECTION 1: INFORMASI PRIBADI --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-8">

            {{-- Kolom Kiri: Judul & Deskripsi Bagian --}}
            <div class="md:col-span-1">
                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ translate('Informasi Pribadi') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ translate('Perbarui informasi dasar profil Anda seperti nama, email, dan nomor telepon yang digunakan untuk login.') }}
                </p>
            </div>

            {{-- Kolom Kanan: Form --}}
            <div class="md:col-span-2">
                <form action="{{ route('users.setting.profile') }}" method="POST">
                @csrf
                    <div class="space-y-5 max-w-xl">

                        {{-- Nama Lengkap --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Nama Lengkap') }}</label>
                            <x-ui.input variant="soft" type="text" name="name" :value="old('name', $user->name)" placeholder="{{ translate('Nama Lengkap') }}" required>
                                <x-slot:icon>
                                    <x-icons.user class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Email') }}</label>
                            <x-ui.input variant="soft" type="email" name="email" :value="old('email', $user->email)" placeholder="{{ translate('Email Anda') }}" required>
                                <x-slot:icon>
                                    <x-icons.mail class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No HP --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Nomor Handphone') }}</label>
                            <x-ui.input variant="soft" type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" placeholder="{{ translate('Nomor HP') }}" required>
                                <x-slot:icon>
                                    <x-icons.phone class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                            @error('phone_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tempat, Tanggal Lahir --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Tempat, Tanggal Lahir') }}</label>
                            <div class="flex gap-3">
                                <div class="w-full">
                                    <x-ui.input variant="soft" type="text" name="place_of_birth" :value="old('place_of_birth', $user->place_of_birth)"
                                        placeholder="{{ translate('Jakarta') }}">
                                        <x-slot:icon>
                                            <x-icons.cake class="w-5 h-5" stroke-width="1.5" />
                                        </x-slot:icon>
                                    </x-ui.input>
                                    @error('place_of_birth')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full">
                                    <x-ui.input variant="soft" type="date" name="date_of_birth" :value="old('date_of_birth', $user->date_of_birth)"
                                        placeholder="2001/12/18">
                                        <x-slot:icon>
                                            <x-icons.calendar class="w-5 h-5" stroke-width="1.5" />
                                        </x-slot:icon>
                                    </x-ui.input>
                                    @error('date_of_birth')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Alamat Domisili') }}</label>
                            <x-ui.textarea variant="soft" type="text" name="domicile_address"
                                placeholder="{{ translate('Tuliskan Alamat Tempat Tinggal Saat Ini') }}">
                                {{ old('domicile_address', $user->domicile_address) }}
                                <x-slot:icon>
                                    <x-icons.location class="w-5 h-5" stroke-width="1.5" />
                                </x-slot:icon>
                            </x-ui.textarea>
                            @error('domicile_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol Action --}}
                        <div class="pt-2 flex justify-start">
                            <x-ui.button type="submit" class="rounded-lg font-medium">
                                {{ translate('Simpan Perubahan') }}
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- DIVIDER --}}
        <div class="border-t border-slate-200 my-12"></div>

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
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Password Saat Ini') }}</label>
                            <x-ui.input variant="soft" type="password" name="current_password" placeholder="••••••••" required>
                                <x-slot:icon>
                                    <x-icons.key class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Grid untuk Password Baru & Konfirmasi --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-slate-700">{{ translate('Password Baru') }}</label>
                                <x-ui.input variant="soft" type="password" name="password" placeholder="{{ translate('Minimal 8 karakter') }}" required />
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-slate-700">{{ translate('Konfirmasi') }}</label>
                                <x-ui.input variant="soft" type="password" name="password_confirmation" placeholder="{{ translate('Ulangi password') }}" required />
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

    </div>

</x-layouts.guest>
