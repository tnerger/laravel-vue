<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $listings = Listing::all();

        foreach ($listings as $listing) {
            // get basic Listing Data
            $listingOwnerId = $listing->unser_id;
            $listingPrice = $listing->price;
            $offers = rand(0, 5);

            for ($i = 0; $i < $offers; $i++) {
                // fetch random user, but not the owner of the listing
                do {
                    $otherUserId = $users->random()->id;
                } while ($otherUserId === $listingOwnerId);
                // create fake amount +/-50%
                $offerAmount = (int)($listingPrice + ($listingPrice * (rand(-50, 50) / 100)));
                $listing->offers()->create([
                    'user_id' => $otherUserId,
                    'amount' => $offerAmount
                ]);
            }
        }
    }
}
