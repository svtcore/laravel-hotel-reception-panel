<?php

namespace App\Http\Requests\admin\rooms;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'floorNumber' => 'required|integer|min:1',
            'type' => 'required|string',
            'totalRooms' => 'required|int|min:1|max:10',
            'status' => 'required|string|in:available,occupied,maintence,under_maintenance',
            'adultsBedsCount' => 'required|integer|min:1|max:10',
            'childrenBedsCount' => 'required|integer|min:0|max:10',
            'price' => 'required|numeric|min:0',
            'additionalProperties.*' => 'nullable|integer'
        ];
    }
}
