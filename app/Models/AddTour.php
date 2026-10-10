<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddTour extends Model
{
    protected $table = 'add_tour';

    protected $primaryKey = 'add_tour_id';

    public $timestamps = false;

    protected $fillable = [
        'tour_country',
        'title_of_tour',
        'supplier_name',
        'tour_location',
        'search_tag',
        'opening_hour',
        'tour_type',
        'tour_option',
        'agenda',
        'pick_up_type',
        'product_code',
        'date_time',
        'booking_cutoff',
        'pick_up_point',
        'meeting_point',
        'booking_type',
        'route',
        'short_description',
        'full_description',
        'inclusions',
        'inclusions_description',
        'exclusions',
        'exclusions_description',
        'check_ticket',
        'tour_category',
        'tour_sub_category',
        'no_of_day',
        'forward_supplier_tour',
        'assign_supplier',
        'max_adult',
        'max_adult_child',
        'transfer',
        'isactive',
        'video_gellary',
        'latitude',
        'longitude',
        'currency',
        'activity_info',
        'how_to_use',
        'cancel_policy',
        'request_detail',
        'note',
        'timestamp',
        'remark_pick_up_points',
        'popular',
        'default',
        'approved',
        'assign_toinuser',
    ];
}