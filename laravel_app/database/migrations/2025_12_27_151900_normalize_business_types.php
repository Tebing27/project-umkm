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
        // Normalize 'Retail' -> 'Kelontong'
        DB::table('shops')
            ->where('business_type', 'Retail')
            ->update(['business_type' => 'Kelontong']);

        // Normalize 'Fashion' -> 'Pakaian & Fashion'
        DB::table('shops')
            ->where('business_type', 'Fashion')
            ->orWhere('business_type', 'Pakaian')
            ->update(['business_type' => 'Pakaian & Fashion']);

        // Normalize 'Kerajinan' -> 'Kerajinan Tangan'
        DB::table('shops')
            ->where('business_type', 'Kerajinan')
            ->update(['business_type' => 'Kerajinan Tangan']);

        // Normalize 'Makanan' -> 'Kuliner'
        DB::table('shops')
            ->where('business_type', 'Makanan')
            ->update(['business_type' => 'Kuliner']);

        // Normalize 'Minuman' -> 'Kuliner'
        DB::table('shops')
            ->where('business_type', 'Minuman')
            ->update(['business_type' => 'Kuliner']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No strict reverse needed as this is data normalization
    }
};
