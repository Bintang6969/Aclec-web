<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeTrackerEntry extends Model
{
    protected $fillable = [
        'user_id', 'entry_date', 'water_ml', 'sleep_hours',
        'calories_in', 'calories_out', 'exercise_minutes', 'notes',
    ];

    protected $casts = [
        'entry_date'  => 'date',
        'sleep_hours' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCalorieBalanceAttribute(): int
    {
        return $this->calories_in - $this->calories_out;
    }
}
