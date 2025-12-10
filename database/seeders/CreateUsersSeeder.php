<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin Account
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => 'user123',
            'role' => 'user',
        ]);

        $this->command->info('Sample users created: admin & user.');
    }
}
