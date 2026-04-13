<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webtoon extends Model
{
    use HasFactory;

    // Pastikan ini sesuai nama tabel di phpMyAdmin (biasanya 'webtoons' atau 'webtoon')
    // Kalau migrasi kamu tadi bikinnya 'webtoons', baris ini aman.
    protected $table = 'webtoons'; 

    protected $fillable = [
        'title', 
        'synopsis', 
        'author', 
        'release_year', 
        'cover_image'
    ];

    // Relasi: 1 Webtoon punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Fungsi hitung rating (biar ga error di halaman index)
    public function averageRating()
    {
        // Ambil rata-rata kolom 'rating' dari tabel reviews
        // Jika kosong, kembalikan 0
        return $this->reviews()->avg('rating') ?? 0;
    }
}