<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Weight;
use App\Models\MeasurementType;
use Illuminate\Support\Carbon;
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

        $today = Carbon::now();
        $fiveYearsAgo = Carbon::now()->subYears(5);

        while ($today->gt($fiveYearsAgo)) {
            Weight::factory()->create([
                'user_id' => 1,
                'date' => $fiveYearsAgo->format('Y-m-d'),
                'weight' => rand(75, 110),
            ]);

            $fiveYearsAgo->addDay();
        }

        MeasurementType::factory()->create([
            'user_id' => 1,
            'name' => 'Neck',
        ]);

        MeasurementType::factory()->create([
            'user_id' => 1,
            'name' => 'Waist',
        ]);

        MeasurementType::factory()->create([
            'user_id' => 1,
            'name' => 'Hips',
        ]);
    }
}
