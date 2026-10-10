<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddTourImage extends Model
{
    protected $table = 'add_tour_images';

    public $timestamps = false;

    protected $fillable = [
        'add_tour_id',
        'tour_images',
        'cloudnery_img',
        'img_type',
        'alt_tag',
        'is_featured',
    ];
}