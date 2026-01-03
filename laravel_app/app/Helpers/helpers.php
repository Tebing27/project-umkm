<?php

use App\Services\TranslationService;

if (!function_exists('translate')) {
    /**
     * Translate text using the TranslationService.
     *
     * @param string $text
     * @param string $targetLang
     * @return string
     */
    function translate(string $text, string $targetLang = null): string
    {
        if (is_null($targetLang)) {
            $targetLang = app()->getLocale();
        }
        
        // Return original if target is same as source (assumed 'id')
        if ($targetLang === 'id') {
            return $text;
        }

        return app(TranslationService::class)->translate($text, $targetLang);
    }
}
