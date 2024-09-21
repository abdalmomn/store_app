<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function repairing_center()
    {
        return $this->belongsTo(RepairingCenter::class);
    }
    public function trade_center()
    {
        return $this->belongsTo(TradeCenter::class);
    }
}
