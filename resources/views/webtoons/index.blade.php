@extends('layouts.app')

@section('content')
    <div class="container" style="padding: 40px 0 80px;">

        {{-- Header & Search Section --}}
        <div style="margin-bottom: 50px;">
            {{-- Kita buat Flex Container buat Judul (Kiri) dan Aksi (Kanan) --}}
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">

                {{-- Bagian Kiri: Judul --}}
                <div style="flex: 1; min-width: 250px;">
                    <h1
                        style="font-size: 36px; font-weight: 800; margin-bottom: 5px; color: var(--olive); line-height: 1.2;">
                        Koleksi Webtoon
                    </h1>
                    <p style="color: #888; font-size: 16px; margin: 0;">
                        Cari dan review cerita favoritmu
                    </p>
                </div>

                {{-- Bagian Kanan: Search + Tombol Tambah --}}
                <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">

                    {{-- Tombol Tambah (Sekarang ditaruh di sini supaya selalu muncul) --}}
                    @auth
                        <a href="{{ route('webtoons.create') }}"
                            style="background: var(--orange); color: var(--olive); padding: 12px 25px; border-radius: 50px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 15px rgba(252, 181, 59, 0.4); white-space: nowrap; display: inline-block;">
                            Baru
                        </a>
                    @endauth

                    {{-- Search Bar --}}
                    <form action="{{ route('webtoons.index') }}" method="GET"
                        style="display: flex; gap: 10px; position: relative;">

                        <input type="text" name="search" class="custom-input" placeholder="Cari..."
                            value="{{ request('search') }}"
                            style="border-radius: 50px; padding: 12px 20px; border: 2px solid #eee; outline: none; width: 200px; background: white;">

                        <button type="submit"
                            style="background-color: var(--olive); color: var(--white); border: none; padding: 12px 30px; border-radius: 50px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(252, 181, 59, 0.4); transition: transform 0.2s; white-space: nowrap;">
                            Cari
                    </form>
                </div>
            </div>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div
                style="background: #d1e7dd; color: #0f5132; padding: 15px 25px; border-radius: 20px; margin-bottom: 40px; border: 1px solid #badbcc;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grid Webtoon --}}
        @if($webtoons->count())
            <div class="webtoon-grid"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px;">
                @foreach($webtoons as $webtoon)
                    <div class="webtoon-item"
                        style="border-radius: 24px; overflow: hidden; background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s;">

                        {{-- Cover Image --}}
                        <div class="webtoon-cover" style="height: 320px; position: relative; overflow: hidden;">
                            @if($webtoon->cover_image)
                                <img src="{{ Storage::url($webtoon->cover_image) }}" alt="{{ $webtoon->title }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div
                                    style="height:100%; width:100%; background-color: var(--olive); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    📖
                                </div>
                            @endif
                        </div>

                        {{-- Info Section --}}
                        <div class="webtoon-info" style="padding: 24px;">
                            <div style="margin-bottom: 15px;">
                                <h5
                                    style="font-weight: 700; font-size: 18px; color: var(--olive); margin-bottom: 5px; line-height: 1.3;">
                                    {{ \Illuminate\Support\Str::limit($webtoon->title, 40) }}
                                </h5>
                                <p style="color: #999; font-size: 14px; margin: 0;">by
                                    {{ \Illuminate\Support\Str::limit($webtoon->author, 30) }}
                                </p>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                <div style="display: flex; flex-direction: column;">
                                    <div
                                        style="color: #ddd; font-size: 14px; position: relative; display: inline-block; line-height: 1;">
                                        <span>★★★★★</span>
                                        <div
                                            style="color: var(--orange); position: absolute; top: 0; left: 0; overflow: hidden; width: {{ ($webtoon->averageRating() / 5) * 100 }}%; white-space: nowrap;">
                                            ★★★★★
                                        </div>
                                    </div>
                                    <span style="font-size: 12px; color: #aaa; margin-top: 4px;">
                                        {{ number_format($webtoon->averageRating(), 1) }} / 5.0
                                    </span>
                                </div>

                                <a href="{{ route('webtoons.show', $webtoon) }}"
                                    style="background-color: var(--cream); color: var(--olive); padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 13px; text-decoration: none; border: 1px solid rgba(0,0,0,0.05); transition: background 0.3s;">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 60px; display: flex; justify-content: center;">
                {{ $webtoons->links() }}
            </div>

        @else
            {{-- Empty State (Tetap ada buat jaga-jaga kalau dihapus semua) --}}
            <div
                style="text-align: center; padding: 80px 20px; background: white; border-radius: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.05); margin-top: 40px;">
                <div style="font-size: 60px; margin-bottom: 25px;">🧐</div>
                <h3 style="color: var(--olive); font-weight: 800; font-size: 24px; margin-bottom: 10px;">
                    @if(request('search'))
                        "{{ request('search') }}" tidak ditemukan
                    @else
                        Belum ada Webtoon
                    @endif
                </h3>
                <p style="color: #888; margin-bottom: 30px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    Bantu kami melengkapi koleksi dengan menambahkan webtoon favoritmu.
                </p>

                @auth
                    <a href="{{ route('webtoons.create') }}"
                        style="background: var(--orange); color: var(--olive); padding: 15px 40px; border-radius: 50px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 10px 25px rgba(252, 181, 59, 0.3);">
                        + Tambah Webtoon Baru
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        style="background: var(--olive); color: white; padding: 15px 40px; border-radius: 50px; font-weight: 700; text-decoration: none; display: inline-block;">
                        Login untuk Menambah
                    </a>
                @endauth
            </div>
        @endif
    </div>
@endsection