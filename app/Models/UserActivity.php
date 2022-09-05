<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_time', 'activity', 'url', 'method', 'ip', 'browser', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
