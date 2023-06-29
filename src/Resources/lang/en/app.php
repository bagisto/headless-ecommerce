<?php

    return [
        'admin'     => [
            'menu'  => [
                'push-notification' => 'Push Notification',
            ],

            'acl'  => [
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

            'notification'  => [
                'title'                 => 'Push Notification',
                'add-title'             => 'Add Notification',
                'general'               => 'General',

                'id'                    => 'Id',
                'image'                 => 'Image',
                'text-title'            => 'Title',
                'edit-notification'     => 'Edit Notification',
                'manage'                => 'Notifications',
                'new-notification'      => 'New Notification',
                'create-btn-title'      => 'Save Notification',
                'notification-image'    => 'Notification Image',
                'notification-title'    => 'Notification Title',
                'notification-content'  => 'Notification Content',
                'notification-type'     => 'Notification Type',
                'product-cat-id'        => 'Product/Category Id',
                'store-view'            => 'Channels',
                'notification-status'   => 'Notification Status',
                'created'               => 'Created',
                'modified'              => 'Modified',
                'collection-autocomplete'   => 'Custom Collection - (Autocomplete)',
                'no-collection-found'       => 'Collections not found with same name.',
                'collection-search-hint'    => 'Start typing collection name',
                
                'Action'    => [
                    'edit'      => 'Edit',
                ],

                'status'    => [
                    'enabled'   => 'Enabled',
                    'disabled'  => 'Disabled',
                ],

                'notification-type-option'  => [
                    'select'            => '-- Select --',
                    'simple'            => 'Simple Type',
                    'product'           => 'Product Based',
                    'category'          => 'Category Based',
                ],
            ],

            'alert' => [
                'create-success'        => ':name created successfully',
                'update-success'        => ':name updated successfully',
                'delete-success'        => ':name deleted successfully',
                'delete-failed'         => ':name deleted failed',
                'sended-successfully'   => ':name pushed successfully for android and iOS.',
                'no-value-selected'     => 'there are no existing value',
            ],

            'settings'   => [
                'exchange_rates' => [
                    'error-invalid-target-currency' => 'Warning: Invaid target currency provided.',
                    'delete-success'        => 'Success: Exchange rate deleted successfully.',
                ]
            ],
            
            'response'  => [
                'error-invalid-parameter'   => 'Warning: Invaid parameters provided.',
                'success-login'             => 'Success: User login successfuly.',
                'error-login'               => 'Warning: Admin user is not login.',
                'session-expired'           => 'Warning: Session has expired. Please login again to your account.',
                'invalid-header'            => 'Warning: Invalid header token.',
                'success-logout'            => 'Success: User logout successfully.',
                'no-login-user'             => 'Warning: No login user found.',
                'error-customer-group'      => 'Warning: You are not authorize to delete system created attribute group.',
                'password-invalid'          => 'Warning: Please enter the correct password.',
                'password-match'            => 'Warning: Password doesn\'t matched.',
                'success-registered'        => 'Success: User created successfuly.',
                'cancel-error'              => 'Order can not be canceled.',
                'creation-error'            => 'Refund can not be created for this order.',
                'channel-failure'           => 'Channel Not Found.',
                'script-delete-success'     => 'Script deleted successfuly.'
            ]
        ],

        'shop'  => [
            'customer'  => [
                'success-login'         => 'Success: Customer login successfully.',
                'success-logout'        => 'Success: Customer logout successfully.',
                'no-login-customer'     => 'Warning: No login customer found.',
                'address-list'          => 'Success: Customer\'s address details fetched',
                'not-authorized'        => 'Warning: You are not authorized to update this address.',
                'success-address-list'  => 'Success: Customer\'s addresses fetched successfully.',
                'no-address-list'       => 'Warning: No customer\'s address found.',
                'text-password'         => 'Your Password is: :password',
                'not-exists'            => 'Warning: No customer found for the provided data.',
            ],
            'response'  => [
                'error-registration'        => 'Warning: customer registration failed.',
                'password-reset-failed'     => 'Warning: We already sent you password reset email, try after sometime.',
                'customer-details'          => 'Success: Customer details fetched successfully.',
                'not-found'                 => 'Wanring: No :name found.',
                'no-address-found'          => 'Wanring: No address found.',
                'no-order-found'            => 'Wanring: No order found.',
                'warning-empty-cart'        => 'Warning: There is no product added to the cart.',
                'success-add-to-cart'       => 'Success: Product added to cart successfully.',
                'success-update-to-cart'    => 'Success: Cart item has been updated successfully.',
                'success-delete-cart-item'  => 'Success: Cart item has been removed successfully.',
                'success-moved-cart-item'   => 'Success: Cart item moved to wishlist successfully.',
                'billing-address-missing'   => 'Warning: Billing address is missing for checkout.',
                'shipping-address-missing'  => 'Warning: Shipping address is missing for checkout.',
                'invalid-address'           => 'Wanring: No address found for provided addressId.',
                'wrong-error'               => 'Wanring: There is some error with your cart, try again.',
                'save-cart-address'         => 'Success: Cart address save successfully.',
                'error-payment-selection'   => 'Warning: There is some error in fetching payment methods.',
                'selected-shipment'         => 'Success: Shipment has been selected successfully.',
                'error-payment-save'        => 'Warning: There is some error in saving payment method.',
                'selected-payment'          => 'Success: Payment method selected successfully.',
                'error-placing-order'       => 'Warning: There is some error in order placing.',
                'invalid-product'           => 'Warning: You are requesting for invalid product.',
                'already-exist-inwishlist'  => 'Information: This product is already exist in wishlist.',
                'error-move-to-cart'        => 'Warning: This product might have some required options, not able to move to cart.',
                'no-billing-address-found'  => 'Warning: No billing address record found with :address_id billing id.',
                'no-shipping-address-found'  => 'Warning: No shipping address record found with :address_id shipping id.',
                'invalid-guest-access'      => 'Warning: Guest customer are not allow to get addresses with the help of billing/shipping address id.',
                'guest-address-warning'     => 'Warning: If you are trying as a guest, then try without Authorization token.',
                'warning-num-already-used'  => 'Warning: This :phone number is registered using different email address.',
                'coupon-removed'            => 'Success: coupon removed from cart successfully.',
                'coupon-remove-failed'      => 'Warning: there are some error in removing coupon from cart or coupon not found.',
                'review-create-success'     => 'Success: Review is submitted successfully, please wait for the approval.',
            ]
        ],
        
        'validation' => [
            'unique'    => 'This :field has already been taken.',
            'required'  => 'The :field field is required.',
            'same'      => 'The :field and password must match.'
        ],
        
        'mail' => [
            'customer'  => [
                'password' => [
                    'heading'   => config('app.name') . ' - Password Reset',
                    'reset'     => 'Password Reset Email',
                    'summary' => 'This email related to your account password reset, Your password has been changed successfully.
                    Kindly login to your account using below mentioned password.',
                ]
            ]
        ]
    ];