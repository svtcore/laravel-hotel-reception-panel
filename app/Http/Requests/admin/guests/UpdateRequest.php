<?php

namespace App\Http\Requests\admin\guests;

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
            'phoneNumber' => 'required|string|max:20',
            'gender' => 'required|string|in:M,F,N',
            'dob' => 'required|date',
            'countryCode' => 'required|string|max:2',
            'documentSerial' => 'required|string|max:255',
            'documentNumber' => 'required|string|max:255',
            'documentExpired' => 'required|date',
            'documentIssuedBy' => 'required|string|max:255',
            'documentIssuedDate' => 'required|date',
        ];
    }
}
