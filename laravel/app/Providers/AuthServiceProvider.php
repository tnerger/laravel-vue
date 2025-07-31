<?php

namespace App\Providers;

use App\Models\Listing;
use App\Models\Offer;
use App\Policies\ListingPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\OfferPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Offer::class => OfferPolicy::class,
        Listing::class => ListingPolicy::class,
        DatabaseNotification::class => NotificationPolicy::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        $this->registerPolicies();
    }
}
