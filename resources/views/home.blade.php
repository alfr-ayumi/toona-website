@extends('layouts.app') {{-- <-- Ini kuncinya! Dia pake layout induk --}} @section('content') {{-- Hero Section --}}
    <section class="hero">
    <div class="container">
        <div class="hero-content">
            <h2 class="hero-title">Arsipkan & Review <span class="highlight">Webtoon</span> Favoritmu</h2>
            <p class="hero-description">Simpan, catat, dan bagikan pengalaman membaca webtoon kamu. ToonA adalah
                platform untuk para pencinta webtoon.</p>
            <div class="hero-buttons">
                <a href="{{ route('webtoons.index') }}" class="btn-primary">Mulai Eksplorasi</a>
                <a href="#" class="btn-secondary">Lihat Koleksi</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="card-stack" id="cardStack">
                <div class="webtoon-card card-1" data-position="front">
                    <div class="card-body">
                        {{-- Ganti gambar sesuai aset kamu --}}
                        @if(file_exists(public_path('images/gambar1.png')))
                            <img src="{{ asset('images/gambar1.png') }}" alt="Webtoon 1">
                        @else
                            <div
                                style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center;">
                                📖</div>
                        @endif
                        <h5>Omniscient Reader</h5>
                    </div>
                </div>
                <div class="webtoon-card card-2" data-position="left">
                    <div class="card-body">
                        @if(file_exists(public_path('images/gambar2.png')))
                            <img src="{{ asset('images/gambar2.png') }}" alt="Webtoon 2">
                        @else
                            <div
                                style="height: 100%; background: #ccc; display: flex; align-items: center; justify-content: center;">
                                📖</div>
                        @endif
                        <h5>Lookism</h5>
                    </div>
                </div>
                <div class="webtoon-card card-3" data-position="right">
                    <div class="card-body">
                        @if(file_exists(public_path('images/gambar3.png')))
                            <img src="{{ asset('images/gambar3.png') }}" alt="Webtoon 3">
                        @else
                            <div
                                style="height: 100%; background: #bbb; display: flex; align-items: center; justify-content: center;">
                                📖</div>
                        @endif
                        <h5>Solo Leveling</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    {{-- Features Section --}}
    <section class="features">
        <div class="container">
            <h3 class="section-title">Fitur Unggulan</h3>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #84994f;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FAF8F3" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h4>Arsip Webtoon</h4>
                    <p>Simpan dan organisir koleksi webtoon kamu dengan mudah</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #FCB53B;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FAF8F3" stroke-width="2">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                            </polygon>
                        </svg>
                    </div>
                    <h4>Tulis Review</h4>
                    <p>Bagikan pendapat dan rating untuk setiap webtoon yang kamu baca</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background-color: #A72703;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FAF8F3" stroke-width="2">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                    </div>
                    <h4>Daftar Bacaan</h4>
                    <p>Kelola daftar webtoon yang sedang dan akan kamu baca</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h3>Siap Memulai Perjalanan Webtoon-mu?</h3>
                <p>Bergabung dengan ToonA sekarang dan nikmati pengalaman membaca yang lebih terorganisir</p>
                <a href="{{ route('register') }}" class="btn-primary"
                    style="background: white; color: var(--olive);">Daftar Gratis</a>
            </div>
        </div>
    </section>

    {{-- Script Animasi Hero --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cardStack = document.getElementById('cardStack');
            if (cardStack) {
                const cards = cardStack.querySelectorAll('.webtoon-card');
                cardStack.addEventListener('click', () => {
                    cards.forEach(card => {
                        const currentPos = card.getAttribute('data-position');
                        if (currentPos === 'front') card.setAttribute('data-position', 'right');
                        else if (currentPos === 'left') card.setAttribute('data-position', 'front');
                        else if (currentPos === 'right') card.setAttribute('data-position', 'left');
                    });
                    cards.forEach(card => {
                        const newPos = card.getAttribute('data-position');
                        if (newPos === 'front') card.className = 'webtoon-card card-1';
                        else if (newPos === 'left') card.className = 'webtoon-card card-2';
                        else if (newPos === 'right') card.className = 'webtoon-card card-3';
                    });
                });
            }
        });
    </script>
@endsection