<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trips')->insertOrIgnore(array(
            0 =>
                array(
                    'name' => 'Cairo to Alexandria',
                    'from' => 'Cairo',
                    'to' => 'Alexandria',
                    'price' => 200,
                    'departure_time'=>'2021-02-03 14:00:00',
                    'arrival_time'=> '2021-02-03 16:00:00',
                    'bus_id'=> 2,
                    'distance'=> '90 KM',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            1 =>
                array(
                    'name' => 'Cairo to Aswan',
                    'from' => 'Cairo',
                    'to' => 'Aswan',
                    'price' => 600,
                    'departure_time'=>'2021-02-03 14:00:00',
                    'arrival_time'=> '2021-02-03 2:00:00',
                    'bus_id'=> 1,
                    'distance'=> '150 KM',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
        ));
    }
}
