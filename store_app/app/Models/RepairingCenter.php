<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairingCenter extends Model
{
    use HasFactory;
    protected $fillable = [
<<<<<<< HEAD
        'product_name',
        'memory',
        'brand_name',
        'date_of_manufacture',
        'malfunction_notes',
        'addition_notes',
=======
        'repairing_order_reference',
        'name',
        'photos',
        'date_of_manufacture',
        'malfunction_type',
        'malfunctions_description',
        'additional_notes',
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        'user_id',
        'status_id',
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
