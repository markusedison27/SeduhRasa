<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }

        // CARI USER
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        // TIDAK DITEMUKAN → MUNCULKAN NOTIFIKASI
        if (! $user) {
            return redirect()
                ->route('login')
                ->with('error', 'Akun Google Anda belum terdaftar di sistem.');
        }

        // SAMBUNGKAN GOOGLE ID
        if (! $user->google_id) {
            $user->google_id = $googleUser->getId();
        }

        // Optional update avatar
        if (isset($user->avatar)) {
            $user->avatar = $googleUser->getAvatar();
        }

        $user->save();

        // LOGIN
        Auth::login($user, true);

        return $this->redirectByRole($user);
    }

    protected function redirectByRole(User $user)
    {
        return match ($user->role) {
            'super_admin' => redirect()->route('super.dashboard'),
            'owner'       => redirect()->route('owner.dashboard'),
            'admin',
            'staff'       => redirect()->route('staff.dashboard'),
            default       => redirect()->route('home'),
        };
    }
}
