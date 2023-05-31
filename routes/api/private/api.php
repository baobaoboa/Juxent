<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;


Route::prefix('operations-manager')->middleware(['role:operations-manager'])->group(function () {
    //issue
    Route::post('/issue', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/issue', [IssueController::class, 'index'])->name('issue.index');

    //users
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    //clients
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');

    //warranties
    Route::put('/warranties/{id}', [WarrantyController::class, 'update'])->name('warranty.update');
    Route::delete('/warranties/{id}', [WarrantyController::class, 'destroy'])->name('warranty.destroy');
    Route::get('/warranties', [WarrantyController::class, 'showRange'])->name('warranty.showRange');

    //products
    Route::get('/products', [ProductController::class, 'index'])->name('all.product');
    Route::put('/products/{id}', [WarrantyController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [WarrantyController::class, 'destroy'])->name('product.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('show.product');
});

Route::prefix('secretary')->middleware(['role:secretary'])->group(function () {
    //user
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    //clients
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');

    //client
    Route::put('/warranties/{id}', [WarrantyController::class, 'update'])->name('warranty.update');
    Route::delete('/warranties/{id}', [WarrantyController::class, 'destroy'])->name('warranty.destroy');
    Route::get('/warranties', [WarrantyController::class, 'showRange'])->name('warranty.showRange');

    //products
    Route::get('/products', [ProductController::class, 'index'])->name('all.product');
    Route::put('/products/{id}', [WarrantyController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [WarrantyController::class, 'destroy'])->name('product.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('show.product');
});

Route::prefix('sales-consultant')->middleware(['role:sales-consultant'])->group(function () {
    //clients
    Route::post('/clients/search/', [ClientController::class, 'search'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::post('/clients', [ClientController::class, 'store'])->name('client.store');

    //records
    Route::get('/records', [ResourceController::class, 'getRecords'])->name('all.records');
    Route::get('/records/{date}', [ResourceController::class, 'showRecords'])->name('show.records');

    //warranties
    Route::put('/warranties/{id}', [WarrantyController::class, 'update'])->name('warranty.update');
    Route::delete('/warranties/{id}', [WarrantyController::class, 'destroy'])->name('warranty.destroy');
    Route::get('/warranties', [WarrantyController::class, 'showRange'])->name('warranty.showRange');
    Route::post('/warranties', [WarrantyController::class, 'store'])->name('warranty.store');

    //products
    Route::get('/products', [ProductController::class, 'index'])->name('all.product');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::delete('/products/{id}', [WarrantyController::class, 'destroy'])->name('product.destroy');
    Route::put('/products/{id}', [WarrantyController::class, 'update'])->name('product.update');
    Route::post('/products/search/', [ProductController::class, 'search'])->middleware(['throttle:searchUser'])->name('products.search');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('show.product');
});
