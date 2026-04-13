<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebtoonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReadingListController;
use App\Http\Controllers\ProfileController; // <--- Jangan lupa ini di paling atas file


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('webtoons', WebtoonController::class);

Route::post(
    'webtoons/{webtoon}/reviews',
    [ReviewController::class, 'store']
)->name('reviews.store');

Route::get('/profile', function () {
    $user = auth()->user()->load('reviews.webtoon');
    return view('profile.index', compact('user'));
})->middleware('auth');


// ... di dalam middleware auth group
Route::resource('reading-lists', ReadingListController::class);
// Route khusus untuk destroy all jika mau dipakai
Route::delete('reading-lists/destroy-all', [ReadingListController::class, 'destroyAll'])->name('reading-lists.destroyAll');
Route::post('/reading-lists/{webtoon}', [ReadingListController::class, 'store'])->name('reading-lists.add');

// Route resource standar (untuk index, update, destroy)
Route::resource('reading-lists', ReadingListController::class)->except(['store', 'create', 'show']);
// ... code lain ...

Route::middleware(['auth'])->group(function () {
    // ... route webtoon/reading-list yang lain ...

    // TAMBAHKAN INI:
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});