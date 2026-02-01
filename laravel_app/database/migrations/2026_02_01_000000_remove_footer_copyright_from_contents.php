<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('contents')->where('key', 'footer_copyright')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-insert the default value if rolled back
        DB::table('contents')->insert([
            'key' => 'footer_copyright',
            'group' => 'footer',
            'label' => 'Copyright Text',
            'type' => 'text',
            'value' => 'Copyright © 2026',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
