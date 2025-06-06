<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'concert_id' => 'required|integer|exists:concerts,id',
            'seat_type_id' => 'required|integer|exists:seat_types,id',
        ];
    }

    public function messages(): array
    {
        return [
            'concert_id.required' => 'Concert ID is required.',
            'concert_id.exists' => 'Concert does not exist.',
            'seat_type_id.required' => 'Seat type ID is required.',
            'seat_type_id.exists' => 'Seat type does not exist.',
        ];
    }
}

