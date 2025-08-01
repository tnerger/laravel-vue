<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Listing::class);

        $filters = $request->only([
            'priceFrom',
            'priceTo',
            'beds',
            'baths',
            'areaFrom',
            'areaTo',
        ]);

        $query = Listing::mostRecent()->filter($filters);



        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => $query->notSold()->with('images')->paginate(10)->withQueryString()
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, Listing $listing)
    {
        Gate::authorize('view', $listing);

        $listing->load('images');

        $offer = $request->user() ? $listing->offers()->byActiveUser()->first() : null;

        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
                'offerMade' => $offer
            ]
        );
    }
}
