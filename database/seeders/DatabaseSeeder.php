<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin User
        User::firstOrCreate(
            ['email' => 'admin@akhitech.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
            ]
        );

        // Seed domain data
        $this->call([
            SettingSeeder::class,
            PageSeeder::class,
            ServiceSeeder::class,
            PortfolioSeeder::class,
            PostSeeder::class,
        ]);
    }
}
