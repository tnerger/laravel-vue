<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);

Route::get('login', [AuthController::class, 'create'])
    ->name('login');

Route::post('login', [AuthController::class, 'store'])
    ->name('login.store');

Route::resource('user-account', UserAccountController::class)->only('create', 'store');

// Geschützte Listing-Routen (CREATE muss vor SHOW stehen!)
Route::middleware('auth')->group(function () {
    Route::get('/hello', [IndexController::class, 'show']);

    Route::delete('logout', [AuthController::class, 'destroy'])
        // CSRF beim Logout rausnehmen
        ->withoutMiddleware([VerifyCsrfToken::class])
        ->name('logout');
});

// Öffentliche Listing-Routen (INDEX und SHOW kommen NACH den geschützten Routen)
Route::resource('listing', ListingController::class)->only(['index', 'show']);

Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
    ->group(function () {
        Route::resource('listing.image', RealtorListingImageController::class)->withoutMiddleware([VerifyCsrfToken::class])->only(['store', 'create']);
        Route::resource('listing', RealtorListingController::class)->withTrashed();
        Route::put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])
            ->withTrashed()
            ->name('listing.restore');
    });
