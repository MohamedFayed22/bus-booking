<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'required|exists:seats,id',
            'trip_id' => 'required|exists:trips,id',
            'station_id' => 'required|exists:stations,id',
            'destination_id' => 'required|exists:destinations,id',
        ];
    }
}
