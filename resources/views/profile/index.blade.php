@extends('layouts.app')

@section('content')
    <style>
        /* Menggunakan variabel dari style.css utama, tapi menambahkan style khusus halaman ini */

        .profile-page {
            padding: 40px 0;
        }

        /* Header Profile */
        .profile-header {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            align-items: center;
        }

        .profile-avatar img, .profile-avatar-placeholder {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--white);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .profile-avatar-placeholder {
            background: var(--olive);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: 800;
        }

        .profile-info h2 {
            margin: 0;
            font-size: 28px;
            color: var(--olive);
            font-weight: 800;
        }

        .bio {
            margin: 10px 0;
            color: #666;
            font-size: 16px;
        }

        /* Stats */
        .profile-stats {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }

        .stat-card {
            background: var(--white);
            padding: 10px 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            min-width: 90px;
        }

        .stat-card strong {
            display: block;
            font-size: 20px;
            color: var(--olive);
        }

        .stat-card span {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Tabs */
        .profile-tabs {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
        }

        .tab {
            background: none;
            border: none;
            font-weight: 600;
            cursor: pointer;
            padding-bottom: 10px;
            font-size: 16px;
            color: #888;
            transition: all 0.3s;
        }

        .tab:hover {
            color: var(--olive);
        }

        .tab.active {
            border-bottom: 3px solid var(--orange);
            color: var(--olive);
        }

        /* Tab Contents */
        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Reading Stats Box */
        .reading-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: var(--white);
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--olive);
        }

        .stat-box strong {
            font-size: 20px;
            color: var(--orange);
        }

        /* Section Titles */
        .profile-section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--olive);
            margin-bottom: 20px;
            border-left: 4px solid var(--orange);
            padding-left: 15px;
        }

        /* Activity & Timeline */
        .extra-section {
            margin-top: 50px;
        }

        .activity-card {
            display: flex;
            align-items: center;
            gap: 15px;
            background: var(--white);
            padding: 15px 20px;
            border-radius: 14px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .dot {
            width: 10px;
            height: 10px;
            background: var(--olive);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .timeline {
            border-left: 3px solid #e5e7eb;
            padding-left: 25px;
            margin-left: 10px;
        }

        .timeline-item {
            margin-bottom: 25px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -33px;
            top: 5px;
            width: 12px;
            height: 12px;
            background: var(--orange);
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        .timeline-item span {
            font-weight: 700;
            color: var(--olive);
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        /* Horizontal Scroll */
        .horizontal-scroll {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding-bottom: 15px;
            scrollbar-width: none;
        }
        .horizontal-scroll::-webkit-scrollbar { display: none; }

        .mini-cover {
            width: 100px;
            height: 140px;
            background: #eee;
            border-radius: 12px;
            flex-shrink: 0;
            overflow: hidden;
        }
        .mini-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Reading List Item */
        .profile-reading-item {
            background: var(--white);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .pill-reading { background: var(--orange); color: var(--olive); }
        .pill-completed { background: var(--olive); color: var(--white); }
        .pill-want { background: #fee2e2; color: var(--red); }

        /* Footer */
        .profile-footer {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #888;
            font-size: 13px;
        }

        /* Buttons */
        .btn-outline {
            border: 2px solid var(--olive);
            background: transparent;
            color: var(--olive);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-outline:hover {
            background: var(--olive);
            color: var(--white);
        }
    </style>

    <div class="container profile-page">

        <section class="profile-header">
            <div class="profile-avatar">
                <div class="profile-avatar-placeholder">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>

            <div class="profile-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p class="bio">{{ Auth::user()->email }}</p>

                <div class="profile-stats">
                    <div class="stat-card">
                        <strong>{{ $readingStats['reading'] ?? 0 }}</strong>
                        <span>Sedang Baca</span>
                    </div>
                    <div class="stat-card">
                        <strong>{{ $userReviews->count() ?? 0 }}</strong>
                        <span>Review</span>
                    </div>
                    <div class="stat-card">
                        <strong>{{ number_format($avgRating ?? 0, 1) }}</strong>
                        <span>Rating Avg</span>
                    </div>
                </div>

                <button class="btn-outline">Edit Profile</button>
            </div>
        </section>

        <nav class="profile-tabs">
            <button class="tab active" onclick="openTab(event, 'overview')">Overview</button>
            <button class="tab" onclick="openTab(event, 'reading-list')">Daftar Bacaan</button>
            <button class="tab" onclick="openTab(event, 'reviews')">Review</button>
        </nav>

        <div id="overview" class="tab-content active">
            <h3 class="profile-section-title">Statistik Bacaan</h3>
            <div class="reading-stats">
                <div class="stat-box">Reading <strong>{{ $readingStats['reading'] ?? 0 }}</strong></div>
                <div class="stat-box">Completed <strong>{{ $readingStats['completed'] ?? 0 }}</strong></div>
                <div class="stat-box">Want to Read <strong>{{ $readingStats['want_to_read'] ?? 0 }}</strong></div>
            </div>

            <div class="extra-section">
                <h3 class="profile-section-title">Recently Read</h3>
                <div class="horizontal-scroll">
                    @forelse($recentRead as $item)
                        <div class="mini-cover">
                            @if($item->webtoon->cover_image)
                                <img src="{{ Storage::url($item->webtoon->cover_image) }}" alt="{{ $item->webtoon->title }}">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #ddd; color: #888;">📖</div>
                            @endif
                        </div>
                    @empty
                        <p style="color: #999; font-style: italic; padding: 20px;">Belum ada aktivitas membaca.</p>
                    @endforelse
                </div>
            </div>

            <div class="extra-section">
                <h3 class="profile-section-title">Reading Timeline</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <span>Terbaru</span>
                        <p>Memperbarui daftar bacaan kamu.</p>
                    </div>
                    <div class="timeline-item">
                        <span>{{ Auth::user()->created_at->format('F Y') }}</span>
                        <p>Bergabung dengan ToonA</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="reading-list" class="tab-content">
            <h3 class="profile-section-title">Daftar Bacaan Lengkap</h3>
            @forelse($allReadingList as $list)
                <div class="profile-reading-item">
                    <div>
                        <h4 style="margin:0 0 5px 0; color: var(--olive);">{{ $list->webtoon->title }}</h4>
                        <span class="status-pill {{ $list->status == 'reading' ? 'pill-reading' : ($list->status == 'completed' ? 'pill-completed' : 'pill-want') }}">
                            {{ ucfirst(str_replace('_', ' ', $list->status)) }}
                        </span>
                    </div>
                    <a href="{{ route('webtoons.show', $list->webtoon) }}" style="color: var(--orange); font-weight: 700; text-decoration: none; font-size: 14px;">Lihat</a>
                </div>
            @empty
                <p style="text-align: center; color: #999; padding: 40px;">Belum ada daftar bacaan.</p>
            @endforelse
        </div>

        <div id="reviews" class="tab-content">
            <h3 class="profile-section-title">Review Saya</h3>
            @forelse($userReviews as $review)
                <div style="background: var(--white); padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <h4 style="margin: 0; color: var(--olive);">{{ $review->webtoon->title }}</h4>
                        <span style="color: var(--orange);">★ {{ $review->rating }}</span>
                    </div>
                    <p style="color: #555; margin-bottom: 10px;">{{ $review->review_text }}</p>
                    <small style="color: #999;">{{ $review->created_at->format('d M Y') }}</small>
                </div>
            @empty
                <p style="text-align: center; color: #999; padding: 40px;">Belum ada review yang ditulis.</p>
            @endforelse
        </div>

        <footer class="profile-footer">
            <p>
                {{ '@' . strtolower(str_replace(' ', '', Auth::user()->name)) }} di ToonA  
                <span>• Bergabung sejak {{ Auth::user()->created_at->year }}</span>
            </p>
        </footer>

    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove('active');
            }
            tablinks = document.getElementsByClassName("tab");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            document.getElementById(tabName).classList.add('active');
            evt.currentTarget.className += " active";
        }
    </script>
@endsection