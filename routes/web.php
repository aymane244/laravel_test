<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::post('/store', [ProductController::class, 'store'])->name('store');
Route::get('/products', [ProductController::class, 'products'])->name('products');
Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
Route::post('/update', [ProductController::class, 'update'])->name('update');