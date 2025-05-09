<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KosanController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PembayaranController;



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => 'Ini halaman admin');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'user' => $request->user(),
    ]);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('kosans', KosanController::class);
    // tambahkan resource lainnya di sini jika perlu autentikasi
});


Route::apiResource('kategoris', KategoriController::class);
Route::apiResource('fasilitas', FasilitasController::class);
Route::apiResource('pengaduans', PengaduanController::class);
Route::apiResource('pembayarans', PembayaranController::class);


