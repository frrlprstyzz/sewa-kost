<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KosanController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PembayaranController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('kosans', KosanController::class);
    // tambahkan resource lainnya di sini jika perlu autentikasi
});


Route::apiResource('kategoris', KategoriController::class);
Route::apiResource('kosans', KosanController::class);
Route::apiResource('fasilitas', FasilitasController::class);
Route::apiResource('pengaduans', PengaduanController::class);
Route::apiResource('pembayarans', PembayaranController::class);


