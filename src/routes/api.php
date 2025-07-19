<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\Api\LayananController;

Route::prefix('v1')->group(function () {
    Route::get('/artikels', [ArtikelController::class, 'index']);
    Route::get('/artikels/{id}', [ArtikelController::class, 'show']);
});

// Register dan login tidak perlu auth
//Route::post('/register', [RegisterController::class, 'store']);
//Route::post('/login', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'store']);

// Routes yang butuh autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::delete('/logout', [AuthController::class, 'destroy']);
    Route::get('/documents/{id}', [DocumentController::class, 'show']);
});

// Endpoint dokumen umum tanpa autentikasi
Route::get('/documents', [DocumentController::class, 'index']);

Route::get('/layanan', [LayananController::class, 'index']);

// webhook dari midtrans
Route::post('/midtrans/webhook', [MidtransController::class, 'webhook']);
