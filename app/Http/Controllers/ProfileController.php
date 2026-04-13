<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil Statistik Bacaan
        // Pastikan model User punya relasi readingLists()
        $readingStats = [
            'reading' => $user->readingLists()->where('status', 'reading')->count(),
            'completed' => $user->readingLists()->where('status', 'completed')->count(),
            'want_to_read' => $user->readingLists()->where('status', 'want_to_read')->count(),
        ];

        // 2. Ambil Bacaan Terakhir
        $recentRead = $user->readingLists()->with('webtoon')->latest('updated_at')->take(5)->get();

        // 3. Ambil Semua Daftar Bacaan
        $allReadingList = $user->readingLists()->with('webtoon')->latest()->get();

        // 4. Ambil Review User
        $userReviews = $user->reviews()->with('webtoon')->latest()->get();

        // 5. Hitung Rata-rata Rating
        $avgRating = $user->reviews()->avg('rating') ?? 0;

        return view('profile.index', compact(
            'readingStats',
            'recentRead',
            'allReadingList',
            'userReviews',
            'avgRating'
        ));
    }
}