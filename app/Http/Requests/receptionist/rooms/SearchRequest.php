<?php

namespace App\Http\Requests\receptionist\rooms;

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
            'roomNumber' => 'nullable|integer|min:1',
            'guestName' => 'nullable|string|max:255', 
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'adultsBedsCount' => 'nullable|integer|min:0|max:10',
            'childrenBedsCount' => 'nullable|integer|min:-1|max:10',
            'additionalProperties.*' => 'nullable|integer'
        ];
    }
}
