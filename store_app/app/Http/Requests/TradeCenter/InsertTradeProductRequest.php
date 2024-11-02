<?php

namespace App\Http\Requests\TradeCenter;

use Illuminate\Foundation\Http\FormRequest;

class InsertTradeProductRequest extends FormRequest
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
            'condition' => 'required|string|max:255',
            'storage_capacity' => 'required|string|in:8,16,32,64,128,256,512,1024,2048,4096',
            'accessories' => 'nullable|string|max:255',
            'purchase_date' => 'required',
            'purchase_price' => 'numeric|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_notes' => 'nullable|string|max:1000',
            'brand_id' => 'exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'product_id' => 'required|exists:products,id',
        ];
    }
}
