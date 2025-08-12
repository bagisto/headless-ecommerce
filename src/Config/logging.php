<?php

return [
    'graphql-cache' => [
        'driver' => 'single',
        'path'   => storage_path('logs/graphql-cache.log'),
        'level'  => 'debug',
    ],
];
