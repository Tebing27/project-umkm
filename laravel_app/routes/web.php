<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;

// Public Routes
Route::get('/', function () {
    return view('home');
});

Route::get('/umkm', function () {
    return view('umkm.index');
});

Route::get('/umkm/detail', function () {
    return view('umkm.detail');
});

// Dashboard Redirect
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    return redirect('/users/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Users Routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':users'])->group(function () {
    Route::get('/users/dashboard', [UserDashboardController::class, 'index'])->name('users.dashboard');
    Route::get('/users/lokasi', [UserDashboardController::class, 'detailLokasi']);
    Route::post('/users/lokasi/store', [UserDashboardController::class, 'storeLokasi']);
    
    Route::get('/users/toko', [UserDashboardController::class, 'toko']);
    
    // Autofill Routes
    Route::get('/users/edit-toko', [UserDashboardController::class, 'editToko']);
    Route::post('/users/edit-toko', [UserDashboardController::class, 'updateToko'])->name('users.update-toko');
    
    Route::get('/users/setting', [UserDashboardController::class, 'setting']);
    Route::get('/users/foto', [UserDashboardController::class, 'foto']);
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Custom Verification Route
    Route::post('/admin/verify-shop/{id}', [AdminDashboardController::class, 'verifyShop'])->name('admin.verify-shop');
    Route::post('/admin/reject-shop/{id}', [AdminDashboardController::class, 'rejectShop'])->name('admin.reject-shop');
    
    Route::get('/admin/users', [AdminDashboardController::class, 'users']);
    Route::get('/admin/users/detail/{id}', [AdminDashboardController::class, 'userDetail']);
    Route::get('/admin/setting', [AdminDashboardController::class, 'setting']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
