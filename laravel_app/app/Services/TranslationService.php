<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected string $apiKey;
    protected string $model;
    protected string $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key');
        $this->model = 'xiaomi/mimo-v2-flash:free';
    }

    /**
     * Translate text using OpenRouter AI or retrieve from cache.
     *
     * @param string $text The text to translate
     * @param string $targetLang Target language code (default: 'en')
     * @param string $sourceLang Source language code (default: 'id')
     * @return string Translated text
     */
public function translate(string $text, string $targetLang = 'en', string $sourceLang = 'id'): string
{
    if (empty(trim($text))) return $text;
    $hash = md5($text);
    $cacheKey = "translation_{$targetLang}_{$hash}";
    // Use Laravel Cache to prevent hitting DB/API every time
    return \Illuminate\Support\Facades\Cache::rememberForever($cacheKey, function () use ($text, $hash, $targetLang, $sourceLang) {
        
        // 1. Check Database
        $cachedDb = Translation::where('text_hash', $hash)
            ->where('target_lang', $targetLang)
            ->first();
        if ($cachedDb) {
            return $cachedDb->translated_text;
        }
        // 2. Call API (If not in DB)
        try {
            $translatedText = $this->callOpenRouterApi($text, $targetLang, $sourceLang);
            // Store in DB
            Translation::create([
                'text_hash' => $hash,
                'original_text' => $text,
                'translated_text' => $translatedText,
                'source_lang' => $sourceLang,
                'target_lang' => $targetLang,
            ]);
            return $translatedText;
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage());
            return $text; // Fallback
        }
    });
}

    protected function callOpenRouterApi(string $text, string $targetLang, string $sourceLang): string
    {
        // 1. Identify and protect Laravel placeholders (e.g., :attribute, :max, :min)
        $placeholders = [];
        $protectedText = preg_replace_callback('/:\w+/', function ($matches) use (&$placeholders) {
            $token = '[[VAR_' . count($placeholders) . ']]';
            $placeholders[$token] = $matches[0];
            return $token;
        }, $text);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'HTTP-Referer' => config('app.url'), // Optional
            'X-Title' => config('app.name'), // Optional
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a professional translator. Translate the following text from {$sourceLang} to {$targetLang}. Return ONLY the translated text, no additional commentary or quotes. PRESERVE any tokens like [[VAR_0]], [[VAR_1]] exactly as they are in the correct position."
                ],
                [
                    'role' => 'user',
                    'content' => $protectedText
                ]
            ],
            'temperature' => 0.3,
        ]);

        if ($response->failed()) {
            throw new \Exception('OpenRouter API Error: ' . $response->body());
        }

        $data = $response->json();
        $translatedText = trim($data['choices'][0]['message']['content'] ?? $protectedText);

        // 2. Restore placeholders
        foreach ($placeholders as $token => $original) {
            $translatedText = str_replace($token, $original, $translatedText);
        }

        return $translatedText;
    }
}
