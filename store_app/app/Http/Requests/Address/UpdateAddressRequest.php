<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'full_name' => ['regex:/^[a-zA-Z]+(?:\s+[a-zA-Z]+)+$/'],
            'phone_number' => ['numeric', 'digits_between:10,15'],
            'country' => ['string', 'max:100'],
            'city' => ['string', 'max:100'],
            'street' => ['nullable', 'string', 'max:150'],
            'building' => ['string', 'max:10'],
            'apartment' => ['nullable', 'string', 'max:10'],
            'primary' => [''],

        ];
    }
    public function messages()
    {
        return [
            'full_name.regex' => 'The full name must contain at least a first and last name, separated by a space.',
        ];
    }
}
