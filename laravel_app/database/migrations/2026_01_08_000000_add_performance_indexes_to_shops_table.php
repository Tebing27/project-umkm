<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            // Index for high-frequency filters
            $table->index('is_verified'); 
            $table->index('business_type');
            
            // Compound index for "Region-based active shops" (used in Home Controller)
            // Helps: where('region_id', X)->where('is_verified', true)
            $table->index(['region_id', 'is_verified']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropIndex(['is_verified']);
            $table->dropIndex(['business_type']);
            $table->dropIndex(['region_id', 'is_verified']);
        });
    }
};
