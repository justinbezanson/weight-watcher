<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Weight;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Justin',
            'email' => 'justinbezanson+weightwatcher@gmail.com',
            'password' => bcrypt('password'),
            'lbs' => false,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-01',
            'weight' => 125,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-02',
            'weight' => 124.6,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-03',
            'weight' => 124.2,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-04',
            'weight' => 123.9,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-05',
            'weight' => 123.6,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-06',
            'weight' => 123.2,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-07',
            'weight' => 123,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-08',
            'weight' => 122.7,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-09',
            'weight' => 122.5,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-10',
            'weight' => 122.4,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-11',
            'weight' => 123.1,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-12',
            'weight' => 123.4,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-13',
            'weight' => 123,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-14',
            'weight' => 122.7,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-15',
            'weight' => 122.4,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-16',
            'weight' => 122,
        ]);
    }
}
