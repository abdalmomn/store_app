<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discount_amount',
        'discount_percentage',
        'start_date',
        'end_date',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'favoriteable');
    }

}
