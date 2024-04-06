<?php

namespace App\Http\Requests\admin\booking;

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
            'adultsCount' => 'required|integer|min:1',
            'childrenCount' => 'nullable|regex:/^[0-9]{0,9}$/',
            'checkInDate' => 'required|date|date_format:Y-m-d',
            'checkOutDate' => 'required|date|date_format:Y-m-d',
            'paymentType' => 'required|string|in:credit_card,cash,discount',
            'status' => 'required|string|in:reserved,cancelled,active,expired,completed',
            'note' => 'nullable|string|max:500',
            'additionalServices.*' => 'nullable|regex:/^[1-9][0-9]{0,9}$/'
        ];
    }
}
