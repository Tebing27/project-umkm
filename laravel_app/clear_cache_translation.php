<?php

use App\Models\Translation;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Hash for the problematic string
$text = ':attribute wajib diisi.';
$hash = md5($text);

$cached = Translation::where('text_hash', $hash)->first();

if ($cached) {
    echo "Found corrupted cache:\n";
    echo "Original: " . $cached->original_text . "\n";
    echo "Translated: " . $cached->translated_text . "\n";
    
    // Check if translated text contains :attribute
    if (strpos($cached->translated_text, ':attribute') === false) {
        echo "FAIL: Translated text MISSING placeholder!\n";
        $cached->delete();
        echo "Deleted corrupted cache entry.\n";
    } else {
        echo "OK: Translated text contains placeholder.\n";
    }
} else {
    echo "No cache found for: $text\n";
}

// Clear all validation-like cache just in case
$badTranslations = Translation::where('original_text', 'LIKE', '%:attribute%')
    ->where('translated_text', 'NOT LIKE', '%:attribute%')
    ->get();

if ($badTranslations->count() > 0) {
    echo "\nFound " . $badTranslations->count() . " other bad translations. Deleting...\n";
    foreach ($badTranslations as $bad) {
        echo "Deleting: " . $bad->original_text . " -> " . $bad->translated_text . "\n";
        $bad->delete();
    }
} else {
    echo "\nNo other bad translations found.\n";
}
