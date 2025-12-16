<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoginController extends Controller
{
    private const MAX_ATTEMPTS = 3;

    private function getLockDuration(int $attempts): int
    {
        return match (true) {
            $attempts <= 3 => 1,
            $attempts <= 5 => 5,
            default        => 15,
        };
    }

    private function formatRemainingTime(int $seconds): string
    {
        if ($seconds <= 0) return '0 detik';

        $minutes = intdiv($seconds, 60);
        $sec = $seconds % 60;

        if ($minutes > 0 && $sec > 0) return "$minutes menit $sec detik";
        if ($minutes > 0) return "$minutes menit";
        return "$sec detik";
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email     = $request->email;
        $ipAddress = $request->ip();

        // Ambil atau buat record attempts
        $loginAttempt = LoginAttempt::firstOrCreate(
            ['email' => $email, 'ip_address' => $ipAddress],
            ['attempts' => 0, 'locked_until' => null, 'last_attempt_at' => null]
        );

        // Jika terkunci → tampilkan error + countdown
        if (method_exists($loginAttempt, 'isLocked') && $loginAttempt->isLocked()) {
            $remaining = Carbon::now()->diffInSeconds($loginAttempt->locked_until, false);

            if ($remaining <= 0 && method_exists($loginAttempt, 'reset')) {
                $loginAttempt->reset();
            } else {
                return back()
                    ->withErrors([
                        'email' => "🔒 Akun terkunci. Coba lagi dalam " . $this->formatRemainingTime(max(0, $remaining))
                    ])
                    ->with('lock_remaining_seconds', max(0, $remaining))
                    ->onlyInput('email');
            }
        }

        /**
         * ✅ ANTI 500 untuk kasus password di DB bukan bcrypt
         * - Auth::attempt bisa throw RuntimeException
         * - kita tangkap dan kasih pesan yang jelas
         */
        try {
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                if (method_exists($loginAttempt, 'reset')) {
                    $loginAttempt->reset();
                }

                return $this->redirectByRole(Auth::user());
            }
        } catch (\RuntimeException $e) {
            // Kasus paling sering: "This password does not use the Bcrypt algorithm."
            return back()
                ->withErrors([
                    'email' => '⚠️ Password akun ini di database belum terenkripsi (bcrypt). Reset password admin dulu (bcrypt), lalu coba login lagi.'
                ])
                ->onlyInput('email');
        }

        // LOGIN GAGAL → tambah attempt
        if (method_exists($loginAttempt, 'incrementAttempts')) {
            $loginAttempt->incrementAttempts();
        } else {
            // fallback kalau method belum ada
            $loginAttempt->attempts = ($loginAttempt->attempts ?? 0) + 1;
            $loginAttempt->last_attempt_at = now();
            $loginAttempt->save();
        }

        // Jika sudah mencapai batas → KUNCI AKUN
        if (($loginAttempt->attempts ?? 0) >= self::MAX_ATTEMPTS) {
            $minutes = $this->getLockDuration((int) $loginAttempt->attempts);

            if (method_exists($loginAttempt, 'lockAccount')) {
                $loginAttempt->lockAccount($minutes);
            } else {
                // fallback lock sederhana
                $loginAttempt->locked_until = now()->addMinutes($minutes);
                $loginAttempt->save();
            }

            $seconds = $minutes * 60;

            return back()
                ->withErrors([
                    'email' => "❌ Terlalu banyak percobaan! Akun dikunci selama " . $this->formatRemainingTime($seconds)
                ])
                ->with('lock_remaining_seconds', $seconds)
                ->onlyInput('email');
        }

        return back()
            ->with('error', 'Email atau password salah! Periksa kembali data Anda.')
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }

    protected function redirectByRole($user)
    {
        return match ($user->role) {
            'super_admin' => redirect()->route('super.dashboard'),
            'owner'       => redirect()->route('owner.dashboard'),
            'admin', 'staff' => redirect()->route('staff.dashboard'),
            default       => redirect()->route('home'),
        };
    }

    public function resetLoginAttempts(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        LoginAttempt::where('email', $request->email)->delete();

        return back()->with('success', 'Percobaan login berhasil direset.');
    }
}
