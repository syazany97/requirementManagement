<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('layouts.app');
});

Auth::routes();



Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index');
});

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*')
    ->middleware('auth:sanctum');

