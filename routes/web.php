<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('api/register', [AuthController::class, 'register']);
Route::post('api/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('api/user-profile', [AuthController::class, 'userProfile'])->name('user-profile');
    Route::post('api/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/auth', function () {
    return view('auth');
});
