<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;
use Illuminate\Http\Request;



Route::prefix('issues')->middleware(['role:Operations Manager'])->group(function () {
    Route::post('/', [IssueController::class, 'index'])->name('issue.store');
    Route::get('/', [IssueController::class, 'store'])->name('issue.index');
});
