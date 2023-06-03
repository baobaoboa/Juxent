<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//rate limit
Route::group(['middleware' => ['throttle:verifyUser']], function(){
    Route::post('/login', [AuthController::class,'login'])->name('auth.login');
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/profile', [AuthController::class,'profile'])->name('auth.profile');
    Route::put('/profile', [AuthController::class,'updateProfile'])->name('auth.updateProfile');
    Route::post('/logout', [AuthController::class,'logout'])->name('auth.logout');
});


Route::prefix('operations-manager')->group(function () {
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
