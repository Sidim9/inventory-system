<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PicklistController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('order_items', OrderItemController::class);
Route::resource('stock_movements', StockMovementController::class);

Route::get('picklists', [PicklistController::class, 'index'])->name('picklists.index');
Route::post('picklists/generate', [PicklistController::class, 'generate'])->name('picklists.generate');
Route::get('picklists/{picklist}', [PicklistController::class, 'show'])->name('picklists.show');

