<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(40)->create();

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'is_admin' => true
        ]);
        for ($i = 0; $i <= 20; $i++) {
            Listing::factory()->create([
                'user_id' => $users->random()->id
            ]);
        }
        for ($i = 0; $i <= 20; $i++) {
            Listing::factory()->create([
                'user_id' => $admin->id
            ]);
        }
    }
}
