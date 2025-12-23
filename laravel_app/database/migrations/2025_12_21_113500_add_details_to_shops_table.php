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
            $table->text('description')->nullable()->after('name');
            $table->bigInteger('omset_min')->nullable()->after('business_type');
            $table->bigInteger('omset_max')->nullable()->after('omset_min');
            $table->decimal('latitude', 10, 8)->nullable()->after('rw');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['description', 'omset_min', 'omset_max', 'latitude', 'longitude']);
        });
    }
};
