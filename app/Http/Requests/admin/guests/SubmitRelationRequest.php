<?php

namespace App\Http\Requests\admin\guests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitRelationRequest extends FormRequest
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
            'guest_id' => 'required|numeric|mix:1',
            'booking_id' => 'required|numeric|mix:1',
        ];
    }
}
