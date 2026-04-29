<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    /** Menampilkan postingan DAN SEMUA komentar (termasuk balasan) yang mengandung hashtag */
    public function show($tag)
    {
        // 1. Cari di Postingan
        $posts = Post::with(['user', 'comments.user', 'likes'])
            ->where('content', 'LIKE', "%#{$tag}%")
            ->latest()
            ->get();

        // 2. Cari di SEMUA Komentar (tidak dibedakan utama atau balasan)
        $comments = Comment::with(['user', 'likes', 'parent.user']) // load parent untuk tahu konteksnya
            ->where('content', 'LIKE', "%#{$tag}%")
            ->latest()
            ->get();

         $pageTitle = '#' . $tag . ' — Vyona';

        return view('hashtag.index', compact('posts', 'comments', 'tag', 'pageTitle'));
    }
}