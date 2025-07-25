<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $imageseeder = new ImageSeeder();
        $imageseeder->run();
        $examplePicturesHouses = ImageSeeder::$picturesHouses;
        $examplePicturesRooms = ImageSeeder::$picturesRooms;

       $listingSeeder = new ListingSeeder();

        $users = User::factory(40)->create();

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'is_admin' => true
        ]);
        for ($i = 0; $i <= 20; $i++) {
            $user = $users->random();
            $listingSeeder->createListingForUser($user, $examplePicturesHouses, $examplePicturesRooms);
        }
        for ($i = 0; $i <= 10; $i++) {
            $listingSeeder->createListingForUser($admin, $examplePicturesHouses, $examplePicturesRooms);
        }
    }
}
