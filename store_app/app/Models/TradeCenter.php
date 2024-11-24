<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeCenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'trading_order_reference',
        'name',
        'condition',
        'storage_capacity',
        'accessories',
        'purchase_date',
        'purchase_price',
        'photos',
        'additional_notes',
        'approximate_price',
        'brand_id',
        'category_id',
        'user_id',
        'status_id',
        'product_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
