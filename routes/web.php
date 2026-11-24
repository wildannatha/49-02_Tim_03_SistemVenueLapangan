<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// ---------- Autentikasi ----------
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->middleware('throttle:10,1')->name('login.attempt');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ---------- Area wajib login ----------
Route::middleware('auth')->group(function () {
    // Dashboard: admin saja
    Route::get('/dashboard', DashboardController::class)
        ->middleware('admin')
        ->name('dashboard');

    // Pemesanan. Hak akses (lihat PemesananPolicy):
    //   lihat & tambah -> admin + user
    //   edit & hapus   -> admin saja
    Route::prefix('pemesanan-user')
        ->name('pemesanan.')
        ->controller(PemesananController::class)
        ->group(function () {
            Route::get('/data', 'index')->can('viewAny', Pemesanan::class)->name('index');
            Route::get('/', 'create')->can('create', Pemesanan::class)->name('create');
            Route::post('/', 'store')->can('create', Pemesanan::class)->name('store');
            Route::get('/{pemesanan}/edit', 'edit')->can('update', 'pemesanan')->name('edit');
            Route::put('/{pemesanan}', 'update')->can('update', 'pemesanan')->name('update');
            Route::delete('/{pemesanan}', 'destroy')->can('delete', 'pemesanan')->name('destroy');
        });
});
