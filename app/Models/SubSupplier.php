<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SubSupplier extends Authenticatable
{
    protected $table = 'add_sub_supplier';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'supplier_id',
        'status',
        'date',
        'name',
        'mobile',
        'company_name',
        'address',
        'id_card',
        'type',
        'payment_type',
        'account_no',
        'bank_name',
        'ifsc_code',
        'account_name',
    ];

    protected $hidden = [
        'password',
    ];
}