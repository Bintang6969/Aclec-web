<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'gender', 'age', 'height_cm', 'weight_kg',
        'goal', 'activity_level', 'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function lifeTrackerEntries()
    {
        return $this->hasMany(LifeTrackerEntry::class);
    }

    public function workoutSessions()
    {
        return $this->hasMany(WorkoutSession::class);
    }

    public function lifestyleScores()
    {
        return $this->hasMany(LifestyleScore::class);
    }

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function consultationMessages()
    {
        return $this->hasMany(ConsultationMessage::class);
    }

    public function getBmrAttribute(): float
    {
        if (!$this->weight_kg || !$this->height_cm || !$this->age || !$this->gender) {
            return 0;
        }
        if ($this->gender === 'male') {
            return 10 * $this->weight_kg + 6.25 * $this->height_cm - 5 * $this->age + 5;
        }
        return 10 * $this->weight_kg + 6.25 * $this->height_cm - 5 * $this->age - 161;
    }

    public function getTdeeAttribute(): float
    {
        $multipliers = [
            'sedentary'  => 1.2,
            'light'      => 1.375,
            'moderate'   => 1.55,
            'active'     => 1.725,
            'very_active'=> 1.9,
        ];
        return round($this->bmr * ($multipliers[$this->activity_level] ?? 1.55));
    }
}
