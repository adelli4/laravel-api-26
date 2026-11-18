<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // membuat data pengguna awal agar aplikasi masih memiliki akun default untuk kebutuhan pengujian.
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );

        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
    }
}
