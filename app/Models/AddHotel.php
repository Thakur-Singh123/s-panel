<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddHotel extends Model
{
    protected $table = 'add_hotel';

    protected $primaryKey = 'add_hotel_id';

    public $timestamps = false;

    protected $fillable = [
        'country',
        'city',
        'hotel_name',
        'hotel_address',
        'hotel_zip_code',
        'hotel_phone',
        'hotel_fax',
        'images',
        'hotel_website',
        'hotel_contact_name',
        'hotel_contact_role',
        'hotel_contact_email',
        'accomodation_type',
        'hotel_room',
        'hotel_rating',
        'contact_rate_image',
        'hotel_description',
        'hotel_facility',
        'hotel_additional',
        'isactive',
    ];
}