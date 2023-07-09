<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'trip_id',
        'user_id',
        'bus_id',
        'status',
        'departure_time',
        'arrival_time',
        'booking_time',
        'seats_count',
        'price',
        'discount',
        'total_price',
        'station_id',
        'destination_id',
    ];

    const STATUS_SELECT = [
        'processing' => 'Processing',
        'confirmed'  => 'Confirmed',
        'rejected'   => 'Rejected',
        'canceled'   => 'Canceled',
    ];

    protected $casts = [
        'trip_id' => 'integer',
        'user_id' => 'integer',
        'bus_id' => 'integer',
        'station_id' => 'integer',
        'destination_id' => 'integer',
        'seats_count' => 'integer',
    ];

    protected $dates = [
        'deleted_at',
        'departure_time',
        'arrival_time',
        'booking_time',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    /* ===================================== Relations ===================================== */

    /**
     * Get the trip that owns the Booking
     *
     * @return BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Get the user that owns the Booking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bus that owns the Booking
     *
     * @return BelongsTo
     */
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    /**
     * Get all the seats for the Booking
     *
     * @return BelongsToMany
     */
    public function bookingSeats(): BelongsToMany
    {
        return $this->belongsToMany(Seat::class, 'book_seats', 'booking_id', 'seat_id');
    }

    /**
     * Get the station that owns the Booking
     *
     * @return BelongsTo
     */
    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Get the destination that owns the Booking
     *
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /* ===================================== Logic methods ===================================== */

    /**
     * Create new Booking
     * @param $inputs
     * @return true
     */
    public static function newBook($inputs): bool
    {
        // check bus is completed
        if (!self::checkTripCompleted($inputs['trip_id'])) {
            return false;
        }

        // check trip date before now
        if (self::tripDetails($inputs['trip_id'])->departure_time  >= now()) {
            return false;
        }

        DB::transaction(function () use ($inputs) {
            try {
                $inputs = collect($inputs)->all();
                $discount = self::discountTrip($inputs['seat_ids']);
                $price = self::tripDetails($inputs['trip_id'])->price;
                $booking = self::create([
                        'user_id'               => User::first()->id,
                        'trip_id'               => $inputs['trip_id'],
                        'destination_id'        => $inputs['destination_id'],
                        'station_id'            => $inputs['station_id'],
                        'status'                => self::STATUS_SELECT['processing'],
                        'departure_time'        => self::tripDetails($inputs['trip_id'])->departure_time,
                        'arrival_time'          => self::tripDetails($inputs['trip_id'])->arrival_time,
                        'booking_time'          => now(),
                        'seats_count'           => count($inputs['seat_ids']),
                        'price'                 => $price,
                        'discount'              => $discount,
                        'total_price'           => self::calculateTotalPrice($discount, $price, $inputs['seat_ids'])
                     ]);

                $booking->bookingSeats()->attach($inputs['seat_ids']);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
        return true;
    }

    /**
     * Calculate total price
     * @param $discount
     * @param $price
     * @param $seats
     * @return float|int
     */
    public static function calculateTotalPrice($discount, $price, $seats): float|int
    {
        return  ($price * count($seats))  - $discount;
    }

    /**
     * Get discount for trip
     * @param $seats
     * @return float|int
     */
    public static function discountTrip($seats): float|int
    {
        $discountFirst = Discount::first();
        if ($discountFirst) {
            $discount = $discountFirst->amount;
            if ($discountFirst->max_seat_count <= count($seats)) {
                return $discount;
            }
        }
        return 0;
    }

    /**
     * Check if booking can be canceled
     * @param $tripId
     * @return bool
     */
    public static function checkTripCompleted($tripId): bool
    {
        $seatsCount = Trip::find($tripId)->bus->seats_count;
        $bookedSeats = (int) Booking::where('trip_id', $tripId)
                                    ->whereDate('booking_time', Carbon::today())
                                    ->sum('seats_count');
        if ($seatsCount >= $bookedSeats) {
            return true;
        }
        return false;
    }

    /**
     * Get trip details
     * @param $tripId
     * @return mixed
     */
    public static function tripDetails($tripId): mixed
    {
        return Trip::find($tripId);
    }

    /**
     * cancel booking
     * @param $booking
     * @return bool
     */
    public static function cancelBooking($booking): bool
    {
        if (self::canBeCanceled($booking)) {
            return false;
        }
        $booking->status = self::STATUS_SELECT['canceled'];
        $booking->save();
        return true;
    }

    /**
     * Check if booking can be canceled
     * @param $booking
     * @return bool
     */
    public static function canBeCanceled($booking): bool
    {
        return $booking->departure_time > now();
    }

    /**
     * Update booking
     * @return mixed
     */
    public static function updateBooking($booking, $inputs): bool
    {
        $booking->update([
            'destination_id' => $inputs['destination_id'],
            'station_id' => $inputs['station_id'],
        ]);
        return true;
    }

    public static function frequentTripUser()
    {
        return DB::table('bookings')
            ->select('user_id', 'trip_id', DB::raw('COUNT(trip_id) as `trip_count`'))
            ->groupBy('user_id', 'trip_id')
            ->get();
    }
}
