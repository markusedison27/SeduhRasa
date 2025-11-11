<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ===================
// Public pages
// ===================
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');

// Kalau halaman order itu 'menu', pakai salah satu saja (hapus duplikat)
Route::view('/order', 'menu')->name('order');   // -> resources/views/menu.blade.php

// Contact (GET halaman + POST kirim form)
Route::view('/contact', 'contact')->name('contact');          // GET /contact => resources/views/contact.blade.php
Route::post('/contact', function (Request $request) {
    // TODO: validasi & simpan kalau perlu
    return back()->with('success', 'Pesan berhasil dikirim!');
})->name('contact.submit');

// ===================
// Dashboard (opsional contoh)
// ===================
Route::view('/dashboard', 'dashboard')->name('dashboard');
// Kalau ada halaman contact khusus dashboard, taruh di /dashboard/contact (view-nya beda)
// Route::view('/dashboard/contact', 'dashboard.contact')->name('dashboard.contact');

Route::get('/ping', fn() => 'PONG from ' . base_path());
