<?php

namespace App\Providers;

use App\Models\Offer;
use App\Policies\OfferPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Offer::class => OfferPolicy::class,
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
