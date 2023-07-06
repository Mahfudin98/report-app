<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageRoationSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['start_date', 'end_date', 'headline_image_id'];
    public function headlineImage()
    {
        return $this->belongsTo(HeadlineImage::class);
    }
}
