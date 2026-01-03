<x-layouts.admin :title="translate('Setting Admin - UMKM Sasuma Admin')" :header-title="translate('Pengaturan')" :header-subtitle="translate('Kelola Akun & Sistem')">
    <div class="max-w-5xl mx-auto">

        {{-- Header Page --}}
        <div class="mb-12 pb-6 border-b border-slate-200">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ translate('Pengaturan Akun') }}</h2>
            <p class="text-slate-500 mt-2 text-lg">{{ translate('Kelola informasi profil dan keamanan akun Anda.') }}</p>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
                <x-icons.check class="w-5 h-5 shrink-0" />
                <p>{{ session('success') }}</p>
            </div>
        @endif

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
                <form action="{{ route('admin.setting.profile') }}" method="POST">
                    @csrf
                    <div class="space-y-5 max-w-xl">

                        {{-- Nama Lengkap --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Nama Lengkap') }}</label>
                            <x-ui.input variant="soft" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="{{ translate('Nama Lengkap') }}">
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
                            <x-ui.input variant="soft" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ translate('Email Anda') }}">
                                <x-slot:icon>
                                    <x-icons.mail class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                            @error('email')
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
                <form action="{{ route('admin.setting.password') }}" method="POST">
                    @csrf
                    <div class="space-y-5 max-w-xl">

                        {{-- Password Lama --}}
                        <div class="space-y-1.5" x-data="{ show: false }">
                            <label class="block text-sm font-semibold text-slate-700">{{ translate('Password Saat Ini') }}</label>
                            <x-ui.input variant="soft" ::type="show ? 'text' : 'password'" name="current_password" placeholder="••••••••">
                                <x-slot:icon>
                                    <x-icons.key class="w-5 h-5" />
                                </x-slot:icon>
                                <x-slot:suffix>
                                     <button type="button" @click="show = !show" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                                        <x-icons.eye x-show="!show" class="w-5 h-5" />
                                        <x-icons.eye-off x-show="show" class="w-5 h-5" />
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
                                            <x-icons.eye x-show="!show" class="w-5 h-5" />
                                            <x-icons.eye-off x-show="show" class="w-5 h-5" />
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
                                            <x-icons.eye x-show="!show" class="w-5 h-5" />
                                            <x-icons.eye-off x-show="show" class="w-5 h-5" />
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

    </div>

</x-layouts.admin>
