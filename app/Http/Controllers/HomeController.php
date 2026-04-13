<?php

namespace App\Http\Controllers;

use App\Models\Webtoon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $latestWebtoons = Webtoon::withCount('reviews')
            ->latest()
            ->take(6)
            ->get();

        $popularWebtoons = Webtoon::withCount('reviews')
            ->orderByDesc('reviews_count')
            ->take(6)
            ->get();

        return view('home', compact('latestWebtoons', 'popularWebtoons'));
    }
}
