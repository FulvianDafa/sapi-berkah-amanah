<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HewanKurbanController;
use App\Http\Controllers\AuthApiController;

Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('HewanKurban', HewanKurbanController::class);
});

