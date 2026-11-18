<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\ProductIngredientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;

// Halaman login untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

// Halaman yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::resource('ingredients', IngredientController::class)
    ->except(['show']);

    Route::resource('stock-movements', StockMovementController::class)
    ->only(['index', 'create', 'store']);

    // Transaksi Penjualan
    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');

    Route::get('/products/{product}/ingredients', [ProductIngredientController::class, 'index'])
    ->name('product-ingredients.index');

    Route::get('/products/{product}/ingredients/create', [ProductIngredientController::class, 'create'])
        ->name('product-ingredients.create');

    Route::post('/products/{product}/ingredients', [ProductIngredientController::class, 'store'])
        ->name('product-ingredients.store');

    Route::get('/product-ingredients/{productIngredient}/edit', [ProductIngredientController::class, 'edit'])
        ->name('product-ingredients.edit');

    Route::put('/product-ingredients/{productIngredient}', [ProductIngredientController::class, 'update'])
        ->name('product-ingredients.update');

    Route::delete('/product-ingredients/{productIngredient}', [ProductIngredientController::class, 'destroy'])
        ->name('product-ingredients.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
