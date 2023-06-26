<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPlaceOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    function marketPlace()
    {
        return $this->belongsTo(MarketPlace::class);
    }
}
