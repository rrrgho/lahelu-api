<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthenticationController;


Route::prefix('v1')->group(function(){
    Route::get('auth/missing-token', [AuthenticationController::class, 'missingToken'])->name('login');
    Route::post('auth/user/registration', [AuthenticationController::class, 'registration']);
    Route::post('auth/user/login', [AuthenticationController::class, 'login']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function(){
    Route::get('auth/user', [AuthenticationController::class, 'getUserData']);
});