<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insertOrIgnore(array(
            0 =>
                array(
                    'amount' => 10,
                    'max_seat_count' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
        ));
    }
}
