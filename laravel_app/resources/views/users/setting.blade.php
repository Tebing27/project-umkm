<x-layouts.guest title="Pengaturan - UMKM Sasuma" header-title="Pengaturan" header-subtitle="Kelola akun & keamanan">

    <div class="max-w-5xl mx-auto">

        {{-- Header Page --}}
        <div class="mb-12 pb-6 border-b border-slate-200">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Akun</h2>
            <p class="text-slate-500 mt-2 text-lg">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>

        {{-- SECTION 1: INFORMASI PRIBADI --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-8">

            {{-- Kolom Kiri: Judul & Deskripsi Bagian --}}
            <div class="md:col-span-1">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Informasi Pribadi</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Perbarui informasi dasar profil Anda seperti nama, email, dan nomor telepon yang digunakan untuk
                    login.
                </p>
            </div>

            {{-- Kolom Kanan: Form --}}
            <div class="md:col-span-2">
                <form action="#" method="POST">
                    <div class="space-y-5 max-w-xl">

                        {{-- Nama Lengkap --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                            <x-ui.input variant="soft" type="text" value="Budi Santoso" placeholder="Nama Lengkap">
                                <x-slot:icon>
                                    <x-icons.user class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Email</label>
                            <x-ui.input variant="soft" type="email" value="budi@sasuma.com" placeholder="Email Anda">
                                <x-slot:icon>
                                    <x-icons.mail class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                        </div>

                        {{-- No HP --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Nomor Handphone</label>
                            <x-ui.input variant="soft" type="text" value="08123456789" placeholder="Nomor HP">
                                <x-slot:icon>
                                    <x-icons.phone class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                        </div>

                        {{-- Tempat, Tanggal Lahir --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Tempat, Tanggal Lahir</label>
                            <div class="flex gap-3">
                                <x-ui.input variant="soft" type="text" name="place_of_birth" value=""
                                    placeholder="Jakarta">
                                    <x-slot:icon>
                                        <x-icons.cake class="w-5 h-5" stroke-width="1.5" />
                                    </x-slot:icon>
                                </x-ui.input>

                                <x-ui.input variant="soft" type="text" name="date_of_birth" value=""
                                    onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="2001/12/18">
                                    <x-slot:icon>
                                        <x-icons.calendar class="w-5 h-5" stroke-width="1.5" />
                                    </x-slot:icon>
                                </x-ui.input>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Alamat Domisili</label>
                            <x-ui.textarea variant="soft" type="text" name="domicile_address"
                                placeholder="Tuliskan Alamat Tempat Tinggal Saat Ini">
                                {{ old('domicile_address') }}
                                <x-slot:icon>
                                    <x-icons.location class="w-5 h-5" stroke-width="1.5" />
                                </x-slot:icon>
                            </x-ui.textarea>
                        </div>

                        {{-- Tombol Action --}}
                        <div class="pt-2 flex justify-start">
                            <x-ui.button type="submit" class="rounded-lg font-medium">
                                Simpan Perubahan
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
                <h3 class="text-lg font-bold text-slate-900 mb-2">Password & Keamanan</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Pastikan akun Anda tetap aman dengan menggunakan password yang kuat. Jangan bagikan password kepada
                    orang lain.
                </p>
            </div>

            {{-- Kolom Kanan --}}
            <div class="md:col-span-2">
                <form action="#" method="POST">
                    <div class="space-y-5 max-w-xl">

                        {{-- Password Lama --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Password Saat Ini</label>
                            <x-ui.input variant="soft" type="password" placeholder="••••••••">
                                <x-slot:icon>
                                    <x-icons.key class="w-5 h-5" />
                                </x-slot:icon>
                            </x-ui.input>
                        </div>

                        {{-- Grid untuk Password Baru & Konfirmasi --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-slate-700">Password Baru</label>
                                <x-ui.input variant="soft" type="password" placeholder="Minimal 8 karakter" />
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-slate-700">Konfirmasi</label>
                                <x-ui.input variant="soft" type="password" placeholder="Ulangi password" />
                            </div>
                        </div>

                        {{-- Tombol Action --}}
                        <div class="pt-2 flex justify-start">
                            <x-ui.button type="submit" class="rounded-lg font-medium">
                                Update Password
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-layouts.guest>
