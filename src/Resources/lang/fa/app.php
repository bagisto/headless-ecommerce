<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'شما قبلاً در خبرنامه ما مشترک شده‌اید.',
            'subscribe-success'  => 'شما با موفقیت در خبرنامه ما مشترک شدید.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'با تشکر از تماس شما. به زودی با شما تماس خواهیم گرفت.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'هشدار: لینک دانلود یافت نشد.',
                'sample-not-found' => 'هشدار: نمونه قابل دانلود یافت نشد.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'هشدار: هیچ مشتری وارد شده ای یافت نشد.',
            'success-login'     => 'موفقیت: ورود مشتری با موفقیت انجام شد.',
            'success-logout'    => 'موفقیت: خروج مشتری با موفقیت انجام شد.',

            'signup' => [
                'error-registration' => 'هشدار: ثبت نام مشتری ناموفق بود.',
                'success-verify'     => 'حساب با موفقیت ایجاد شد، یک ایمیل برای تأیید ارسال شده است.',
                'success'            => 'موفقیت: مشتری با موفقیت ثبت نام و وارد شد.',
            ],

            'social-login' => [
                'disabled' => 'هشدار: ورود اجتماعی غیرفعال است.',
            ],

            'login' => [
                'invalid-creds' => 'لطفاً اعتبارهای خود را بررسی کنید و دوباره امتحان کنید.',
                'not-activated' => 'فعال سازی شما نیاز به تأیید مدیر دارد',
                'verify-first'  => 'لطفاً ابتدا ایمیل خود را تأیید کنید.',
                'suspended'     => 'حساب شما توسط مدیر معلق شده است.',

                'validation' => [
                    'required' => 'فیلد :field الزامی است.',
                    'same'     => 'فیلد :field و رمز عبور باید یکسان باشد.',
                    'unique'   => 'این :field قبلاً استفاده شده است.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'لینک بازنشانی رمز عبور قبلاً به ایمیل شما ارسال شده است.',
                'email-not-exist' => 'ایمیل وجود ندارد.',
                'reset-link-sent' => 'لینک بازنشانی رمز عبور به ایمیل شما ارسال شد.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'موفقیت: جزئیات مشتری با موفقیت دریافت شد.',
                    'delete-success'   => 'موفقیت: حساب با موفقیت حذف شد.',
                    'password-unmatch' => 'رمز عبور مطابقت ندارد.',
                    'update-fail'      => 'هشدار: پروفایل به‌روزرسانی نشد.',
                    'update-success'   => 'موفقیت: پروفایل با موفقیت به‌روزرسانی شد.',
                    'wrong-password'   => 'هشدار: رمز عبور اشتباه وارد شده است.',
                    'order-pending'    => 'نمی‌توانید حساب را حذف کنید زیرا چند سفارش معلق دارید.',
                ],

                'addresses' => [
                    'create-success'         => 'آدرس با موفقیت ایجاد شد.',
                    'default-update-success' => 'آدرس به عنوان پیش فرض تنظیم شد',
                    'delete-success'         => 'آدرس با موفقیت حذف شد',
                    'not-found'              => 'هشدار: آدرس یافت نشد.',
                    'update-success'         => 'آدرس با موفقیت به روز شد.',
                    'already-default'        => 'هشدار: این آدرس قبلاً به عنوان پیش‌فرض تنظیم شده است.',
                ],

                'wishlist' => [
                    'product-removed' => 'هشدار: محصول یافت نشد.',
                    'success'         => 'موفقیت: محصول با موفقیت به لیست علاقه مندی ها اضافه شد.',
                    'already-exist'   => 'هشدار: قبلاً به لیست علاقه مندی ها اضافه شده است.',
                    'remove-success'  => 'موفقیت: آیتم با موفقیت از لیست علاقه مندی ها حذف شد.',
                    'not-found'       => 'هشدار: هیچ محصولی در لیست علاقه مندی ها یافت نشد.',
                    'moved-to-cart'   => 'موفقیت: محصول با موفقیت به سبد خرید انتقال یافت.',
                ],

                'orders' => [
                    'not-found'      => 'هشدار: هیچ سفارشی یافت نشد.',
                    'cancel-error'   => 'هشدار: سفارش لغو نشد.',
                    'cancel-success' => 'موفقیت: سفارش با موفقیت لغو شد.',

                    'shipment' => [
                        'not-found' => 'هشدار: ارسال یافت نشد.',
                    ],

                    'invoice' => [
                        'not-found' => 'هشدار: فاکتور یافت نشد.',
                    ],

                    'refund' => [
                        'not-found' => 'هشدار: بازپرداخت یافت نشد.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'هشدار: محصول قابل دانلود یافت نشد.',
                    'not-auth'       => 'هشدار: شما مجاز به انجام این عمل نیستید.',
                    'payment-error'  => 'پرداخت برای این دانلود انجام نشده است.',
                    'download-error' => 'لینک دانلود منقضی شده است.',
                ],

                'gdpr' => [
                    'create-success'       => 'موفقیت: درخواست GDPR با موفقیت ایجاد شد.',
                    'revoke-failed'        => 'هشدار: درخواست GDPR لغو نشد.',
                    'revoked-successfully' => 'موفقیت: درخواست GDPR با موفقیت لغو شد.',
                    'not-enabled'          => 'هشدار: GDPR فعال نیست.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'هشدار: محصول مقایسه یافت نشد.',
                'product-not-found'   => 'هشدار: محصولی یافت نشد.',
                'already-added'       => 'هشدار: محصول قبلاً به لیست مقایسه اضافه شده است.',
                'item-add-success'    => 'موفقیت: محصول با موفقیت به لیست مقایسه اضافه شد.',
                'remove-success'      => 'موفقیت: آیتم با موفقیت از لیست مقایسه حذف شد.',
                'mass-remove-success' => 'موفقیت: آیتم‌های انتخاب شده با موفقیت حذف شدند.',
                'not-auth'            => 'هشدار: شما مجاز به انجام این عمل نیستید.',
            ],

            'reviews' => [
                'create-success'      => 'موفقیت: نقد و بررسی با موفقیت ایجاد شد.',
                'delete-success'      => 'موفقیت: نقد و بررسی با موفقیت حذف شد.',
                'mass-delete-success' => 'موفقیت: نقد و بررسی های انتخاب شده با موفقیت حذف شدند.',
                'not-found'           => 'هشدار: نقد و بررسی یافت نشد.',
                'product-not-found'   => 'هشدار: محصولی یافت نشد.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'هشدار: لینک های دانلود برای محصول :product_name منقضی شده است.',
                        'invalid-parameter'  => 'هشدار: پارامترهای نامعتبر ارائه شده است.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'موفقیت: محصول با موفقیت به سبد خرید اضافه شد.',
                        'update-to-cart'   => 'موفقیت: محصول با موفقیت به سبد خرید به روز شد.',
                        'delete-cart-item' => 'موفقیت: آیتم با موفقیت از سبد خرید حذف شد.',
                        'all-remove'       => 'موفقیت: تمام آیتم ها از سبد خرید حذف شدند.',
                        'move-to-wishlist' => 'موفقیت: آیتم های انتخاب شده با موفقیت به لیست علاقه مندی ها منتقل شدند.',
                    ],

                    'fail' => [
                        'all-remove'       => 'هشدار: تمام آیتم ها از سبد خرید حذف نشدند.',
                        'update-to-cart'   => 'هشدار: محصول به سبد خرید به روز نشد.',
                        'delete-cart-item' => 'هشدار: آیتم از سبد خرید حذف نشد.',
                        'not-found'        => 'هشدار: سبد خرید یافت نشد.',
                        'item-not-found'   => 'هشدار: آیتم یافت نشد.',
                        'move-to-wishlist' => 'هشدار: آیتم های انتخاب شده به لیست علاقه مندی ها منتقل نشدند.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'هشدار: کاربر مهمان نمی تواند آدرس اضافه کند.',
                'guest-checkout-warning'    => 'هشدار: کاربر مهمان نمی تواند خرید را انجام دهد.',
                'no-billing-address-found'  => 'هشدار: هیچ آدرس صورتحسابی یافت نشد.',
                'no-shipping-address-found' => 'هشدار: هیچ آدرس حمل و نقلی یافت نشد.',
                'address-save-success'      => 'موفقیت: آدرس با موفقیت ذخیره شد.',
            ],

            'shipping' => [
                'method-not-found' => 'هشدار: روش حمل و نقل یافت نشد.',
                'method-fetched'   => 'موفقیت: روش حمل و نقل با موفقیت دریافت شد.',
                'save-failed'      => 'هشدار: روش حمل و نقل ذخیره نشد.',
                'save-success'     => 'موفقیت: روش حمل و نقل با موفقیت ذخیره شد.',
            ],

            'payment' => [
                'method-not-found' => 'هشدار: روش پرداخت یافت نشد.',
                'method-fetched'   => 'موفقیت: روش پرداخت با موفقیت دریافت شد.',
                'save-failed'      => 'هشدار: روش پرداخت ذخیره نشد.',
                'save-success'     => 'موفقیت: روش پرداخت با موفقیت ذخیره شد.',
            ],

            'coupon' => [
                'apply-success'   => 'موفقیت: کد تخفیف با موفقیت اعمال شد.',
                'already-applied' => 'هشدار: کد تخفیف قبلاً اعمال شده است.',
                'invalid-code'    => 'هشدار: کد تخفیف نامعتبر است.',
                'remove-success'  => 'موفقیت: کد تخفیف با موفقیت حذف شد.',
                'remove-failed'   => 'هشدار: کد تخفیف حذف نشد.',
            ],

            'something-wrong'          => 'هشدار: مشکلی پیش آمد.',
            'invalid-guest-user'       => 'هشدار: کاربر مهمان نامعتبر است.',
            'empty-cart'               => 'هشدار: سبد خرید خالی است.',
            'missing-billing-address'  => 'هشدار: آدرس صورتحساب گم شده است.',
            'missing-shipping-address' => 'هشدار: آدرس حمل و نقل گم شده است.',
            'missing-shipping-method'  => 'هشدار: روش حمل و نقل گم شده است.',
            'missing-payment-method'   => 'هشدار: روش پرداخت گم شده است.',
            'no-address-found'         => 'هشدار: هیچ آدرس صورتحسابی و حمل و نقلی یافت نشد.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'ایجاد',
            'delete'            => 'حذف',
            'edit'              => 'ویرایش',
            'mass-delete'       => 'حذف گروهی',
            'mass-update'       => 'به روزرسانی گروهی',
            'push-notification' => 'اعلان های فشاری',
            'send'              => 'ارسال',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'اعلان های فشاری',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'موضوع اعلان',
                        'info'                            => 'پیکربندی‌های مرتبط با اعلان',
                        'push-notification-configuration' => 'پیکربندی اعلان‌های فشاری FCM',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'محتوای فایل JSON کلید خصوصی',
                        'info-get-private-key'            => 'اطلاعات: برای دریافت محتوای فایل JSON کلید خصوصی FCM: <a href="https://console.firebase.google.com/" target="_blank">اینجا کلیک کنید</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'موفقیت: اسکریپت‌های سفارشی با موفقیت به‌روزرسانی شدند.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'هشدار: سفارش قابل لغو نیست.',
                'cancel-success' => 'موفقیت: سفارش با موفقیت لغو شد.',
                'not-found'      => 'هشدار: سفارش یافت نشد.',
            ],

            'shipments' => [
                'creation-error'   => 'هشدار: حمل و نقل ایجاد نشد.',
                'not-found'        => 'هشدار: حمل و نقل یافت نشد.',
                'quantity-invalid' => 'هشدار: مقدار نامعتبر وارد شده است.',
                'shipment-error'   => 'هشدار: حمل و نقل ایجاد نشد.',
                'create-success'   => 'موفقیت: حمل و نقل با موفقیت ایجاد شد.',
            ],

            'invoices' => [
                'creation-error' => 'هشدار: فاکتور ایجاد نشد.',
                'not-found'      => 'هشدار: فاکتور یافت نشد.',
                'product-error'  => 'هشدار: محصول نامعتبر وارد شده است.',
                'create-success' => 'موفقیت: فاکتور با موفقیت ایجاد شد.',
                'invalid-qty'    => 'هشدار: مقدار نامعتبر برای آیتم‌های فاکتور یافت شد.',
            ],

            'refunds' => [
                'creation-error'      => 'هشدار: بازپرداخت ایجاد نشد.',
                'refund-amount-error' => 'هشدار: مقدار بازپرداخت وارد شده نامعتبر است.',
                'refund-limit-error'  => 'هشدار: مقدار بازپرداخت بیش از حد مجاز :amount است',
                'not-found'           => 'هشدار: بازپرداخت یافت نشد.',
                'create-success'      => 'موفقیت: بازپرداخت با موفقیت ایجاد شد.',
            ],

            'transactions' => [
                'already-paid'   => 'هشدار: فاکتور قبلاً پرداخت شده است.',
                'amount-exceed'  => 'هشدار: مقدار تراکنش بیش از حد مجاز است.',
                'zero-amount'    => 'هشدار: مقدار تراکنش باید بیشتر از صفر باشد.',
                'create-success' => 'موفقیت: تراکنش با موفقیت ایجاد شد.',
            ],

            'reorder' => [
                'customer-not-found'       => 'هشدار: مشتری یافت نشد.',
                'cart-not-found'           => 'هشدار: سبد خرید یافت نشد.',
                'cart-item-not-found'      => 'هشدار: مورد سبد خرید یافت نشد.',
                'cart-create-success'      => 'موفقیت: سبد خرید با موفقیت ایجاد شد.',
                'cart-item-add-success'    => 'موفقیت: محصول با موفقیت به سبد خرید اضافه شد.',
                'cart-item-remove-success' => 'موفقیت: مورد با موفقیت از سبد خرید حذف شد.',
                'cart-item-update-success' => 'موفقیت: محصول با موفقیت در سبد خرید به روز شد.',
                'something-wrong'          => 'هشدار: مشکلی پیش آمده است.',
                'address-save-success'     => 'موفقیت: آدرس با موفقیت ذخیره شد.',
                'shipping-save-success'    => 'موفقیت: روش حمل و نقل با موفقیت ذخیره شد.',
                'payment-save-success'     => 'موفقیت: روش پرداخت با موفقیت ذخیره شد.',
                'order-placed-success'     => 'موفقیت: سفارش با موفقیت ثبت شد.',
                'payment-method-not-found' => 'هشدار: روش پرداخت یافت نشد.',
                'minimum-order-amount-err' => 'هشدار: حداقل مبلغ سفارش باید :amount باشد',
                'check-shipping-address'   => 'هشدار: لطفاً آدرس حمل و نقل را بررسی کنید.',
                'check-billing-address'    => 'هشدار: لطفاً آدرس صورتحساب را بررسی کنید.',
                'specify-shipping-method'  => 'هشدار: لطفاً روش حمل و نقل را مشخص کنید.',
                'specify-payment-method'   => 'هشدار: لطفاً روش پرداخت را مشخص کنید.',
                'coupon-not-valid'         => 'هشدار: کد تخفیف معتبر نیست.',
                'coupon-already-applied'   => 'هشدار: کد تخفیف قبلاً اعمال شده است.',
                'coupon-applied'           => 'موفقیت: کد تخفیف با موفقیت اعمال شد.',
                'coupon-removed'           => 'موفقیت: کد تخفیف با موفقیت حذف شد.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'محصول با موفقیت ایجاد شد.',
                'delete-success'            => 'محصول با موفقیت حذف شد.',
                'not-found'                 => 'هشدار: محصول یافت نشد.',
                'update-success'            => 'محصول با موفقیت به روز شد.',
                'configurable-attr-missing' => 'هشدار: ویژگی قابل پیکربندی وجود ندارد.',
                'simple-products-error'     => 'هشدار: محصولات ساده وجود ندارند.',
            ],

            'categories' => [
                'already-taken'  => 'هشدار: اسلاگ قبلاً استفاده شده است.',
                'create-success' => 'دسته بندی با موفقیت ایجاد شد.',
                'delete-success' => 'دسته بندی با موفقیت حذف شد.',
                'not-found'      => 'هشدار: دسته بندی یافت نشد.',
                'update-success' => 'دسته بندی با موفقیت به روز شد.',
                'root-delete'    => 'هشدار: دسته بندی اصلی قابل حذف نیست.',
            ],

            'attributes' => [
                'create-success'    => 'ویژگی با موفقیت ایجاد شد.',
                'delete-success'    => 'ویژگی با موفقیت حذف شد.',
                'not-found'         => 'هشدار: ویژگی یافت نشد.',
                'update-success'    => 'ویژگی با موفقیت به روز شد.',
                'user-define-error' => 'هشدار: شما مجاز به حذف ویژگی سیستمی ایجاد شده نیستید.',
            ],

            'attribute-groups' => [
                'create-success'    => 'گروه ویژگی با موفقیت ایجاد شد.',
                'delete-success'    => 'گروه ویژگی با موفقیت حذف شد.',
                'not-found'         => 'هشدار: گروه ویژگی یافت نشد.',
                'update-success'    => 'گروه ویژگی با موفقیت به روز شد.',
                'user-define-error' => 'هشدار: شما مجاز به حذف گروه ویژگی سیستمی ایجاد شده نیستید.',
            ],

            'attribute-families' => [
                'create-success'          => 'خانواده ویژگی با موفقیت ایجاد شد.',
                'delete-success'          => 'خانواده ویژگی با موفقیت حذف شد.',
                'not-found'               => 'هشدار: خانواده ویژگی یافت نشد.',
                'update-success'          => 'خانواده ویژگی با موفقیت به روز شد.',
                'last-delete-error'       => 'هشدار: آخرین خانواده ویژگی قابل حذف نیست.',
                'attribute-product-error' => 'هشدار: برخی از محصولات با این خانواده ویژگی مرتبط هستند.',
                'user-define-error'       => 'هشدار: شما مجاز به حذف خانواده ویژگی سیستمی ایجاد شده نیستید.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'مشتری با موفقیت ایجاد شد.',
                'delete-order-pending' => 'امکان حذف حساب کاربری مشتری وجود ندارد زیرا برخی از سفارش‌ها در حالت در انتظار یا در حال پردازش هستند.',
                'delete-success'       => 'مشتری با موفقیت حذف شد.',
                'not-found'            => 'هشدار: مشتری یافت نشد.',
                'note-created-success' => 'یادداشت با موفقیت ایجاد شد.',
                'update-success'       => 'مشتری با موفقیت به روز شد.',
                'login-success'        => 'مشتری با موفقیت وارد شد.',
            ],

            'addresses' => [
                'create-success'         => 'آدرس مشتری با موفقیت ایجاد شد.',
                'default-update-success' => 'آدرس به عنوان پیش فرض تنظیم شد.',
                'delete-success'         => 'آدرس مشتری با موفقیت حذف شد.',
                'not-found'              => 'هشدار: آدرس مشتری یافت نشد.',
                'update-success'         => 'آدرس مشتری با موفقیت به روز شد.',
                'already-default'        => 'هشدار: این آدرس قبلاً به عنوان پیش‌فرض تنظیم شده است.',
            ],

            'groups' => [
                'create-success'     => 'گروه مشتری با موفقیت ایجاد شد.',
                'customer-associate' => 'هشدار: امکان حذف گروه وجود ندارد. مشتری با آن مرتبط است.',
                'delete-success'     => 'گروه مشتری با موفقیت حذف شد.',
                'not-found'          => 'هشدار: گروه مشتری یافت نشد.',
                'update-success'     => 'گروه مشتری با موفقیت به روز شد.',
                'user-define-error'  => 'هشدار: شما مجاز به حذف گروه مشتری سیستمی ایجاد شده نیستید.',
            ],

            'reviews' => [
                'delete-success' => 'نقد و بررسی با موفقیت حذف شد.',
                'not-found'      => 'هشدار: نقد و بررسی یافت نشد.',
                'update-success' => 'نقد و بررسی با موفقیت به روز شد.',
            ],

            'gdpr' => [
                'delete-success' => 'موفقیت: درخواست GDPR با موفقیت حذف شد.',
                'not-found'      => 'هشدار: درخواست GDPR پیدا نشد.',
                'update-success' => 'درخواست GDPR با موفقیت به‌روزرسانی شد.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'هشدار: اسلاگ قبلاً استفاده شده است.',
            'create-success' => 'CMS با موفقیت ایجاد شد.',
            'delete-success' => 'CMS با موفقیت حذف شد.',
            'not-found'      => 'هشدار: CMS یافت نشد.',
            'update-success' => 'CMS با موفقیت به روز شد.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'قانون کاتالوگ با موفقیت ایجاد شد.',
                    'delete-failed'  => 'هشدار: قانون کاتالوگ حذف نشد',
                    'delete-success' => 'قانون کاتالوگ با موفقیت حذف شد',
                    'not-found'      => 'هشدار: قانون کاتالوگ یافت نشد.',
                    'update-success' => 'قانون کاتالوگ با موفقیت به روز شد.',
                ],

                'cart-rules' => [
                    'create-success' => 'قانون سبد خرید با موفقیت ایجاد شد.',
                    'delete-failed'  => 'هشدار: قانون سبد خرید حذف نشد',
                    'delete-success' => 'قانون سبد خرید با موفقیت حذف شد',
                    'not-found'      => 'قانون سبد خرید یافت نشد',
                    'update-success' => 'قانون سبد خرید با موفقیت به روز شد.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'قالب ایمیل با موفقیت ایجاد شد.',
                    'delete-success' => 'قالب ایمیل با موفقیت حذف شد',
                    'not-found'      => 'هشدار: قالب ایمیل یافت نشد.',
                    'update-success' => 'قالب ایمیل با موفقیت به روز شد.',
                ],

                'events' => [
                    'create-success' => 'رویداد با موفقیت ایجاد شد.',
                    'delete-success' => 'رویداد با موفقیت حذف شد',
                    'not-found'      => 'هشدار: رویداد یافت نشد.',
                    'update-success' => 'رویداد با موفقیت به روز شد.',
                ],

                'campaigns' => [
                    'create-success' => 'کمپین با موفقیت ایجاد شد.',
                    'delete-success' => 'کمپین با موفقیت حذف شد',
                    'not-found'      => 'هشدار: کمپین یافت نشد.',
                    'update-success' => 'کمپین با موفقیت به روز شد.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'اشتراک با موفقیت حذف شد',
                    'not-found'           => 'هشدار: اشتراک یافت نشد.',
                    'unsubscribe-success' => 'موفقیت: اشتراک با موفقیت لغو شد.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'بازنویسی URL با موفقیت ایجاد شد.',
                    'delete-success' => 'بازنویسی URL با موفقیت حذف شد',
                    'not-found'      => 'هشدار: بازنویسی URL یافت نشد.',
                    'update-success' => 'بازنویسی URL با موفقیت به روز شد.',
                ],

                'search-terms' => [
                    'create-success' => 'عبارت جستجو با موفقیت ایجاد شد.',
                    'delete-success' => 'عبارت جستجو با موفقیت حذف شد',
                    'not-found'      => 'هشدار: عبارت جستجو یافت نشد.',
                    'update-success' => 'عبارت جستجو با موفقیت به روز شد.',
                ],

                'search-synonyms' => [
                    'create-success' => 'مترادف جستجو با موفقیت ایجاد شد.',
                    'delete-success' => 'مترادف جستجو با موفقیت حذف شد',
                    'not-found'      => 'هشدار: مترادف جستجو یافت نشد.',
                    'update-success' => 'مترادف جستجو با موفقیت به روز شد.',
                ],

                'sitemaps' => [
                    'create-success' => 'نقشه سایت با موفقیت ایجاد شد.',
                    'delete-success' => 'نقشه سایت با موفقیت حذف شد',
                    'not-found'      => 'هشدار: نقشه سایت یافت نشد.',
                    'update-success' => 'نقشه سایت با موفقیت به روز شد.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'زبان با موفقیت ایجاد شد.',
                'default-delete-error' => 'امکان حذف زبان پیش فرض وجود ندارد.',
                'delete-error'         => 'حذف زبان با خطا مواجه شد.',
                'delete-success'       => 'زبان با موفقیت حذف شد.',
                'last-delete-error'    => 'امکان حذف آخرین زبان وجود ندارد.',
                'not-found'            => 'هشدار: زبان یافت نشد.',
                'update-success'       => 'زبان با موفقیت به روز شد.',
            ],

            'currencies' => [
                'create-success'       => 'واحد پول با موفقیت ایجاد شد.',
                'default-delete-error' => 'امکان حذف واحد پول پیش فرض وجود ندارد.',
                'delete-error'         => 'حذف واحد پول با خطا مواجه شد.',
                'delete-success'       => 'واحد پول با موفقیت حذف شد.',
                'last-delete-error'    => 'امکان حذف آخرین واحد پول وجود ندارد.',
                'not-found'            => 'هشدار: واحد پول یافت نشد.',
                'update-success'       => 'واحد پول با موفقیت به روز شد.',
            ],

            'exchange-rates' => [
                'create-success'          => 'نرخ تبادل با موفقیت ایجاد شد.',
                'delete-error'            => 'حذف نرخ تبادل با خطا مواجه شد.',
                'delete-success'          => 'نرخ تبادل با موفقیت حذف شد.',
                'invalid-target-currency' => 'هشدار: واحد پول مقصد نامعتبر است.',
                'last-delete-error'       => 'امکان حذف آخرین نرخ تبادل وجود ندارد.',
                'not-found'               => 'هشدار: نرخ تبادل یافت نشد.',
                'update-success'          => 'نرخ تبادل با موفقیت به روز شد.',
            ],

            'inventory-sources' => [
                'create-success'    => 'منبع موجودی با موفقیت ایجاد شد.',
                'delete-error'      => 'حذف منبع موجودی با خطا مواجه شد.',
                'delete-success'    => 'منبع موجودی با موفقیت حذف شد.',
                'last-delete-error' => 'امکان حذف آخرین منبع موجودی وجود ندارد.',
                'not-found'         => 'هشدار: منبع موجودی یافت نشد.',
                'update-success'    => 'منبع موجودی با موفقیت به روز شد.',
            ],

            'channels' => [
                'create-success'       => 'کانال با موفقیت ایجاد شد.',
                'default-delete-error' => 'امکان حذف کانال پیش فرض وجود ندارد.',
                'delete-error'         => 'حذف کانال با خطا مواجه شد.',
                'delete-success'       => 'کانال با موفقیت حذف شد.',
                'last-delete-error'    => 'امکان حذف آخرین کانال وجود ندارد.',
                'not-found'            => 'هشدار: کانال یافت نشد.',
                'update-success'       => 'کانال با موفقیت به روز شد.',
            ],

            'users' => [
                'activate-warning'  => 'حساب کاربری شما هنوز فعال نشده است، لطفا با مدیریت تماس بگیرید.',
                'create-success'    => 'کاربر با موفقیت ایجاد شد.',
                'delete-error'      => 'حذف کاربر با خطا مواجه شد.',
                'delete-success'    => 'کاربر با موفقیت حذف شد.',
                'last-delete-error' => 'امکان حذف آخرین کاربر وجود ندارد.',
                'login-error'       => 'لطفا اعتبارهای خود را بررسی کنید و دوباره تلاش کنید.',
                'not-found'         => 'هشدار: کاربر یافت نشد.',
                'success-login'     => 'موفقیت: کاربر با موفقیت وارد شد.',
                'success-logout'    => 'موفقیت: کاربر با موفقیت خارج شد.',
                'update-success'    => 'کاربر با موفقیت به روز شد.',
            ],

            'roles' => [
                'create-success'    => 'نقش با موفقیت ایجاد شد.',
                'delete-error'      => 'حذف نقش با خطا مواجه شد.',
                'delete-success'    => 'نقش با موفقیت حذف شد.',
                'last-delete-error' => 'امکان حذف آخرین نقش وجود ندارد.',
                'not-found'         => 'هشدار: نقش یافت نشد.',
                'update-success'    => 'نقش با موفقیت به روز شد.',
            ],

            'themes' => [
                'create-success' => 'قالب با موفقیت ایجاد شد.',
                'delete-success' => 'قالب با موفقیت حذف شد.',
                'not-found'      => 'هشدار: قالب یافت نشد.',
                'update-success' => 'قالب با موفقیت به روز شد.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'شناسه category_id مشخص شده وجود ندارد.',
                        'invalid-boolean-value' => 'مقدار :key باید 0 یا 1 باشد.',
                        'invalid-filter-key'    => 'کلید فیلتر ":key" مجاز نیست.',
                        'invalid-limit-value'   => 'مقدار limit باید یکی از گزینه‌های زیر باشد: :options.',
                        'invalid-select-option' => 'مقدار :key نامعتبر است. گزینه‌های معتبر عبارتند از: :options.',
                        'invalid-sort-value'    => 'مقدار مرتب‌سازی باید یکی از گزینه‌های زیر باشد: :options.',
                        'missing-limit-key'     => 'فیلترهای ورودی باید کلید "limit" را شامل باشند.',
                        'missing-sort-key'      => 'فیلترهای ورودی باید کلید "sort" را شامل باشند.',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'نرخ مالیات با موفقیت ایجاد شد.',
                'delete-error'   => 'حذف نرخ مالیات با خطا مواجه شد.',
                'delete-success' => 'نرخ مالیات با موفقیت حذف شد.',
                'not-found'      => 'هشدار: نرخ مالیات یافت نشد.',
                'update-success' => 'نرخ مالیات با موفقیت به روز شد.',
            ],

            'tax-category' => [
                'create-success'     => 'دسته مالیاتی با موفقیت ایجاد شد.',
                'delete-error'       => 'حذف دسته مالیاتی با خطا مواجه شد.',
                'delete-success'     => 'دسته مالیاتی با موفقیت حذف شد.',
                'not-found'          => 'هشدار: دسته مالیاتی یافت نشد.',
                'tax-rate-not-found' => 'شناسه های داده شده یافت نشد. شناسه ها: :ids',
                'update-success'     => 'دسته مالیاتی با موفقیت به روز شد.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'افزودن اعلان',
                    'general'   => 'عمومی',
                    'title'     => 'اعلان های پوش',

                    'datagrid' => [
                        'channel-name'         => 'نام کانال',
                        'created-at'           => 'زمان ایجاد',
                        'delete'               => 'حذف',
                        'id'                   => 'شناسه',
                        'image'                => 'تصویر',
                        'notification-content' => 'محتوای اعلان',
                        'notification-status'  => 'وضعیت اعلان',
                        'notification-type'    => 'نوع اعلان',
                        'text-title'           => 'عنوان',
                        'update'               => 'به روز رسانی',
                        'updated-at'           => 'زمان به روز رسانی',

                        'status' => [
                            'disabled' => 'غیرفعال',
                            'enabled'  => 'فعال',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'بازگشت',
                    'content-and-image'    => 'محتوای اعلان و تصویر',
                    'create-btn-title'     => 'ذخیره اعلان',
                    'general'              => 'عمومی',
                    'image'                => 'تصویر',
                    'new-notification'     => 'اعلان جدید',
                    'notification-content' => 'محتوای اعلان',
                    'notification-type'    => 'نوع اعلان',
                    'product-cat-id'       => 'شناسه محصول/دسته بندی',
                    'settings'             => 'تنظیمات',
                    'status'               => 'وضعیت',
                    'store-view'           => 'کانال ها',
                    'title'                => 'اعلان های پوش',

                    'option-type' => [
                        'category' => 'دسته بندی',
                        'others'   => 'ساده',
                        'product'  => 'محصول',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'بازگشت',
                    'content-and-image'    => 'محتوای اعلان و تصویر',
                    'edit-notification'    => 'ویرایش اعلان',
                    'general'              => 'عمومی',
                    'image'                => 'تصویر',
                    'notification-content' => 'محتوای اعلان',
                    'notification-type'    => 'نوع اعلان',
                    'product-cat-id'       => 'شناسه محصول/دسته بندی',
                    'send-title'           => 'ارسال اعلان',
                    'settings'             => 'تنظیمات',
                    'status'               => 'وضعیت',
                    'store-view'           => 'کانال ها',
                    'title'                => 'اعلان های پوش',
                    'update-btn-title'     => 'به روز رسانی',

                    'option-type' => [
                        'category' => 'دسته بندی',
                        'others'   => 'ساده',
                        'product'  => 'محصول',
                    ],
                ],

                'not-found'           => 'هشدار: اعلان یافت نشد.',
                'create-success'      => 'اعلان با موفقیت ایجاد شد.',
                'delete-failed'       => 'حذف اعلان با خطا مواجه شد.',
                'delete-success'      => 'اعلان با موفقیت حذف شد.',
                'mass-update-success' => 'اعلان های انتخاب شده با موفقیت به روز شدند.',
                'mass-delete-success' => 'اعلان های انتخاب شده با موفقیت حذف شدند.',
                'no-value-selected'   => 'هیچ مقداری انتخاب نشده است.',
                'send-success'        => 'اعلان با موفقیت ارسال شد.',
                'update-success'      => 'اعلان با موفقیت به روز شد.',
                'configuration-error' => 'هشدار: تنظیمات FCM یافت نشد.',
                'product-not-found'   => 'هشدار: محصول یافت نشد.',
                'category-not-found'  => 'هشدار: دسته بندی یافت نشد.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'هشدار: پارامترهای نامعتبر ارائه شده است.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'هشدار: پیکربندی ایمیل یافت نشد.',
    ],
];
