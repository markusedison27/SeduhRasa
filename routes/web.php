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

// controller baru untuk multi role
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Public pages (tanpa login)
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');

Route::post('/contact', function (Request $request) {
    return back()->with('success', 'Pesan berhasil dikirim!');
})->name('contact.submit');

Route::view('/order', 'order')->name('order');
Route::view('/menu', 'menu')->name('menu');

/*
|--------------------------------------------------------------------------
| Public Orders (checkout dari halaman menu)
|--------------------------------------------------------------------------
*/

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN + LOGOUT)
|--------------------------------------------------------------------------
*/

// tampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// proses login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'index'])
        ->name('super.dashboard');

    // kelola owner
    Route::get('/super-admin/owners', [SuperAdminController::class, 'ownersIndex'])
        ->name('super.owners.index');

    // TIDAK pakai halaman create terpisah, redirect balik ke index
    Route::get('/super-admin/owners/create', function () {
        return redirect()->route('super.owners.index');
    })->name('super.owners.create');

    Route::post('/super-admin/owners', [SuperAdminController::class, 'ownersStore'])
        ->name('super.owners.store');
});

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])->group(function () {
    // dashboard owner
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])
        ->name('owner.dashboard');

    // halaman keuangan (pemasukan & pengeluaran)
    Route::get('/owner/finance', [OwnerController::class, 'finance'])
        ->name('owner.finance');

    // kelola kasir (pakai KaryawanController yang sama, tapi route khusus owner)
    Route::get('/owner/kasir', [KaryawanController::class, 'index'])
        ->name('owner.kasir.index');

    Route::get('/owner/kasir/create', [KaryawanController::class, 'create'])
        ->name('owner.kasir.create');

    Route::post('/owner/kasir', [KaryawanController::class, 'store'])
        ->name('owner.kasir.store');
});

/*
|--------------------------------------------------------------------------
| STAFF / KARYAWAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])->group(function () {

    // dashboard kasir/staff
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('staff.dashboard');

    // area admin untuk kasir
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('menus', MenuController::class);
        Route::resource('transaksi', TransaksiController::class);
        Route::resource('pelanggan', PelangganController::class);
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('orders', OrderController::class);

        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
    });
});

/*
|--------------------------------------------------------------------------
| UTILITIES
|--------------------------------------------------------------------------
*/
Route::get('/ping', fn () => 'PONG from ' . base_path());
