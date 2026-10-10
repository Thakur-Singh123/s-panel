<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    protected $table = 'hotels_images';

    public $timestamps = false;

    protected $fillable = [
        'hotel_id',
        'room_id',
        'is_featured',
        'hotel_images',
        'cloudnary_img',
        'alt_tag',
        'created_at',
    ];
}