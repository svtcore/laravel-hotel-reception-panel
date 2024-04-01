<?php

namespace App\Http\Requests\admin\rooms;

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
            'roomType' => 'nullable|string',
            'roomStatus' => 'nullable|string',
            'roomAdult' => 'nullable|integer|min:0|max:10',
            'roomChildren' => 'nullable|integer|min:-1|max:10',
            'properties.*' => 'nullable|integer'
        ];
    }
}
