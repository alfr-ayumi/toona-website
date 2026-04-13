<?php

namespace App\Http\Controllers;

use App\Models\Webtoon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebtoonController extends Controller
{
    public function index()
    {
        // Mengambil data terbaru dengan pagination
        $webtoons = Webtoon::latest()->paginate(8);
        return view('webtoons.index', compact('webtoons'));
    }

    public function create()
    {
        return view('webtoons.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'synopsis' => 'required',
            'author' => 'required',
            'release_year' => 'required|digits:4',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('covers', 'public');
        }

        Webtoon::create($validated);

        return redirect()
            ->route('webtoons.index')
            ->with('success', 'Webtoon berhasil ditambahkan!');
    }
    public function show(Webtoon $webtoon)
    {
        // Load ulasan agar bisa ditampilkan
        $webtoon->load('reviews.user');
        return view('webtoons.show', compact('webtoon'));
    }

    public function edit(Webtoon $webtoon)
    {
        return view('webtoons.edit', compact('webtoon'));
    }

    public function update(Request $request, Webtoon $webtoon)
    {
        $request->validate([
            // Saat edit, kita harus ignore ID webtoon ini sendiri agar tidak dianggap duplikat diri sendiri
            'title' => 'required|max:255|unique:webtoons,title,' . $webtoon->id,
            'synopsis' => 'required',
            'author' => 'required',
            'release_year' => 'required|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada gambar baru
            if ($webtoon->cover_image) {
                Storage::disk('public')->delete($webtoon->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $webtoon->update($data);

        return redirect()->route('webtoons.index')->with('success', 'Webtoon berhasil diperbarui!');
    }

    public function destroy(Webtoon $webtoon)
    {
        if ($webtoon->cover_image) {
            Storage::disk('public')->delete($webtoon->cover_image);
        }

        $webtoon->delete();

        return redirect()->route('webtoons.index')->with('success', 'Webtoon berhasil dihapus!');
    }
}