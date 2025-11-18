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
                // pakai nama route yg ada di web.php ->name('super.dashboard')
                $fallback = route('super.dashboard');
            } elseif ($user->role === 'owner') {
                $fallback = route('owner.dashboard');
            } elseif ($user->role === 'staff') {
                $fallback = route('staff.dashboard');
            } else {
                $fallback = route('home');
            }

            // intended = kalau sebelumnya akses halaman yang butuh login, balik ke sana
            return redirect()->intended($fallback);
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
