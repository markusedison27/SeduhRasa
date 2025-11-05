<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');   // ← ini mengganti redirect ke dashboard
Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::get('/ping', fn() => 'PONG from '.base_path());

// untuk order
use App\Http\Controllers\OrderController;

Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
