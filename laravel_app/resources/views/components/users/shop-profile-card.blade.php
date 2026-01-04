@props(['shop'])

@php
    // 1. Cek License
    $licenses = is_string($shop->licenses) ? json_decode($shop->licenses, true) : $shop->licenses;
    $hasLicenses = !empty($licenses);

    // 2. Cek Sosmed (Apakah minimal salah satu ada?)
    $hasSocials = $shop->social_instagram || $shop->social_tiktok || $shop->social_facebook || $shop->social_website;

    // Gabungan: Apakah bagian "Detail" perlu muncul?
    $showDetails = $hasLicenses || $hasSocials;

    // 3. Cek Deskripsi (Hanya tampil jika ada isi, saya hapus default text 'belum diisi' agar logic ini jalan)
    $hasDescription = !empty($shop->description);
@endphp

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
                <img src="{{ $shop->logo_url }}" loading="lazy" class="w-full h-full rounded-full object-cover"
                    alt="Foto Toko">
            </div>
        </div>

        {{-- Info Text --}}
        <div class="flex-1 text-left space-y-5">

            {{-- Header Info --}}
            <div>
                <p class="text-slate-500 font-medium text-sm mb-1">{{ translate('Pemilik') }}: <span
                        class="text-slate-900 font-bold">{{ $shop->user->name ?? 'Nama Pemilik' }}</span></p>
                <div class="flex flex-row flex-wrap items-center gap-3 justify-start">
                    <h3 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight break-words max-w-full">
                        {{ $shop->name ?? 'Nama Toko' }}</h3>
                    <x-ui.badge class="px-2.5 py-1">{!! $shop->business_type ?? 'Kategori' !!}</x-ui.badge>
                </div>
            </div>

            {{-- Alamat (Lokasi) --}}
            <div class="flex items-start gap-1 md:gap-3 text-slate-600 justify-start">
                <x-icons.map-pin class="w-5 h-5 shrink-0" />
                <span class="font-medium">{{ $shop->address ?? 'Alamat belum diisi' }}</span>
            </div>

            {{-- LOGIC: Divider & Detail hanya muncul jika ada License ATAU Sosmed --}}
            @if ($showDetails)
                {{-- Divider 1 --}}
                <div class="w-full h-px bg-slate-100"></div>

                {{-- Detail Lainnya --}}
                <div class="space-y-2">
                    {{-- Izin Usaha --}}
                    @if ($hasLicenses)
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-1">{{ translate('Izin Usaha') }}</h4>
                            @foreach ($licenses as $license)
                                <p class="text-slate-600 text-sm">{{ $license['type'] ?? 'Izin' }}:
                                    {{ $license['number'] ?? '-' }}</p>
                            @endforeach
                        </div>
                    @endif

                    {{-- Kontak & Sosmed --}}
                    @if ($hasSocials)
                        <div
                            class="{{ $hasLicenses ? 'border-t border-slate-200/60 pt-3' : '' }} grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">
                            {{-- IG --}}
                            @if ($shop->social_instagram)
                                @php
                                    $igUsername = str_replace(
                                        ['https://www.instagram.com/', 'https://instagram.com/', '@', '/'],
                                        '',
                                        $shop->social_instagram,
                                    );
                                @endphp
                                <a href="https://instagram.com/{{ $igUsername }}" target="_blank"
                                    class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <x-icons.social-instagram class="text-red-500" />
                                    <span class="font-medium text-slate-900">{{ '@' . $igUsername }}</span>
                                </a>
                            @endif

                            {{-- Tiktok --}}
                            @if ($shop->social_tiktok)
                                @php
                                    $tiktokUsername = str_replace(
                                        ['https://www.tiktok.com/', 'https://tiktok.com/', '@', '/'],
                                        '',
                                        $shop->social_tiktok,
                                    );
                                @endphp
                                <a href="{{ 'https://tiktok.com/@' . $tiktokUsername }}" target="_blank"
                                    class="flex items-center gap-1 hover:opacity-80 transition-opacity">
                                    <x-icons.social-tiktok class="text-slate-900" />
                                    <span class="font-medium text-slate-900">{{ '@' . $tiktokUsername }}</span>
                                </a>
                            @endif

                            {{-- FB --}}
                            @if ($shop->social_facebook)
                                @php
                                    $fbUsername = str_replace(
                                        ['https://www.facebook.com/', 'https://facebook.com/', '/'],
                                        '',
                                        $shop->social_facebook,
                                    );
                                @endphp
                                <a href="https://facebook.com/{{ $fbUsername }}" target="_blank"
                                    class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <x-icons.social-facebook class="text-[#1877F2]" />
                                    <span class="font-medium text-slate-900">{{ $fbUsername }}</span>
                                </a>
                            @endif

                            {{-- Website --}}
                            @if ($shop->social_website)
                                <a href="{{ Str::startsWith($shop->social_website, ['http://', 'https://']) ? $shop->social_website : 'https://' . $shop->social_website }}"
                                    target="_blank" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <x-icons.map-globe class="text-slate-900" />
                                    <span class="font-medium text-slate-900">Website</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            {{-- LOGIC: Divider & Deskripsi hanya muncul jika deskripsi TIDAK kosong --}}
            @if ($hasDescription)
                {{-- Divider 2 --}}
                <div class="w-full h-px bg-slate-100"></div>

                {{-- Deskripsi --}}
                <div>
                    <p class="text-slate-500 leading-relaxed">
                        {{ translate($shop->description) }}
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>
