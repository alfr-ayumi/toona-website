<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ToonA</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- CSS Utama --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div id="app">
        {{-- NAVBAR (Satu-satunya Navbar di Aplikasi) --}}
        <nav class="navbar">
            <div class="container">
                <div class="nav-brand">
                    <a href="{{ url('/') }}" style="text-decoration: none;">
                        <h1>ToonA</h1>
                    </a>
                </div>

                <ul class="nav-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('webtoons.index') }}"
                            class="{{ request()->routeIs('webtoons.*') ? 'active' : '' }}">Daftar Webtoon</a></li>
                    @auth
                        <li>
                            <a href="{{ route('reading-lists.index') }}"
                                class="{{ request()->routeIs('reading-lists.*') ? 'active' : '' }}">
                                Bacaan Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.index') }}"
                                class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                Profil
                            </a>
                    @endauth
                </ul>

                <div class="nav-buttons">
                    @guest
                        <a href="{{ route('login') }}" class="btn-login"
                            style="color: #fff; text-decoration: none; margin-right: 15px;">Login</a>
                        <a href="{{ route('register') }}" class="btn-register"
                            style="background: var(--orange); color: var(--olive); padding: 8px 20px; border-radius: 50px; text-decoration: none; font-weight: bold;">Register</a>
                    @else
                        <span style="color: rgba(255,255,255,0.9); margin-right: 15px;">
                            Hi, {{ Auth::user()->name }}
                        </span>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            style="color: #fff; text-decoration: none; font-weight: bold; cursor: pointer;">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </nav>

        {{-- KONTEN (Isi Halaman akan muncul di sini) --}}
        <main style="min-height: 80vh;">
            @yield('content')
        </main>

        {{-- FOOTER (Satu-satunya Footer, Keren & Konsisten) --}}
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-brand">
                        <h2>ToonA</h2>
                        <p>Platform arsip dan review webtoon terbaik untuk komunitas pembaca Indonesia.</p>
                    </div>
                    <div class="footer-links-wrapper">
                        <div class="footer-column">
                            <h5>Navigasi</h5>
                            <ul>
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ route('webtoons.index') }}">Daftar Webtoon</a></li>
                                <li><a href="#">Tentang Kami</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h5>Bantuan</h5>
                            <ul>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Kontak</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2024 ToonA. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>