<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\OrderController;

// ===================
// Public pages
// ===================
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');

// Halaman order publik (pakai view menu.blade.php)
Route::view('/order', 'menu')->name('order');

// Contact (GET halaman + POST kirim form)
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', function (Request $request) {
    // TODO: validasi atau simpan pesan ke database
    return back()->with('success', 'Pesan berhasil dikirim!');
})->name('contact.submit');

// ===================
// Auth (logout)
// ===================
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

// ===================
// Dashboard (opsional)
// ===================
Route::view('/dashboard', 'dashboard')->name('dashboard');

// Tes koneksi server
Route::get('/ping', fn() => 'PONG from ' . base_path());

// ===================
// Admin area
// ===================
// (kalau nanti sudah pakai login, tinggal tambahkan ->middleware('auth'))
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/menus',     [MenuController::class,     'index'])->name('menus.index');
    Route::get('/transaksi', [TransaksiController::class,'index'])->name('transaksi.index');
    Route::get('/pelanggan', [PelangganController::class,'index'])->name('pelanggan.index');
    Route::get('/karyawan',  [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/orders',    [OrderController::class,    'index'])->name('orders.index');
});
