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
            $table->enum('role', ['admin', 'users'])->default('users')->after('password');
            $table->string('phone_number')->nullable()->after('role');
            $table->string('place_of_birth')->nullable()->after('phone_number');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->text('domicile_address')->nullable()->after('date_of_birth');
            $table->string('domicile_rt')->nullable()->after('domicile_address');
            $table->string('domicile_rw')->nullable()->after('domicile_rt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone_number',
                'place_of_birth',
                'date_of_birth',
                'domicile_address',
                'domicile_rt',
                'domicile_rw'
            ]);
        });
    }
};
