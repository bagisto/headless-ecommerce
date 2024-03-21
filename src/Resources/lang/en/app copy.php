<?php

return [
    'admin' => [

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Order cannot be canceled.',
                'cancel-success' => 'Order canceled successfully',
                'not-found'      => 'Warning: Order not found.',
            ],

            'shipments' => [
                'not-found'        => 'Warning: Shipment not found.',
                'shipment-error'   => 'Order shipment creation is not allowed.',
                'creation-error'   => 'Shipment can not be created for this order.',
                'quantity-invalid' => 'Requested quantity is invalid or not available.',
            ],

            'invoices' => [
                'not-found'      => 'Warning: Invoice not found.',
                'creation-error' => 'Order invoice creation is not allowed.',
                'product-error'  => 'Invoice can not be created without products.',
            ],

            'refunds' => [
                'invalid-refund-amount-error' => 'Refund amount should be non zero.',
                'refund-limit-error'          => 'The most money available to refund is :amount.',
                'creation-error'              => 'Refund can not be created for this order.',
                'create-success'              => 'Refund created successfully for this order.',
            ]
        ],

        'catalog' => [
            'products' => [
                'create' => [
                    'configurable-error'      => 'Please select atleast one configurable attribute.',
                    'grouped-error-not-added' => 'is not added to Grouped product',
                    'grouped-error-not-added' => 'is not a added to Bundle product',
                ],

                'delete-success' => 'Product deleted successfully.',
                'delete-failed'  => 'Warning: Product is not deleted',
            ],

            'categories' => [
                'already-taken'        => 'The Category has already been taken.',
                'delete-category-root' => 'The Root category can not be deleted.',
                'delete-success'       => 'Category deleted successfully.',
                'delete-failed'        => 'Warning: Category is not deleted',
            ],

            'attributes' => [
                'delete-success'    => 'Attribute deleted successfully.',
                'delete-failed'     => 'Warning: Attribute is not deleted',
                'user-define-error' => 'Warning: You are not authorized to delete system-created attribute group.',
            ],

            'attribute-families' => [
                'last-delete-error'       => 'Last Attribute Family delete failed',
                'attribute-product-error' => 'family is used in products.',
                'delete-success'          => 'Family deleted successfully.',
                'delete-failed'           => 'Warning: Family is not deleted',
            ],

            'attribute-groups' => [
                'delete-success'       => 'Family Group deleted successfully.',
                'delete-failed'        => 'Warning: Family Group is not deleted',
                'error-customer-group' => 'Warning: You are not authorized to delete system-created attribute group.',
            ],
        ],

        'customers' => [
            'no-customer-found'      => 'Customer not found',
            'address-delete-success' => 'Customer\'s Address deleted successfully',
            'user-define-error'      => 'Warning: You are not authorized to delete system-created Customer Group.',
            'delete-order-pending'   => 'Cannot delete the customer account because some Order(s) are pending or in a processing state.',
            'delete-success'         => 'Customer deleted successfully',

            'groups' => [
                'user-define-error'  => 'Warning: You are not authorized to delete system-created Customer Group.',
                'customer-associate' => 'Warning: Group can\'t be deleted. customer is Associated with it.',
                'delete-success'     => 'Customer deleted successfully',
            ]
        ],

        'cms' => [
            'already-taken'  => 'CMS Page URL already taken',
            'delete-success' => 'CMS Page deleted successfully.',
            'delete-failed'  => 'Warning: CMS Page is not deleted',
        ],

        'marketing' => [
            'communications' => [
                'campaigns' => [
                    'delete-success' => 'Campaign deleted successfully',
                    'delete-failed'  => 'Warning: Campaign is not deleted',
                ],

                'templates' => [
                    'delete-success' => 'Email Template deleted successfully',
                    'delete-failed'  => 'Warning: Email Template is not deleted',
                ],

                'events' => [
                    'delete-success' => 'Event deleted successfully',
                    'delete-failed'  => 'Warning: Event is not deleted',
                ],

                'subscriptions' => [
                    'no-subscriber-found'  => 'Subscriber not found',
                    'already-subscriber'   => 'You are already subscribed to our subscription list.',
                    'not-subscribed'       => 'You can not be subscribed to subscription emails, please try again later.',
                    'already-unsubscribed' => 'You are already unsubscribed.',
                    'delete-success'       => 'Subscription deleted successfully',
                    'unsubscribe'          => 'Unsubcribe',
                    'subscribe'            => 'Subscribe',
                ],
            ],

            'promotions' => [
                'cart-rules' => [
                    'delete-success' => 'Cart Rule deleted successfully',
                    'delete-failed'  => 'Warning: Cart Rule is not deleted',
                    'cart-rule-not-defind' => 'Cart rule is not defined',
                ],

                'catalog-rules' => [
                    'delete-success' => 'Catalog Rule deleted successfully',
                    'delete-failed'  => 'Warning: Catalog Rule is not deleted',
                ],

                'sitemaps' => [
                    'delete-success' => 'Site Map deleted successfully',
                    'delete-failed'  => 'Warning: Site Map is not deleted',
                ],
            ],

            'sitemaps' => [
                'delete-success' => 'Site Map deleted successfully',
                'delete-failed'  => 'Warning: Site Map is not deleted',
            ]
        ],

        'configuration' => [

            'custom-scripts' => [
                'channel-not-found' => 'Warning: Channel not found.',
                'create-success'    => 'Custom Script added successfully.',
                'update-success'    => 'Custom Script updated successfully.',
                'delete-success'    => 'Custom Script removed successfully.',
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
                'delete-error'      => 'User deleted failed.',
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

        'alerts' => [
            'notifications' => [
                'create-success'      => 'Notifications created successfully',
                'update-success'      => 'Notifications updated successfully',
                'delete-success'      => 'Notifications deleted successfully',
                'delete-failed'       => 'Notifications deleted failed',
                'sended-successfully' => 'Notifications pushed successfully for android and iOS.',
                'no-value-selected'   => 'there are no existing value',
            ],
        ],
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
                    'success-delete' => 'Review deleted successfully',
                    'not-found' => 'Review not found',
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
