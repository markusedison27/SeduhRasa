<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');   // ← ini mengganti redirect ke dashboard
Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::get('/ping', fn() => 'PONG from '.base_path());