<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Juan',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'admin' => true,
        ]);

        User::create([
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'admin' => false,
        ]);

        // Puedes añadir más usuarios según sea necesario
    }
}
