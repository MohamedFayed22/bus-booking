<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $format = 'Y-m-d H:i:s';
        return [
            'id' => $this->id,
            'status' => $this->status,
            'user_name' => optional($this->user)->name,
            'user_email' => optional($this->user)->email,
            'user_phone' => optional($this->user)->phone,
            'trip_name' => optional($this->trip)->name,
            'trip_distance' => $this->trip->distance,
            'station_name' => $this->station->name,
            'destination_name' => $this->destination->name,
            'departure_time' =>  Carbon::create($this->departure_time)->format(
                $format
            ),
            'arrival_time' => Carbon::create($this->arrival_time)->format(
                $format
            ),
            'booking_time' => Carbon::create($this->booking_time)->format(
                $format
            ),
            'total_price' => $this->total_price,
            'discount' => $this->discount,
            'booking_seats_number' => SeatResource::collection(
                $this->bookingSeats
            ),

        ];
    }
}
