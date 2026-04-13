@extends('layouts.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Menggunakan font yang bersih dan modern */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');

        /* Definisi Palet Warna (Sesuai Request) */
        :root {
            --color-primary: #84994F;
            --color-secondary: #FFE797;
            --color-accent: #FCB53B;
            --color-danger: #A72703;
        }

        /* Override body background dari layout app jika perlu */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Container styling */
        .widget-container {
            /* background-color: #f7f7f7;  Opsional, sesuaikan dengan tema */
            width: 100%;
            padding: 20px 0;
        }

        /* Gaya Kartu Minimalis */
        .minimal-card {
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            width: 160px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 290px;
            overflow: hidden;
            position: relative;
        }

        .minimal-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        .cover-image {
            width: 100%;
            height: 65%;
            object-fit: cover;
            border-bottom: 3px solid var(--color-secondary);
        }

        /* Tombol Aksi */
        .action-icon-btn {
            color: #888;
            padding: 5px;
            border-radius: 6px;
            transition: all 0.2s;
            background: #f3f4f6;
        }

        .action-icon-btn:hover {
            color: white;
        }

        .btn-edit:hover {
            background-color: var(--color-accent);
        }

        .btn-delete:hover {
            background-color: var(--color-danger);
        }

        /* Badge Status */
        .status-badge {
            font-family: 'Inter', sans-serif;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .bg-reading {
            background-color: var(--color-accent);
            color: white;
        }

        .bg-completed {
            background-color: var(--color-primary);
            color: white;
        }

        .bg-want {
            background-color: var(--color-secondary);
            color: var(--color-danger);
        }

        /* Scrollbar Hide */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Judul Section */
        .section-header {
            color: var(--olive);
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 10px;
            padding-left: 1.25rem;
            border-left: 4px solid var(--olive);
        }
    </style>

    <div class="container mx-auto px-4 py-8">

        {{-- Header Page --}}
        <div class="flex justify-between items-end mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-bold" color: var(Olive);">
                    Daftar Bacaan Saya
                </h1>
                <p class="text-gray-500 text-sm mt-1">Kelola progres membaca webtoonmu.</p>
            </div>
            {{-- Tombol Tambah Mengarah ke Index Webtoon --}}
            <a href="{{ route('webtoons.index') }}"
                class="px-4 py-2 rounded-full text-white text-sm font-semibold shadow-md transition transform hover:scale-105"
                style="background-color: var(--color-accent);">
                Cari Webtoon Baru
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- LOOPING STATUS (Reading, Completed, Want to Read) --}}
        @php
            $statuses = [
                'reading' => ['label' => 'Sedang Dibaca', 'class' => 'bg-reading'],
                'want_to_read' => ['label' => 'Ingin Dibaca', 'class' => 'bg-want'],
                'completed' => ['label' => 'Selesai', 'class' => 'bg-completed'],
            ];
        @endphp

        <div class="space-y-10">
            @foreach($statuses as $key => $meta)
                @if(isset($readingLists[$key]) && $readingLists[$key]->count() > 0)
                    <div class="widget-container">
                        <h2 class="section-header">{{ $meta['label'] }}</h2>

                        {{-- Horizontal Scroll List --}}
                        <div class="flex gap-4 overflow-x-auto pb-4 px-2 scrollbar-hide">
                            @foreach($readingLists[$key] as $item)
                                <div class="minimal-card relative group">
                                    {{-- Cover --}}
                                    <div class="relative h-2/3">
                                        @if($item->webtoon->cover_image)
                                            <img src="{{ Storage::url($item->webtoon->cover_image) }}" alt="{{ $item->webtoon->title }}"
                                                class="cover-image">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-2xl">📖</div>
                                        @endif
                                        <span class="status-badge {{ $meta['class'] }} absolute top-2 right-2">
                                            {{ $meta['label'] }}
                                        </span>
                                    </div>

                                    {{-- Info --}}
                                    <div class="p-3 pt-1 h-1/3 flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-sm font-bold text-gray-800 leading-tight line-clamp-2"
                                                title="{{ $item->webtoon->title }}">
                                                {{ $item->webtoon->title }}
                                            </h3>
                                            <p class="text-xs text-gray-500 italic mt-1 truncate">
                                                {{ $item->webtoon->author }}
                                            </p>
                                        </div>

                                        <div class="flex justify-between items-center mt-2 border-t pt-2">
                                            <span class="text-xs font-semibold text-gray-400">
                                                {{ $item->webtoon->release_year }}
                                            </span>

                                            <div
                                                class="flex gap-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                                {{-- Tombol Edit --}}
                                                <button
                                                    onclick="openEditModal('{{ $item->id }}', '{{ $item->webtoon->title }}', '{{ $item->status }}')"
                                                    class="action-icon-btn btn-edit" title="Ubah Status">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M12 20h9" />
                                                        <path d="M16.5 3.5l4 4L7.5 19H3v-4L16.5 3.5z" />
                                                    </svg>
                                                </button>

                                                {{-- Tombol Hapus --}}
                                                <button onclick="openDeleteModal('{{ $item->id }}', '{{ $item->webtoon->title }}')"
                                                    class="action-icon-btn btn-delete" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                        <path d="M10 11v6" />
                                                        <path d="M14 11v6" />
                                                        <path d="M14 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            {{-- Empty State jika tidak ada data sama sekali --}}
            @if($readingLists->isEmpty())
                <div class="text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <div class="text-4xl mb-3">📚</div>
                    <h3 class="text-xl font-bold text-gray-600">Daftar Bacaan Kosong</h3>
                    <p class="text-gray-500 mb-6">Kamu belum menambahkan webtoon apapun ke daftar bacaan.</p>
                    <a href="{{ route('webtoons.index') }}"
                        class="px-6 py-2 bg-orange-400 text-white rounded-full font-bold hover:bg-orange-500 transition">
                        Mulai Jelajahi Webtoon
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL EDIT STATUS --}}
    <div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4">
        <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm transform transition-all scale-100">
            <h3 class="text-lg font-bold text-center mb-1" style="color: var(--color-danger);">UBAH STATUS</h3>
            <p id="edit-title-display" class="text-center text-sm text-gray-500 mb-6 italic truncate"></p>

            <form id="edit-form" method="POST">
                @csrf
                @method('PUT') {{-- Method Spoofing untuk Update --}}

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pilih Status Baru</label>
                    <select name="status" id="edit-status-input"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-orange-300 focus:border-orange-300 outline-none">
                        <option value="want_to_read">Mau Baca (Want to Read)</option>
                        <option value="reading">Sedang Dibaca (Reading)</option>
                        <option value="completed">Selesai (Completed)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('edit-modal')"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300 font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-white rounded-md text-sm font-semibold hover:opacity-90 transition"
                        style="background-color: var(--color-accent);">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div id="delete-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-xs text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus dari List?</h3>
            <p class="text-sm text-gray-500 mb-6">Kamu yakin ingin menghapus "<span id="delete-title-display"
                    class="font-bold"></span>"?</p>

            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeModal('delete-modal')"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300 font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700 font-semibold shadow-md">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MODAL --}}
    <script>
        function openEditModal(id, title, status) {
            const modal = document.getElementById('edit-modal');
            const form = document.getElementById('edit-form');
            const titleDisplay = document.getElementById('edit-title-display');
            const statusInput = document.getElementById('edit-status-input');

            // Set URL Action Form sesuai ID ReadingList
            // Asumsi route bernama 'reading-lists.update'
            form.action = `/reading-lists/${id}`;

            titleDisplay.textContent = title;
            statusInput.value = status;

            modal.classList.remove('hidden');
        }

        function openDeleteModal(id, title) {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-form');
            const titleDisplay = document.getElementById('delete-title-display');

            // Set URL Action Form
            // Asumsi route bernama 'reading-lists.destroy'
            form.action = `/reading-lists/${id}`;

            titleDisplay.textContent = title;
            modal.classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const editModal = document.getElementById('edit-modal');
            const deleteModal = document.getElementById('delete-modal');
            if (event.target == editModal) {
                editModal.classList.add('hidden');
            }
            if (event.target == deleteModal) {
                deleteModal.classList.add('hidden');
            }
        }
    </script>
@endsection