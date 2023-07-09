<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Tests\TestCase;

class BookingTest extends TestCase
{
    public function testBookingListedSuccessfully()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        factory(Booking::class)->create([
            'user_id'               => User::first()->id,
            'trip_id'               => 1,
            'destination_id'        => 1,
            'station_id'            => 1,
            'status'                => 'processing',
            'departure_time'        => 1,
            'arrival_time'          => now(),
            'booking_time'          => now(),
            'seats_count'           => 5,
            'price'                 => 100,
            'discount'              => 10,
            'total_price'           => 500
        ]);

        $this->json('GET', 'api/v1/bookings', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "data" => [
                    'user_id'               => User::first()->id,
                    'trip_id'               => 1,
                    'destination_id'        => 1,
                    'station_id'            => 1,
                    'status'                => 'processing',
                    'departure_time'        => 1,
                    'arrival_time'          => now(),
                    'booking_time'          => now(),
                    'seats_count'           => 5,
                    'price'                 => 100,
                    'discount'              => 10,
                    'total_price'           => 500
                ],
                "message" => "Retrieved successfully"
            ]);
    }



    public function testRetrieveBookingSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $booking = factory(Booking::class)->create([
            'user_id'               => User::first()->id,
            'trip_id'               => 1,
            'destination_id'        => 1,
            'station_id'            => 1,
            'status'                => 'processing',
            'departure_time'        => 1,
            'arrival_time'          => now(),
            'booking_time'          => now(),
            'seats_count'           => 5,
            'price'                 => 100,
            'discount'              => 10,
            'total_price'           => 500
        ]);

        $this->json('GET', 'api/v1/booking/' . $booking->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "data" => [
                    'user_id'               => User::first()->id,
                    'trip_id'               => 1,
                    'destination_id'        => 1,
                    'station_id'            => 1,
                    'status'                => 'processing',
                    'departure_time'        => 1,
                    'arrival_time'          => now(),
                    'booking_time'          => now(),
                    'seats_count'           => 5,
                    'price'                 => 100,
                    'discount'              => 10,
                    'total_price'           => 500
                ],
                "message" => "Retrieved successfully"
            ]);
    }

    public function testDeleteBooking()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $booking = factory(Booking::class)->create([
            'user_id'               => User::first()->id,
            'trip_id'               => 1,
            'destination_id'        => 1,
            'station_id'            => 1,
            'status'                => 'processing',
            'departure_time'        => 1,
            'arrival_time'          => now(),
            'booking_time'          => now(),
            'seats_count'           => 5,
            'price'                 => 100,
            'discount'              => 10,
            'total_price'           => 500
        ]);

        $this->json('DELETE', 'api/v1/booking/' . $booking->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }


}
