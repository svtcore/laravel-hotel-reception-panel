<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmationRequest extends FormRequest
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
            'token' => 'required|string|max:60',
            'password' => 'required|confirmed|min:8',
        ];
    }
}
