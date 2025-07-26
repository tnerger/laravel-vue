<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\Offer;
use App\Models\User;

class OfferPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(?User $user, Listing $listing)
    {
        // Benutzer muss eingeloggt sein
        if (!$user) {
            return false;
        }

        // Benutzer kann kein Angebot für sein eigenes Listing machen
        if ($listing->user_id === $user->id) {
            return false;
        }

        // Benutzer kann nur ein Angebot pro Listing machen
        if ($listing->offers()->where('user_id', $user->id)->exists()) {
            return false;
        }

        return true;
    }
}
