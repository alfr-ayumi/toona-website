<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Webtoon;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        // pastikan semua aksi review harus login
        $this->middleware('auth');
    }

    public function store(Request $request, Webtoon $webtoon)
    {
        // validasi input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string',
        ]);

        // cek apakah user sudah pernah mereview webtoon ini
        $alreadyReviewed = Review::where('user_id', auth()->id())
            ->where('webtoon_id', $webtoon->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Kamu sudah mereview webtoon ini.');
        }

        // simpan review
        Review::create([
            'user_id' => auth()->id(),
            'webtoon_id' => $webtoon->id,
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'] ?? null,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }

    public function update(Request $request, Review $review)
    {
        // pastikan review milik user yang login
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review berhasil diperbarui!');
    }

    public function destroy(Review $review)
    {
        // pastikan review milik user yang login
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus!');
    }
}
