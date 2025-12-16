<?php

use Illuminate\Support\Facades\Route;

// Import untuk fitur lupa sandi pakai OTP
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

use App\Models\User;

// Import Controllers
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PengeluaranController;


/*
|--------------------------------------------------------------------------
| HALAMAN UMUM
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| MENU & ORDER PUBLIK (HALAMAN PELANGGAN)
|--------------------------------------------------------------------------
*/

Route::get('/order', [OrderController::class, 'create'])->name('order');
Route::post('/order', [OrderController::class, 'storeCustomerInfo'])->name('order.storeInfo');

Route::get('/menu', [MenuController::class, 'publicMenu'])->name('menu');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

Route::get('/orders/{order}/status-json', [OrderController::class, 'statusJson'])
    ->name('orders.statusJson');

// Halaman sukses pesanan
Route::get('/pesanan/{order}/berhasil', [OrderController::class, 'showCustomer'])
    ->name('customer.orders.show');

// ✅ BARU: status untuk halaman pembeli (buat “diproses/selesai” realtime)
Route::get('/pesanan/{order}/status', [OrderController::class, 'customerStatusJson'])
    ->name('customer.orders.status');

// Route opsional untuk konfirmasi pembayaran (kalau view-nya masih dipakai)
Route::get('/pesanan/{order}/konfirmasi-pembayaran', [OrderController::class, 'showPaymentConfirmation'])
    ->name('customer.orders.payment');


/*
|--------------------------------------------------------------------------
| AUTH (LOGIN + LOGOUT + LUPA SANDI OTP + GOOGLE)
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Google Auth
Route::get('/oauth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/oauth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');


// ================== LUPA SANDI PAKAI KODE OTP ==================
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar di sistem.',
            ]);
        }

        $otp = random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => now(),
            ]
        );

        try {
            Mail::raw(
                "Kode OTP reset password Anda adalah: {$otp}\n\nKode ini berlaku selama 10 menit.",
                function ($message) use ($request) {
                    $message->to($request->email)
                        ->subject('Kode OTP Reset Password - SeduhRasa');
                }
            );
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim email OTP: ' . $e->getMessage());
        }

        session([
            'password_reset_email' => $request->email,
        ]);

        return redirect()->route('password.otp.form')
            ->with('status', 'Kode OTP berhasil dikirim ke email Anda.');
    })->name('password.email');

    Route::get('/forgot-password/verify-otp', function () {
        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp', [
            'email' => $email,
        ]);
    })->name('password.otp.form');

    Route::post('/forgot-password/verify-otp', function (Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors([
                'otp' => 'Kode OTP salah.',
            ])->withInput();
        }

        $created = \Carbon\Carbon::parse($record->created_at);
        if ($created->lt(now()->subMinutes(10))) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.',
            ]);
        }

        session([
            'password_reset_email_verified' => $request->email,
        ]);

        return redirect()->route('password.reset.form');
    })->name('password.otp.verify');

    Route::get('/reset-password', function () {
        $email = session('password_reset_email_verified');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-otp', [
            'email' => $email,
        ]);
    })->name('password.reset.form');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $email = session('password_reset_email_verified');

        if (!$email || $email !== $request->email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi reset password tidak valid, silakan ulangi proses.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        session()->forget(['password_reset_email', 'password_reset_email_verified']);

        event(new PasswordReset($user));

        return redirect()->route('login')
            ->with('status', 'Password berhasil direset. Silakan login dengan password baru.');
    })->name('password.reset.otp');
});
// ================== END LUPA SANDI OTP ==================


/*
|--------------------------------------------------------------------------
| NOTIFIKASI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/orders', [OrderController::class, 'notificationsJson'])
        ->name('notifications.orders');
});


/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'index'])
        ->name('super.dashboard');

    Route::get('/super-admin/owners', [SuperAdminController::class, 'ownersIndex'])
        ->name('super.owners.index');

    Route::get('/super-admin/owners/create', function () {
        return redirect()->route('super.owners.index');
    })->name('super.owners.create');

    Route::post('/super-admin/owners', [SuperAdminController::class, 'ownersStore'])
        ->name('super.owners.store');
});


/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {

    Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
    Route::get('/finance', [OwnerController::class, 'finance'])->name('finance');

    // --- Manajemen Kasir (Karyawan) ---
    Route::get('/kasir', [KaryawanController::class, 'index'])->name('kasir.index');
    Route::get('/kasir/create', [KaryawanController::class, 'create'])->name('kasir.create');
    Route::post('/kasir', [KaryawanController::class, 'store'])->name('kasir.store');

    // --- Profil Owner ---
    Route::get('/profile/edit', [OwnerController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [OwnerController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [OwnerController::class, 'updatePassword'])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| STAFF / KARYAWAN (KASIR) + ADMIN + OWNER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,staff,owner'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('staff.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('menus', MenuController::class);

        Route::resource('transaksi', TransaksiController::class);
        Route::get('transaksi/export', [TransaksiController::class, 'export'])
            ->name('transaksi.export');

        Route::resource('pelanggan', PelangganController::class);
        Route::resource('karyawan', KaryawanController::class);

        Route::resource('pengeluaran', PengeluaranController::class);

        Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);

        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        Route::get('messages', [ContactController::class, 'index'])
            ->name('messages.index');
    });
});


/*
|--------------------------------------------------------------------------
| TEST ROUTE
|--------------------------------------------------------------------------
*/
Route::get('/ping', fn() => 'PONG from ' . base_path());
