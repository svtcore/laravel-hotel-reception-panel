<?php

namespace App\Http\Requests\admin\booking;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'roomNumber' => 'nullable|string|max:3',
            'guestName' => 'nullable|string|max:255', 
            'phoneNumber' => 'nullable|string|max:20',
        ];
    }
}
