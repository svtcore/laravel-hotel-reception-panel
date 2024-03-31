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
            'adult_amount' => ['required', 'integer', 'min:1'],
            'children_amount' => ['nullable', 'regex:/^[0-9]{0,9}$/'],
            'check_in_date' => ['required', 'date', 'date_format:Y-m-d'],
            'check_out_date' => ['required', 'date', 'date_format:Y-m-d'],
            'payment_type' => ['required', 'string', 'in:credit_card,cash'],
            'status' => ['required', 'string', 'in:reserved,canceled,active,expired,completed'],
            'note' => ['nullable', 'string', 'max:500'],
            'services.*' => ['nullable', 'regex:/^[1-9][0-9]{0,9}$/']
        ];
    }
}
