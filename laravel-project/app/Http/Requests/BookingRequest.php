<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'concert_id' => 'required|integer|exists:concerts,id',
            'seat_type_id' => 'required|integer|exists:seat_types,id',
        ];
    }

    public function messages()
    {
        return [
            'concert_id.required' => 'You must select a concert.',
            'concert_id.exists' => 'Selected concert does not exist.',
            'seat_type_id.required' => 'You must select a seat type.',
            'seat_type_id.exists' => 'Selected seat type does not exist.',
        ];
    }
}
