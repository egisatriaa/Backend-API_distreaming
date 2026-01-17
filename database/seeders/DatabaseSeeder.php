<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan seeder admin & user
        $this->call([
            CreateUsersSeeder::class,
            CreateMoviesAndCategoriesSeeder::class,
        ]);
    }
}
