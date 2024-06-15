<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
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
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],
        'media' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media'),
            'url' => env('APP_URL').'/media',
        ],
        'covers' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/covers'),
            'url' => env('APP_URL').'/storage/media/covers',
        ],
        'avatars' => [
            'driver' => 'local',
            'root' => storage_path('app/public/media/avatars'),
            'url' => env('APP_URL').'/storage/media/avatars',
        ],
        'temp' => [
            'driver' => 'local',
            'root' => storage_path('app/public/tmp'),
            'visibility' => 'public',
        ],
        'digitalocean' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'region' => env('DO_SPACES_REGION', 'nyc3'),
            'bucket' => env('DO_SPACES_BUCKET', 'udemy'),
            'cdn_endpoint' => env('DO_SPACES_CDN_ENDPOINT', 'https://cdn.fusigabs.com'),
            'endpoint' => env('DO_SPACES_ENDPOINT', 'https://nyc3.digitaloceanspaces.com/'),
            'url' => env('DO_SPACES_URL', 'https://cdn.fusigabs.com'),
            'use_path_style_endpoint' => env('DO_SPACES_USE_PATH_STYLE_ENDPOINT', false),
            'disable_asserts' => true,
            'visibility' => 'public',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
