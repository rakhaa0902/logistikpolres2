<?php

namespace Database\Seeders;

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
        // Seed akun default (admin + user)
        $this->call(AccountSeeder::class);

        // Seed kategori default agar opsi kategori tersedia di form
        $this->call(KategoriSeeder::class);
    }
}
