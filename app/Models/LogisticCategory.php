<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(LogisticCategory::class);
    }

    public function child()
    {
        return $this->hasMany(LogisticCategory::class, 'parent_category_id');
    }

    public function logistic()
    {
        return $this->hasMany(Logistic::class);
    }
}
