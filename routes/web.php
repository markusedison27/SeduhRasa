<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Public pages (tanpa login)
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');

// Halaman 1: isi data pembeli
Route::view('/order', 'order')->name('order');

// Halaman 2: pilih menu (menu.blade.php yang panjang itu)
Route::view('/menu', 'menu')->name('menu');

Route::view('/contact', 'contact')->name('contact');

Route::post('/contact', function (Request $request) {
    return back()->with('success', 'Pesan berhasil dikirim!');
})->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Public Orders (checkout dari halaman menu)
|--------------------------------------------------------------------------
*/

// List order publik (opsional)
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// Simpan pesanan dari halaman menu (checkout)
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Detail pesanan
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

/*
|--------------------------------------------------------------------------
| Auth (LOGIN, LOGOUT)
|--------------------------------------------------------------------------
*/

// Tampilkan form login
Route::middleware('guest')->get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses login
Route::middleware('guest')->post('/login', function (Request $request) {
    $cred = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($cred, $remember)) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
})->name('login.post');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login')->with('status', 'Berhasil keluar.');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Area yang butuh login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin area (prefix /admin, nama route admin.*)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('menus', MenuController::class);           // admin.menus.*
        Route::resource('transaksi', TransaksiController::class);  // admin.transaksi.*
        Route::resource('pelanggan', PelangganController::class);  // admin.pelanggan.*
        Route::resource('karyawan', KaryawanController::class);    // admin.karyawan.*
        Route::resource('orders', OrderController::class);         // admin.orders.*

        // 👉 route tambahan untuk ubah status order
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
    });
});

/*
|--------------------------------------------------------------------------
| Utilities
|--------------------------------------------------------------------------
*/

Route::get('/ping', fn () => 'PONG from ' . base_path());
