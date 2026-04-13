@extends('layouts.app')

@section('content')
    <div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">

        {{-- Kartu Create Utama --}}
        <div class="login-card" style="width: 100%; max-width: 700px; text-align: left;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1 style="font-size: 32px; margin: 0; font-weight: 800; color: var(--olive);">Tambah Webtoon</h1>
                <a href="{{ route('webtoons.index') }}"
                    style="color: var(--olive); text-decoration: none; font-weight: 600;">
                    Batal
                </a>
            </div>

            <form action="{{ route('webtoons.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Judul
                        Webtoon</label>
                    <input type="text" name="title" class="custom-input @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" style="border-radius: 50px; padding: 12px 20px;"
                        placeholder="Masukkan judul..." required>
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Penulis
                            (Author)</label>
                        <input type="text" name="author" class="custom-input" value="{{ old('author') }}"
                            style="border-radius: 50px; padding: 12px 20px;" placeholder="Nama penulis" required>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Tahun
                            Rilis</label>
                        <input type="number" name="release_year" class="custom-input" value="{{ old('release_year') }}"
                            style="border-radius: 50px; padding: 12px 20px;" placeholder="2024" required>
                    </div>
                </div>

                <div class="form-group">
                    <label
                        style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Sinopsis</label>
                    <textarea name="synopsis" class="custom-input" rows="5"
                        style="border-radius: 20px; padding: 15px 20px; resize: vertical;"
                        placeholder="Ceritakan ringkasan ceritanya..." required>{{ old('synopsis') }}</textarea>
                </div>

                <div class="form-group">
                    <label style="font-weight: 600; color: var(--olive); margin-bottom: 8px; display: block;">Cover
                        Image</label>
                    <div
                        style="border: 2px dashed #ccc; padding: 20px; text-align: center; border-radius: 20px; cursor: pointer; position: relative; background: #f9f9f9;">
                        <input type="file" name="cover_image"
                            style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;">
                        <span style="color: #888;">Klik atau drop gambar di sini (JPG/PNG)</span>
                    </div>
                    @error('cover_image') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-login"
                    style="margin-top: 20px; background-color: var(--orange); color: var(--olive); border-radius: 50px; font-weight: 700; padding: 14px; box-shadow: 0 5px 15px rgba(252, 181, 59, 0.3);">
                    Simpan Webtoon
                </button>
            </form>
        </div>
    </div>
@endsection