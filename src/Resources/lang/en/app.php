<?php

return [
    'admin' => [
        'acl' => [
            'push-notification' => 'Push Notification',
            'create'            => 'Create',
            'edit'              => 'Edit',
            'delete'            => 'Delete',
            'mass-delete'       => 'Mass Delete',
            'mass-update'       => 'Mass Update',
            'send'              => 'Send',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Push Notification',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'title'                           => 'GraphQL API',
                        'info'                            => 'Notification related configurations',
                        'push-notification-configuration' => 'FCM Push Notification Configuration',
                        'server-key'                      => 'Server Key',
                        'info-get-server-key'             => 'Info: To get FCM API credentials: <a href="https://console.firebase.google.com/" target="_blank">Click here</a>',
                        'android-topic'                   => 'Android Topic',
                        'ios-topic'                       => 'IOS Topic',
                    ],
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Locale created successfully.',
                'update-success'       => 'Locale updated successfully.',
                'last-delete-error'    => 'Last Locale delete failed',
                'delete-success'       => 'Locale deleted successfully.',
                'delete-error'         => 'Locale deleted failed.',
                'not-found'            => 'Warning: Locale not found.',
                'default-delete-error' => 'Default locale can not be deleted.'
            ],

            'currencies' => [
                'last-delete-error'    => 'Last Currency delete failed',
                'delete-success'       => 'Currency deleted successfully.',
                'delete-error'         => 'Currency deleted failed.',
                'not-found'            => 'Warning: Currency not found.',
                'create-success'       => 'Currency created successfully.',
                'update-success'       => 'Currency updated successfully.',
                'default-delete-error' => 'Default currency can not be deleted.'
            ],

            'exchange-rates' => [
                'invalid-target-currency' => 'Warning: Invalid target currency provided.',
                'create-success'          => 'Exchange rate created successfully.',
                'update-success'          => 'Exchange rate updated successfully.',
                'delete-success'          => 'Success: Exchange rate deleted successfully.',
                'last-delete-error'       => 'Last Exchange rate delete failed',
                'delete-error'            => 'Exchange rate deleted failed.',
                'not-found'               => 'Warning: Exchange rate not found.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Inventory created successfully.',
                'update-success'    => 'Inventory updated successfully.',
                'last-delete-error' => 'Last Inventory delete failed',
                'delete-success'    => 'Inventory deleted successfully.',
                'delete-error'      => 'Inventory deleted failed.',
                'not-found'         => 'Warning: Inventory not found.',
            ],

            'channels' => [
                'create-success'       => 'Channel created successfully.',
                'update-success'       => 'Channel updated successfully.',
                'last-delete-error'    => 'Last Channel delete failed',
                'delete-success'       => 'Channel deleted successfully.',
                'delete-error'         => 'Channel deleted failed.',
                'not-found'            => 'Warning: Channel not found.',
                'default-delete-error' => 'Default Channel can not be deleted.'
            ],

            'users' => [
                'login-error'       => 'Please check your credentials and try again.',
                'activate-warning'  => 'Your account is yet to be activated, please contact administrator.',
                'success-login'     => 'Success: User login successfully.',
                'success-logout'    => 'Success: User logout successfully.',
                'create-success'    => 'User created successfully.',
                'not-found'         => 'Warning: User not found.',
                'update-success'    => 'User updated successfully.',
                'delete-success'    => 'User deleted successfully.',
                'last-delete-error' => 'Last User delete failed',
                'delete-error'      => 'User deleted failed.',
            ],

            'roles' => [
                'create-success'    => 'Role created successfully.',
                'update-success'    => 'Role updated successfully.',
                'last-delete-error' => 'Last Role can not be deleted.',
                'delete-success'    => 'Role deleted successfully.',
                'delete-error'      => 'Role deleted failed.',
                'not-found'         => 'Warning: Role not found.',
            ],

            'themes' => [
                'create-success' => 'Theme created successfully.',
                'update-success' => 'Theme updated successfully.',
                'delete-success' => 'Theme deleted successfully.',
                'not-found'      => 'Warning: Theme not found.',
            ],

            'notification' => [
                'index' => [
                    'title'     => 'Push Notification',
                    'add-title' => 'Add Notification',
                    'general'   => 'General',

                    'datagrid' => [
                        'id'                   => 'Id',
                        'image'                => 'Image',
                        'text-title'           => 'Title',
                        'notification-content' => 'Notification Content',
                        'notification-type'    => 'Notification Type',
                        'notification-status'  => 'Notification Status',
                        'created-at'           => 'Created Time',
                        'updated-at'           => 'Updated Time',
                        'delete'               => 'Delete',
                        'update'               => 'Update',

                        'status' => [
                            'enabled'  => 'Enabled',
                            'disabled' => 'Disabled',
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
                    'settings'             => 'Setting',
                    'status'               => 'Status',
                    'store-view'           => 'Channels',
                    'notification-type'    => 'Notification Type',
                    'product-cat-id'       => 'Product/Category Id',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Product',
                        'category' => 'Category'
                    ],
                ],

                'edit' => [
                    'edit-notification'    => 'Edit Notification',
                    'back-btn'             => 'Back',
                    'send-title'           => 'Send Notification',
                    'update-btn-title'     => 'Update',
                    'general'              => 'General',
                    'title'                => 'Push Notification',
                    'content-and-image'    => 'Notification Content And Image',
                    'notification-content' => 'Notification Content',
                    'image'                => 'Image',
                    'settings'             => 'Setting',
                    'status'               => 'Status',
                    'store-view'           => 'Channels',
                    'notification-type'    => 'Notification Type',
                    'product-cat-id'       => 'Product/Category Id',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Product',
                        'category' => 'Category'
                    ],
                ],

                'create-success'      => 'Notification created successfully.',
                'update-success'      => 'Notification updated successfully.',
                'delete-success'      => 'Notification deleted successfully.',
                'delete-failed'       => 'Notification deleted failed.',
                'massdelete-success'  => 'Selected notifications deleted successfully.',
                'mass-update-success' => 'Selected notifications updated successfully.',
                'sended-successfully' => 'Notification pushed successfully for android and iOS.',
                'no-value-selected'   => 'there are no existing value.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Warning: Invalid parameters provided.',
                'no-login-user'     => 'Warning: No login user found.',
            ],
        ],
    ],
];
