<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HewanKurbanController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\ResellerController;

// Admin routes
Route::prefix('admin')->group(function () {
    // Auth routes
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
    
   // CRUD Hewan Kurban dengan middleware auth
   Route::apiResource('hewan-kurban', HewanKurbanController::class)->middleware('auth:sanctum');
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint untuk katalog hewan kurban
Route::get('/hewan-kurban', [HewanKurbanController::class, 'getKatalog']);

Route::get('/hewan-kurban/{id}', [HewanKurbanController::class, 'show']);

Route::post('/daftar-reseller', [ResellerController::class, 'store']);


