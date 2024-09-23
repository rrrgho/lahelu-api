<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthenticationController;
use App\Http\Controllers\api\v1\PostController;


Route::prefix('v1')->group(function(){
    Route::get('auth/missing-token', [AuthenticationController::class, 'missingToken'])->name('login');
    Route::post('auth/user/registration', [AuthenticationController::class, 'registration']);
    Route::post('auth/user/login', [AuthenticationController::class, 'login']);
    Route::get('posts', [PostController::class, 'index']);
    Route::get('comments', [PostController::class, 'comment']);  
    
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function(){
    Route::get('auth/user', [AuthenticationController::class, 'getUserData']);  
});

