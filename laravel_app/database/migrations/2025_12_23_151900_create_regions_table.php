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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Seed default data
        $now = now();
        DB::table('regions')->insert([
            ['name' => 'Cinangka', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kedaung', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sawangan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pengasinan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bojongsari', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pasir Putih', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bedahan', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
