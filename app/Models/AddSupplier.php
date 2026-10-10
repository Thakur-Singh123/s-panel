<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AddSupplier extends Authenticatable
{
    protected $table = 'add_supplier';

    protected $primaryKey = 'add_supplier_id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'contact_person',
        'address',
        'telephone',
        'fax',
        'email',
        'partial_payment_allow',
        'vat_invoice_allow',
        'password',
        'image',
        'licence',
        'isactive',
        'token',
        'country',
        'tour_location',
        'company_name',
        'type',
        'toins_user_id',
        'services',
    ];

    protected $hidden = [
        'password',
        'token',
    ];
}