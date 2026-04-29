<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Auth;

/**
 * CommentLikeController - Menangani logika Like/Unlike pada komentar.
 * Mengembalikan data JSON agar bisa diproses oleh JavaScript tanpa reload halaman.
 */
class CommentLikeController extends Controller
{
    /**
     * Toggle like: jika belum like -> like. Jika sudah like -> unlike (hapus).
     */
    public function toggle($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $user = Auth::user();

        // Cek apakah user sudah like komentar ini
        $existingLike = CommentLike::where('comment_id', $comment->id)
                                    ->where('user_id', $user->id)
                                    ->first();

        if ($existingLike) {
            // Jika sudah like, hapus like (Unlike)
            $existingLike->delete();
            $isLiked = false;
        } else {
            // Jika belum like, buat like baru
            CommentLike::create([
                'comment_id' => $comment->id,
                'user_id' => $user->id,
            ]);
            $isLiked = true;
        }

        // Hitung total like terbaru
        $likeCount = $comment->likes()->count();

        // Kembalikan dalam format JSON
        return response()->json([
            'liked' => $isLiked,
            'count' => $likeCount
        ]);
    }
}