<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;


Route::prefix('operation-manager')->middleware(['role:operations-manager'])->group(function () {
    Route::post('/issue', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/issue', [IssueController::class, 'index'])->name('issue.index');
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::get('/user', [UserController::class, 'index'])->name('users.index');
});

Route::prefix('secretary')->middleware(['role:secretary'])->group(function () {
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::get('/user', [UserController::class, 'index'])->name('users.index');
});
