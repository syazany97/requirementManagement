<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Project\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('layouts.app');
});

Auth::routes();




//Route::middleware(['auth'])->group(function () {
////    Route::get('/home', 'HomeController@index');
////    Route::apiResource('projects', ProjectController::class);
//});

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*')
    ->middleware('auth:sanctum');

