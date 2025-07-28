<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $this->command->line("  Creating example Images");
        $imageseeder = new ImageSeeder();
        $imageseeder->run();
        $examplePicturesHouses = ImageSeeder::$picturesHouses;
        $examplePicturesRooms = ImageSeeder::$picturesRooms;

        $this->command->line('  Seeding Users + Admin');
        $users = User::factory(40)->create();

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'is_admin' => true
        ]);

        $this->command->line('  Seeding listings with nice pictures');
        $listingSeeder = new ListingSeeder();
        for ($i = 0; $i <= 20; $i++) {
            $user = $users->random();
            $listingSeeder->createListingForUser($user, $examplePicturesHouses, $examplePicturesRooms);
        }
        for ($i = 0; $i <= 10; $i++) {
            $listingSeeder->createListingForUser($admin, $examplePicturesHouses, $examplePicturesRooms);
        }

        $this->command->line('  Seeding offers');
        $offerSeeder = new OfferSeeder();
        $offerSeeder->run();
    }
}
