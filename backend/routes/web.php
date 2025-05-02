<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HewanKurbanController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\ResellerController;

// Authentication Routes
Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AdminAuthController::class, 'login']);
Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('hewan-kurban', HewanKurbanController::class);
    Route::delete('hewan-kurban/photo/{id}', [HewanKurbanController::class, 'deletePhoto'])
        ->name('hewan-kurban.photo.delete');
    Route::delete('admin/hewan-kurban/photo/{id}', [HewanKurbanController::class, 'deletePhoto'])->name('admin.hewan-kurban.photo.delete');
});

Route::get('/admin/reseller', [ResellerController::class, 'index'])->name('admin.reseller');

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});