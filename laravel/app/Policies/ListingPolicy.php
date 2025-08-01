<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{

    public function before(?User $user, $ability)
    {
        // Grant full access to admins, let other users go through normal policy checks
        if ($user?->is_admin) {
            return true;
        }

        // Return null to continue with normal policy methods for non-admin users
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listing $listing): bool
    {
        if ($listing->user_id === $user?->id) {
            return true;
        }

        return $listing->sold_at === null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !($user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): bool
    {
        return $listing->sold_at === null && ($user->id === $listing->user_id);
    }


    /**
     * Determine wether the user can see Listing in Reator-View
     */
    public function viewRealtor(User $user, Listing $listing): bool
    {
        return ($user->id === $listing->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id;
    }
}
