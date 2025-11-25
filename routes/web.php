<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (TANPA LOGIN)
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');

Route::post('/contact', function (Request $request) {
    return back()->with('success', 'Pesan berhasil dikirim!');
})->name('contact.submit');

/*
|--------------------------------------------------------------------------
| MENU & ORDER PUBLIK (HALAMAN PELANGGAN)
|--------------------------------------------------------------------------
*/

Route::get('/order', [OrderController::class, 'create'])->name('order');
Route::post('/order', [OrderController::class, 'storeCustomerInfo'])->name('order.storeInfo');

Route::get('/menu', [MenuController::class, 'publicMenu'])->name('menu');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

Route::get('/orders/{order}/status-json', [OrderController::class, 'statusJson'])
    ->name('orders.statusJson');

Route::get('/pesanan/{order}/berhasil', [OrderController::class, 'showCustomer'])
    ->name('customer.orders.show');

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN + LOGOUT)
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| NOTIFIKASI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/orders', [OrderController::class, 'notificationsJson'])
        ->name('notifications.orders');
});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'index'])
        ->name('super.dashboard');

    Route::get('/super-admin/owners', [SuperAdminController::class, 'ownersIndex'])
        ->name('super.owners.index');

    Route::get('/super-admin/owners/create', function () {
        return redirect()->route('super.owners.index');
    })->name('super.owners.create');

    Route::post('/super-admin/owners', [SuperAdminController::class, 'ownersStore'])
        ->name('super.owners.store');
});

/*
|--------------------------------------------------------------------------
| OWNER + ADMIN (boleh kelola kasir/karyawan)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner,admin'])->group(function () {

    Route::get('/owner/dashboard', [OwnerController::class, 'index'])
        ->name('owner.dashboard');

    Route::get('/owner/finance', [OwnerController::class, 'finance'])
        ->name('owner.finance');

    Route::get('/owner/kasir', [KaryawanController::class, 'index'])
        ->name('owner.kasir.index');

    Route::get('/owner/kasir/create', [KaryawanController::class, 'create'])
        ->name('owner.kasir.create');

    Route::post('/owner/kasir', [KaryawanController::class, 'store'])
        ->name('owner.kasir.store');
});

/*
|--------------------------------------------------------------------------
| STAFF / KARYAWAN (KASIR) + ADMIN + OWNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,staff,owner'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('staff.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('menus', MenuController::class);
        Route::resource('transaksi', TransaksiController::class);
        Route::resource('pelanggan', PelangganController::class);
        Route::resource('karyawan', KaryawanController::class);

        Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);

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