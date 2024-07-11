<?php

return [
    'api' => [
        'driver'   => 'jwt',
        'provider' => 'customer',
    ],

    'admin-api' => [
        'driver'   => 'jwt',
        'provider' => 'admin',
    ],
];
