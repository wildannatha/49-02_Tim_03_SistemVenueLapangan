<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\InstrukturController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware(['guest', 'throttle:5,1']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::resource('lapangan', LapanganController::class);
    Route::resource('pelanggan', PelangganController::class)->except('show');

    Route::get('/instruktur', [InstrukturController::class, 'index'])->name('instruktur.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/instruktur/create', [InstrukturController::class, 'create'])->name('instruktur.create');
    Route::post('/instruktur', [InstrukturController::class, 'store'])->name('instruktur.store');
    Route::get('/instruktur/{instruktur}/edit', [InstrukturController::class, 'edit'])->name('instruktur.edit');
    Route::put('/instruktur/{instruktur}', [InstrukturController::class, 'update'])->name('instruktur.update');
    Route::delete('/instruktur/{instruktur}', [InstrukturController::class, 'destroy'])->name('instruktur.destroy');
});
