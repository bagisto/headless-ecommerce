<?php

return [
    'admin' => [
        'menu' => [
            'push-notification' => 'Push Notification',
        ],

        'acl' => [
            'push-notification' => 'Push Notification',
            'send'              => 'Send',
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
                'last-delete-error' => 'Last Locale delete failed',
                'delete-success'    => 'Locale deleted successfully.',
                'delete-error'      => 'Locale deleted failed.',
                'not-found'         => 'Warning: Locale not found.',
            ],

            'currencies' => [
                'last-delete-error' => 'Last Currency delete failed',
                'delete-success'    => 'Currency deleted successfully.',
                'delete-error'      => 'Currency deleted failed.',
                'not-found'         => 'Warning: Currency not found.',
            ],

            'exchange-rates' => [
                'invalid-target-currency' => 'Warning: Invalid target currency provided.',
                'delete-success'          => 'Success: Exchange rate deleted successfully.',
                'last-delete-error'       => 'Last Exchange rate delete failed',
                'delete-error'            => 'Exchange rate deleted failed.',
                'not-found'               => 'Warning: Exchange rate not found.',
            ],

            'inventory-sources' => [
                'last-delete-error' => 'Last Inventory delete failed',
                'delete-success'    => 'Inventory deleted successfully.',
                'delete-error'      => 'Inventory deleted failed.',
                'not-found'         => 'Warning: Inventory not found.',
            ],

            'channels' => [
                'last-delete-error' => 'Last Channel delete failed',
                'delete-success'    => 'Channel deleted successfully.',
                'delete-error'      => 'Channel deleted failed.',
                'not-found'         => 'Warning: Channel not found.',
            ],

            'users' => [
                'login-error'       => 'Please check your credentials and try again.',
                'activate-warning'  => 'Your account is yet to be activated, please contact administrator.',
                'success-login'     => 'Success: User login successfully.',
                'success-logout'    => 'Success: User logout successfully.',
                'last-delete-error' => 'Last User delete failed',
                'delete-success'    => 'User deleted successfully.',
                'delete-error'     => 'User deleted failed.',
                'create-success'    => 'User created successfully.',
                'not-found'         => 'Warning: User not found.',
            ],

            'roles' => [
                'last-delete-error' => 'Last Role delete failed',
                'delete-success'    => 'Role deleted successfully.',
                'delete-error'      => 'Role deleted failed.',
                'not-found'         => 'Warning: Role not found.',
            ],

            'themes' => [
                'delete-success' => 'Theme deleted successfully.',
                'not-found'      => 'Warning: User not found.',
            ],

            'tax-rate' => [
                'delete-success' => 'Tax Rate deleted successfully.',
                'delete-error'   => 'Tax Rate deleted failed.',
                'not-found'      => 'Warning: Tax Rate not found.',
            ],

            'tax-category' => [
                'delete-success'     => 'Tax Category deleted successfully.',
                'delete-error'       => 'Tax Category deleted failed.',
                'not-found'          => 'Warning: Tax Category not found.',
                'tax-rate-not-found' => 'The Given ids not found. Ids:- :ids',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Warning: Invalid parameters provided.',
                'no-login-user'     => 'Warning: No login user found.',
            ],
        ],

        // 'response' => [
        //     'delete-success'          => 'Success: User deleted successfully.',
        //     'last-delete-error'       => 'Warning: At least one user is required',
        //     'delete-failed'           => 'Warning: Admin user is not deleted',
        //     'error-login'             => 'Warning: Admin user is not logged in.',
        //     'session-expired'         => 'Warning: Session has expired. Please log in again to your account.',
        //     'invalid-header'          => 'Warning: Invalid header token.',
        //     'error-customer-group'    => 'Warning: You are not authorized to delete system-created attribute group.',
        //     'password-invalid'        => 'Warning: Please enter the correct password.',
        //     'password-match'          => 'Warning: Passwords don\'t match.',
        //     'success-registered'      => 'Success: User created successfully.',
        //     'cancel-error'            => 'Order cannot be canceled.',
        //     'creation-error'          => 'Refund cannot be created for this order.',
        //     'channel-failure'         => 'Channel Not Found.',
        //     'script-delete-success'   => 'Script deleted successfully.',
        // ],





        // 'settings' => [
        //     'notification' => [
        //         'index' => [
        //             'title'               => 'Push Notification',
        //             'add-title'           => 'Add Notification',
        //             'delete-success'      => 'Notification deleted successfully',
        //             'mass-update-success' => 'Selected Notifications updated successfully',
        //             'mass-delete-success' => 'Selected Notifications deleted successfully',

        //             'datagrid' => [
        //                 'id'                   => 'Id',
        //                 'image'                => 'Image',
        //                 'text-title'           => 'Title',
        //                 'notification-content' => 'Notification Content',
        //                 'notification-type'    => 'Notification Type',
        //                 'store-view'           => 'Channels',
        //                 'notification-status'  => 'Notification Status',
        //                 'created-at'           => 'Created Time',
        //                 'updated-at'           => 'Updated Time',
        //                 'delete'               => 'Delete',
        //                 'update'               => 'Update',

        //                 'status' => [
        //                     'enabled'  => 'Enabled',
        //                     'disabled' => 'Disabled',
        //                 ],
        //             ],
        //         ],

        //         'create' => [
        //             'new-notification'     => 'New Notification',
        //             'back-btn'             => 'Back',
        //             'create-btn-title'     => 'Save Notification',
        //             'general'              => 'General',
        //             'title'                => 'Push Notification',
        //             'content-and-image'    => 'Notification Content And Image',
        //             'notification-content' => 'Notification Content',
        //             'image'                => 'Image',
        //             'settings'             => 'Settings',
        //             'status'               => 'Status',
        //             'store-view'           => 'Channels',
        //             'notification-type'    => 'Notification Type',
        //             'product-cat-id'       => 'Product/Category Id',
        //             'success'              => 'Notification created successfully',

        //             'option-type' => [
        //                 'others'   => 'Simple',
        //                 'product'  => 'Product',
        //                 'category' => 'Category',
        //             ],
        //         ],

        //         'edit' => [
        //             'edit-notification'         => 'Edit Notification',
        //             'back-btn'                  => 'Back',
        //             'send-title'                => 'Send Notification',
        //             'update-btn-title'          => 'Update Notification',
        //             'general'                   => 'General',
        //             'title'                     => 'Push Notification',
        //             'content-and-image'         => 'Notification Content And Image',
        //             'notification-content'      => 'Notification Content',
        //             'image'                     => 'Image',
        //             'settings'                  => 'Settings',
        //             'status'                    => 'Status',
        //             'store-view'                => 'Channels',
        //             'notification-type'         => 'Notification Type',
        //             'product-cat-id'            => 'Product/Category Id',
        //             'success'                   => 'Notification updated successfully',
        //             'notification-send-success' => 'Notification send successfully for Android and iOS.',

        //             'option-type' => [
        //                 'others'   => 'Simple',
        //                 'product'  => 'Product',
        //                 'category' => 'Category',
        //             ],
        //         ],
        //     ],

        //
        // ],

        // 'customer' => [
        //     'no-customer-found' => 'No customer found',
        // ],



        // 'shop' => [
        //     'response' => [
        //         'no-address-found'         => 'Warning: No address found.',
        //         'invalid-address'          => 'Warning: No address found for provided address ID.',
        //         'invalid-product'          => 'Warning: You are requesting an invalid product.',
        //         'already-exist-inwishlist' => 'Information: This product already exists in the wishlist.',
        //         'un-authorized-access'     => 'Warning: You are not authorized to use this section.',
        //     ],
        // ],

        // 'validation' => [
        //     'unique'   => 'This :field has already been taken.',
        //     'required' => 'The :field field is required.',
        //     'same'     => 'The :field and password must match.',
        // ],

        // 'mail' => [
        //     'customer' => [
        //         'password' => [
        //             'heading' => config('app.name') . ' - Password Reset',
        //             'reset'   => 'Password Reset Email',
        //             'summary' => 'This email is related to your account password reset. Your password has been changed successfully.
        //             Kindly log in to your account using the below-mentioned password.',
        //         ],
        //     ],
        // ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => 'Success: Cart address saved successfully.',
            'error-payment-selection'   => 'Warning: There is an error in fetching payment methods.',
            'selected-shipment'         => 'Success: Shipment has been selected successfully.',
            'warning-empty-cart'        => 'Warning: There are no products added to the cart.',
            'billing-address-missing'   => 'Warning: Billing address is missing for checkout.',
            'shipping-address-missing'  => 'Warning: Shipping address is missing for checkout.',
            'invalid-guest-access'      => 'Warning: Guest customers are not allowed to get addresses with the help of billing/shipping address ID.',
            'guest-address-warning'     => 'Warning: If you are trying as a guest, then try without an Authorization token.',
            'wrong-error'               => 'Warning: There is an error with your cart, try again.',
            'no-billing-address-found'  => 'Warning: No billing address record found with :address_id billing ID.',
            'no-shipping-address-found' => 'Warning: No shipping address record found with :address_id shipping ID.',
            'error-invalid-parameter'   => 'Warning: Invalid parameters provided.',
            'already-applied'           => 'Coupon code already applied.',
            'success-apply'             => 'Coupon code applied successfully.',
            'coupon-removed'            => 'Success: coupon removed from the cart successfully.',
            'coupon-remove-failed'      => 'Warning: there are some errors in removing the coupon from the cart or the coupon is not found.',
            'error-placing-order'       => 'Warning: There is an error in placing the order.',
            'selected-payment'          => 'Success: Payment method selected successfully.',
            'error-payment-save'        => 'Warning: There is an error in saving the payment method.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'All items successfully removed from the cart.',
                    'fail-all-remove'          => 'Error in removing items from the cart.',
                    'error-invalid-parameter'  => 'Warning: Invalid parameters provided.',
                    'success-moved-cart-item'  => 'Success: Cart item moved to the wishlist successfully.',
                    'fail-moved-cart-item'     => 'Fail: Cart item is not moved to the wishlist.',
                    'success-add-to-cart'      => 'Success: Product added to the cart successfully.',
                    'fail-add-to-cart'         => 'Fail: Product is not added to the cart.',
                    'success-update-to-cart'   => 'Success: Cart item has been updated successfully.',
                    'fail-update-to-cart'      => 'Fail: Cart item has not been updated.',
                    'success-delete-cart-item' => 'Success: Cart item has been removed successfully.',
                    'fail-delete-cart-item'    => 'Fail: Cart item not found.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'Success: Customer login successful.',
            'success-logout'        => 'Success: Customer logout successful.',
            'no-login-customer'     => 'Warning: No login customer found.',
            'address-list'          => 'Success: Customer\'s address details fetched',
            'not-authorized'        => 'Warning: You are not authorized to update this address.',
            'no-address-list'       => 'Warning: No customer\'s address found.',
            'text-password'         => 'Your Password is: :password',
            'not-exists'            => 'Warning: No customer found for the provided data.',
            'success-address-list'  => 'Success: Customer\'s addresses fetched successfully.',
            'reset-link-sent'       => 'Success: Password reset email has been sent successfully.',
            'password-reset-failed' => 'Warning: We already sent you a password reset email, try again after some time.',
            'no-login-user'         => 'Warning: No login user found.',
            'customer-details'      => 'Success: Customer details fetched successfully.',

            'account' => [
                'not-found' => 'Warning: No :name found.',

                'profile' => [
                    'edit-success'   => 'Profile Updated Successfully',
                    'edit-fail'      => 'Profile not updated',
                    'unmatch'        => 'The old password does not match.',
                    'order-pending'  => 'Cannot delete the customer account because some Order(s) are pending or in a processing state.',
                    'delete-success' => 'Customer deleted successfully',
                    'wrong-password' => 'Wrong Password!',
                ],

                'order' => [
                    'no-order-found' => 'Warning: No order found.',
                    'cancel-success' => 'Order canceled successfully',
                ],

                'review' => [
                    'success' => 'Success: Review is submitted successfully, please wait for the approval.',
                ],

                'wishlist' => [
                    'removed'            => 'Item Successfully Removed From Wishlist',
                    'remove-fail'        => 'Item Cannot Be Removed From Wishlist',
                    'remove-all-success' => 'All the items from your wishlist have been removed',
                    'success'            => 'Item Successfully Added To Wishlist',
                    'already-exist'      => 'Product already exists in the wishlist',
                    'move-to-cart'       => 'Move To Cart',
                    'moved-success'      => 'Item Successfully Moved to Cart',
                    'error-move-to-cart' => 'Warning: This product might have some required options, not able to move to the cart.',
                    'no-item-found'      => 'Warning: There is no product found.',
                ],

                'addressess' => [
                    'delete-success' => 'Customer\'s Address deleted successfully',
                ]
            ],

            'signup-form' => [
                'error-registration'       => 'Warning: Customer registration failed.',
                'warning-num-already-used' => 'Warning: This :phone number is registered using a different email address.',
                'success-verify'           => 'Account created successfully, an email has been sent for verification.',
                'invalid-creds'            => 'Please check your credentials and try again.',

                'validation' => [
                    'unique'   => 'This :field has already been taken.',
                    'required' => 'The :field field is required.',
                    'same'     => 'The :field and password must match.',
                ],
            ],

            'login-form' => [
                'not-activated' => 'Your activation requires admin approval',
                'invalid-creds' => 'Please check your credentials and try again.',
            ],
        ],

        'response' => [
            'error-invalid-parameter' => 'Warning: Invalid parameters provided.',
            'invalid-header'          => 'Warning: Invalid header token.',
            'cancel-error'            => 'Order cannot be canceled.',
        ],
    ],
];
