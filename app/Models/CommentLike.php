<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model CommentLike - merepresentasikan satu aksi "Suka" pada komentar.
 */
class CommentLike extends Model
{
    use HasFactory;

    /** Kolom yang boleh diisi massal */
    protected $fillable = ['comment_id', 'user_id'];
}