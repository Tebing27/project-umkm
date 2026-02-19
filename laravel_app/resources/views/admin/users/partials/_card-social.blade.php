<x-ui.card class="p-8">
    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
        <x-icons.map-globe class="w-5 h-5 text-primary" />
        {{ translate('Sosial Media') }}
    </h3>
    <div class="space-y-4">
        @if ($shop->social_instagram)
            <div class="flex items-center gap-3">
                <x-icons.social-instagram class="w-5 h-5 text-social-instagram" />
                <a href="{{ $shop->social_instagram }}" target="_blank"
                    class="text-blue-600 hover:underline truncate">{{ $shop->social_instagram }}</a>
            </div>
        @endif
        @if ($shop->social_facebook)
            <div class="flex items-center gap-3">
                <x-icons.social-facebook class="w-5 h-5 text-social-facebook" />
                <a href="{{ $shop->social_facebook }}" target="_blank"
                    class="text-blue-600 hover:underline truncate">{{ $shop->social_facebook }}</a>
            </div>
        @endif
        @if ($shop->social_tiktok)
            <div class="flex items-center gap-3">
                <x-icons.social-tiktok class="w-5 h-5 text-black" />
                <a href="{{ $shop->social_tiktok }}" target="_blank"
                    class="text-blue-600 hover:underline truncate">{{ $shop->social_tiktok }}</a>
            </div>
        @endif
        @if (!$shop->social_instagram && !$shop->social_facebook && !$shop->social_tiktok)
            <p class="text-slate-500 text-sm">{{ translate('Tidak ada social media tercantum.') }}</p>
        @endif
    </div>
</x-ui.card>
