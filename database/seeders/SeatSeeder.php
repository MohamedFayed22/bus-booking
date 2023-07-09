<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seat_types = ['A', 'B'];
        foreach ($seat_types as $seat_type) {
            for ($i = 1; $i <= 10; $i++) {
                DB::table('seats')->insertOrIgnore(array (
                    0 =>
                    array (
                        'seat_type' => $seat_type,
                        'seat_number' => $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ),
                ));
            }
        }

    }
}
