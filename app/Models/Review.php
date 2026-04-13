<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'webtoon_id',
        'user_id',
        'rating',
        'review_text'
    ];

    // Review milik Webtoon
    public function webtoon()
    {
        return $this->belongsTo(Webtoon::class);
    }

    // Review milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}