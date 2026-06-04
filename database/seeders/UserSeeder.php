<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@emak.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Ahmad Penimbang',
            'email' => 'penimbang@emak.id',
            'password' => Hash::make('password123'),
            'role' => 'penimbang',
        ]);

        User::create([
            'name' => 'Budi Pengelola',
            'email' => 'pengelola@emak.id',
            'password' => Hash::make('password123'),
            'role' => 'pengelola',
        ]);
    }
}
