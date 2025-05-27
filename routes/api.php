<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    KategoriController,
    KosanController,
    FasilitasController,
    PengaduanController,
    PembayaranController,
    AdminController,
    PemilikController,
    UserController
};

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated User Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/check-role/{role}', [AuthController::class, 'checkRole']);
    Route::get('/auth/check-admin', [AuthController::class, 'checkAdmin']);

    // Kosan Routes
    Route::apiResource('kosans', KosanController::class);
    Route::get('/kosans/featured', [KosanController::class, 'featured']);

    // Optional: make these private too
    Route::apiResource('kategoris', KategoriController::class);
    Route::apiResource('fasilitas', FasilitasController::class);
    Route::apiResource('pengaduans', PengaduanController::class);
    Route::apiResource('pembayarans', PembayaranController::class);

    // Role-based dashboards
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
    });

    Route::prefix('pemilik')->middleware('role:pemilik')->group(function () {
        Route::get('/dashboard', [PemilikController::class, 'dashboard']);
    });

    Route::prefix('user')->middleware('role:user')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard']);
    });
});
