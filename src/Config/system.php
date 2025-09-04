<?php

return [
    [
        'key'  => 'general.api',
        'name' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.title',
        'info' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info',
        'icon' => 'settings/settings.svg',
        'sort' => 3,
    ], [
        'key'    => 'general.api.pushnotification',
        'name'   => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.push-notification-configuration',
        'info'   => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'private_key',
                'title'         => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.private-key',
                'type'          => 'textarea',
                'validation'    => 'required',
                'info'          => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info-get-private-key',
                'channel_based' => true,
            ], [
                'name'          => 'notification_topic',
                'title'         => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.notification-topic',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
            ],
        ],
    ], [
        'key'    => 'sales.payment_methods.paypal_standard',
        'name'   => 'admin::app.configuration.index.sales.payment-methods.paypal-standard',
        'info'   => 'admin::app.configuration.index.sales.payment-methods.paypal-standard-info',
        'sort'   => 3,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.title',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.description',
                'type'          => 'textarea',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'image',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.logo',
                'type'          => 'image',
                'info'          => 'admin::app.configuration.index.sales.payment-methods.logo-information',
                'channel_based' => false,
                'locale_based'  => false,
                'validation'    => 'mimes:bmp,jpeg,jpg,png,webp',
            ], [
                'name'          => 'business_account',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.business-account',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'client_id',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.client-id',
                'info'          => 'admin::app.configuration.index.sales.payment-methods.client-id-info',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
                'default'       => 'sb',
            ], [
                'name'          => 'client_secret',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.client-secret',
                'info'          => 'admin::app.configuration.index.sales.payment-methods.client-secret-info',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
                'default'       => 'CLIENT_SECRET',
            ], [
                'name'          => 'active',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.status',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'sandbox',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.sandbox',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'    => 'sort',
                'title'   => 'admin::app.configuration.index.sales.payment-methods.sort-order',
                'type'    => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1,
                    ], [
                        'title' => '2',
                        'value' => 2,
                    ], [
                        'title' => '3',
                        'value' => 3,
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ],
                ],
            ],
        ],
    ],
];
