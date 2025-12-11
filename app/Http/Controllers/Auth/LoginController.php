<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if ($loginAttempt->isLocked()) {
            $remaining = Carbon::now()->diffInSeconds($loginAttempt->locked_until, false);

            if ($remaining <= 0) {
                $loginAttempt->reset();
            } else {
                return back()
                    ->withErrors([
                        'email' => "🔒 Akun terkunci. Coba lagi dalam " . $this->formatRemainingTime($remaining)
                    ])
                    ->with('lock_remaining_seconds', $remaining)
                    ->onlyInput('email');
            }
        }

        // Coba login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();
            $loginAttempt->reset();

            $user = Auth::user();
            return $this->redirectByRole($user);
        }

        // LOGIN GAGAL → tambah attempt
        $loginAttempt->incrementAttempts();

        // Jika sudah mencapai batas → KUNCI AKUN
        if ($loginAttempt->attempts >= self::MAX_ATTEMPTS) {
            $minutes = $this->getLockDuration($loginAttempt->attempts);
            $loginAttempt->lockAccount($minutes);

            $seconds = $minutes * 60;

            return back()
                ->withErrors([
                    'email' => "❌ Terlalu banyak percobaan! Akun dikunci selama " . $this->formatRemainingTime($seconds)
                ])
                ->with('lock_remaining_seconds', $seconds)
                ->onlyInput('email');
        }

        // LOGIN GAGAL BIASA → tampilkan session('error')
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
            'admin',
            'staff'       => redirect()->route('staff.dashboard'),
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
