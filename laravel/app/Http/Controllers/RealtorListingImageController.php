<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\ListingImageSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Str;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load(['images']);
        return inertia('Realtor/ListingImage/Create', [
            'listing' => $listing
        ]);
    }

    public function store(Listing $listing, Request $request)
    {
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
            ], [
                'images.*:mimes' => "The file should be in on the formats: pg,png,jpeg,webp"
            ]);

            $maxSort = $listing->images()->max('sort') ?? 0;

            foreach ($request->file('images') as $file) {
                $baseImg = $listing->images()->create([
                    'is_cover' => $maxSort === 0, // Set first image as cover
                    'sort' => ++$maxSort,
                ]);
                $baseFilename = Str::uuid();
                foreach ($baseImg->file_sizes as $fileSizeName => $fileSize) {
                    $image = Image::read($file)
                        ->scale(height: $fileSize)
                        ->encodeByMediaType('image/jpeg', progressive: true, quality: 80);
                    $filename = $baseFilename . '.jpg';
                    $path = 'images/' . $fileSizeName . '/' . $filename;

                    Storage::disk('public')->put($path, $image->toString());

                    $baseImg->sizes()->save(new ListingImageSize([
                        'filename' => $path,
                        'size' => $fileSizeName
                    ]));
                }
            }
        }
        return redirect()->back()->with('success', 'Images Uploaded');
    }

    public function destroy($listing, ListingImage $image)
    {
        foreach ($image->sizes as $size) {
            Storage::disk('public')->delete($size->filename);
        }
        $image->delete();
        return redirect()->back()->with('success', 'Images deleted!');
    }

    public function update(Request $request, Listing $listing, ListingImage $image)
    {
        $request->validate([
            'sort' => 'required|integer',
            'is_cover' => 'boolean'
        ]);

        if ($request->input('is_cover')) {
            $listing->images()->update(['is_cover' => false]);
        }

        $image->update([
            'sort' => $request->input('sort'),
            'is_cover' => $request->input('is_cover', false)
        ]);

        return redirect()->back()->with('success', 'Image updated successfully!');
    }

    public function move(Request $request, Listing $listing, ListingImage $image)
    {

        $vData = $request->validate([
            'direction' => 'required|integer|in:-1,1'
        ]);

        $currentSort = $image->sort;
        $targetSort = $currentSort + $vData['direction'];

        // Find the image with the target sort order
        $targetImage = $listing->images()->where('sort', $targetSort)->first();

        if ($targetImage) {
            // Swap the sort values
            $image->update(['sort' => $targetSort]);
            $targetImage->update(['sort' => $currentSort]);
        }

        return redirect()->back()->with('success', 'Image moved successfully!');
    }
}
