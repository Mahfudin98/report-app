<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productPrice()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function transactionProduct()
    {
        return $this->hasMany(TransactionProduct::class);
    }
}
