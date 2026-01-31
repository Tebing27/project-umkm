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
            $table->index('created_at'); // Used for ordering (latest)
            
            // Compound index for "Region-based active shops" (used in Home Controller)
            // Helps: where('region_id', X)->where('is_verified', true)
            $table->index(['region_id', 'is_verified']);
        });
        
        // Add index to products table for shop filtering
        Schema::table('products', function (Blueprint $table) {
            // Composite index for filtering products by shop and active status
            // Helps: where('shop_id', X)->where('is_active', true)
            $table->index(['shop_id', 'is_active']);
        });
        
        // Add index to shop_photos table for ordering
        Schema::table('shop_photos', function (Blueprint $table) {
            // Composite index for fetching photos sorted by order
            // Helps: where('shop_id', X)->orderBy('order')
            $table->index(['shop_id', 'order']);
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
            $table->dropIndex(['created_at']);
            $table->dropIndex(['region_id', 'is_verified']);
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['shop_id', 'is_active']);
        });
        
        Schema::table('shop_photos', function (Blueprint $table) {
            $table->dropIndex(['shop_id', 'order']);
        });
    }
};
