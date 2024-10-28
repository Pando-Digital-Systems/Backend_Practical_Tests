<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorProductController;

Route::post('/import-csv', [TutorProductController::class, 'importCsv']);
Route::get('/tutor-products', [TutorProductController::class, 'list']);
