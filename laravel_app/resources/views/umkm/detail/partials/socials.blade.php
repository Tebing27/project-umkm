<div class="border-t border-[#FFF0A6] pt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">
<div class="border-t border-[#FFF0A6] pt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">
    <template x-if="shop.instagram_username">
        <a :href="'https://instagram.com/' + shop.instagram_username" target="_blank"
            class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <x-icons.social-instagram class="text-red-500" />
            <span class="font-medium text-base text-slate-900" x-text="'@' + shop.instagram_username"></span>
        </a>
    </template>

    <template x-if="shop.tiktok_username">
        <a :href="'https://tiktok.com/@' + shop.tiktok_username" target="_blank"
            class="flex items-center gap-1 hover:opacity-80 transition-opacity">
            <x-icons.social-tiktok class="text-slate-900" />
            <span class="font-medium text-base text-slate-900" x-text="'@' + shop.tiktok_username"></span>
        </a>
    </template>

    <template x-if="shop.facebook_username">
        <a :href="'https://facebook.com/' + shop.facebook_username" target="_blank"
            class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <x-icons.social-facebook class="text-[#1877F2]" />
            <span class="font-medium text-base text-slate-900" x-text="shop.facebook_username"></span>
        </a>
    </template>

    <template x-if="shop.website_url">
        <a :href="shop.website_url" target="_blank" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <x-icons.map-globe class="text-slate-900" />
            <span class="font-medium text-base text-slate-900">Website</span>
        </a>
    </template>
</div>
</div>
