<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
<<<<<<< HEAD
        'type',
        'value',
=======
        'discount_amount',
        'discount_percentage',
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        'start_date',
        'end_date',
    ];

<<<<<<< HEAD

    public function products()
    {
        return $this->belongsToMany(Product::class,'offer_products') ->withPivot('quantity')
        ->withTimestamps();;
=======
    public function products()
    {
        return $this->belongsToMany(Product::class);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    }

    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'favoriteable');
    }

}
