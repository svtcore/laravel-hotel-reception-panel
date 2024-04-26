<?php

namespace App\Http\Requests\receptionist\guests;

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
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phoneNumber' => 'nullable|string|max:20',
            'gender' => 'required|string|in:M,F,N',
            'dob' => 'required|date',
            'countryCode' => 'nullable|string|max:2',
            'documentSerial' => 'nullable|string|max:255',
            'documentNumber' => 'nullable|string|max:255',
            'documentExpired' => 'nullable|date',
            'documentIssuedBy' => 'nullable|string|max:255',
            'documentIssuedDate' => 'nullable|date',
        ];
    }
}
