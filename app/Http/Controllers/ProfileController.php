<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/**
 * ProfileController - Menangani pengaturan profil user:
 * menampilkan form edit dan memperbarui bio serta foto profil.
 */
class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil dengan data user saat ini.
     */
        public function edit()
    {
        $user = Auth::user();
        
        // Keamanan tambahan: Pastikan yang buka hanya pemilik akun
        // (Meskipun di view sudah diblokir, ini mencegah akses paksa via URL)
        abort_if($user->id !== Auth::id(), 403, 'Anda tidak memiliki akses ke profil ini.');

        return view('profile.edit', compact('user'));
    }
    /**
     * Memperbarui data profil user (nama, username, bio, foto).
     * Jika ada foto baru diupload, foto lama akan dihapus dari storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name'          => 'required|max:50',
            'username'      => 'required|alpha_num|min:3|max:20|unique:users,username,' . $user->id,
            'bio'           => 'nullable|max:160',
            'profile_photo' => 'nullable|image|max:2048', // Maks 2MB, harus gambar
        ]);

        // Proses upload foto profil baru jika ada
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama dari storage jika ada
            if ($user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
            }
            // Simpan foto baru ke folder storage/app/public/profiles
            $validated['profile_photo_path'] = $request->file('profile_photo')
                ->store('profiles', 'public');
        }

        // Update data user di database
        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');

    }
}