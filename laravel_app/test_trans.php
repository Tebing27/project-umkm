<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Translating 'Semangka'...\n";
    $result = translate('Semangka');
    echo "Result: " . $result . "\n";

    echo "Checking Cache...\n";
    $cached = \App\Models\Translation::where('original_text', 'Semangka')->first();
    if ($cached) {
        echo "Cache Found: " . $cached->translated_text . "\n";
    } else {
        echo "Cache NOT Found!\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
