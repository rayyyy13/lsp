<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    /** Toggle like: jika sudah like -> unlike, jika belum -> like */
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);
        $user = Auth::user();

        $existingLike = PostLike::where('post_id', $post->id)
                                ->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $isLiked = false;
        } else {
            PostLike::create(['post_id' => $post->id, 'user_id' => $user->id]);
            $isLiked = true;
        }

        return response()->json([
            'liked' => $isLiked,
            'count' => $post->likes()->count()
        ]);
    }
}