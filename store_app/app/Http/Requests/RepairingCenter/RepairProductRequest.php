<?php

namespace App\Http\Requests\RepairingCenter;

use Illuminate\Foundation\Http\FormRequest;

class RepairProductRequest extends FormRequest
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
            'name' => 'required|string',
            'photos' => 'array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_manufacture' => 'required',
            'malfunction_type' => 'string|in:hardware,software',
            'malfunctions_description' => 'required|string|min:10',
            'additional_notes' => 'nullable|string|max:1000',
        ];
    }
}
