<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // ← tambahkan ini untuk handle request form

Route::view('/', 'home')->name('home');   // ← ini mengganti redirect ke dashboard
Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::get('/ping', fn() => 'PONG from '.base_path());

// untuk order
use App\Http\Controllers\OrderController;

Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/order', 'order')->name('order');
Route::view('/contact', 'contact')->name('contact');

// 🔹 Tambahkan route POST untuk form Contact
Route::post('/contact', function (Request $request) {
    // Sementara hanya kirim pesan sukses, belum simpan ke database
    return back()->with('success', 'Pesan berhasil dikirim!');
});
