<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'content', 'is_moderated'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
