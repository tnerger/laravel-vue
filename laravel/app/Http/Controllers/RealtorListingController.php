<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RealtorListingController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->only(['deleted']);
        $sort = $request->only(['by', 'order']);
        // dd($sort);
        return inertia('Realtor/Index', [
            'listings' => $request->user()
                ->listings()
                ->when(
                    ($filter['deleted'] ?? false)  === 'true',
                    fn($query) => $query->withTrashed()
                )
                ->sort($sort)
                ->withCount('images')
                ->paginate(10)
                ->withQueryString(),
            'filter' => $filter,
            'sort' => $sort
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('delete', $listing);
        $listing->deleteOrFail();
        return redirect()->back()
            ->with('success', 'Listing was deleted');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('update', $listing);
        return inertia(
            'Realtor/Edit',
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);
        return inertia('Realtor/Create');
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
        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing was created!');
    }

    public function restore(Request $request, Listing $listing)
    {
        $listing->restore();
        return redirect()->back()
            ->with('success', 'Listing was restored!');
    }
}
