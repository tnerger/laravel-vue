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
            'listings' => $request->user()->listings()->when(
                $filter['deleted'] === 'true',
                fn($query) => $query->withTrashed()
            )->sort($sort)->paginate(10)->withQueryString(),
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
}
