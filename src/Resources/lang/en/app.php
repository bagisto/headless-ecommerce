<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'You are already subscribed to our newsletter.',
            'subscribe-success'  => 'You have successfully subscribed to our newsletter.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Thank you for contacting us. We will get back to you soon.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Warning: Downloadable link not found.',
                'sample-not-found' => 'Warning: Downloadable sample not found.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Warning: No login customer found.',
            'success-login'     => 'Success: Customer login successful.',
            'success-logout'    => 'Success: Customer logout successful.',

            'signup' => [
                'error-registration' => 'Warning: Customer registration failed.',
                'success-verify'     => 'Account created successfully, an e-mail has been sent for verification.',
                'success'            => 'Success: Customer registered and login successfully.',
            ],

            'social-login' => [
                'disabled' => 'Warning: Social login is disabled.',
            ],

            'login' => [
                'invalid-creds' => 'Please check your credentials and try again.',
                'not-activated' => 'Your activation requires admin approval',
                'verify-first'  => 'Please verify your email first.',
                'suspended'     => 'Your account has been suspended by the administrator.',

                'validation' => [
                    'required' => 'The :field field is required.',
                    'same'     => 'The :field and password must match.',
                    'unique'   => 'This :field has already been taken.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Reset password link already sent to your email.',
                'email-not-exist' => 'Email does not exist.',
                'reset-link-sent' => 'Reset password link sent to your email.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Success: Customer details fetched successfully.',
                    'delete-success'   => 'Success: Account deleted successfully.',
                    'password-unmatch' => 'Password does not match.',
                    'update-fail'      => 'Warning: Profile not updated',
                    'update-success'   => 'Success: Profile updated successfully.',
                    'wrong-password'   => 'Warning: Wrong password provided.',
                    'order-pending'    => 'You cannot delete the account because you have some pending orders.',
                ],

                'addresses' => [
                    'create-success'         => 'Address created successfully.',
                    'default-update-success' => 'Address is setted as default',
                    'delete-success'         => 'Address deleted successfully',
                    'not-found'              => 'Warning: Address not found.',
                    'update-success'         => 'Address updated successfully.',
                    'already-default'        => 'Warning: This address is already set as default.',
                ],

                'wishlist' => [
                    'product-removed' => 'Warning: Product not found.',
                    'success'         => 'Success: Product added to wishlist successfully.',
                    'already-exist'   => 'Warning: Already added to Wishlist.',
                    'remove-success'  => 'Success: Item is successfully removed from the wishlist.',
                    'not-found'       => 'Warning: No products found in Wishlist.',
                    'moved-to-cart'   => 'Success: Product moved to cart successfully.',
                ],

                'orders' => [
                    'not-found'      => 'Warning: No orders found.',
                    'cancel-error'   => 'Warning: Order not canceled.',
                    'cancel-success' => 'Success: Order canceled successfully.',

                    'shipment' => [
                        'not-found' => 'Warning: Shipment not found.',
                    ],

                    'invoice' => [
                        'not-found' => 'Warning: Invoice not found.',
                    ],

                    'refund' => [
                        'not-found' => 'Warning: Refund not found.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Warning: Downloadable product not found.',
                    'not-auth'       => 'Warning: You are not authorized to perform this action.',
                    'payment-error'  => 'Payment has not been done for this download.',
                    'download-error' => 'Download link has been expired.',
                ],

                'gdpr' => [
                    'create-success'       => 'Success: GDPR request created successfully.',
                    'revoke-failed'        => 'Warning: GDPR request not revoked.',
                    'revoked-successfully' => 'Success: GDPR request revoked successfully.',
                    'not-enabled'          => 'Warning: GDPR is not enabled.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Warning: Compare product not found.',
                'product-not-found'   => 'Warning: Product not found.',
                'already-added'       => 'Warning: Product already added to compare list.',
                'item-add-success'    => 'Success: Product added to compare list successfully.',
                'remove-success'      => 'Success: Item is successfully removed from the compare list.',
                'mass-remove-success' => 'Success: Selected items deleted successfully.',
                'not-auth'            => 'Warning: You are not authorized to perform this action.',
            ],

            'reviews' => [
                'create-success'      => 'Success: Review created successfully.',
                'delete-success'      => 'Success: Review deleted successfully.',
                'mass-delete-success' => 'Success: Selected reviews deleted successfully.',
                'not-found'           => 'Warning: Review not found.',
                'product-not-found'   => 'Warning: Product not found.',
                'not-auth'            => 'Warning: You are not authorized to perform this action.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Warning: Invalid downloadable link provided.',
                        'invalid-parameter'  => 'Warning: Invalid parameters provided.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Success: Product added to cart successfully.',
                        'update-to-cart'   => 'Success: Product updated to cart successfully.',
                        'delete-cart-item' => 'Success: Item is successfully removed from the cart.',
                        'all-remove'       => 'Success: All items removed from the cart.',
                        'move-to-wishlist' => 'Success: Selected items successfully moved to wishlist.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Warning: All items not removed from the cart.',
                        'update-to-cart'   => 'Warning: Product not updated to cart.',
                        'delete-cart-item' => 'Warning: Item is not removed from the cart.',
                        'not-found'        => 'Warning: Cart not found.',
                        'item-not-found'   => 'Warning: Item not found.',
                        'move-to-wishlist' => 'Warning: Selected items not moved to wishlist.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Warning: Guest user can not add address.',
                'guest-checkout-warning'    => 'Warning: Guest user can not checkout.',
                'no-billing-address-found'  => 'Warning: No billing address found.',
                'no-shipping-address-found' => 'Warning: No shipping address found.',
                'address-save-success'      => 'Success: Address saved successfully.',
            ],

            'shipping' => [
                'method-not-found' => 'Warning: Shipping method not found.',
                'method-fetched'   => 'Success: Shipping method fetched successfully.',
                'save-failed'      => 'Warning: Shipping method not saved.',
                'save-success'     => 'Success: Shipping method saved successfully.',
            ],

            'payment' => [
                'method-not-found' => 'Warning: Payment method not found.',
                'method-fetched'   => 'Success: Payment method fetched successfully.',
                'save-failed'      => 'Warning: Payment method not saved.',
                'save-success'     => 'Success: Payment method saved successfully.',
            ],

            'coupon' => [
                'apply-success'   => 'Success: Coupon code applied successfully.',
                'already-applied' => 'Warning: Coupon code already applied.',
                'invalid-code'    => 'Warning: Coupon code is invalid.',
                'remove-success'  => 'Success: Coupon code removed successfully.',
                'remove-failed'   => 'Warning: Coupon code not removed.',
            ],

            'something-wrong'          => 'Warning: Something went wrong.',
            'invalid-guest-user'       => 'Warning: Invalid guest user.',
            'empty-cart'               => 'Warning: Cart is empty.',
            'missing-billing-address'  => 'Warning: Missing billing address.',
            'missing-shipping-address' => 'Warning: Missing shipping address.',
            'missing-shipping-method'  => 'Warning: Missing shipping method.',
            'missing-payment-method'   => 'Warning: Missing payment method.',
            'no-address-found'         => 'Warning: No billing and shipping address found.',
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
                        'notification-topic'              => 'Notification Topic',
                        'info'                            => 'Notification related configurations',
                        'push-notification-configuration' => 'FCM Push Notification Configuration',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Private Key JSON File Content',
                        'info-get-private-key'            => 'Info: To Get FCM Private Key JSON File Content: <a href="https://console.firebase.google.com/" target="_blank">Click here</a>',
                        'credentials'                     => 'Credentials',
                        'credentials-info'                => 'Info: Used to get essential or curious data like payment method keys, client id, secret key, etc.',
                        'username'                        => 'Username',
                        'username-info'                   => 'Info: Used to get essential or curious data like payment method keys, client id, secret key, etc.',
                        'password'                        => 'Password',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Success: Custom scripts updated successfully.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Warning: Order can not canceled.',
                'cancel-success' => 'Success: Order canceled successfully.',
                'not-found'      => 'Warning: Order not found.',
            ],

            'shipments' => [
                'creation-error'   => 'Warning: Shipment not created.',
                'not-found'        => 'Warning: Shipment not found.',
                'quantity-invalid' => 'Warning: Invalid quantity provided.',
                'shipment-error'   => 'Warning: Shipment not created.',
                'create-success'   => 'Success: Shipment created successfully.',
            ],

            'invoices' => [
                'creation-error' => 'Warning: Invoice not created.',
                'not-found'      => 'Warning: Invoice not found.',
                'product-error'  => 'Warning: Invalid product provided.',
                'create-success' => 'Success: Invoice created successfully.',
                'invalid-qty'    => 'Warning: We found an invalid quantity to invoice items.',
            ],

            'refunds' => [
                'creation-error'      => 'Warning: Refund not created.',
                'refund-amount-error' => 'Warning: Invalid refund amount provided.',
                'refund-limit-error'  => 'Warning: Refund amount exceeds the limit of :amount',
                'not-found'           => 'Warning: Refund not found.',
                'create-success'      => 'Success: Refund created successfully.',
            ],

            'transactions' => [
                'already-paid'   => 'Warning: Invoice is already paid.',
                'amount-exceed'  => 'Warning: Transaction amount exceeds the limit.',
                'zero-amount'    => 'Warning: Transaction amount should be greater than zero.',
                'create-success' => 'Success: Transaction created successfully.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Warning: Customer not found.',
                'cart-not-found'           => 'Warning: Cart not found.',
                'cart-item-not-found'      => 'Warning: Cart item not found.',
                'cart-create-success'      => 'Success: Cart created successfully.',
                'cart-item-add-success'    => 'Success: Product added to cart successfully.',
                'cart-item-remove-success' => 'Success: Item is successfully removed from the cart.',
                'cart-item-update-success' => 'Success: Product updated to cart successfully.',
                'something-wrong'          => 'Warning: Something went wrong.',
                'address-save-success'     => 'Success: Address saved successfully.',
                'shipping-save-success'    => 'Success: Shipping method saved successfully.',
                'payment-save-success'     => 'Success: Payment method saved successfully.',
                'order-placed-success'     => 'Success: Order placed successfully.',
                'payment-method-not-found' => 'Warning: Payment method not found.',
                'minimum-order-amount-err' => 'Warning: Minimum order amount should be :amount',
                'check-shipping-address'   => 'Warning: Please check the shipping address.',
                'check-billing-address'    => 'Warning: Please check the billing address.',
                'specify-shipping-method'  => 'Warning: Please specify the shipping method.',
                'specify-payment-method'   => 'Warning: Please specify the payment method.',
                'coupon-not-valid'         => 'Warning: Coupon code is not valid.',
                'coupon-already-applied'   => 'Warning: Coupon code already applied.',
                'coupon-applied'           => 'Success: Coupon code applied successfully.',
                'coupon-removed'           => 'Success: Coupon code removed successfully.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Product created successfully.',
                'delete-success'            => 'Product deleted successfully',
                'not-found'                 => 'Warning: Product not found.',
                'update-success'            => 'Product updated successfully.',
                'configurable-attr-missing' => 'Warning: Configurable attribute is missing.',
                'simple-products-error'     => 'Warning: Simple products are missing.',
            ],

            'categories' => [
                'already-taken'  => 'Warning: The slug has already been taken.',
                'create-success' => 'Category created successfully.',
                'delete-success' => 'Category deleted successfully',
                'not-found'      => 'Warning: Category not found.',
                'update-success' => 'Category updated successfully.',
                'root-delete'    => 'Warning: Root category can not be deleted.',
            ],

            'attributes' => [
                'create-success'    => 'Attribute created successfully.',
                'delete-success'    => 'Attribute deleted successfully',
                'not-found'         => 'Warning: Attribute not found.',
                'update-success'    => 'Attribute updated successfully.',
                'user-define-error' => 'Warning: You are not authorized to delete system-created Attribute.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Attribute Group created successfully.',
                'delete-success'    => 'Attribute Group deleted successfully',
                'not-found'         => 'Warning: Attribute Group not found.',
                'update-success'    => 'Attribute Group updated successfully.',
                'user-define-error' => 'Warning: You are not authorized to delete system-created Attribute Group.',
            ],

            'attribute-families' => [
                'create-success'          => 'Attribute Family created successfully.',
                'delete-success'          => 'Attribute Family deleted successfully',
                'not-found'               => 'Warning: Attribute Family not found.',
                'update-success'          => 'Attribute Family updated successfully.',
                'last-delete-error'       => 'Warning: Last Attribute Family can not be deleted.',
                'attribute-product-error' => 'Warning: Some product(s) are associated with this attribute family.',
                'user-define-error'       => 'Warning: You are not authorized to delete system-created Attribute Family.',
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
                'login-success'        => 'Customer logged in successfully.',
            ],

            'addresses' => [
                'create-success'         => 'Customer\'s address created successfully.',
                'default-update-success' => 'Address is setted as default',
                'delete-success'         => 'Customer\'s Address deleted successfully',
                'not-found'              => 'Warning: Customer\'s address not found.',
                'update-success'         => 'Customer\'s address updated successfully.',
                'already-default'        => 'Warning: This address is already set as default.',
            ],

            'groups' => [
                'create-success'     => 'Customer Group created successfully.',
                'customer-associate' => 'Warning: Group can\'t be deleted. customer is Associated with it.',
                'delete-success'     => 'Customer Group deleted successfully',
                'not-found'          => 'Warning: Customer Group not found.',
                'update-success'     => 'Customer Group updated successfully.',
                'user-define-error'  => 'Warning: You are not authorized to delete system-created Customer Group.',
            ],

            'reviews' => [
                'delete-success' => 'Review deleted successfully',
                'not-found'      => 'Warning: Review not found.',
                'update-success' => 'Review updated successfully.',
            ],

            'gdpr' => [
                'delete-success'       => 'Success: GDPR request deleted successfully.',
                'not-found'            => 'Warning: GDPR request not found.',
                'update-success'       => 'GDPR request updated successfully.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Warning: The slug has already been taken.',
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

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Email Template created successfully.',
                    'delete-success' => 'Email Template deleted successfully',
                    'not-found'      => 'Warning: Email Template not found.',
                    'update-success' => 'Email Template updated successfully.',
                ],

                'events' => [
                    'create-success' => 'Event created successfully.',
                    'delete-success' => 'Event deleted successfully',
                    'not-found'      => 'Warning: Event not found.',
                    'update-success' => 'Event updated successfully.',
                ],

                'campaigns' => [
                    'create-success' => 'Campaign created successfully.',
                    'delete-success' => 'Campaign deleted successfully',
                    'not-found'      => 'Warning: Campaign not found.',
                    'update-success' => 'Campaign updated successfully.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Subscription deleted successfully',
                    'not-found'           => 'Warning: Subscription not found.',
                    'unsubscribe-success' => 'Success: Subscription unsubscribed successfully.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL Rewrite created successfully.',
                    'delete-success' => 'URL Rewrite deleted successfully',
                    'not-found'      => 'Warning: URL Rewrite not found.',
                    'update-success' => 'URL Rewrite updated successfully.',
                ],

                'search-terms' => [
                    'create-success' => 'Search Term created successfully.',
                    'delete-success' => 'Search Term deleted successfully',
                    'not-found'      => 'Warning: Search Term not found.',
                    'update-success' => 'Search Term updated successfully.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Search Synonym created successfully.',
                    'delete-success' => 'Search Synonym deleted successfully',
                    'not-found'      => 'Warning: Search Synonym not found.',
                    'update-success' => 'Search Synonym updated successfully.',
                ],

                'sitemaps' => [
                    'create-success' => 'Sitemap created successfully.',
                    'delete-success' => 'Sitemap deleted successfully',
                    'not-found'      => 'Warning: Sitemap not found.',
                    'update-success' => 'Sitemap updated successfully.',
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

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'The specified category_id does not exist.',
                        'invalid-boolean-value' => 'The :key value must be either 0 or 1.',
                        'invalid-filter-key'    => 'The filter key ":key" is not permitted.',
                        'invalid-limit-value'   => 'The limit value must be one of the following: :options.',
                        'invalid-select-option' => 'The :key value is invalid. Valid options are: :options.',
                        'invalid-sort-value'    => 'The sort value must be one of the following: :options.',
                        'missing-limit-key'     => 'The filtersInput must include a "limit" key.',
                        'missing-sort-key'      => 'The filtersInput must include a "sort" key.',
                    ],
                ],
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
                        'channel-name'         => 'Channel Name',
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
                    'settings'             => 'Settings',
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
                    'settings'             => 'Settings',
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

                'not-found'           => 'Warning: Notification not found.',
                'create-success'      => 'Notification created successfully.',
                'delete-failed'       => 'Notification deleted failed.',
                'delete-success'      => 'Notification deleted successfully.',
                'mass-update-success' => 'Selected notifications updated successfully.',
                'mass-delete-success' => 'Selected notifications deleted successfully.',
                'no-value-selected'   => 'there are no existing value.',
                'send-success'        => 'Notification sent successfully.',
                'update-success'      => 'Notification updated successfully.',
                'configuration-error' => 'Warning: FCM configuration not found.',
                'product-not-found'   => 'Warning: Product not found.',
                'category-not-found'  => 'Warning: Category not found.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Warning: Invalid parameters provided.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Warning: Email configuration not found.',
    ],
];
