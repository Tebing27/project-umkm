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
                                    <x-icons.data-user class="w-5 h-5" />
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
                                    <x-icons.contact-mail class="w-5 h-5" />
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
                                    <x-icons.contact-phone class="w-5 h-5" />
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
                                            <x-icons.data-cake class="w-5 h-5" stroke-width="1.5" />
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
                                            <x-icons.data-calendar class="w-5 h-5" stroke-width="1.5" />
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
                                    <x-icons.map-pin class="w-5 h-5" stroke-width="1.5" />
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
