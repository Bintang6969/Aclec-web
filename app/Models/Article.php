<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'image',
        'category', 'author_id', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public static function categories(): array
    {
        return [
            'nutrition'     => 'Nutrisi',
            'workout'       => 'Olahraga',
            'mental_health' => 'Kesehatan Mental',
            'lifestyle'     => 'Gaya Hidup',
            'news'          => 'Berita',
        ];
    }
}
