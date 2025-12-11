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
    private const MAX_ATTEMPTS = 3;

    /**
     * Durasi lock PROGRESIF
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
     * Format waktu sisa lock
     */
    private function formatRemainingTime(int $seconds): string
    {
        if ($seconds <= 0) return '0 detik';

        $minutes = intdiv($seconds, 60);
        $sec = $seconds % 60;

        if ($minutes > 0 && $sec > 0) return "$minutes menit $sec detik";
        if ($minutes > 0) return "$minutes menit";
        return "$sec detik";
    }

    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Logic Login
     */
    public function login(Request $request)
    {
        // Validasi awal
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email     = $request->email;
        $ipAddress = $request->ip();

        // Ambil atau buat record login attempt
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

        // Jika akun terkunci
        if ($loginAttempt->isLocked()) {
            $remainingSeconds = Carbon::now()->diffInSeconds($loginAttempt->locked_until, false);

            if ($remainingSeconds <= 0) {
                $loginAttempt->reset();
            } else {
                return back()
                    ->withErrors([
                        'email' => "🔒 Akun terkunci. Coba lagi dalam " . $this->formatRemainingTime($remainingSeconds)
                    ])
                    ->with('lock_remaining_seconds', $remainingSeconds)
                    ->onlyInput('email');
            }
        }

        // Mencoba login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();
            $loginAttempt->reset();

            $user = Auth::user();
            return $this->redirectByRole($user);
        }

        // LOGIN GAGAL → tambahkan attempt
        $loginAttempt->incrementAttempts();

        // Jika sudah mencapai batas lock
        if ($loginAttempt->attempts >= self::MAX_ATTEMPTS) {
            $durationMinutes = $this->getLockDuration($loginAttempt->attempts);
            $loginAttempt->lockAccount($durationMinutes);

            $seconds = $durationMinutes * 60;

            return back()
                ->withErrors([
                    'email' => "❌ Terlalu banyak percobaan! Akun dikunci selama " . $this->formatRemainingTime($seconds)
                ])
                ->with('lock_remaining_seconds', $seconds)
                ->onlyInput('email');
        }

        // BELUM TERKUNCI → tampilkan sisa percobaan
        $remaining = self::MAX_ATTEMPTS - $loginAttempt->attempts;

        return back()
            ->withErrors([
                'email' => "⚠️ Email/Password salah. Sisa percobaan: {$remaining} kali."
            ])
            ->onlyInput('email');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    /**
     * Redirect berdasarkan role
     */
    protected function redirectByRole($user)
    {
        return match ($user->role) {
            'super_admin' => redirect()->route('super.dashboard'),
            'owner'       => redirect()->route('owner.dashboard'),
            'admin', 
            'staff'       => redirect()->route('staff.dashboard'),
            default       => redirect()->route('home'),
        };
    }

    /**
     * Reset Login Attempt (optional)
     */
    public function resetLoginAttempts(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        LoginAttempt::where('email', $request->email)->delete();

        return back()->with('success', 'Percobaan login berhasil direset.');
    }
}
