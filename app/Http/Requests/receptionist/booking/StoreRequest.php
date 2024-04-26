<?php

namespace App\Http\Requests\receptionist\booking;

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
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'room_id' => 'required|numeric|min:1|max:999999',
            'adultsCount' => 'required|integer|min:1',
            'childrenCount' => 'required|integer|min:0',
            'checkInDate' => 'required|date|after_or_equal:today',
            'checkOutDate' => 'required|date|after:checkInDate',
            'paymentType' => 'required|string|in:cash,credit_card, discount',
            'status' => 'required|string|in:reserved,cancelled,active,expired,completed',
            'note' => 'nullable|string|max:500',
            'additionalServices.*' => 'nullable|regex:/^[1-9][0-9]{0,9}$/',
        ];
    }
}
