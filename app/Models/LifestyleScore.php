<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifestyleScore extends Model
{
    protected $fillable = [
        'user_id', 'score_date', 'score', 'reward_type', 'reward_message',
    ];

    protected $casts = ['score_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
