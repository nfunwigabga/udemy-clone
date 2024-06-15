<?php

return [
    'disks' => [
        'images' => [
            'avatars' => 'avatars',
        ],
        'videos' => [
            'temp' => 'temp',
            'stream' => 'digitalocean',
        ],
    ],
    'extensions' => [
        'thumbnails' => '.png',
        'stream' => '.m3u8',
        'stream_mimetype' => 'application/x-mpegURL',
    ],
    'currency' => 'usd',
    'price_tiers' => [
        ['label' => 'Free', 'value' => '0.00'],
        ['label' => '$19.99 (tier 1)', 'value' => '19.99'],
        ['label' => '$49.99 (tier 2)', 'value' => '49.99'],
        ['label' => '$99.99 (tier 3)', 'value' => '99.99'],
        ['label' => '$119.99 (tier 3)', 'value' => '119.99'],
    ],
    'cookie_domain' => env('COOKIE_DOMAIN'),
    'stripe' => [
        'secret' => env('STRIPE_SECRET_KEY'),
    ],
    'author_percent' => 0.6,
];
