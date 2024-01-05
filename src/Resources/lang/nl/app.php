<?php

return [
    'admin' => [
        'menu'          => [
            'push-notification' => 'Push Notification',
        ],

        'acl'           => [
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
                        'info-get-server-key'             => 'Info: To get fcm API credentials: <a href="https://console.firebase.google.com/" target="_blank">Click here</a>',
                        'android-topic'                   => 'Android Topic',
                        'ios-topic'                       => 'IOS Topic',
                    ],
                ],
            ],
        ],

        'settings'      => [
            'notification'   => [
                'index'  => [
                    'title'               => 'Push Notification',
                    'add-title'           => 'Add Notification',
                    'delete-success'      => 'Notification deleted successfully',
                    'mass-update-success' => 'Selected Notifications updated successfully',
                    'mass-delete-success' => 'Selected Notifications deleted successfully',

                    'datagrid'            => [
                        'id'                   => 'Id',
                        'image'                => 'Image',
                        'text-title'           => 'Title',
                        'notification-content' => 'Notification Content',
                        'notification-type'    => 'Notification Type',
                        'store-view'           => 'Channels',
                        'notification-status'  => 'Notification Status',
                        'created-at'           => 'Created Time',
                        'updated-at'           => 'Updated Time',
                        'delete'               => 'Delete',
                        'update'               => 'Update',

                        'status'               => [
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
                    'settings'             => 'Settings',
                    'status'               => 'Status',
                    'store-view'           => 'Channels',
                    'notification-type'    => 'Notification Type',
                    'product-cat-id'       => 'Product/Category Id',
                    'success'              => 'Notification created successfully',

                    'option-type'          => [
                        'others'   => 'Simple',
                        'product'  => 'Product',
                        'category' => 'Category'
                    ],

                ],

                'edit'   => [
                    'edit-notification'         => 'Edit Notification',
                    'back-btn'                  => 'Back',
                    'send-title'                => 'Send Notification',
                    'update-btn-title'          => 'Update Notification',
                    'general'                   => 'General',
                    'title'                     => 'Push Notification',
                    'content-and-image'         => 'Notification Content And Image',
                    'notification-content'      => 'Notification Content',
                    'image'                     => 'Image',
                    'settings'                  => 'Settings',
                    'status'                    => 'Status',
                    'store-view'                => 'Channels',
                    'notification-type'         => 'Notification Type',
                    'product-cat-id'            => 'Product/Category Id',
                    'success'                   => 'Notification updated successfully',
                    'notification-send-success' => 'Notification send successfully for android and iOS.',

                    'option-type'               => [
                        'others'   => 'Simple',
                        'product'  => 'Product',
                        'category' => 'Category'
                    ],
                ]
            ],

            'exchange_rates' => [
                'error-invalid-target-currency' => 'Warning: Invaid target currency provided.',
                'delete-success'                => 'Success: Exchange rate deleted successfully.',
            ]
        ],

        'customer'      => [
            'no-customer-found' => 'No customer found',
        ],

        'response'      => [
            'delete-success'          => 'Success: User deleted successfuly.',
            'last-delete-error'       => 'Warning: Atleast on user is  required',
            'delete-failed'           => 'Warning: Admin user is not deleted',
            'error-invalid-parameter' => 'Warning: Invaid parameters provided.',
            'success-login'           => 'Success: User login successfuly.',
            'error-login'             => 'Warning: Admin user is not login.',
            'session-expired'         => 'Warning: Session has expired. Please login again to your account.',
            'invalid-header'          => 'Warning: Invalid header token.',
            'success-logout'          => 'Success: User logout successfully.',
            'no-login-user'           => 'Warning: No login user found.',
            'error-customer-group'    => 'Warning: You are not authorize to delete system created attribute group.',
            'password-invalid'        => 'Warning: Please enter the correct password.',
            'password-match'          => 'Warning: Password doesn\'t matched.',
            'success-registered'      => 'Success: User created successfuly.',
            'cancel-error'            => 'Order can not be canceled.',
            'creation-error'          => 'Refund can not be created for this order.',
            'channel-failure'         => 'Channel Not Found.',
            'script-delete-success'   => 'Script deleted successfuly.',
        ],

        'shop'          => [

            'response' => [
                'no-address-found'         => 'Wanring: No address found.',
                'invalid-address'          => 'Wanring: No address found for provided addressId.',
                'invalid-product'          => 'Warning: You are requesting for invalid product.',
                'already-exist-inwishlist' => 'Information: This product is already exist in wishlist.',
                'un-authorized-access'     => 'Warning: You are not authorized to use this section.',
            ]
        ],

        'validation'    => [
            'unique'   => 'This :field has already been taken.',
            'required' => 'The :field field is required.',
            'same'     => 'The :field and password must match.',
        ],

        'mail'          => [
            'customer' => [
                'password' => [
                    'heading' => config('app.name') . ' - Password Reset',
                    'reset'   => 'Password Reset Email',
                    'summary' => 'This email related to your account password reset, Your password has been changed successfully.
                    Kindly login to your account using below mentioned password.',
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => 'Success: Cart address save successfully.',
            'error-payment-selection'   => 'Warning: There is some error in fetching payment methods.',
            'selected-shipment'         => 'Success: Shipment has been selected successfully.',
            'warning-empty-cart'        => 'Warning: There is no product added to the cart.',
            'billing-address-missing'   => 'Warning: Billing address is missing for checkout.',
            'shipping-address-missing'  => 'Warning: Shipping address is missing for checkout.',
            'invalid-guest-access'      => 'Warning: Guest customer are not allow to get addresses with the help of billing/shipping address id.',
            'guest-address-warning'     => 'Warning: If you are trying as a guest, then try without Authorization token.',
            'wrong-error'               => 'Wanring: There is some error with your cart, try again.',
            'no-billing-address-found'  => 'Warning: No billing address record found with :address_id billing id.',
            'no-shipping-address-found' => 'Warning: No shipping address record found with :address_id shipping id.',
            'error-invalid-parameter'   => 'Warning: Invaid parameters provided.',
            'already-applied'           => 'Coupon code already applied.',
            'success-apply'             => 'Coupon code applied successfully.',
            'coupon-removed'            => 'Success: coupon removed from cart successfully.',
            'coupon-remove-failed'      => 'Warning: there are some error in removing coupon from cart or coupon not found.',
            'error-placing-order'       => 'Warning: There is some error in order placing.',
            'selected-payment'          => 'Success: Payment method selected successfully.',
            'error-payment-save'        => 'Warning: There is some error in saving payment method.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'All items successfully removed from cart.',
                    'fail-all-remove'          => 'Error in removing items from cart.',
                    'error-invalid-parameter'  => 'Warning: Invaid parameters provided.',
                    'success-moved-cart-item'  => 'Success: Cart item moved to wishlist successfully.',
                    'fail-moved-cart-item'     => 'Fail: Cart item is not moved to wishlist.',
                    'success-add-to-cart'      => 'Success: Product added to cart successfully.',
                    'fail-add-to-cart'         => 'Fail: Product is not added to cart.',
                    'success-update-to-cart'   => 'Success: Cart item has been updated successfully.',
                    'fail-update-to-cart'      => 'Fail: Cart item has not been updated.',
                    'success-delete-cart-item' => 'Success: Cart item has been removed successfully.',
                    'fail-delete-cart-item'    => 'Fail: Cart item not found.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'Success: Customer login successfully.',
            'success-logout'        => 'Success: Customer logout successfully.',
            'no-login-customer'     => 'Warning: No login customer found.',
            'address-list'          => 'Success: Customer\'s address details fetched',
            'not-authorized'        => 'Warning: You are not authorized to update this address.',
            'no-address-list'       => 'Warning: No customer\'s address found.',
            'text-password'         => 'Your Password is: :password',
            'not-exists'            => 'Warning: No customer found for the provided data.',
            'success-address-list'  => 'Success: Customer\'s addresses fetched successfully.',
            'reset-link-sent'       => 'Success: Password reset email has been sent successfully.',
            'password-reset-failed' => 'Warning: We already sent you password reset email, try after sometime.',
            'no-login-user'         => 'Warning: No login user found.',
            'customer-details'      => 'Success: Customer details fetched successfully.',

            'account'               => [
                'not-found' => 'Wanring: No :name found.',

                'profile'   => [
                    'edit-success'   => 'Profile Updated Successfully',
                    'edit-fail'      => 'Profile not updated',
                    'unmatch'        => 'The old password does not match.',
                    'order-pending'  => 'Cannot delete customer account because some Order(s) are pending or processing state.',
                    'delete-success' => 'Customer deleted successfully',
                    'wrong-password' => 'Wrong Password !',
                ],

                'order' => [
                    'no-order-found' => 'Wanring: No order found.',
                    'cancel-success' => 'Order cancelled successfully',

                ],

                'review'    => [
                    'success' => 'Success: Review is submitted successfully, please wait for the approval.',
                ],

                'wishlist' => [
                    'removed'            => 'Item Successfully Removed From Wishlist',
                    'remove-fail'        => 'Item Cannot Be Removed From Wishlist',
                    'remove-all-success' => 'All the items from your wishlist have been removed',
                    'success'            => 'Item Successfully Added To Wishlist',
                    'already-exist'      => 'Product already exist in wishlist',
                    'move-to-cart'       => 'Move To Cart',
                    'moved-success'      => 'Item Successfully Moved to Cart',
                    'error-move-to-cart' => 'Warning: This product might have some required options, not able to move to cart.',
                    'no-item-found'      => 'Warning: There is no product found.',

                ],

                'addressess' => [
                    'delete-success' => 'Customer\'s Address deleted successfully'
                ]
            ],

            'signup-form'           => [
                'error-registration'       => 'Warning: customer registration failed.',
                'warning-num-already-used' => 'Warning: This :phone number is registered using different email address.',
                'success-verify'           => 'Account created successfully, an e-mail has been sent for verification.',
                'invalid-creds'            => 'Please check your credentials and try again.',

                'validation'               => [
                    'unique'   => 'This :field has already been taken.',
                    'required' => 'The :field field is required.',
                    'same'     => 'The :field and password must match.',
                ],
            ],

            'login-form'            => [
                'not-activated' => 'Your activation seeks admin approval',
                'invalid-creds' => 'Please check your credentials and try again.',
            ],
        ],

        'response' => [
            'error-invalid-parameter' => 'Warning: Invaid parameters provided.',
            'invalid-header'          => 'Warning: Invalid header token.',
            'cancel-error'            => 'Order can not be canceled.',
        ],
    ]
];
