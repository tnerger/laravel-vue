<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Listing::class);
        return inertia(
            'Listing/Index',
            [
                'listings' => Listing::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);
        return inertia('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Gate::authorize('create', Listing::class);
        $vData = $request->validate([
            "beds" => "required|integer|min:1|max:255",
            "baths" => "required|integer|min:1|max:255",
            "area" => "required|integer|min:1|max:10000",
            "city" => "required|string",
            "code" => "required|string",
            "street" => "required|string",
            "street_nr" => "required|string",
            "price" => "required|integer|min:1|max:10000000",

        ]);
        $request->user()->listings()->create($vData);
        // Listing::create([...$vData, 'user_id' => $request->user()->id]);
        return redirect()->route('listing.index')
            ->with('success', 'Listing was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);
        return inertia(
            'Listing/Show',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('update', $listing);
        return inertia(
            'Listing/Edit',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('update', $listing);
        $vData = $request->validate([
            "beds" => "required|integer|min:1|max:255",
            "baths" => "required|integer|min:1|max:255",
            "area" => "required|integer|min:1|max:10000",
            "city" => "required|string",
            "code" => "required|string",
            "street" => "required|string",
            "street_nr" => "required|string",
            "price" => "required|integer|min:1|max:10000000",

        ]);
        $listing->update($vData);
        return redirect()->route('listing.show', $listing)
            ->with('success', 'Listing was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('delete', $listing);
        $listing->delete();
        return redirect()->route('listing.index')
            ->with('success', 'Listing was deleted');
    }
}
