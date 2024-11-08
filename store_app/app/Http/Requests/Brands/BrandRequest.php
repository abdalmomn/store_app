<?php

namespace App\Http\Requests\Brands;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name'=>'string|max:40',
            'category_id' => 'exists:categories,id',

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The Brand name is required.',
            'category_id.required' => 'A valid category is required.',

        ];
    }
}
