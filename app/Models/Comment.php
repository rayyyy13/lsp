<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Model Comment - merepresentasikan satu komentar pada postingan.
 * Memiliki relasi ke Post, User, dan akses hashtag.
 */
class Comment extends Model
{
    use HasFactory;

    /** Kolom yang boleh diisi secara massal */
    protected $fillable = ['post_id', 'user_id', 'parent_id', 'content', 'image_path', 'file_path', 'file_name'];

    /**
     * Booted method: otomatis hapus file terkait saat komentar dihapus.
     */
    protected static function booted(): void
    {
        static::deleting(function (Comment $comment) {
            if ($comment->image_path) Storage::delete($comment->image_path);
            if ($comment->file_path) Storage::delete($comment->file_path);
        });
    }

        /** Relasi: Balasan dari komentar ini (Nested Comment) */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user', 'likes');
    }

    /** Relasi: Komentar ini adalah balasan dari komentar mana */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /** Relasi: komentar ini dimiliki oleh satu user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi: komentar ini termasuk dalam satu postingan */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Accessor: mengambil array hashtag dari konten komentar.
     */
    public function getHashtagsAttribute(): array
    {
        preg_match_all('/#(\w+)/', $this->content, $matches);
        return $matches[1] ?? [];
    }
        /**
     * Relasi: satu komentar bisa memiliki banyak like.
     */
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Method helper: mengecek apakah user yang sedang login menyukai komentar ini.
     */
    public function isLikedByAuthUser()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
}