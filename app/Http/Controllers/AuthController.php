<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

/**
 * AuthController - Menangani seluruh proses autentikasi:
 * menampilkan form login/register, proses login, register, dan logout.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     * Jika user sudah login, langsung redirect ke beranda.
     */
    public function showLogin()
    {
        if (Auth::check()) return redirect('/');
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     * Validasi email & password, lalu buat session jika cocok.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login dengan guard default (web)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Cegah session fixation
            return redirect()->intended('/')->with('success', 'Login berhasil!');
        }

        // Jika gagal, kembalikan dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Menampilkan halaman form registrasi.
     */
    public function showRegister()
    {
        if (Auth::check()) return redirect('/');
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru.
     * Validasi data, hash password, buat user, lalu auto-login.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|max:50',
            'username' => 'required|alpha_num|min:3|max:20|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Langsung login setelah register
        Auth::login($user);
        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    /**
     * Proses logout user.
     * Hapus session dan invalidate token keamanan.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}