<x-ui.card class="p-4 sm:p-6 md:p-8">

    {{-- Description --}}
    <section>
        <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">{{ translate('Deskripsi Toko') }}</h2>
        <p class="text-slate-700 leading-relaxed whitespace-pre-line text-base md:text-lg"
            x-text="shop.description || '{{ translate('Tidak ada deskripsi') }}'"></p>
    </section>

    <hr class="border-gray-200 my-4">

    {{-- Info Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
        <section>
            <h2 class="text-lg font-bold text-slate-900 mb-4">
                {{ translate('Informasi Toko') }}
            </h2>

            <dl class="space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-4">
                    <dt class="w-full sm:w-40 text-slate-500 text-base shrink-0">{{ translate('Pemilik') }}</dt>
                    <dd class="text-slate-900 font-medium text-base break-words"
                        x-text="shop.user ? shop.user.name : (shop.user_name || '-')"></dd>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-4">
                    <dt class="w-full sm:w-40 text-slate-500 text-base shrink-0">{{ translate('Bergabung') }}</dt>
                    <dd class="text-slate-900 font-medium text-base"
                        x-text="new Date(shop.created_at).toLocaleDateString('id-ID', {year: 'numeric', month: 'long', day: 'numeric'})">
                    </dd>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-4">
                    <dt class="w-full sm:w-40 text-slate-500 text-base shrink-0">{{ translate('Wilayah') }}</dt>
                    <dd class="text-slate-900 font-medium text-base break-words" x-text="shop.region ? shop.region.name : '-'"></dd>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-4">
                    <dt class="w-full sm:w-40 text-slate-500 text-base shrink-0">{{ translate('Alamat') }}</dt>
                    <dd class="text-slate-900 font-medium text-base break-words leading-relaxed" x-text="shop.address || '-'"></dd>
                </div>
            </dl>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-900 mb-4">
                {{ translate('Statistik & Legalitas') }}
            </h2>

            <dl class="space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-4" x-show="formattedOmset">
                    <dt class="w-full sm:w-40 text-slate-500 text-base shrink-0">{{ translate('Omset') }}</dt>
                    <dd class="text-slate-900 font-bold text-base text-[#03AC0E]" x-text="formattedOmset"></dd>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-4"
                    x-show="licenses && licenses.length > 0">
                    <dt class="w-full sm:w-40 text-slate-500 text-base shrink-0">{{ translate('Izin Usaha') }}</dt>
                    <dd class="flex-1 min-w-0">
                        <ul class="space-y-2">
                            <template x-for="(license, index) in licenses" :key="index">
                                <li class="text-base text-slate-900 break-words">
                                    <span class="font-medium" x-text="license.type"></span>: <span class="text-slate-600"
                                        x-text="license.number"></span>
                                </li>
                            </template>
                        </ul>
                    </dd>
                </div>
            </dl>
        </section>
    </div>

    <hr class="border-gray-200 my-4">

    {{-- Social Media --}}
    <section>
        <h2 class="text-lg font-bold text-slate-900 mb-4">
            {{ translate('Media Sosial') }}
        </h2>
        <div class="flex flex-wrap gap-3">
            <template x-if="shop.instagram_username">
                <a :href="`https://instagram.com/${shop.instagram_username}`" target="_blank"
                    class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-gray-50 text-slate-700 hover:text-pink-600 rounded-xl transition-all border border-gray-200 hover:border-pink-200 hover:bg-pink-50">
                    <x-icons.social-instagram class="w-5 h-5 flex-shrink-0" />
                    <span class="text-base font-medium">Instagram</span>
                </a>
            </template>

            <template x-if="shop.tiktok_username">
                <a :href="`https://tiktok.com/@${shop.tiktok_username}`" target="_blank"
                    class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-gray-50 text-slate-700 hover:text-slate-900 rounded-xl transition-all border border-gray-200 hover:border-gray-300 hover:bg-gray-100">
                    <x-icons.social-tiktok class="w-5 h-5 flex-shrink-0" />
                    <span class="text-base font-medium">TikTok</span>
                </a>
            </template>

            <template x-if="shop.facebook_username">
                <a :href="`https://facebook.com/${shop.facebook_username}`" target="_blank"
                    class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-gray-50 text-slate-700 hover:text-blue-600 rounded-xl transition-all border border-gray-200 hover:border-blue-200 hover:bg-blue-50">
                    <x-icons.social-facebook class="w-5 h-5 flex-shrink-0" />
                    <span class="text-base font-medium">Facebook</span>
                </a>
            </template>

            <template x-if="shop.website_url">
                <a :href="shop.website_url" target="_blank"
                    class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-gray-50 text-slate-700 hover:text-slate-900 rounded-xl transition-all border border-gray-200 hover:border-slate-300 hover:bg-slate-100">
                    <x-icons.map-globe class="w-5 h-5 flex-shrink-0" />
                    <span class="text-base font-medium">Website</span>
                </a>
            </template>

            <template x-if="!shop.instagram_username && !shop.tiktok_username && !shop.facebook_username && !shop.website_url">
                <span class="text-slate-400 text-base italic">{{ translate('Belum ada data sosial media') }}</span>
            </template>
        </div>
    </section>
</x-ui.card>
