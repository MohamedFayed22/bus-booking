<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buses')->insertOrIgnore(array(
            0 =>
                array(
                    'driver_name' => 'Driver 1',
                    'bus_number' => 'Bus 1',
                    'bus_type' => 'Long Distance',
                    'seats_count' => 20,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            1 =>
                array(
                    'driver_name' => 'Driver 2',
                    'bus_number' => 'Bus 2',
                    'bus_type' => 'Short Distance',
                    'seats_count' => 20,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
        ));
    }
}
