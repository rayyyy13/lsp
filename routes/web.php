<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\CommentLikeController;

/*
|--------------------------------------------------------------------------
| Rute Publik - Tidak memerlukan login
|--------------------------------------------------------------------------
*/

/** Menampilkan halaman login */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

/** Proses submit form login */
Route::post('/login', [AuthController::class, 'login']);

/** Menampilkan halaman register */
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

/** Proses submit form register */
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Rute Terproteksi - Harus login dulu (middleware 'auth')
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

        /** Toggle like pada komentar (mengembalikan JSON) */
    Route::post('/comments/{id}/like', [CommentLikeController::class, 'toggle'])->name('comments.like');

    /** Proses logout */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /** Halaman edit profil */
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    /** Proses update profil */
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /** Beranda - menampilkan feed semua postingan */
    Route::get('/', [PostController::class, 'index'])->name('home');

    /** Membuat postingan baru */
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    /** Melihat detail postingan + komentar */
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

    /** Halaman edit postingan */
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');

    /** Proses update postingan */
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

    /** Menghapus postingan */
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    /** Menambah komentar pada postingan */
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store');

    /** Halaman edit komentar */
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');

    /** Proses update komentar */
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');

    /** Menghapus komentar */
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

        /** Toggle like pada postingan */
    Route::post('/posts/{id}/like', [PostLikeController::class, 'toggle'])->name('posts.like');

    /** Filter postingan berdasarkan hashtag */
    Route::get('/hashtag/{tag}', [HashtagController::class, 'show'])->name('hashtag.show');
});