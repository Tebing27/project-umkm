<div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-8">
    <div class="md:col-span-1">
        <h3 class="text-lg font-bold text-slate-900 mb-2">{{ translate('Informasi Pribadi') }}</h3>
        <p class="text-slate-500 text-sm leading-relaxed">
            {{ translate('Perbarui informasi dasar profil Anda seperti nama, email, dan nomor telepon yang digunakan untuk login.') }}
        </p>
    </div>

    <div class="md:col-span-2">
        <form action="{{ route('admin.setting.profile') }}" method="POST">
            @csrf
            <div class="space-y-5 max-w-xl">
                {{-- Nama Lengkap --}}
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-slate-700">{{ translate('Nama Lengkap') }}</label>
                    <x-ui.input variant="soft" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="{{ translate('Nama Lengkap') }}">
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
                    <x-ui.input variant="soft" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ translate('Email Anda') }}">
                        <x-slot:icon>
                            <x-icons.contact-mail class="w-5 h-5" />
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
