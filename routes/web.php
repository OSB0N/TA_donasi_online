<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\OverlayController;
use App\Http\Controllers\DonateController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/',           [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',     [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',   [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',  [AuthController::class, 'register'])->name('register.post');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',         [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaksi',         [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/profil',            [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil',           [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/overlay',           [OverlayController::class, 'edit'])->name('overlay.edit');
    Route::post('/overlay',          [OverlayController::class, 'update'])->name('overlay.update');

    // Donate (auth only)
    Route::get('/donate',            [DonateController::class, 'show'])->name('donate.show');
    Route::post('/donate',           [DonateController::class, 'send'])->name('donate.send');

    Route::post('/logout',           [AuthController::class, 'logout'])->name('logout');
});
