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

// Public Kosan Routes
Route::get('/kosans/public', [KosanController::class, 'getAllPublic']);
Route::get('/kosans/public/{id}', [KosanController::class, 'getPublicById']); // Add this line
Route::get('/fasilitas', [FasilitasController::class, 'index']);
Route::get('/kategoris', [KategoriController::class, 'index']);

// Authenticated User Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/check-role/{role}', [AuthController::class, 'checkRole']);
    Route::get('/auth/check-admin', [AuthController::class, 'checkAdmin']);

    // Kosan Routes
    Route::apiResource('kosans', KosanController::class);
    Route::get('/kosans/featured', [KosanController::class, 'featured']);
    Route::get('/kosans/owner/{userId}', [KosanController::class, 'getByOwnerId']);

    // Optional: make these private too
    Route::apiResource('kategoris', KategoriController::class);
    Route::apiResource('fasilitas', FasilitasController::class);
    Route::apiResource('pengaduans', PengaduanController::class);
    Route::apiResource('pembayarans', PembayaranController::class);
    Route::get('/pembayarans/accepted/{userId}', [PembayaranController::class, 'getAcceptedPaymentsByKosanOwner']);
    Route::get('/pembayarans/user/{userId}', [PembayaranController::class, 'getUserPayments']);

    // Profile update route
    Route::put('/me/update', [AuthController::class, 'updateProfile']);

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

    Route::get('/users', [AuthController::class, 'getAllUsers'])->middleware('role:admin');
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);
    Route::put('/users/{id}', [AuthController::class, 'update'])->middleware('role:admin');
});
