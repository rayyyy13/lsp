<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk tabel comment_likes.
 * Menyimpan data user yang menyukai sebuah komentar.
 * Menggunakan unique constraint agar 1 user hanya bisa like 1 komentar sekali.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comment_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->constrained()->onDelete('cascade'); // Relasi ke komentar
            $table->foreignId('user_id')->constrained()->onDelete('cascade');    // Relasi ke user
            $table->timestamps();
            
            // Mencegah duplikasi like (1 user 1 komentar maksimal 1 like)
            $table->unique(['comment_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comment_likes');
    }
};