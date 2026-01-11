<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;

// NOTE: /test-pusher route removed for security reasons.
// To test Pusher in development, use: php artisan tinker -> App\Events\ShopUpdated::dispatch()


Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('switch_language');

// Public Routes
Route::get('/', [HomeController::class, 'index']);

Route::get('/umkm', [PublicController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{id}', [PublicController::class, 'show'])->name('umkm.comment');

// Dashboard Redirect
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    return redirect('/users/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Users Routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckRole::class . ':users'])->group(function () {
    Route::get('/users/dashboard', [UserDashboardController::class, 'index'])->name('users.dashboard');
    Route::get('/users/lokasi', [UserDashboardController::class, 'detailLokasi']);
    Route::post('/users/lokasi/store', [UserDashboardController::class, 'storeLokasi']);
    
    Route::get('/users/toko', [UserDashboardController::class, 'toko']);
    
    // Autofill Routes
    Route::get('/users/edit-toko', [UserDashboardController::class, 'editToko']);
    Route::post('/users/edit-toko', [UserDashboardController::class, 'updateToko'])
        ->middleware('throttle:6,1') // Rate Limit: 6 req/min
        ->name('users.update-toko');
    
    Route::get('/users/setting', [UserDashboardController::class, 'setting']);
    Route::post('/users/setting/profile', [UserDashboardController::class, 'updateProfile'])->name('users.setting.profile');
    Route::post('/users/setting/password', [UserDashboardController::class, 'updatePassword'])->name('users.setting.password');
    Route::get('/users/foto', [UserDashboardController::class, 'foto']);
    // Product & Photo Management
    Route::post('/users/foto/store', [UserDashboardController::class, 'storePhoto'])->name('user.toko.foto.store');
    Route::post('/users/toko/produk', [UserDashboardController::class, 'storeProduct'])->name('user.toko.produk.store');
    Route::post('/toko/produk/{id}/toggle', [UserDashboardController::class, 'toggleProductStatus'])->name('user.toko.produk.toggle');
    Route::put('/toko/produk/{id}', [UserDashboardController::class, 'updateProduct'])->name('user.toko.produk.update');
    Route::delete('/toko/produk/{id}', [UserDashboardController::class, 'deleteProduct'])->name('user.toko.produk.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Custom Verification Route
    Route::post('/admin/verify-shop/{id}', [AdminDashboardController::class, 'verifyShop'])->name('admin.verify-shop');
    Route::post('/admin/reject-shop/{id}', [AdminDashboardController::class, 'rejectShop'])->name('admin.reject-shop');
    
    Route::get('/admin/users', [AdminDashboardController::class, 'users']);
    Route::get('/admin/users/detail/{id}', [AdminDashboardController::class, 'userDetail']);
    Route::get('/admin/setting', [AdminDashboardController::class, 'setting']);
    Route::post('/admin/setting/profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.setting.profile');
    Route::post('/admin/setting/password', [AdminDashboardController::class, 'updatePassword'])->name('admin.setting.password');
    Route::resource('/admin/contents', \App\Http\Controllers\Admin\ContentController::class, ['as' => 'admin']);
    Route::put('/admin/regions/{id}/image', [\App\Http\Controllers\Admin\RegionController::class, 'updateImage'])->name('admin.regions.update_image');
    Route::put('/admin/regions/{id}/featured-shop', [\App\Http\Controllers\Admin\RegionController::class, 'updateFeaturedShop'])->name('admin.regions.update_featured_shop');
    Route::delete('/admin/contents/{id}/image', [\App\Http\Controllers\Admin\ContentController::class, 'deleteImage'])->name('admin.contents.delete_image');
    Route::put('/admin/regions/{id}/details', [\App\Http\Controllers\Admin\RegionController::class, 'updateDetails'])->name('admin.regions.update_details');
    Route::delete('/admin/regions/{id}/image', [\App\Http\Controllers\Admin\RegionController::class, 'deleteImage'])->name('admin.regions.delete_image');
    Route::post('/admin/regions', [\App\Http\Controllers\Admin\RegionController::class, 'store'])->name('admin.regions.store');
    Route::delete('/admin/regions/{id}', [\App\Http\Controllers\Admin\RegionController::class, 'destroy'])->name('admin.regions.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';