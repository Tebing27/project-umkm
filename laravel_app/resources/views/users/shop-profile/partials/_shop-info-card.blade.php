@props(['shop'])

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
                    <x-ui.badge variant="outline" class="border-slate-200 text-base text-slate-600 py-1 bg-slate-50">
                        <span>{{ $shop->business_type ?? 'Kategori' }}</span>
                    </x-ui.badge>
                </div>
            </div>

            {{-- Alamat (Lokasi) --}}
            <div class="flex items-start gap-1 md:gap-3 text-slate-600 justify-start">
                <x-icons.map-pin class="w-5 h-5 shrink-0" />
                <span class="font-medium">{{ $shop->address ?? 'Alamat belum diisi' }}</span>
            </div>

            {{-- Divider & Detail --}}
            @if (!empty($shop->licenses_array) || $shop->has_socials)

                <div class="w-full h-px bg-slate-100"></div>

                <div class="space-y-2">
                    {{-- Izin Usaha --}}
                    @if (!empty($shop->licenses_array))
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-1">{{ translate('Izin Usaha') }}</h4>
                            @foreach ($shop->licenses_array as $license)
                                <p class="text-slate-600 text-sm">{{ $license['type'] ?? 'Izin' }}:
                                    {{ $license['number'] ?? '-' }}</p>
                            @endforeach
                        </div>
                    @endif

                    {{-- Kontak & Sosmed --}}
                    @if ($shop->has_socials)
                        <div
                            class="{{ !empty($shop->licenses_array) ? 'border-t border-slate-200/60 pt-3' : '' }} grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">

                            {{-- IG --}}
                            @if ($shop->social_instagram)
                                <a href="https://instagram.com/{{ $shop->instagram_username }}" target="_blank"
                                    class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <x-icons.social-instagram class="text-red-500" />
                                    <span
                                        class="font-medium text-slate-900">{{ '@' . $shop->instagram_username }}</span>
                                </a>
                            @endif

                            {{-- Tiktok --}}
                            @if ($shop->social_tiktok)
                                <a href="{{ 'https://tiktok.com/@' . $shop->tiktok_username }}" target="_blank"
                                    class="flex items-center gap-1 hover:opacity-80 transition-opacity">
                                    <x-icons.social-tiktok class="text-slate-900" />
                                    <span class="font-medium text-slate-900">{{ '@' . $shop->tiktok_username }}</span>
                                </a>
                            @endif

                            {{-- FB --}}
                            @if ($shop->social_facebook)
                                <a href="https://facebook.com/{{ $shop->facebook_username }}" target="_blank"
                                    class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <x-icons.social-facebook class="text-social-facebook" />
                                    <span class="font-medium text-slate-900">{{ $shop->facebook_username }}</span>
                                </a>
                            @endif

                            {{-- Website --}}
                            @if ($shop->social_website)
                                <a href="{{ $shop->website_url }}" target="_blank"
                                    class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <x-icons.map-globe class="text-slate-900" />
                                    <span class="font-medium text-slate-900">Website</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            {{-- Divider & Deskripsi --}}
            @if (!empty($shop->description))
                <div class="w-full h-px bg-slate-100"></div>

                <div>
                    <p class="text-slate-500 leading-relaxed">
                        {{ translate($shop->description) }}
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>
