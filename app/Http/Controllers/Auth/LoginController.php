<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    // Percobaan maksimal sebelum terkunci
    private const MAX_ATTEMPTS = 3; // setelah 3x gagal -> mulai di-lock

    /**
     * Durasi lock PROGRESIF (menit) berdasarkan total attempts
     * - attempts <= 3  → 1 menit
     * - attempts <= 5  → 5 menit
     * - attempts > 5   → 15 menit
     */
    private function getLockDuration(int $attempts): int
    {
        return match (true) {
            $attempts <= 3 => 1,
            $attempts <= 5 => 5,
            default        => 15,
        };
    }

    /**
     * Format sisa waktu (detik) ke teks Indonesia yang enak dibaca.
     * Contoh: 90 → "1 menit 30 detik"
     */
    private function formatRemainingTime(int $seconds): string
    {
        if ($seconds <= 0) {
            return '0 detik';
        }

        $minutes = intdiv($seconds, 60);
        $sec     = $seconds % 60;

        if ($minutes > 0 && $sec > 0) {
            return "{$minutes} menit {$sec} detik";
        } elseif ($minutes > 0) {
            return "{$minutes} menit";
        }

        return "{$sec} detik";
    }

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

        $email     = $request->email;
        $ipAddress = $request->ip();

        // 2. Cek / buat record login attempts
        $loginAttempt = LoginAttempt::firstOrCreate(
            [
                'email'      => $email,
                'ip_address' => $ipAddress,
            ],
            [
                'attempts'        => 0,
                'locked_until'    => null,
                'last_attempt_at' => null,
            ]
        );

        // 3. Cek apakah akun masih terkunci
        if ($loginAttempt->isLocked()) {
            $remainingSeconds = Carbon::now()->diffInSeconds($loginAttempt->locked_until, false);

            // Kalau waktu lock sebenarnya sudah habis, reset supaya user bisa login lagi
            if ($remainingSeconds <= 0) {
                $loginAttempt->reset();
            } else {
                $timeMessage = $this->formatRemainingTime($remainingSeconds);

                return back()
                    ->withErrors([
                        'email' => "🔒 Akun Anda terkunci karena terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$timeMessage}."
                    ])
                    ->with('lock_remaining_seconds', $remainingSeconds) // buat countdown di Blade
                    ->onlyInput('email');
            }
        }

        // 4. Coba Otentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Reset login attempts jika berhasil
            $loginAttempt->reset();

            $user = Auth::user();

            // 5. Tentukan redirect berdasarkan role
            if ($user->role === 'super_admin') {
                $fallback = route('super.dashboard');
            } elseif ($user->role === 'owner') {
                $fallback = route('owner.dashboard');
            } elseif ($user->role === 'admin' || $user->role === 'staff') {
                $fallback = route('staff.dashboard');
            } else {
                $fallback = route('home');
            }

            return redirect($fallback);
        }

        // 6. Login Gagal - Increment Attempts
        $loginAttempt->incrementAttempts();

        // 7. Cek apakah sudah mencapai batas maksimal → KUNCI
        if ($loginAttempt->attempts >= self::MAX_ATTEMPTS) {
            // Durasi lock progresif
            $durationMinutes = $this->getLockDuration($loginAttempt->attempts);
            $loginAttempt->lockAccount($durationMinutes);

            $seconds    = $durationMinutes * 60;
            $timeString = $this->formatRemainingTime($seconds);

            return back()
                ->withErrors([
                    'email' => "❌ Terlalu banyak percobaan login gagal! Akun Anda dikunci selama {$timeString}. Silakan coba lagi nanti."
                ])
                ->with('lock_remaining_seconds', $seconds)
                ->onlyInput('email');
        }

        // 8. Belum terkunci → tampilkan sisa percobaan
        $remainingAttempts = self::MAX_ATTEMPTS - $loginAttempt->attempts;

        return back()
            ->withErrors([
                'email' => "⚠️ Email atau Password yang Anda masukkan salah. Sisa percobaan: {$remainingAttempts} kali."
            ])
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

    /**
     * Reset login attempts (opsional - untuk admin)
     */
    public function resetLoginAttempts(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        LoginAttempt::where('email', $request->email)->delete();

        return back()->with('status', 'Login attempts berhasil direset.');
    }
}
