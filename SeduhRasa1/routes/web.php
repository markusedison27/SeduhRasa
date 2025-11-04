<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/dashboard'));
Route::view('/dashboard', 'dashboard')->name('dashboard');
