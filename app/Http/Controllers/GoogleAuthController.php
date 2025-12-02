<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

        // cari user berdasarkan google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            // kalau belum ada, coba cek by email (biar tidak dobel akun)
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // kalau ada user dengan email yg sama, sambungkan google_id-nya
                $user->google_id = $googleUser->getId();
                $user->avatar    = $googleUser->getAvatar();
                $user->save();
            } else {
                // kalau benar-benar user baru, buat user baru
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    // SESUAIKAN DEFAULT ROLE & OWNER DI SINI
                    'role'      => 'owner',      // atau 'admin' / 'staff' sesuai kebijakanmu
                    'owner_id'  => null,         // kalau perlu
                    'password'  => bcrypt(Str::random(16)), // random aja
                ]);
            }
        }

        // kalau user lama tapi role-nya masih null, kasih default juga
        if (! $user->role) {
            $user->role = 'owner'; // atau apa pun default kamu
            $user->save();
        }

        // login-kan user
        Auth::login($user, true);

        // redirect JANGAN pakai intended(), pakai route sesuai role
        if ($user->role === 'super_admin') {
            return redirect()->route('super.dashboard');
        }

        if ($user->role === 'owner') {
            return redirect()->route('owner.dashboard');
        }

        // fallback untuk admin / staff
        return redirect()->route('staff.dashboard'); // ini /dashboard
    }
}
