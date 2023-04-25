<?php

use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;
use Illuminate\Http\Request;


Route::prefix('issues')->middleware(['role:operations-manager'])->group(function () {
    Route::post('/', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/', [IssueController::class, 'index'])->name('issue.index');
});

Route::prefix('users')->middleware(['role:operations-manager,secretary'])->group(function () {
    Route::post('/', [ResourceController::class, 'store'])->name('users.store');
    Route::get('/', [ResourceController::class, 'index'])->name('users.index');
});
