<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. Import Semua Controller yang Dibutuhkan
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
Route::get('/ping', fn(): string => 'PONG from ' . base_path());

// ✅ Halaman order publik: tampilkan produk tanpa login
Route::get('/order', [OrderController::class, 'showPublicOrderPage'])->name('order.page');

// Tambahkan route POST untuk form Contact
Route::post('/contact', function (Request $request) {
    return back()->with('success', 'Pesan berhasil dikirim!');
})->name('contact.send');

// --- 3. ROUTES OTENTIKASI ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 

// --- 4. ROUTES DASHBOARD DAN MANAJEMEN (HANYA UNTUK PENGGUNA YANG SUDAH LOGIN) ---
Route::middleware(['auth'])->group(function () {

    // Rute Dashboard Utama
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Rute Resource untuk Manajemen CRUD Admin
    Route::resource('menus', MenuController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('orders', OrderController::class);
});
