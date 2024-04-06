<?php

namespace App\Http\Requests\admin\rooms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'roomNumber' => 'required|integer|min:1',
            'roomFloor' => 'required|integer|min:1',
            'roomType' => 'required|string',
            'roomCount' => 'required|int|min:1|max:10',
            'roomStatus' => 'required|string|in:free,busy,maintence,reserved',
            'roomAdult' => 'required|integer|min:1|max:10',
            'roomChild' => 'required|integer|min:0|max:10',
            'roomPrice' => 'required|numeric|min:0',
            'properties.*' => 'nullable|integer'
        ];
    }
}
