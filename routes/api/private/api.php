<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;


Route::prefix('operations-manager')->middleware(['role:operations-manager'])->group(function () {
    Route::post('/issue', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/issue', [IssueController::class, 'index'])->name('issue.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
});

Route::prefix('secretary')->middleware(['role:secretary'])->group(function () {
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
});

Route::prefix('sales-consultant')->middleware(['role:sales-consultant'])->group(function () {
    Route::post('/clients/search/', [ClientController::class, 'search'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::post('/products/search/', [ProductController::class, 'search'])->middleware(['throttle:searchUser'])->name('products.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::post('/clients', [ClientController::class, 'store'])->name('client.store');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::post('/warranties', [WarrantyController::class, 'store'])->name('product.store');
    Route::get('/records', [ResourceController::class, 'getRecords'])->name('all.records');
});
