<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ListingSeeder extends Seeder
{
    private function addImageSizesToListingImage(ListingImage $image, String $filename): void
    {
        foreach ($image->file_sizes as $sizeName => $size) {
            $sizeFilename = 'images' . DIRECTORY_SEPARATOR . $size . DIRECTORY_SEPARATOR . $filename; // Dateiname mit Größe
            $image->sizes()->create([
                'size' => $sizeName,
                'filename' => $sizeFilename
            ]);
        }
    }


    function createListingForUser(User $user, Collection $examplePicturesHouses, Collection $examplePicturesRooms): void
    {
        $listing = Listing::factory()->create([
            'user_id' => $user->id
        ]);

        $image = $listing->images()->create();
        $filename = $examplePicturesHouses->random()['filename'];

        $this->addImageSizesToListingImage($image, $filename);

        // 1 to 4 additional images from rooms
        $numberOfAdditionalImages = rand(1, 4);
        for ($j = 0; $j < $numberOfAdditionalImages; $j++) {
            $additionalImage = $listing->images()->create();
            $additionalFilename = $examplePicturesRooms->random()['filename'];
            $this->addImageSizesToListingImage($additionalImage, $additionalFilename);
        }
    }

    public function run(): void
    {
        //
    }
}
