<?php

namespace App\Http\Requests\admin\employees;

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
            'dob' => 'required|date',
            'phoneNumber' => 'required|string|max:20',
            'position' => 'nullable|string|max:255',
            'status' => 'required|in:active,fired,vacation,other',
        ];
    }
}
