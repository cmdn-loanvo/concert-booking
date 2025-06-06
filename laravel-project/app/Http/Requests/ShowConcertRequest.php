<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowConcertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:concerts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Concert ID is required.',
            'id.integer' => 'Concert ID must be an integer.',
            'id.exists' => 'Concert not found.',
        ];
    }

    public function validationData()
    {
        return ['id' => $this->route('id')];
    }
}
