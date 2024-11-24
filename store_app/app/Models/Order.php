<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_reference',
        'user_id',
        'status_id',
        'coupon_id',
        'address_id',
        'shipping_method',
        'payment_method',
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupons()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'order_items')
            ->withPivot('quantity', 'total_price')->withTimestamps();
    }


    public function address()
    {
        return $this->belongsTo(Address::class);
    }

}
