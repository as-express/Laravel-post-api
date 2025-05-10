<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('/post')->middleware('auth:sanctum')->group(function () {
    Route::post('/store', [AuthController::class,'store']);
    Route::post('/my', [AuthController::class,'myPost']);
});

Route::get('/user/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');