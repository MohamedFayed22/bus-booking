<?php

namespace Database\Seeders;

use Database\Seeders\BusSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\SeatSeeder;
use Database\Seeders\TripSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        $this->call(SeatSeeder::class);
        $this->call(BusSeeder::class);
        $this->call(TripSeeder::class);
        $this->call(StationSeeder::class);
        $this->call(DestinationSeeder::class);
        $this->call(DiscountSeeder::class);
    }
}
