<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AnggotaController;
// use App\Http\Controllers\Auth\LoginController; // removed, not used
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('home');
});

Route::resource('user', UserController::class);
Route::resource('buku', BukuController::class);
Route::resource('peminjaman', PeminjamanController::class);
Route::resource('anggota', AnggotaController::class);
// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\DetailPeminjamanController;
// ...existing code...
Route::get('/detail-peminjaman', [DetailPeminjamanController::class, 'index'])->name('detail_peminjaman.index');