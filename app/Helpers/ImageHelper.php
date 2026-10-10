<?php

namespace App\Helpers;

class ImageHelper
{
    //Function for get images
    public static function path($type, $image = null)
    {
        if (empty($image)) {
            return null;
        }

        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        $paths = [
            'tour' =>'https://pub-2b7cc5cb8e514458b769e32609b79ac1.r2.dev/tours/',
            'transfer' =>'https://pub-2b7cc5cb8e514458b769e32609b79ac1.r2.dev/transfers/',
            'package' =>'https://pub-2b7cc5cb8e514458b769e32609b79ac1.r2.dev/packages/',
            'hotel' =>'https://pub-2b7cc5cb8e514458b769e32609b79ac1.r2.dev/hotels/',
            'ferry' =>'https://pub-2b7cc5cb8e514458b769e32609b79ac1.r2.dev/transfers/',
            'wedding' =>'https://pub-2b7cc5cb8e514458b769e32609b79ac1.r2.dev/wedding/',
            'attraction' =>'https://sun-b2b.s3.us-east-2.amazonaws.com/attraction/',
            'voucher_qr' =>'https://pub-2b7cc5cb8e514458b769e32609b79ac1.r2.dev/voucher_qr_code/',
        ];

        $basePath = $paths[$type] ?? null;
        if (!$basePath) {
            return $image;
        }
        return rtrim($basePath, '/') . '/' . ltrim($image, '/');
    }
}