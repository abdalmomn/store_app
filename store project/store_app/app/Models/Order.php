<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'status_id',
        'coupon_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function status()
    {
        return $this->hasMany(Status::class);
    }

    public function coupons()
    {
        return $this->belongsTo(Coupon::class);
    }
}
