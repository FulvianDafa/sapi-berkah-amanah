<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HewanKurbanController;
use App\Http\Controllers\AdminAuthController;

// Admin routes
Route::prefix('admin')->group(function () {
    // Auth routes
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
    
   // CRUD Hewan Kurban dengan middleware auth
   Route::apiResource('hewan-kurban', HewanKurbanController::class)->middleware('auth:sanctum');
});


