<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Model Post - merepresentasikan satu postingan.
 * Memiliki relasi ke User (pemilik) dan Comment (daftar komentar).
 */
class Post extends Model
{
    use HasFactory;

    /** Kolom yang boleh diisi secara massal */
    protected $fillable = ['user_id', 'content', 'image_path', 'file_path', 'file_name'];

    /**
     * Booted method: otomatis hapus file gambar & file saat postingan dihapus.
     * Mencegah file orphan di folder storage.
     */
    protected static function booted(): void
    {
        static::deleting(function (Post $post) {
            if ($post->image_path) Storage::delete($post->image_path);
            if ($post->file_path) Storage::delete($post->file_path);
        });
    }

    /** Relasi: postingan ini dimiliki oleh satu user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi: postingan ini memiliki banyak komentar */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

        /** Relasi: satu post punya banyak like */
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    /** Cek apakah user yang login menyukai post ini */
    public function isLikedByAuthUser()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    /**
     * Accessor: mengambil array hashtag yang ada di dalam konten postingan.
     * @return array - Daftar hashtag tanpa simbol #
     */
    public function getHashtagsAttribute(): array
    {
        preg_match_all('/#(\w+)/', $this->content, $matches);
        return $matches[1] ?? [];
    }
}