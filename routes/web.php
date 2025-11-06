<?php

use Illuminate\Support\Facades\Route;

// 1. Import Semua Controller yang Dibutuhkan
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController; // Pastikan namespace ini benar

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 2. Routes Halaman Publik (Landing Page, About, Contact) ---
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');
Route::view('/order', 'order')->name('order');
Route::get('/ping', fn(): string => 'PONG from ' . base_path());

// ------------------------------------------------------------------
// --- 3. ROUTES OTENTIKASI (HARUS DI LUAR MIDDLEWARE 'auth') ---
// ------------------------------------------------------------------
// Ini adalah halaman yang harus bisa diakses SEMUA ORANG (termasuk yang belum login)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [LoginController::class, 'login']);

// Rute Logout harus berada di luar blok 'auth', tetapi akan berfungsi hanya setelah login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 


// -------------------------------------------------------------------------------------
// --- 4. ROUTES DASHBOARD DAN MANAJEMEN (HANYA UNTUK PENGGUNA YANG SUDAH LOGIN) ---
// -------------------------------------------------------------------------------------
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