<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/Main', function () {
    return view('Main');
});
Route::get('/register', [RegisterController::class, 'create'])->middleware("guest");
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/logout',[SessionController::class, 'destroy']);

Route::get('/login', [SessionController::class, 'create'])->middleware("guest");
Route::post('/login', [SessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    });
    Route::get('/settings', function () {
        return view('settings');
    });
});
