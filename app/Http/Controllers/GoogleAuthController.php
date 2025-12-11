<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // 1. Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Terima callback dari Google
    public function callback()
    {
        try {
            // kalau error CSRF / state bisa pakai ->stateless()
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Gagal login dengan Google.');
        }

        // CARI USER YANG SUDAH TERDAFTAR DI DB
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        // JIKA TIDAK ADA → TOLAK LOGIN, JANGAN BUAT OWNER BARU
        if (! $user) {
            return redirect()
                ->route('login')
                ->with('error', 'Akun Google Anda belum terdaftar di sistem. Silakan hubungi admin/owner.');
        }

        // JIKA ADA TAPI BELUM PUNYA google_id → HUBUNGKAN
        if (! $user->google_id) {
            $user->google_id = $googleUser->getId();
        }

        // opsional: update avatar / name jika mau
        $user->avatar = $googleUser->getAvatar();
        // $user->name   = $googleUser->getName(); // kalau mau ikut diupdate
        $user->save();

        // LOGIN-KAN USER
        Auth::login($user, true);

        // REDIRECT SESUAI ROLE
        if ($user->role === 'super_admin') {
            return redirect()->route('super.dashboard');   // routes/web.php :contentReference[oaicite:1]{index=1}
        }

        if ($user->role === 'owner') {
            return redirect()->route('owner.dashboard');   // routes/web.php :contentReference[oaicite:2]{index=2}
        }

        // fallback: admin / staff
        return redirect()->route('staff.dashboard');       // routes/web.php :contentReference[oaicite:3]{index=3}
    }
}
