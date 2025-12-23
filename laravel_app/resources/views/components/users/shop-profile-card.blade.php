<div
    class="bg-white rounded-3xl p-6 md:p-8 shadow-xl shadow-slate-200/60 border border-slate-100 mb-12 relative overflow-hidden group">
    {{-- Decor --}}
    <div
        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-yellow-100/50 to-orange-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
    </div>

    <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-8">
        {{-- Foto Profil --}}
        <div class="relative shrink-0 group-hover:scale-[1.02] transition-transform duration-500">
            <div
                class="w-28 h-28 md:w-36 md:h-36 rounded-full p-1 bg-white shadow-lg border border-slate-100 overflow-hidden">
                {{-- GANTI GAMBAR DI SINI --}}
                <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=300&q=80"
                    class="w-full h-full rounded-full object-cover" alt="Foto Toko">
            </div>

        </div>

        {{-- Info Text --}}
        <div class="flex-1 text-left space-y-5">

            {{-- Header Info --}}
            <div>
                <p class="text-slate-500 font-medium text-sm mb-1">Pemilik: <span class="text-slate-900 font-bold">Budi
                        Santoso</span></p>
                <div class="flex flex-row flex-wrap items-center gap-3 justify-start">
                    <h3 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight break-words max-w-full">
                        Tebing UMKM</h3>
                    <x-ui.badge class="px-2.5 py-1">Kuliner</x-ui.badge>
                </div>
            </div>

            {{-- Alamat (Lokasi) --}}
            <div class="flex items-start gap-1 md:gap-3 text-slate-600 justify-start">
                <x-icons.location class="w-5 h-5 shrink-0" />
                <span class="font-medium">Jl. Merpati asasasasasasasasas No. 45, RT 005/RW 012</span>
            </div>

            {{-- Divider --}}
            <div class="w-full h-px bg-slate-100"></div>

            {{-- Detail Lainnya --}}
            <div class="space-y-4">
                {{-- Izin Usaha --}}
                <div>
                    <h4 class="text-sm font-bold text-slate-900 mb-1">Izin Usaha</h4>
                    <p class="text-slate-600">NIB: 1234567890</p>
                </div>

                {{-- Kontak & Sosmed --}}
                <div class="flex flex-wrap items-center gap-x-6 gap-y-3 justify-start">
                    {{-- IG --}}
                    <a href="#" class="flex items-center gap-2">
                        <x-icons.instagram class="text-red-500" />
                        <span class="font-medium text-slate-900">@umkm</span>
                    </a>
                    {{-- Tiktok --}}
                    <a href="#" class="flex items-center gap-2">
                        <x-icons.tiktok class="text-slate-900" />
                        <span class="font-medium text-slate-900">@umkm</span>
                    </a>
                    {{-- FB --}}
                    <a href="#" class="flex items-center gap-2">
                        <x-icons.facebook class="text-[#1877F2]" />
                        <span class="font-medium text-slate-900">Tebing UMKM</span>
                    </a>
                    {{-- Website --}}
                    <a href="#" class="flex items-center gap-2">
                        <x-icons.globe class="text-slate-900" />
                        <span class="font-medium text-slate-900">https://google.com</span>
                    </a>
                </div>
            </div>

            {{-- Divider --}}
            <div class="w-full h-px bg-slate-100"></div>

            {{-- Deskripsi --}}
            <div>
                <p class="text-slate-500 leading-relaxed">
                    Menyediakan berbagai macam makanan ringan dan berat khas daerah dengan cita rasa
                    otentik
                    dan harga terjangkau. Kami berkomitmen untuk memberikan produk terbaik bagi
                    pelanggan setia kami.
                </p>
            </div>

        </div>
    </div>
</div>
