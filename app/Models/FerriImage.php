<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FerriImage extends Model
{
    protected $table = 'ferri_images';

    public $timestamps = false;

    protected $fillable = [
        'ferry_id',
        'cloudnery_img',
        'alt_tag',
    ];
}