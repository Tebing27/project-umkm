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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['domicile_rt', 'domicile_rw']);
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('domicile_rt')->nullable()->after('domicile_address');
            $table->string('domicile_rw')->nullable()->after('domicile_rt');
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
        });
    }
};
