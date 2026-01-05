<div class="border-t border-[#FFF0A6] pt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">
    @if ($shop->instagram_username)
        <a href="https://instagram.com/{{ $shop->instagram_username }}" target="_blank"
            class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <x-icons.social-instagram class="text-red-500" />
            <span class="font-medium text-base text-slate-900">{{ '@' . $shop->instagram_username }}</span>
        </a>
    @endif

    @if ($shop->tiktok_username)
        <a href="{{ 'https://tiktok.com/@' . $shop->tiktok_username }}" target="_blank"
            class="flex items-center gap-1 hover:opacity-80 transition-opacity">
            <x-icons.social-tiktok class="text-slate-900" />
            <span class="font-medium text-base text-slate-900">{{ '@' . $shop->tiktok_username }}</span>
        </a>
    @endif

    @if ($shop->facebook_username)
        <a href="https://facebook.com/{{ $shop->facebook_username }}" target="_blank"
            class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <x-icons.social-facebook class="text-[#1877F2]" />
            <span class="font-medium text-base text-slate-900">{{ $shop->facebook_username }}</span>
        </a>
    @endif

    @if ($shop->website_url)
        <a href="{{ $shop->website_url }}" target="_blank" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <x-icons.map-globe class="text-slate-900" />
            <span class="font-medium text-base text-slate-900">Website</span>
        </a>
    @endif
</div>
