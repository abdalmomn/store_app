<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
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
            'code' => 'string|unique:coupons,code|max:50', // Required, unique, and max length 50
            'discount_percentage' => 'nullable|numeric|between:0,100', // Optional, percentage between 0 and 100
            'usage_limit' => 'nullable|integer|min:1', // Optional, must be at least 1 if provided
            'expires_in' => 'nullable|date|after:today', // Optional, but if provided, must be a date in the future
        ];
    }
}
