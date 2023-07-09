<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')->insertOrIgnore(array(
            0 =>
                array(
                    'name' => 'Station 1',
                    'address' => 'Address 1',
                    'lat' => 10.0,
                    'lng' => 10.1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            1 =>
                array(
                    'name' => 'Station 2',
                    'address' => 'Address 2',
                    'lat' => 11.0,
                    'lng' => 11.1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            2 =>
                array(
                    'name' => 'Station 3',
                    'address' => 'Address 3',
                    'lat' => 12.0,
                    'lng' => 12.1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            3 =>
                array(
                    'name' => 'Station 4',
                    'address' => 'Address4',
                    'lat' => 13.0,
                    'lng' => 13.1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
        ));
    }
}
