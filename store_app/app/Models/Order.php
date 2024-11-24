<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
<<<<<<< HEAD
        'product_id',
        'user_id',
        'status_id',
        'coupon_id',
=======
        'order_reference',
        'user_id',
        'status_id',
        'coupon_id',
        'address_id',
        'shipping_method',
        'payment_method',
        'total_price'
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
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

<<<<<<< HEAD
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
=======
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

}
