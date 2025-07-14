<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingCrontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show']);

Route::resource('listing', ListingCrontroller::class);
