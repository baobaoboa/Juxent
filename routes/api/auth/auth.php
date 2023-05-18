<?php

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


Route::get('/test', [\App\Http\Controllers\ResourceController::class,'getRecords'])->name('auth.logout');
