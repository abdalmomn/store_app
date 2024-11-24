<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'rate',
        'like',
<<<<<<< HEAD
        'user_id',
        'product_id',
        'likes_count',
        'dislikes_count',
=======
        'dislike',
        'user_id',
        'product_id',
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
<<<<<<< HEAD
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withPivot('status_like' );
    }
=======
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
}
