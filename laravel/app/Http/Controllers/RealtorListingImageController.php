<?php

namespace App\Http\Controllers;

use App\Models\Listing;
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
            foreach ($request->file('images') as $file) {
                $baseImg = $listing->images()->create();
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
}
