<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Translation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Fix "Hero Section" translation for ID (Prevent "Deskripsi Pahlawan")
        $heroText = 'Hero Section';
        Translation::updateOrCreate(
            [
                'text_hash' => md5($heroText),
                'target_lang' => 'id',
            ],
            [
                'original_text' => $heroText,
                'translated_text' => 'Hero Section', // Keep as Loan Word or "Bagian Hero"
                'source_lang' => 'en', // Assuming source is EN
            ]
        );

        // 2. Fix "Judul" translation for EN (Add missing translation)
        $judulText = 'Judul';
        Translation::updateOrCreate(
            [
                'text_hash' => md5($judulText),
                'target_lang' => 'en',
            ],
            [
                'original_text' => $judulText,
                'translated_text' => 'Title',
                'source_lang' => 'id',
            ]
        );
        
        // 3. Fix "Content" -> "Konten" (Just in case)
        $contentText = 'Content';
        Translation::updateOrCreate(
            [
                'text_hash' => md5($contentText),
                'target_lang' => 'id',
            ],
            [
                'original_text' => $contentText,
                'translated_text' => 'Konten',
                'source_lang' => 'en',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse really, as these are fixes.
    }
};
