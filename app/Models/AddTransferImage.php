<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddTransferImage extends Model
{
    protected $table = 'add_transfer_images';

    public $timestamps = false;

    protected $fillable = [
        'add_transfer_id',
        'transfer_images',
        'cloudnery_img',
        'img_type',
        'is_featured',
        'alt_tag',
    ];
}