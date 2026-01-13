<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('home');

Route::get('/home', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::get('/aboutus', function() {
    return 'This is about us page';
});

Route::get('/homepage', function() {
    return view('homepage');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    
    // Product routes - export must be before {product} route to avoid conflicts
    Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    
    // Product update/delete routes - only match numeric IDs to avoid conflicts with image files
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->where('id', '[0-9]+');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->where('id', '[0-9]+');

    Route::get('/trash', [\App\Http\Controllers\TrashController::class, 'index'])->name('trash.index');
    
    // Product trash routes
    Route::post('/trash/products/{id}/restore', [\App\Http\Controllers\TrashController::class, 'restoreProduct'])->name('trash.restore-product');
    Route::delete('/trash/products/{id}', [\App\Http\Controllers\TrashController::class, 'forceDeleteProduct'])->name('trash.force-delete-product');
    
    // Category trash routes
    Route::post('/trash/categories/{id}/restore', [\App\Http\Controllers\TrashController::class, 'restoreCategory'])->name('trash.restore-category');
    Route::delete('/trash/categories/{id}', [\App\Http\Controllers\TrashController::class, 'forceDeleteCategory'])->name('trash.force-delete-category');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
