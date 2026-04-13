@extends('layouts.app')

@section('content')
    <div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">

        {{-- Kartu Edit Utama --}}
        <div class="login-card"
            style="width: 100%; max-width: 700px; text-align: left; border-radius: 30px; box-shadow: 0 15px 40px rgba(0,0,0,0.06);">

            {{-- Header --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1 style="font-size: 32px; margin: 0; font-weight: 800; color: var(--olive);">Edit Webtoon</h1>
                <a href="{{ route('webtoons.show', $webtoon) }}"
                    style="color: var(--olive); text-decoration: none; font-weight: 600;">
                    Kembali
                </a>
            </div>

            <form action="{{ route('webtoons.update', $webtoon->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Judul
                        Webtoon</label>
                    <input type="text" name="title" class="custom-input" value="{{ old('title', $webtoon->title) }}"
                        style="border-radius: 50px; padding: 12px 20px;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label
                            style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Penulis</label>
                        <input type="text" name="author" class="custom-input" value="{{ old('author', $webtoon->author) }}"
                            style="border-radius: 50px; padding: 12px 20px;" required>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Tahun
                            Rilis</label>
                        <input type="number" name="release_year" class="custom-input"
                            value="{{ old('release_year', $webtoon->release_year) }}"
                            style="border-radius: 50px; padding: 12px 20px;" required>
                    </div>
                </div>

                <div class="form-group">
                    <label
                        style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Sinopsis</label>
                    <textarea name="synopsis" class="custom-input" rows="5" style="border-radius: 20px; padding: 15px 20px;"
                        required>{{ old('synopsis', $webtoon->synopsis) }}</textarea>
                </div>

                <div class="form-group">
                    <label style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Ganti Cover
                        (Opsional)</label>
                    <div
                        style="display: flex; gap: 20px; align-items: center; background: #f9f9f9; padding: 15px; border-radius: 20px; border: 1px solid #eee;">
                        @if($webtoon->cover_image)
                            <img src="{{ Storage::url($webtoon->cover_image) }}"
                                style="width: 60px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #ddd;">
                        @else
                            <div
                                style="width: 60px; height: 80px; background: var(--olive); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                                📖</div>
                        @endif
                        <input type="file" name="cover_image" class="custom-input"
                            style="padding: 10px; border: none; background: transparent; border-radius: 0;">
                    </div>
                </div>

                <button type="submit" class="btn-login"
                    style="margin-top: 30px; background-color: var(--orange); color: var(--olive); border-radius: 50px; font-weight: 700; padding: 14px; box-shadow: 0 5px 15px rgba(252, 181, 59, 0.3);">
                    Update Perubahan
                </button>
            </form>
        </div>
    </div>
@endsection