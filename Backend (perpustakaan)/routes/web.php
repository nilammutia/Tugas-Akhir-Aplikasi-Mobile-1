<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DetailPeminjamanController;
// use App\Http\Controllers\Auth\LoginController; // removed, not used
use App\Http\Controllers\LoginController;


use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    } else {
        return redirect()->route('login');
    }
});

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('detailpeminjaman', DetailPeminjamanController::class);
    // Route khusus agar /detail-peminjaman tetap bisa diakses
    Route::get('/detail-peminjaman', [App\Http\Controllers\DetailPeminjamanController::class, 'index'])->name('detailpeminjaman.index.alias');
    Route::get('detailpeminjaman/{id}/kembalikan', [DetailPeminjamanController::class, 'kembalikan'])->name('detailpeminjaman.kembalikan');
});
// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



