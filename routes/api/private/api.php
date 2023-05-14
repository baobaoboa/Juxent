<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;


Route::prefix('operations-manager')->middleware(['role:operations-manager'])->group(function () {
    Route::post('/issue', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/issue', [IssueController::class, 'index'])->name('issue.index');
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/user', [UserController::class, 'index'])->name('users.index');
    Route::post('/record', [ClientController::class, 'store'])->name('record.store');
    Route::post('/clients/', [ClientController::class, 'search-client'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');


});

Route::prefix('secretary')->middleware(['role:secretary'])->group(function () {
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/user', [UserController::class, 'index'])->name('users.index');
    Route::post('/record', [ClientController::class, 'store'])->name('record.store');
    Route::post('/clients/', [ClientController::class, 'search-client'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
});

Route::prefix('sales-consultant')->middleware(['role:sales-consultant'])->group(function () {
    Route::post('/clients/', [ClientController::class, 'search-client'])->middleware(['throttle:searchUser'])->name('clients.search');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
});
