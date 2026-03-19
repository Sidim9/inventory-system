<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderAddressController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('products', ProductController::class);
Route::resource('marketplaces', MarketplaceController::class);
Route::resource('orders', OrderController::class);
Route::resource('order_items', OrderItemController::class);
Route::resource('order_addresses', OrderAddressController::class);
Route::resource('stock_movements', StockMovementController::class);