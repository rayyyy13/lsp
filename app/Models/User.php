<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * Model User - merepresentasikan satu pengguna di sistem.
 * Memiliki relasi ke Post dan Comment.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /** Kolom yang boleh diisi secara massal */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'bio', 'profile_photo_path'
    ];

    /** Kolom yang disembunyikan saat di-serialize (misal ke JSON/API) */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Relasi: satu user bisa memiliki banyak postingan.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relasi: satu user bisa memiliki banyak komentar.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Accessor: mengembalikan URL foto profil.
     * Jika tidak ada foto, gunakan placeholder dari ui-avatars.com.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return Storage::url($this->profile_photo_path);
        }
        return 'https://ui-avatars.com/api/?name=' 
             . urlencode($this->name) 
             . '&background=1d9bf0&color=fff&size=200';
    }

     public function getIsOwnProfileAttribute()
    {
        // Return true jika ID user ini sama dengan ID user yang sedang login
        return $this->id === auth()->id();
    }
}