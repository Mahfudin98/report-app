<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function transactionProduct()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
