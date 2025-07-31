<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Notifications\OfferMade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        Gate::authorize('create', [Offer::class, $listing]);

        $offer = $listing->offers()->save(
            Offer::make(
                $request->validate(
                    ['amount' => 'required|integer|min:1|max:20000000']
                )
            )
                ->user()
                ->associate($request->user())
        );

        $listing->user->notify(
            new OfferMade($offer)
        );

        return redirect()->back()->with('success', 'Offer was made!');
    }
}
