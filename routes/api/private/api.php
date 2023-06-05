<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
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
    Route::post('/clients/search/', [ClientController::class, 'search'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');

    //warranties
    Route::get('/warranties', [WarrantyController::class, 'index'])->name('all.warranties');
    Route::get('/warranties/{id}', [WarrantyController::class, 'show'])->name('show.warranty');
    Route::put('/warranties/{id}', [WarrantyController::class, 'update'])->name('warranty.update');
    Route::delete('/warranties/{id}', [WarrantyController::class, 'destroy'])->name('warranty.destroy');
    Route::get('/warranties', [WarrantyController::class, 'index'])->name('warranty.index');

    //products
    Route::get('/products', [ProductController::class, 'index'])->name('all.product');
    Route::put('/products/{id}', [WarrantyController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [WarrantyController::class, 'destroy'])->name('product.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('show.product');


    //records
    Route::get('/records', [ResourceController::class, 'getRecords'])->name('all.records');
    Route::get('/records/{date}', [ResourceController::class, 'showRecords'])->name('show.records');
});

Route::prefix('secretary')->middleware(['role:secretary'])->group(function () {
    //users
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    //clients
    Route::post('/clients/search/', [ClientController::class, 'search'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');

    //warranties
    Route::get('/warranties', [WarrantyController::class, 'index'])->name('all.warranties');
    Route::get('/warranties/{id}', [WarrantyController::class, 'show'])->name('show.warranty');
    Route::put('/warranties/{id}', [WarrantyController::class, 'update'])->name('warranty.update');
    Route::delete('/warranties/{id}', [WarrantyController::class, 'destroy'])->name('warranty.destroy');
    Route::get('/warranties', [WarrantyController::class, 'index'])->name('warranty.index');

    //products
    Route::get('/products', [ProductController::class, 'index'])->name('all.product');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('show.product');

    //records
    Route::get('/records', [ResourceController::class, 'getRecords'])->name('all.records');
    Route::get('/records/{date}', [ResourceController::class, 'showRecords'])->name('show.records');
    Route::get('/records/show/{id}', [ResourceController::class, 'show'])->name('show.record');

    //dashboard
    Route::get('/dashboard/clients/{year}', [DashboardController::class, 'totalClientRecords'])->name('clients.byYear');
    Route::get('/dashboard/clients/month/{year}', [DashboardController::class, 'totalClientRecordsByMonth'])->name('clients.byMonth');
    Route::get('/dashboard/warranty/{year}', [DashboardController::class, 'totalWarrantyRecords'])->name('warranties.byYear');
    Route::get('/dashboard/warranty/month/{year}', [DashboardController::class, 'totalWarrantyRecordsByMonth'])->name('warranties.byMonth');
    Route::get('/dashboard/clients', [DashboardController::class, 'purchasedByClient'])->name('totalPurchasedClients');
});

Route::prefix('sales-consultant')->middleware(['role:sales-consultant'])->group(function () {
    //users
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    //clients
    Route::post('/clients/search/', [ClientController::class, 'search'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::post('/clients', [ClientController::class, 'store'])->name('client.store');

    //warranties
    Route::get('/warranties', [WarrantyController::class, 'index'])->name('warranty.index');
    Route::get('/warranties/{id}', [WarrantyController::class, 'show'])->name('show.warranty');
    Route::put('/warranties/{id}', [WarrantyController::class, 'update'])->name('warranty.update');
    Route::delete('/warranties/{id}', [WarrantyController::class, 'destroy'])->name('warranty.destroy');
    Route::post('/warranties', [WarrantyController::class, 'store'])->name('warranty.store');

    //products
    Route::get('/products', [ProductController::class, 'index'])->name('all.product');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::delete('/products/{id}', [WarrantyController::class, 'destroy'])->name('product.destroy');
    Route::put('/products/{id}', [WarrantyController::class, 'update'])->name('product.update');
    Route::post('/products/search/', [ProductController::class, 'search'])->middleware(['throttle:searchUser'])->name('products.search');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('show.product');

    //records
    Route::get('/records', [ResourceController::class, 'getRecords'])->name('all.records');
    Route::get('/records/{date}', [ResourceController::class, 'showRecords'])->name('show.records');
    Route::get('/records/show/{id}', [ResourceController::class, 'show'])->name('record.show');

    //dashboard
    Route::get('/dashboard/clients/{year}', [DashboardController::class, 'totalClientRecords'])->name('clients.byYear');
    Route::get('/dashboard/clients/month/{year}', [DashboardController::class, 'totalClientRecordsByMonth'])->name('clients.byMonth');
    Route::get('/dashboard/warranty/{year}', [DashboardController::class, 'totalWarrantyRecords'])->name('warranties.byYear');
    Route::get('/dashboard/warranty/month/{year}', [DashboardController::class, 'totalWarrantyRecordsByMonth'])->name('warranties.byMonth');
    Route::get('/dashboard/clients', [DashboardController::class, 'purchasedByClient'])->name('totalPurchasedClients');
});
