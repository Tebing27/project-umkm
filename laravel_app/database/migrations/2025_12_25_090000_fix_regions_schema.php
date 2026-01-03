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
        Schema::table('regions', function (Blueprint $table) {
            if (!Schema::hasColumn('regions', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('name');
            }
            if (!Schema::hasColumn('regions', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });

        // 1. Rename ID 3 (currently Sawangan Baru or Sawangan) to Sawangan Lama
        DB::table('regions')->where('id', 3)->update([
            'name' => 'Sawangan Lama',
            'latitude' => -6.40188,
            'longitude' => 106.7569434
        ]);

        // 2. Delete Bojongsari if exists
        DB::table('regions')->where('name', 'Bojongsari')->delete();

        // 3. Insert Sawangan Baru (fresh)
        // Check if exists first to avoid duplicates if migration re-run partially
        if (!DB::table('regions')->where('name', 'Sawangan Baru')->exists()) {
             DB::table('regions')->insert([
                'name' => 'Sawangan Baru',
                'latitude' => -6.4003188,
                'longitude' => 106.7665906,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
             DB::table('regions')->where('name', 'Sawangan Baru')->update([
                'latitude' => -6.4003188,
                'longitude' => 106.7665906,
             ]);
        }

        // 4. Update others
        $regions = [
            'Cinangka' => ['lat' => -6.3671774, 'lon' => 106.7573148],
            'Kedaung' => ['lat' => -6.3662881, 'lon' => 106.7478372],
            'Pengasinan' => ['lat' => -6.4280565, 'lon' => 106.7576837],
            'Pasir Putih' => ['lat' => -6.4212982, 'lon' => 106.7829647],
            'Bedahan' => ['lat' => -6.4267812, 'lon' => 106.7698678],
        ];

        foreach ($regions as $name => $coords) {
            DB::table('regions')->where('name', $name)->update([
                'latitude' => $coords['lat'],
                'longitude' => $coords['lon']
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            if (Schema::hasColumn('regions', 'latitude')) {
                $table->dropColumn(['latitude', 'longitude']);
            }
        });
    }
};
