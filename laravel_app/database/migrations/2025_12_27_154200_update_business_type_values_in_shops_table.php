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
        // Update 'Pakaian & Fashion' to 'Pakaian & Aksesoris'
        DB::table('shops')
            ->where('business_type', 'Pakaian & Fashion')
            ->update(['business_type' => 'Pakaian & Aksesoris']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'Pakaian & Aksesoris' to 'Pakaian & Fashion'
        DB::table('shops')
            ->where('business_type', 'Pakaian & Aksesoris')
            ->update(['business_type' => 'Pakaian & Fashion']);
    }
};
