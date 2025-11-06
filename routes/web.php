<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. Import Semua Controller yang Dibutuhkan
// Pastikan semua nama Controller ini sesuai dengan yang ada di folder app/Http/Controllers
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Rute-rute ini dimuat oleh RouteServiceProvider dan akan diberi
| "web" middleware group.
*/

// --- 2. Routes Halaman Publik (Landing Page, About, Contact) ---
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');
Route::view('/order', 'order')->name('order'); 
Route::get('/ping', fn(): string => 'PONG from ' . base_path());

// Tambahkan route POST untuk form Contact (sesuai perubahan yang Anda sertakan)
Route::post('/contact', function (Request $request) {
    // Sementara hanya kirim pesan sukses, belum simpan ke database
    // Anda bisa menambahkan logika penyimpanan data kontak di sini
    return back()->with('success', 'Pesan berhasil dikirim!');
})->name('contact.send');

// --- 3. ROUTES OTENTIKASI (HARUS DI LUAR MIDDLEWARE 'auth') ---
// Ini yang FIX masalah Route [login] not defined dan redirect loop
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 


// --- 4. ROUTES DASHBOARD DAN MANAJEMEN (HANYA UNTUK PENGGUNA YANG SUDAH LOGIN) ---
Route::middleware(['auth'])->group(function () {

    // Rute Dashboard Utama
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Rute Resource untuk Manajemen CRUD Admin
    // Baris-baris ini menghasilkan rute yang digunakan di sidebar (menus.index, transaksi.index, dll.)
    Route::resource('menus', MenuController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('orders', OrderController::class);
});