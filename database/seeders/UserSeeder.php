<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin/Demo User
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@fitlife.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'age' => 28,
            'height_cm' => 175,
            'weight_kg' => 80,
            'goal' => 'diet',
            'activity_level' => 'moderate',
            'avatar' => null,
        ]);

        // Sample Users
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@fitlife.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'age' => 25,
            'height_cm' => 162,
            'weight_kg' => 58,
            'goal' => 'bulking',
            'activity_level' => 'active',
            'avatar' => null,
        ]);

        User::create([
            'name' => 'Raka Wijaya',
            'email' => 'raka@fitlife.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'age' => 30,
            'height_cm' => 180,
            'weight_kg' => 75,
            'goal' => 'maintenance',
            'activity_level' => 'very_active',
            'avatar' => null,
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@fitlife.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'age' => 32,
            'height_cm' => 165,
            'weight_kg' => 62,
            'goal' => 'diet',
            'activity_level' => 'light',
            'avatar' => null,
        ]);

        User::create([
            'name' => 'Ahmad Hermawan',
            'email' => 'ahmad@fitlife.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'age' => 26,
            'height_cm' => 172,
            'weight_kg' => 85,
            'goal' => 'diet',
            'activity_level' => 'moderate',
            'avatar' => null,
        ]);
    }
}
