<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'resources_id' => 'required|integer',
            'reserved_at' => 'required|date_format:Y-m-d H:i:s',
            'duration' => 'required|regex:/^\d{2}:\d{2}:\d{2}$/',
        ];
    }
}
