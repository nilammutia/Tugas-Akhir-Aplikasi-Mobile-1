<?php
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PeminjamanController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $req) => $req->user());

    Route::get('/buku', [PeminjamanController::class, 'getBuku']);
    Route::get('/peminjaman', [PeminjamanController::class, 'riwayat']);
    Route::post('/peminjaman', [PeminjamanController::class, 'pinjam']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/detail-peminjaman', [DetailPeminjamanController::class, 'index'])->name('detail_peminjaman.index');

});
