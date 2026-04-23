<?php

namespace Database\Seeders;

use App\Models\LifeTrackerEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class LifeTrackerEntrySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'budi@fitlife.com')->first();

        $entries = [
            [
                'user_id' => $user->id,
                'entry_date' => now()->subDays(6)->toDateString(),
                'water_ml' => 2000,
                'sleep_hours' => 7,
                'calories_in' => 2200,
                'calories_out' => 0,
                'exercise_minutes' => 45,
                'notes' => 'Jogging pagi, merasa energik',
            ],
            [
                'user_id' => $user->id,
                'entry_date' => now()->subDays(5)->toDateString(),
                'water_ml' => 2500,
                'sleep_hours' => 7.5,
                'calories_in' => 2100,
                'calories_out' => 0,
                'exercise_minutes' => 60,
                'notes' => 'Gym session - chest day',
            ],
            [
                'user_id' => $user->id,
                'entry_date' => now()->subDays(4)->toDateString(),
                'water_ml' => 1800,
                'sleep_hours' => 6.5,
                'calories_in' => 2300,
                'calories_out' => 0,
                'exercise_minutes' => 30,
                'notes' => 'Rest day tapi tetap minum air banyak',
            ],
            [
                'user_id' => $user->id,
                'entry_date' => now()->subDays(3)->toDateString(),
                'water_ml' => 2200,
                'sleep_hours' => 8,
                'calories_in' => 2000,
                'calories_out' => 0,
                'exercise_minutes' => 50,
                'notes' => 'HIIT training - 25 menit + cooldown',
            ],
            [
                'user_id' => $user->id,
                'entry_date' => now()->subDays(2)->toDateString(),
                'water_ml' => 2400,
                'sleep_hours' => 7,
                'calories_in' => 2150,
                'calories_out' => 0,
                'exercise_minutes' => 45,
                'notes' => 'Lari di taman + stretching',
            ],
            [
                'user_id' => $user->id,
                'entry_date' => now()->subDays(1)->toDateString(),
                'water_ml' => 2100,
                'sleep_hours' => 7.5,
                'calories_in' => 2250,
                'calories_out' => 0,
                'exercise_minutes' => 60,
                'notes' => 'Leg day - heavy lifting',
            ],
            [
                'user_id' => $user->id,
                'entry_date' => now()->toDateString(),
                'water_ml' => 2300,
                'sleep_hours' => 7,
                'calories_in' => 2100,
                'calories_out' => 0,
                'exercise_minutes' => 40,
                'notes' => 'Swimming - 40 menit continuous',
            ],
        ];

        foreach ($entries as $entry) {
            LifeTrackerEntry::create($entry);
        }
    }
}
