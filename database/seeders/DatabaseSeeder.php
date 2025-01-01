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
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-01',
            'weight' => 275,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-02',
            'weight' => 274.6,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-03',
            'weight' => 274.2,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-04',
            'weight' => 273.9,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-05',
            'weight' => 273.6,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-06',
            'weight' => 273.2,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-07',
            'weight' => 273,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-08',
            'weight' => 272.7,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-09',
            'weight' => 272.5,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-10',
            'weight' => 272.4,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-11',
            'weight' => 273.1,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-12',
            'weight' => 273.4,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-13',
            'weight' => 273,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-14',
            'weight' => 272.7,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-15',
            'weight' => 272.4,
        ]);

        Weight::factory()->create([
            'user_id' => 1,
            'date' => '2024-12-16',
            'weight' => 272,
        ]);
    }
}
