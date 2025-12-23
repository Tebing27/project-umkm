<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sasuma',
            'email' => 'admin@sasuma.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'phone_number' => '081234567890',
            'place_of_birth' => 'Jakarta', 
            'date_of_birth' => '1990-01-01', 
            'domicile_address' => 'Kantor Sasuma', 
        ]);
    }
}
