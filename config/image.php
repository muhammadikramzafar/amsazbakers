<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    | Intervention Image supports "gd" and "imagick" (if installed).
    | GD is enabled in C:\php83\php.ini.
    */

    'driver' => 'gd',

    /*
    |--------------------------------------------------------------------------
    | Upload Paths
    |--------------------------------------------------------------------------
    | Paths under storage/app/public where uploaded images are stored.
    */

    'paths' => [
        'products'  => 'products',
        'categories' => 'categories',
        'gallery'   => 'gallery',
        'team'      => 'team',
        'sliders'   => 'sliders',
    ],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail Sizes
    |--------------------------------------------------------------------------
    */

    'thumbnails' => [
        'product'  => ['width' => 600,  'height' => 600],
        'category' => ['width' => 400,  'height' => 300],
        'gallery'  => ['width' => 800,  'height' => 600],
        'slider'   => ['width' => 1920, 'height' => 700],
    ],

];
