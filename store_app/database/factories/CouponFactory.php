<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'C-'.strtoupper(Str::random(8)),
            'discount_percentage' => 10,
            'usage_limit' => 100,
            'usage_count' => 0,
            'expires_in' => now()->addYear(),
        ];
    }
}
