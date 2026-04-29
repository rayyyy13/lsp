<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/**
 * PostController - Menangani seluruh operasi CRUD postingan:
 * melihat feed, membuat, melihat detail, mengedit, dan menghapus postingan.
 */
class PostController extends Controller
{
    /**
     * Menampilkan beranda: daftar seluruh postingan diurutkan dari terbaru.
     * Menggunakan eager loading (termasuk 'likes') untuk mengurangi query N+1.
     */
            public function index()
    {
        $posts = Post::with('user', 'comments', 'likes')->latest()->get();

        // Gabungkan teks dari POST dan SEMUA KOMENTAR (termasuk balasan)
        $postTexts = Post::pluck('content');
        $commentTexts = Comment::pluck('content'); 
        $allTexts = $postTexts->merge($commentTexts);

        $hashtags = $allTexts->map(function ($content) {
            preg_match_all('/#(\w+)/', $content, $matches);
            return $matches[1] ?? [];
        })->flatten()->map(function ($tag) {
            return strtolower($tag);
        })->filter()->groupBy(function ($tag) {
            return $tag;
        })->map(function ($items) {
            return $items->count();
        })->sortDesc()->take(20)->toArray();

        return view('home', compact('posts', 'hashtags'));
    }

    /**
     * Menyimpan postingan baru ke database.
     * Menangani upload gambar dan file sekaligus.
     */
    public function store(Request $request)
    {
        // Validasi: konten wajib & maks 250 karakter
        $validated = $request->validate([
            'content' => 'required|max:250',
            'image'   => 'nullable|image|max:2048',
            'file'    => 'nullable|file|max:5120',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('posts/images', 'public');
        }

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('posts/files', 'public');
            $validated['file_name'] = $file->getClientOriginalName(); // Simpan nama asli
        }

        // Tambahkan ID user yang sedang login
        $validated['user_id'] = Auth::id();

        // Simpan ke database
        Post::create($validated);

        return back()->with('success', 'Postingan berhasil dibuat!');
    }

    /**
     * Menampilkan detail satu postingan beserta komentar-komentarnya.
     * Komentar diurutkan dari terbaru, dan eager loading user serta likes pada komentar.
     */
        public function show($id)
    {
        $post = Post::with(['user', 'comments.user', 'likes'])->findOrFail($id);
        // Hanya ambil komentar yang TIDAK punya parent_id (Komentar Utama)
        $comments = $post->comments()->whereNull('parent_id')->with('user', 'likes', 'replies')->latest()->get();
        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * Menampilkan form edit postingan.
     * Hanya pemilik postingan yang boleh mengakses (autorisasi).
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * Memperbarui postingan yang sudah ada.
     * Jika ada gambar/file baru, yang lama dihapus dan diganti.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated = $request->validate([
            'content' => 'required|max:250',
            'image'   => 'nullable|image|max:2048',
            'file'    => 'nullable|file|max:5120',
        ]);

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('image')) {
            if ($post->image_path) Storage::delete($post->image_path);
            $validated['image_path'] = $request->file('image')
                ->store('posts/images', 'public');
        }

        // Ganti file jika ada upload baru
        if ($request->hasFile('file')) {
            if ($post->file_path) Storage::delete($post->file_path);
            $file = $request->file('file');
            $validated['file_path'] = $file->store('posts/files', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
        }

        $post->update($validated);
        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Postingan berhasil diperbarui!');
    }

    /**
     * Menghapus postingan.
     * File gambar & file akan otomatis terhapus via model event (booted).
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        $post->delete();
        return redirect('/')->with('success', 'Postingan berhasil dihapus.');
    }
}