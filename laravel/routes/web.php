<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    $request->fulfill();

    return redirect()
        ->route('listing.index')
        ->with('success', 'Email verified! Welcome!');
})
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/', [IndexController::class, 'index']);

Route::get('login', [AuthController::class, 'create'])
    ->name('login');

Route::post('login', [AuthController::class, 'store'])
    ->name('login.store');

Route::resource('user-account', UserAccountController::class)->only('create', 'store');

// Geschützte Listing-Routen (CREATE muss vor SHOW stehen!)
Route::middleware('auth')->group(function () {

    Route::delete('logout', [AuthController::class, 'destroy'])
        // CSRF beim Logout rausnehmen
        ->withoutMiddleware([VerifyCsrfToken::class])
        ->name('logout');
});

Route::resource('listing.offer', ListingOfferController::class)
    ->middleware('auth')
    ->only('store');

Route::resource('notification', NotificationController::class)
    ->middleware('auth')
    ->only(['index']);

Route::name('notification.read')
    ->middleware('auth')
    ->put(
        'notification/{notification}/read',
        [NotificationController::class, 'read']
    );

// Öffentliche Listing-Routen (INDEX und SHOW kommen NACH den geschützten Routen)
Route::resource('listing', ListingController::class)->only(['index', 'show']);

Route::prefix('realtor')
    ->name('realtor.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::resource(
            'listing.image',
            RealtorListingImageController::class
        )->withoutMiddleware([VerifyCsrfToken::class])->only(['store', 'create', 'destroy', 'update']);
        Route::put('listing/{listing}/image/{image}/move', [RealtorListingImageController::class, 'move'])
            ->name('listing.image.move');
        Route::resource('listing', RealtorListingController::class)->withTrashed();
        Route::put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])
            ->withTrashed()
            ->name('listing.restore');
        Route::put('listing/{listing}/enable', [RealtorListingController::class, 'enable'])
            ->name('listing.enable');
        Route::name('offer.accept')
            ->put(
                'offer/{offer}/accept',
                RealtorListingAcceptOfferController::class
            );
    });
