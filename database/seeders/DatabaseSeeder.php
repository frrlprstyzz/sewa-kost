<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin if doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nomor' => '6281234567890',
            ]
        );

        // Create Pemilik if doesn't exist
        User::firstOrCreate(
            ['email' => 'pemilik@gmail.com'],
            [
                'name' => 'Pemilik Kos',
                'password' => Hash::make('password'),
                'role' => 'pemilik',
                'nomor' => '6281234567891',
            ]
        );

        // Create User if doesn't exist
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'nomor' => '6281234567892',
            ]
        );

        // Run other seeders
        $this->call([
            KategoriSeeder::class,
            FasilitasSeeder::class,
        ]);
    }
}
