<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Define cuál de los discos definidos abajo se usará por defecto.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Aquí se configuran los distintos "discos" de almacenamiento.
    |
    */

    'disks' => [

        // 📁 Local interno (no público)
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        // 🌐 Público (storage/app/public)
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        // ☁️ Clever Cloud Cellar (para publicaciones)
        'ccs_publicaciones' => [
            'driver' => 's3',
            'key' => env('CELLAR_ADDON_KEY_ID'),
            'secret' => env('CELLAR_ADDON_KEY_SECRET'),
            'region' => 'eu-west-3',
            'bucket' => env('CELLAR_ADDON_BUCKET'),
            'endpoint' => 'https://cellar-c2.services.clever-cloud.com',
            'root' => 'publicaciones',
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => false,
        ],

        // ☁️ Clever Cloud Cellar (para chats)
        'ccs_chats' => [
            'driver' => 's3',
            'key' => env('CELLAR_ADDON_KEY_ID'),
            'secret' => env('CELLAR_ADDON_KEY_SECRET'),
            'region' => 'eu-west-3',
            'bucket' => env('CELLAR_ADDON_BUCKET'),
            'endpoint' => 'https://cellar-c2.services.clever-cloud.com',
            'root' => 'chat_files',
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => false,
        ],

        // ☁️ (opcional) Clever Cloud genérico
        'ccs' => [
            'driver' => 's3',
            'key' => env('CELLAR_ADDON_KEY_ID'),
            'secret' => env('CELLAR_ADDON_KEY_SECRET'),
            'region' => 'eu-west-3',
            'bucket' => env('CELLAR_ADDON_BUCKET'),
            'endpoint' => 'https://cellar-c2.services.clever-cloud.com',
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => false,
            'options' => [
                'ACL' => 'public-read',
                'CacheControl' => 'max-age=31536000, public',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
