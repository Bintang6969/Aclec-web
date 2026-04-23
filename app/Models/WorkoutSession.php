<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutSession extends Model
{
    protected $fillable = [
        'user_id', 'session_date', 'workout_type',
        'duration_minutes', 'calories_burned', 'notes',
    ];

    protected $casts = ['session_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function workoutTypes(): array
    {
        return [
            'cardio'      => 'Kardio (Lari, Sepeda, dll)',
            'strength'    => 'Latihan Beban',
            'hiit'        => 'HIIT',
            'yoga'        => 'Yoga / Stretching',
            'swimming'    => 'Renang',
            'cycling'     => 'Bersepeda',
            'walking'     => 'Jalan Kaki',
            'other'       => 'Lainnya',
        ];
    }

    public static function caloriesPerMinute(): array
    {
        return [
            'cardio'   => 10,
            'strength' => 7,
            'hiit'     => 12,
            'yoga'     => 3,
            'swimming' => 9,
            'cycling'  => 8,
            'walking'  => 4,
            'other'    => 5,
        ];
    }
}
