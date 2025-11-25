<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan Form Login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses Login.
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba Otentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. Tentukan redirect berdasarkan role
            if ($user->role === 'super_admin') {

                $fallback = route('super.dashboard');

            } elseif ($user->role === 'owner') {

                $fallback = route('owner.dashboard');

            } elseif ($user->role === 'admin' || $user->role === 'staff') {

                // admin & staff sama-sama pakai dashboard staff (/dashboard)
                $fallback = route('staff.dashboard');

            } else {

                // kalau role tidak dikenal, balikin ke halaman depan
                $fallback = route('home');
            }

            // langsung pakai fallback, jangan intended supaya tidak balik ke home lagi
            return redirect($fallback);
        }

        // 4. Gagal Otentikasi
        return back()
            ->withErrors(['email' => 'Email atau Password yang Anda masukkan salah.'])
            ->onlyInput('email');
    }

    /**
     * Menangani proses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Berhasil keluar.');
    }
}
