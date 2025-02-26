<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseController;

Route::resource('/database', DatabaseController::class)
    ->middleware('auth');

Route::get('/database/{database}/get-tables', [DatabaseController::class, 'getTables'])
    ->middleware('auth');
