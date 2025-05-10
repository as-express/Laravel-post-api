<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->name('verification.verify');
