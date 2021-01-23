<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::get('/login', [LoginController::class, 'showLoginPage'])
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
});

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*')
    ->middleware('auth:sanctum');


