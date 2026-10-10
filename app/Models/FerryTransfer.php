<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FerryTransfer extends Model
{
    protected $table = 'ferry_transfer';

    protected $primaryKey = 'ferry_id';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'supplier_id',
        'forward_supplier_ferry',
        'ferri_class',
        'category',
        'capacity',
        'city',
        'country',
        'description',
        'highlights',
        'feature_img',
        'isactive',
        'created_at',
        'updated_at',
    ];
}