<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
          //  'shipping_method' => 'required|string|in:local_delivery,external_delivery', // Validate shipping method choices
            'payment_method' => 'required|string|in:card,cash_on_delivery,points_system', // Validate payment methods
        ];
    }
}
