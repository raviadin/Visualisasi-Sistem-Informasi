<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('1'),
                'role' => 'admin',
            ],
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => Hash::make('1'),
                'role' => 'user',
            ],
        ]);
    }
}
