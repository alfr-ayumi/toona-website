@extends('layouts.app')

@section('content')
    <div class="container" style="padding-top: 40px; padding-bottom: 80px;">

        {{-- Tombol Kembali --}}
        <a href="{{ route('webtoons.index') }}"
            style="display: inline-block; margin-bottom: 25px; color: var(--olive); text-decoration: none; font-weight: 600;">
            Kembali ke Daftar
        </a>

        {{-- Container Utama (Simetris & Rounded) --}}
        <div
            style="background: var(--white); border-radius: 30px; box-shadow: 0 15px 40px rgba(0,0,0,0.06); overflow: hidden; display: flex; flex-wrap: wrap;">

            {{-- Kolom Kiri: Cover Image --}}
            <div style="flex: 1; min-width: 350px; position: relative; background: #eee;">
                @if($webtoon->cover_image)
                    <img src="{{ Storage::url($webtoon->cover_image) }}" alt="{{ $webtoon->title }}"
                        style="width: 100%; height: 100%; object-fit: cover; min-height: 500px;">
                @else
                    <div
                        style="width: 100%; height: 100%; min-height: 500px; display: flex; align-items: center; justify-content: center; background-color: var(--olive); color: white; font-size: 5rem;">
                        📖
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan: Informasi --}}
            <div style="flex: 1.2; padding: 50px; display: flex; flex-direction: column; justify-content: center;">
                <div
                    style="background: var(--cream); color: var(--olive); padding: 6px 16px; border-radius: 50px; font-weight: 700; width: fit-content; font-size: 14px; margin-bottom: 15px;">
                    {{ $webtoon->release_year }}
                </div>

                <h1 style="font-size: 46px; color: var(--olive); margin-bottom: 10px; font-weight: 800; line-height: 1.1;">
                    {{ $webtoon->title }}
                </h1>
                <p style="font-size: 18px; color: #888; font-weight: 500; margin-bottom: 25px;">
                    Ditulis oleh {{ $webtoon->author }}
                </p>

                {{-- Rating Visual (5 Bintang) --}}
                <div
                    style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; background: var(--cream); padding: 15px 25px; border-radius: 20px; width: fit-content;">
                    <div style="position: relative; font-size: 24px; color: #ddd; line-height: 1;">
                        ★★★★★
                        <div
                            style="position: absolute; top: 0; left: 0; overflow: hidden; width: {{ ($webtoon->averageRating() / 5) * 100 }}%; color: var(--orange); white-space: nowrap;">
                            ★★★★★
                        </div>
                    </div>
                    <span style="font-weight: 700; font-size: 20px; color: var(--olive);">
                        {{ number_format($webtoon->averageRating(), 1) }}
                    </span>
                    <span style="font-size: 14px; color: #999; border-left: 2px solid #ddd; padding-left: 15px;">
                        ({{ $webtoon->reviews->count() }} Review)
                    </span>
                </div>

                @auth
                    @php
                        // Cek apakah webtoon ini sudah ada di list user?
                        $existingList = \App\Models\ReadingList::where('user_id', auth()->id())
                            ->where('webtoon_id', $webtoon->id)
                            ->first();
                    @endphp

                    <div
                        style="margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 20px; border: 1px solid #eee;">
                        @if($existingList)
                            {{-- Tampilan kalau SUDAH ada di list --}}
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <span
                                        style="display: block; font-size: 12px; color: #888; font-weight: 600; text-transform: uppercase;">Status
                                        Bacaan</span>
                                    <span style="font-weight: 700; font-size: 16px;">
                                        @if($existingList->status == 'reading')Sedang Dibaca
                                        @elseif($existingList->status == 'completed')Selesai
                                        @else Ingin Dibaca
                                        @endif
                                    </span>
                                </div>
                                <a href="{{ route('reading-lists.index') }}"
                                    style="font-size: 14px; color: var(--orange); font-weight: 700; text-decoration: none;">
                                    Lihat List
                                </a>
                            </div>
                        @else
                            {{-- Tampilan kalau BELUM ada di list (Form Tambah) --}}
                            <form action="{{ route('reading-lists.add', $webtoon) }}" method="POST"
                                style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                @csrf

                                <div style="flex: 1; min-width: 150px;">
                                    <label
                                        style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 5px;">Tambahkan
                                        ke Daftar:</label>
                                    <select name="status" class="custom-input"
                                        style="border-radius: 50px; padding: 10px 20px; width: 100%; cursor: pointer;">
                                        <option value="reading">Sedang Dibaca</option>
                                        <option value="want_to_read">Ingin Dibaca</option>
                                        <option value="completed">Selesai</option>
                                    </select>
                                </div>

                                <button type="submit"
                                    style="margin-top: 18px; background: var(--olive); color: white; border: none; padding: 11px 25px; border-radius: 50px; font-weight: 700; cursor: pointer; white-space: nowrap; box-shadow: 0 4px 10px rgba(53, 74, 69, 0.3);">
                                    Simpan
                                </button>
                            </form>
                        @endif
                    </div>
                @endauth
                <h4 style="font-weight: 700; color: var(--olive); margin-bottom: 10px;">Sinopsis</h4>
                <p style="line-height: 1.7; color: #555; font-size: 16px; margin-bottom: 40px;">
                    {{ $webtoon->synopsis }}
                </p>

                {{-- Tombol Admin (Rounded & Cerah) --}}
                @auth
                    <div style="display: flex; gap: 15px; border-top: 1px solid #f0f0f0; padding-top: 30px; margin-top: auto;">
                        <a href="{{ route('webtoons.edit', $webtoon) }}"
                            style="background: var(--orange); color: var(--olive); padding: 12px 30px; border-radius: 50px; font-weight: 700; text-decoration: none; transition: transform 0.2s; box-shadow: 0 5px 15px rgba(252, 181, 59, 0.3);">
                            Edit Info
                        </a>

                        <form action="{{ route('webtoons.destroy', $webtoon) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="background: #fff; color: var(--red); padding: 12px 30px; border-radius: 50px; border: 2px solid #fee; font-weight: 700; cursor: pointer; transition: background 0.2s;">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Bagian Review --}}
        <div style="margin-top: 60px; max-width: 800px; margin-left: auto; margin-right: auto;">
            <h3 style="text-align: center; color: var(--olive); margin-bottom: 40px; font-weight: 800; font-size: 28px;">
                Ulasan Pembaca
            </h3>

            @auth
                <div
                    style="background: var(--white); padding: 30px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 40px;">
                    <h5 style="margin-bottom: 20px; font-weight: 700; color: var(--olive);">Bagikan Pendapatmu</h5>
                    <form action="{{ route('reviews.store', $webtoon) }}" method="POST">
                        @csrf
                        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                            <select name="rating" class="custom-input"
                                style="width: 120px; border-radius: 50px; padding: 12px 20px; cursor: pointer;">
                                <option value="5">⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>
                            </select>
                            <input type="text" name="review_text" class="custom-input"
                                style="border-radius: 50px; padding: 12px 25px;" placeholder="Tulis ulasan singkat...">
                        </div>
                        <button
                            style="background: var(--orange); color: var(--olive); padding: 12px 40px; border-radius: 50px; border: none; font-weight: 700; cursor: pointer; float: right; box-shadow: 0 5px 15px rgba(252, 181, 59, 0.3);">
                            Kirim Ulasan
                        </button>
                        <div style="clear: both;"></div>
                    </form>
                </div>
            @endauth

            <div style="display: flex; flex-direction: column; gap: 20px;">
                @forelse($webtoon->reviews as $review)
                    <div
                        style="background: var(--white); padding: 25px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.03);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 40px; height: 40px; background: var(--cream); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--olive);">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <strong style="color: var(--olive);">{{ $review->user->name }}</strong>
                            </div>
                            <span style="color: var(--orange); font-weight: 700;">⭐ {{ $review->rating }}</span>
                        </div>
                        <p style="margin: 0 0 10px 50px; color: #555; line-height: 1.5;">{{ $review->review_text }}</p>
                        <small
                            style="color: #bbb; display: block; margin-left: 50px;">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <div style="text-align: center; color: #999; padding: 40px;">
                        <p style="font-style: italic;">Belum ada ulasan. Jadilah yang pertama!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection