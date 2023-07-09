<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DestinationResource;
use App\Http\Resources\StationResource;
use App\Models\Bus;
use App\Models\Destination;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use App\Http\Resources\SeatResource;
use App\Http\Resources\TripResource;
use App\Http\Resources\BusResource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class GeneralApiController extends APIController
{
    /**
     * get list of seats
     * Send API Response in JSON format.
     *
     * @return JsonResponse
     */
    public function seats(): JsonResponse
    {
        $seats = Seat::get();
        return $this->sendResponse(SeatResource::collection($seats), 'Seats retrieved successfully');
    }

    /**
     * get list of trips
     * Send API Response in JSON format.
     *
     * @return JsonResponse
     */
    public function trips(): JsonResponse
    {
        $trips = Trip::where('departure_time', '<=', Carbon::now())->get();
        return $this->sendResponse(TripResource::collection($trips), 'Trips retrieved successfully');
    }

    public function buses(): JsonResponse
    {
        $buses = Bus::get();
        return $this->sendResponse(BusResource::collection($buses), 'Buses retrieved successfully');
    }

    /**
     * get list of stations
     */
    public function stations(): JsonResponse
    {
        $stations = Station::get();
        return $this->sendResponse(StationResource::collection($stations), 'Stations retrieved successfully');
    }

    /**
     * get list of destinations
     */
    public function destinations(): JsonResponse
    {
        $destinations = Destination::get();
        return $this->sendResponse(DestinationResource::collection($destinations), 'Destinations retrieved successfully');
    }

}
