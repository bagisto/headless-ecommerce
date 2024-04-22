<?php

return [
    'shop' => [
        'customers' => [
            'success-login' => 'Success: Customer login successful.',
            'success-logout' => 'Success: Customer logout successful.',
            'no-login-customer' => 'Warning: No login customer found.',

            'signup' => [
                'success-verify' => 'Account created successfully, an e-mail has been sent for verification.',
                'error-registration' => 'Warning: Customer registration failed.',
            ],

            'login' => [
                'invalid-creds' => 'Please check your credentials and try again.',
                'not-activated' => 'Your activation requires admin approval',
                'verify-first'  => 'Please verify your email first.',

                'validation' => [
                    'required' => 'The :field field is required.',
                    'same'     => 'The :field and password must match.',
                    'unique'   => 'This :field has already been taken.',
                ],
            ],

            'forgot-password' => [
                'reset-link-sent' => 'Reset password link sent to your email.',
                'already-sent'    => 'Reset password link already sent to your email.',
                'email-not-exist' => 'Email does not exist.',
            ],

            'accout' => [
                'profile' => [
                   'password-unmatch' => 'Password does not match.',
                ],
            ],
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Create',
            'delete'            => 'Delete',
            'edit'              => 'Edit',
            'mass-delete'       => 'Mass Delete',
            'mass-update'       => 'Mass Update',
            'push-notification' => 'Push Notification',
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
                        'android-topic'                   => 'Android Topic',
                        'info'                            => 'Notification related configurations',
                        'info-get-server-key'             => 'Info: To get FCM API credentials: <a href="https://console.firebase.google.com/" target="_blank">Click here</a>',
                        'ios-topic'                       => 'IOS Topic',
                        'push-notification-configuration' => 'FCM Push Notification Configuration',
                        'server-key'                      => 'Server Key',
                        'title'                           => 'GraphQL API',
                    ],
                ],
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Customer created successfully.',
                'delete-order-pending' => 'Cannot delete the customer account because some Order(s) are pending or in a processing state.',
                'delete-success'       => 'Customer deleted successfully',
                'not-found'            => 'Warning: Customer not found.',
                'note-created-success' => 'Note created successfully',
                'update-success'       => 'Customer updated successfully.',
            ],

            'addressess' => [
                'create-success'         => 'Customer\'s address created successfully.',
                'default-update-success' => 'Address is setted as default',
                'delete-success'         => 'Customer\'s Address deleted successfully',
                'not-found'              => 'Warning: Customer\'s address not found.',
                'update-success'         => 'Customer\'s address updated successfully.',
            ],

            'groups' => [
                'create-success'     => 'Customer Group created successfully.',
                'customer-associate' => 'Warning: Group can\'t be deleted. customer is Associated with it.',
                'delete-success'     => 'Customer deleted successfully',
                'not-found'          => 'Warning: Customer Group not found.',
                'update-success'     => 'Customer Group updated successfully.',
                'user-define-error'  => 'Warning: You are not authorized to delete system-created Customer Group.',
            ],

            'reviews' => [
                'delete-success' => 'Review deleted successfully',
                'not-found'      => 'Warning: Review not found.',
                'update-success' => 'Review updated successfully.',
            ],
        ],

        'cms' => [
            'create-success' => 'CMS created successfully.',
            'delete-success' => 'CMS deleted successfully',
            'not-found'      => 'Warning: CMS not found.',
            'update-success' => 'CMS updated successfully.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Catalog Rule created successfully.',
                    'delete-failed'  => 'Warning: Catalog Rule is not deleted',
                    'delete-success' => 'Catalog Rule deleted successfully',
                    'not-found'      => 'Warning: Catalog Rule not found.',
                    'update-success' => 'Catalog Rule updated successfully.',
                ],

                'cart-rules' => [
                    'create-success' => 'Cart Rule created successfully.',
                    'delete-failed'  => 'Warning: Cart Rule is not deleted',
                    'delete-success' => 'Cart Rule deleted successfully',
                    'not-found'      => 'Cart rule is not found',
                    'update-success' => 'Cart Rule updated successfully.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Locale created successfully.',
                'default-delete-error' => 'Default locale can not be deleted.',
                'delete-error'         => 'Locale deleted failed.',
                'delete-success'       => 'Locale deleted successfully.',
                'last-delete-error'    => 'Last Locale delete failed',
                'not-found'            => 'Warning: Locale not found.',
                'update-success'       => 'Locale updated successfully.',
            ],

            'currencies' => [
                'create-success'       => 'Currency created successfully.',
                'default-delete-error' => 'Default currency can not be deleted.',
                'delete-error'         => 'Currency deleted failed.',
                'delete-success'       => 'Currency deleted successfully.',
                'last-delete-error'    => 'Last Currency delete failed',
                'not-found'            => 'Warning: Currency not found.',
                'update-success'       => 'Currency updated successfully.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Exchange rate created successfully.',
                'delete-error'            => 'Exchange rate deleted failed.',
                'delete-success'          => 'Success: Exchange rate deleted successfully.',
                'invalid-target-currency' => 'Warning: Invalid target currency provided.',
                'last-delete-error'       => 'Last Exchange rate delete failed',
                'not-found'               => 'Warning: Exchange rate not found.',
                'update-success'          => 'Exchange rate updated successfully.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Inventory created successfully.',
                'delete-error'      => 'Inventory deleted failed.',
                'delete-success'    => 'Inventory deleted successfully.',
                'last-delete-error' => 'Last Inventory delete failed',
                'not-found'         => 'Warning: Inventory not found.',
                'update-success'    => 'Inventory updated successfully.',
            ],

            'channels' => [
                'create-success'       => 'Channel created successfully.',
                'default-delete-error' => 'Default Channel can not be deleted.',
                'delete-error'         => 'Channel deleted failed.',
                'delete-success'       => 'Channel deleted successfully.',
                'last-delete-error'    => 'Last Channel delete failed',
                'not-found'            => 'Warning: Channel not found.',
                'update-success'       => 'Channel updated successfully.',
            ],

            'users' => [
                'activate-warning'  => 'Your account is yet to be activated, please contact administrator.',
                'create-success'    => 'User created successfully.',
                'delete-error'      => 'User deleted failed.',
                'delete-success'    => 'User deleted successfully.',
                'last-delete-error' => 'Last User delete failed',
                'login-error'       => 'Please check your credentials and try again.',
                'not-found'         => 'Warning: User not found.',
                'success-login'     => 'Success: User login successfully.',
                'success-logout'    => 'Success: User logout successfully.',
                'update-success'    => 'User updated successfully.',
            ],

            'roles' => [
                'create-success'    => 'Role created successfully.',
                'delete-error'      => 'Role deleted failed.',
                'delete-success'    => 'Role deleted successfully.',
                'last-delete-error' => 'Last Role can not be deleted.',
                'not-found'         => 'Warning: Role not found.',
                'update-success'    => 'Role updated successfully.',
            ],

            'themes' => [
                'create-success' => 'Theme created successfully.',
                'delete-success' => 'Theme deleted successfully.',
                'not-found'      => 'Warning: Theme not found.',
                'update-success' => 'Theme updated successfully.',
            ],

            'tax-rates' => [
                'create-success' => 'Tax Rate created successfully.',
                'delete-error'   => 'Tax Rate deleted failed.',
                'delete-success' => 'Tax Rate deleted successfully.',
                'not-found'      => 'Warning: Tax Rate not found.',
                'update-success' => 'Tax Rate updated successfully.',
            ],

            'tax-category' => [
                'create-success'     => 'Tax Category created successfully.',
                'delete-error'       => 'Tax Category deleted failed.',
                'delete-success'     => 'Tax Category deleted successfully.',
                'not-found'          => 'Warning: Tax Category not found.',
                'tax-rate-not-found' => 'The Given ids not found. Ids:- :ids',
                'update-success'     => 'Tax Category updated successfully.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Add Notification',
                    'general'   => 'General',
                    'title'     => 'Push Notification',

                    'datagrid' => [
                        'created-at'           => 'Created Time',
                        'delete'               => 'Delete',
                        'id'                   => 'Id',
                        'image'                => 'Image',
                        'notification-content' => 'Notification Content',
                        'notification-status'  => 'Notification Status',
                        'notification-type'    => 'Notification Type',
                        'text-title'           => 'Title',
                        'update'               => 'Update',
                        'updated-at'           => 'Updated Time',

                        'status' => [
                            'disabled' => 'Disabled',
                            'enabled'  => 'Enabled',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Back',
                    'content-and-image'    => 'Notification Content And Image',
                    'create-btn-title'     => 'Save Notification',
                    'general'              => 'General',
                    'image'                => 'Image',
                    'new-notification'     => 'New Notification',
                    'notification-content' => 'Notification Content',
                    'notification-type'    => 'Notification Type',
                    'product-cat-id'       => 'Product/Category Id',
                    'settings'             => 'Setting',
                    'status'               => 'Status',
                    'store-view'           => 'Channels',
                    'title'                => 'Push Notification',

                    'option-type' => [
                        'category' => 'Category',
                        'others'   => 'Simple',
                        'product'  => 'Product',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Back',
                    'content-and-image'    => 'Notification Content And Image',
                    'edit-notification'    => 'Edit Notification',
                    'general'              => 'General',
                    'image'                => 'Image',
                    'notification-content' => 'Notification Content',
                    'notification-type'    => 'Notification Type',
                    'product-cat-id'       => 'Product/Category Id',
                    'send-title'           => 'Send Notification',
                    'settings'             => 'Setting',
                    'status'               => 'Status',
                    'store-view'           => 'Channels',
                    'title'                => 'Push Notification',
                    'update-btn-title'     => 'Update',

                    'option-type' => [
                        'category' => 'Category',
                        'others'   => 'Simple',
                        'product'  => 'Product',
                    ],
                ],

                'create-success'      => 'Notification created successfully.',
                'delete-failed'       => 'Notification deleted failed.',
                'delete-success'      => 'Notification deleted successfully.',
                'mass-update-success' => 'Selected notifications updated successfully.',
                'massdelete-success'  => 'Selected notifications deleted successfully.',
                'no-value-selected'   => 'there are no existing value.',
                'sended-successfully' => 'Notification pushed successfully for android and iOS.',
                'update-success'      => 'Notification updated successfully.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Warning: Invalid parameters provided.',
                'no-login-user'     => 'Warning: No login user found.',
            ],
        ],
    ],

    'shop' => [
        'response' => [
            'error' => [
                'invalid-parameter' => 'Warning: Invalid parameters provided.',
            ],
        ],

        'subscription' => [
            'already'             => 'You are already subscribed to our newsletter.',
            'already-unsubscribe' => 'You are already unsubscribed to our newsletter.',
            'not-found'           => 'Warning: No subscribtion found.',
            'subscribe-success'   => 'You have successfully subscribed to our newsletter.',
            'unsubscribe-success' => 'You have successfully unsubscribed to our newsletter.',
        ],

        'customers' => [
            'customer-details'  => 'Success: Customer details fetched successfully.',
            'no-login-customer' => 'Warning: No login customer found.',
            'success-login'     => 'Success: Customer login successful.',
            'success-logout'    => 'Success: Customer logout successful.',

            'login-form' => [
                'invalid-creds' => 'Please check your credentials and try again.',
                'not-activated' => 'Your activation requires admin approval',

                'validation' => [
                    'required' => 'The :field field is required.',
                    'same'     => 'The :field and password must match.',
                    'unique'   => 'This :field has already been taken.',
                ],
            ],

            'signup-form' => [
                'error-registration' => 'Warning: Customer registration failed.',
            ],

            'account' => [
                'profile' => [
                    'edit-fail' => 'Warning: Profile not updated',
                ],

                'addresses' => [
                    'not-found' => 'Warning: No Address found.',
                ],

                'wishlist' => [
                    'already-exist' => 'Warning: Already added to Wishlist.',
                    'not-found' => 'Warning: No products found in Wishlist.',
                ],
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'invalid-parameter' => 'Warning: Invalid parameters provided.',
                    ],

                    'success' => [
                        'move-to-wishlist' => 'Success: Selected items successfully moved to wishlist.',
                        'add-to-cart' => 'Success: Product added to cart successfully.',
                        'delete-cart-item' => 'Success: Item is successfully removed from the cart.',
                        'all-remove' => 'Success: All items removed from the cart.',
                    ],

                    'fail' => [
                        'move-to-wishlist' => 'Warning: Selected items not moved to wishlist.',
                        'fail-add-to-cart' => 'Warning: Product not added to cart.',
                        'delete-cart-item' => 'Warning: Item is not removed from the cart.',
                        'not-found' => 'Warning: Cart not found.',
                        'all-remove' => 'Warning: All items not removed from the cart.',
                    ],
                ],
            ],
        ],
    ],
];
