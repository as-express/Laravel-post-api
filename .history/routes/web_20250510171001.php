<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    // Verify the email
})->name('verification.verify');