<?php

    return [
        'admin'      => [
            'menu'  => [
                'push-notification' => 'Push Notification',
            ],

            'acl'   => [
                'push-notification' => 'Push Notification',
                'send'              => 'Send',
            ],

            'system' => [
                'graphql-api'                       => 'GraphQL API',
                'push-notification-configuration'   => 'FCM Push Notification Configuration',
                'server-key'                        => 'Server Key',
                'info-get-server-key'               => 'Info: To get fcm API credentials: <a href="https://console.firebase.google.com/" target="_blank">Click here</a>',
                'android-topic'                     => 'Android Topic',
                'ios-topic'                         => 'IOS Topic',
            ],

            'settings' => [
                'notification' => [
                    'index' => [
                        'title'     => 'Push Notification',
                        'add-title' => 'Add Notification',

                        'datagrid'  => [
                            'id'                   => 'Id',
                            'image'                => 'Image',
                            'text-title'           => 'Title',
                            'notification-content' => 'Notification Content',
                            'notification-type'    => 'Notification Type',
                            'store-view'           => 'Channels',
                            'notification-status'  => 'Notification Status',
                            'created-at'           => 'Created Time',
                            'updated-at'           => 'Updated Time',

                            'status'    => [
                                'enabled'   => 'Enabled',
                                'disabled'  => 'Disabled',
                            ],
                        ],
                    ],

                    'create' => [
                        'new-notification'     => 'New Notification',
                        'back-btn'             => 'Back',
                        'create-btn-title'     => 'Save Notification',
                        'general'              => 'General',
                        'title'                => 'Push Notification',
                        'content-and-image'    => 'Notification Content And Image',
                        'notification-content' => 'Notification Content',
                        'image'                => 'Image',
                        'settings'             => 'Settings',
                        'status'               => 'Status',
                        'store-view'           => 'Channels',
                        'notification-type'    => 'Notification Type',
                        'product-cat-id'       => 'Product/Category Id',
                        'create-success'       => 'Notification created successfully',

                        'option-type' => [
                            'others'   => 'Simple',
                            'product'  => 'Product',
                            'category' => 'Category'
                        ],

                    ]
                ]

            ],
        ]
    ];
