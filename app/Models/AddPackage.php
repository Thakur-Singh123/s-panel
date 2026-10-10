<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddPackage extends Model
{
    protected $table = 'add_package';

    protected $primaryKey = 'add_package_id';

    public $timestamps = false;

    protected $fillable = [
        'package_name',
        'country',
        'package_country',
        'package_type',
        'package_category',
        'package_rating',
        'destination',
        'start_city',
        'duration',
        'package_type_select',
        'hotel_type',
        'no_of_night',
        'no_of_day',
        'no_of_adult',
        'no_of_child',
        'transfers_names',
        'start_date',
        'seven_pax_price',
        'eight_pax_price',
        'price_for_villa_label',
        'hotel_type_economy',
        'tour_id',
        'three_pax_price_economy',
        'four_pax_price_economy',
        'five_pax_price_economy',
        'six_pax_price_economy',
        'seven_pax_price_economy',
        'eight_pax_price_economy',
        'publish_status',
        'hotel_type_luxury',
        'two_pax_price_luxury',
        'three_pax_price_luxury',
        'four_pax_price_luxury',
        'five_pax_price_luxury',
        'six_pax_price_luxury',
        'seven_pax_price_luxury',
        'eight_pax_price_luxury',
        'price_for_villa_label_luxury',
        'day_wise_tour_transfer',
        'package_information',
        'package_itinerary',
        'inclusions',
        'exclusions',
        'max_adult',
        'max_adult_child',
        'transfer',
        'contrace_rate_image',
        'isactive',
        'assign_supplier',
        'latitude',
        'longitude',
        'cancel_policy',
        'combo_package',
        'days',
        'featured_package',
    ];
}