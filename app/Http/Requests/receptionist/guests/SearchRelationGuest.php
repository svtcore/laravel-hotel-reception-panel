<?php

namespace App\Http\Requests\receptionist\guests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRelationGuest extends FormRequest
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
            'guestName' => 'required|string|max:255',
        ];
    }
}
