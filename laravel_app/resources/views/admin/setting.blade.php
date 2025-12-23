<x-layouts.admin title="Setting Admin - UMKM Sasuma Admin" header-title="Pengaturan" header-subtitle="Kelola Akun & Sistem">
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

</x-layouts.admin>
