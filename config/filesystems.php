<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */
    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'ccs' => [
            'driver' => 's3',
            'key' => env('CELLAR_ADDON_KEY_ID'),          // tu Key ID
            'secret' => env('CELLAR_ADDON_KEY_SECRET'),   // tu Key Secret
            'region' => 'paris',                          // región de tu bucket
            'bucket' => env('CELLAR_ADDON_BUCKET'),       // nombre del bucket
            'endpoint' => 'https://cellar-c2.services.clever-cloud.com',
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    */
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
