<?php

namespace Database\Seeders;

use App\Models\WorkoutSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class WorkoutSessionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'budi@fitlife.com')->first();

        $sessions = [
            [
                'user_id' => $user->id,
                'session_date' => now()->subDays(6)->toDateString(),
                'workout_type' => 'cardio',
                'duration_minutes' => 45,
                'calories_burned' => 450,
                'notes' => 'Jogging di taman',
            ],
            [
                'user_id' => $user->id,
                'session_date' => now()->subDays(5)->toDateString(),
                'workout_type' => 'strength',
                'duration_minutes' => 60,
                'calories_burned' => 420,
                'notes' => 'Chest day - barbell bench press, incline dumbbell',
            ],
            [
                'user_id' => $user->id,
                'session_date' => now()->subDays(3)->toDateString(),
                'workout_type' => 'hiit',
                'duration_minutes' => 25,
                'calories_burned' => 300,
                'notes' => 'Burpees, mountain climbers, jump squats',
            ],
            [
                'user_id' => $user->id,
                'session_date' => now()->subDays(2)->toDateString(),
                'workout_type' => 'running',
                'duration_minutes' => 45,
                'calories_burned' => 180,
                'notes' => 'Lari steady state di gym treadmill',
            ],
            [
                'user_id' => $user->id,
                'session_date' => now()->subDays(1)->toDateString(),
                'workout_type' => 'strength',
                'duration_minutes' => 60,
                'calories_burned' => 420,
                'notes' => 'Leg day - squat, leg press, leg curl',
            ],
            [
                'user_id' => $user->id,
                'session_date' => now()->toDateString(),
                'workout_type' => 'swimming',
                'duration_minutes' => 40,
                'calories_burned' => 360,
                'notes' => 'Freestyle swimming - continuous',
            ],
        ];

        foreach ($sessions as $session) {
            WorkoutSession::create($session);
        }
    }
}
