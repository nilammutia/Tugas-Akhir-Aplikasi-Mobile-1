<?php

use App\Http\Controllers\API\AuthController;
// use App\Http\Controllers\API\PeminjamanController;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $req) => $req->user());

    Route::get('/peminjaman', [PeminjamanController::class, 'riwayat']);
    Route::post('/peminjaman', [PeminjamanController::class, 'pinjam']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/detail-peminjaman', [DetailPeminjamanController::class, 'index'])->name('detail_peminjaman.index');
});


// API Buku CRUD tanpa login
use App\Http\Controllers\Api\BukuController;
Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/{id}', [BukuController::class, 'show']);
Route::post('/buku', [BukuController::class, 'store']);
Route::put('/buku/{id}', [BukuController::class, 'update']);
Route::delete('/buku/{id}', [BukuController::class, 'destroy']);

// API Peminjaman CRUD tanpa login
use App\Http\Controllers\Api\PeminjamanController;
Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);
Route::post('/peminjaman', [PeminjamanController::class, 'store']);
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update']);
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);

// API User CRUD tanpa login
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

use App\Http\Controllers\Api\DetailPeminjamanController;
// API DetailPeminjaman CRUD
Route::get('/detailpeminjaman', [DetailPeminjamanController::class, 'index']);
Route::get('/detailpeminjaman/create', [DetailPeminjamanController::class, 'create']);
Route::get('/detailpeminjaman/{id}', [DetailPeminjamanController::class, 'show']);
Route::post('/detailpeminjaman', [DetailPeminjamanController::class, 'store']);
Route::put('/detailpeminjaman/{id}', [DetailPeminjamanController::class, 'update']);
Route::delete('/detailpeminjaman/{id}', [DetailPeminjamanController::class, 'destroy']);