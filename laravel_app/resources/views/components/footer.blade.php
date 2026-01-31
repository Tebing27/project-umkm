@props(['content'])

<footer class="bg-brand-navy text-white pt-16 pb-8">
    <div class="container mx-auto px-4 md:px-8">
        {{-- Top Section: Brand + Links + CTA --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">
            {{-- Brand & Copyright --}}
            <div class="md:col-span-4 flex flex-col justify-between">
                <div>
                    {{-- Logo --}}
                    <div class="flex items-center gap-2 mb-6">
                        @if(isset($content['logo_show_image']->value) && $content['logo_show_image']->value == '1' && isset($content['logo_image']->value) && $content['logo_image']->value)
                            <img src="{{ Storage::url($content['logo_image']->value) }}" alt="Logo" class="h-10 w-auto object-contain">
                        @endif
                        
                        @if(isset($content['logo_show_text']->value) && $content['logo_show_text']->value == '1')
                            <span class="font-bold text-2xl tracking-tight">
                                {{ $content['logo_text']->value ?? 'Sasuma UMKM' }}
                            </span>
                        @endif
                    </div>
                    
                    <p class="text-white/80 text-sm mb-4 max-w-xs">
                        {{ $content['footer_about']->value ?? 'Small change. Big change.' }}
                    </p>
                </div>
            </div>

            {{-- Navigation Links --}}
            <div class="md:col-span-5 grid grid-cols-2 gap-8">
                <div>
                    {{-- Section 1 --}}
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ url('/') }}" class="text-white hover:text-brand-yellow transition-colors font-medium">
                                {{translate('Beranda')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('#regions') }}" class="text-white hover:text-brand-yellow transition-colors font-medium">
                                {{translate('Wilayah')}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    {{-- Section 2 --}}
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ url('#locations') }}" class="text-white hover:text-brand-yellow transition-colors font-medium">
                                {{translate('Lokasi')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/umkm') }}" class="text-white hover:text-brand-yellow transition-colors font-medium">
                                {{translate('UMKM')}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- CTA Button --}}
            <div class="md:col-span-3 flex flex-col items-start md:items-end">
                 @if(isset($content['footer_cta_text']->value) && $content['footer_cta_text']->value)
                    <a href="{{ url($content['footer_cta_link']->value ?? '#') }}" 
                       class="inline-block bg-brand-yellow hover:bg-brand-yellow-hover text-brand-navy font-bold py-3 px-8 rounded-lg shadow-lg transition-all transform hover:-translate-y-1">
                        {{ translate($content['footer_cta_text']->value) }}
                    </a>
                 @endif
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-white/20 mb-8"></div>

        {{-- Bottom Section: Copyright (Left) & Socials (Right) --}}
        <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-4">
            {{-- Copyright --}}
            <div class="text-center md:text-left">
                <p class="text-white/60 text-sm">
                    {{ $content['footer_copyright']->value ?? 'Copyright © 2026' }}
                </p>
            </div>

            {{-- Social Icons --}}
            <div class="flex items-center gap-4">
                @if(isset($content['footer_social_instagram']->value) && $content['footer_social_instagram']->value !== '#')
                    <a href="{{ $content['footer_social_instagram']->value }}" class="text-white hover:text-brand-yellow transition-colors">
                        <x-icons.social-instagram/>
                    </a>
                @endif
                
                @if(isset($content['footer_social_facebook']->value) && $content['footer_social_facebook']->value !== '#')
                    <a href="{{ $content['footer_social_facebook']->value }}" class="text-white hover:text-brand-yellow transition-colors">
                        <x-icons.social-facebook/>
                    </a>
                @endif

                @if(isset($content['footer_social_tiktok']->value) && $content['footer_social_tiktok']->value !== '#')
                    <a href="{{ $content['footer_social_tiktok']->value }}" class="text-white hover:text-brand-yellow transition-colors">
                        <x-icons.social-tiktok/>
                    </a>
                @endif
            </div>
        </div>
    </div>
</footer>
