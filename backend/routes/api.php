<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HewanKurbanController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\ResellerController;

// Admin API routes (Sanctum)
Route::prefix('admin')->group(function () {
    // Auth routes untuk API
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    
    // Endpoint CRUD admin dihapus karena saat ini menggunakan panel Blade.
    // Jika frontend web admin dibangun dengan SPA, route API CRUD admin ditambahkan di sini.
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint untuk katalog hewan kurban publik
Route::get('/hewan-kurban', [HewanKurbanController::class, 'index']);
Route::get('/hewan-kurban/{id}', [HewanKurbanController::class, 'show']);

Route::post('/daftar-reseller', [ResellerController::class, 'store']);
