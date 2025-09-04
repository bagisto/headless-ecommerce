<?php

return [
    'customer' => [
        'driver' => 'eloquent',
        'model'  => Webkul\GraphQLAPI\Models\Customer\Customer::class,
    ],

    'admin' => [
        'driver' => 'eloquent',
        'model'  => Webkul\GraphQLAPI\Models\Admin\Admin::class,
    ],
];
