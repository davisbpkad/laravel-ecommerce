<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// API routes for public access
Route::get('/api/products/{id}', [ProductController::class, 'apiShow'])->name('api.products.show');

// Static pages
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/help', function () {
    return Inertia::render('Help');
})->name('help');

Route::get('/shipping', function () {
    return Inertia::render('Shipping');
})->name('shipping');

Route::get('/returns', function () {
    return Inertia::render('Returns');
})->name('returns');

Route::get('/faq', function () {
    return Inertia::render('FAQ');
})->name('faq');

// Dashboard for authenticated users
Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Cart routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    
    // API routes for cart hover and operations
    Route::get('/api/cart/items', [\App\Http\Controllers\Api\CartController::class, 'getItems'])->name('api.cart.items');
    Route::get('/api/cart/count', [\App\Http\Controllers\Api\CartController::class, 'getCount'])->name('api.cart.count');
    Route::post('/api/cart/add', [\App\Http\Controllers\Api\CartController::class, 'add'])->name('api.cart.add');
    Route::put('/api/cart/update/{id}', [\App\Http\Controllers\Api\CartController::class, 'update'])->name('api.cart.update');
    Route::delete('/api/cart/remove/{id}', [\App\Http\Controllers\Api\CartController::class, 'remove'])->name('api.cart.remove');
    Route::delete('/api/cart/clear', [\App\Http\Controllers\Api\CartController::class, 'clear'])->name('api.cart.clear');
});

// Order routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/sales-report', [AdminDashboardController::class, 'salesReport'])->name('sales-report');
    
    // Product management
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    
    
        // Bulk product operations (must be before individual product routes)
    Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
    Route::post('/products/bulk-restore', [ProductController::class, 'bulkRestore'])->name('products.bulk-restore');
    Route::post('/products/bulk-force-delete', [ProductController::class, 'bulkForceDelete'])->name('products.bulk-force-delete');
    Route::post('/products/bulk-toggle-status', [ProductController::class, 'bulkToggleStatus'])->name('products.bulk-toggle-status');
    
    Route::get('/products/{product}', [ProductController::class, 'adminShow'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDestroy'])->name('products.force-delete');
    
    Route::get('/products/{product}', [ProductController::class, 'adminShow'])->name('admin.products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('admin.products.restore');
    Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDestroy'])->name('admin.products.force-delete');
    
    // Order management
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Settings
    Route::redirect('/settings', '/admin/settings/store')->name('settings');
    Route::get('/settings/store', [App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.store');
    Route::put('/settings/store', [App\Http\Controllers\Admin\StoreSettingController::class, 'update'])->name('settings.store.update');
    Route::post('/settings/store/upload-image', [App\Http\Controllers\Admin\StoreSettingController::class, 'uploadImage'])->name('settings.store.upload-image');
    Route::post('/settings/store/reset', [App\Http\Controllers\Admin\StoreSettingController::class, 'reset'])->name('settings.store.reset');
    
    Route::get('/settings/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('settings.profile');
    Route::put('/settings/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('settings.profile.update');
    Route::put('/settings/profile/password', [App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('settings.profile.password');
    Route::delete('/settings/profile/avatar', [App\Http\Controllers\Admin\AdminProfileController::class, 'removeAvatar'])->name('settings.profile.remove-avatar');
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
