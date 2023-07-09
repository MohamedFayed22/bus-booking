<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateBookingRequest;

class BookingController extends APIController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * list all bookings
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $bookings = Booking::with('trip:id,name,distance', 'bookingSeats')->get();
        return $this->sendResponse(BookingResource::collection($bookings), 'Bookings retrieved successfully');
    }

    /**
     * create new booking
     * @param CreateBookingRequest $request
     * @return JsonResponse
     */
    public function store(CreateBookingRequest $request): JsonResponse
    {
        $booking = Booking::newBook($request);
        if (!$booking) {
            return $this->sendSuccess('You cannot book more seats than are available.');
        }
        return $this->sendSuccess('Bookings retrieved successfully');
    }

    /**
     * cancel booking
     * @param Booking $booking
     * @return JsonResponse
     */
    public function cancel(Booking $booking): JsonResponse
    {
        $cancel = Booking::cancelBooking($booking);
        if (!$cancel) {
            return $this->sendSuccess('You cannot cancel this booking.');
        }
        return $this->sendSuccess('Booking canceled successfully');
    }

    /**
     * get booking details
     * @param Booking $booking
     * @return JsonResponse
     */
    public function show(Booking $booking): JsonResponse
    {
        return $this->sendResponse(new BookingResource($booking), 'Booking retrieved successfully');
    }

    /**
     * update booking
     * @param Booking $booking
     * @param CreateBookingRequest $request
     * @return JsonResponse
     */
    public function update(Booking $booking, CreateBookingRequest $request): JsonResponse
    {
        $booking = Booking::updateBooking($booking, $request);
        return $this->sendResponse(new BookingResource($booking), 'Booking updated successfully');
    }

    /**
     * soft delete booking
     * @param Booking $booking
     * @return JsonResponse
     */
    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();
        return $this->sendSuccess('Booking deleted successfully');
    }

    public function getFrequentTripUser(): JsonResponse
    {
        $user = Booking::frequentTripUser();
        return $this->sendResponse($user, 'Frequent Trip User retrieved successfully');
    }

}
