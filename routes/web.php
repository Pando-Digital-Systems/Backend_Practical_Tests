<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('api/register', [AuthController::class, 'register']);
Route::post('api/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('api/user-profile', [AuthController::class, 'userProfile']);
    Route::post('api/logout', [AuthController::class, 'logout']);
});

Route::get('/auth', function () {
    return view('auth');
});
