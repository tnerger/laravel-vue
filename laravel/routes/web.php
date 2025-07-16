<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingCrontroller;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);


Route::resource('listing', ListingCrontroller::class)->only(['index', 'show']);

Route::get('login', [AuthController::class, 'create'])
    ->name('login');

Route::post('login', [AuthController::class, 'store'])
    ->name('login.store');

Route::resource('user-account', UserAccountController::class)->only('create', 'store');


Route::middleware('auth')->group(function () {
    Route::get('/hello', [IndexController::class, 'show']);
    Route::resource('listing', ListingCrontroller::class)->only(['update', 'store', 'create', 'destroy', 'edit']);
    Route::delete('logout', [AuthController::class, 'destroy'])
        // CSRF beim Logout rausnehmen
        ->withoutMiddleware([VerifyCsrfToken::class])
        ->name('logout');
});
