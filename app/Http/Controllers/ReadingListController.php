<?php

namespace App\Http\Controllers;

use App\Models\ReadingList;
use App\Models\Webtoon;
use Illuminate\Http\Request;

class ReadingListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $readingLists = ReadingList::where('user_id', auth()->id())
            ->with('webtoon')
            ->latest()
            ->get()
            ->groupBy('status');

        return view('reading-lists.index', compact('readingLists'));
    }

    public function store(Request $request, Webtoon $webtoon)
    {
        $validated = $request->validate([
            'status' => 'required|in:reading,completed,want_to_read'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['webtoon_id'] = $webtoon->id;

        // Check if already in list
        $existing = ReadingList::where('user_id', auth()->id())
            ->where('webtoon_id', $webtoon->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Webtoon sudah ada di daftar bacaan!');
        }

        ReadingList::create($validated);

        return back()->with('success', 'Webtoon ditambahkan ke daftar bacaan!');
    }

    public function update(Request $request, ReadingList $readingList)
    {
        // Check authorization
        if ($readingList->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:reading,completed,want_to_read'
        ]);

        $readingList->update($validated);

        return back()->with('success', 'Status bacaan berhasil diupdate!');
    }

    public function destroy(ReadingList $readingList)
    {
        // Check authorization
        if ($readingList->user_id !== auth()->id()) {
            abort(403);
        }

        $readingList->delete();

        return back()->with('success', 'Webtoon dihapus dari daftar bacaan!');
    }

    public function destroyAll()
    {
        ReadingList::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Semua daftar bacaan berhasil dihapus!');
    }
}