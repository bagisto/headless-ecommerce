<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'أنت مشترك بالفعل في نشرتنا الإخبارية.',
            'subscribe-success'  => 'لقد اشتركت بنجاح في نشرتنا الإخبارية.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'شكراً لتواصلكم معنا. سنعاود الاتصال بكم قريباً.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'تحذير: لم يتم العثور على رابط التنزيل.',
                'sample-not-found' => 'تحذير: لم يتم العثور على العينة القابلة للتنزيل.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'تحذير: لا يوجد عميل مسجل الدخول.',
            'success-login'     => 'تم تسجيل الدخول بنجاح.',
            'success-logout'    => 'تم تسجيل الخروج بنجاح.',

            'signup' => [
                'error-registration' => 'تحذير: فشل تسجيل العميل.',
                'success-verify'     => 'تم إنشاء الحساب بنجاح، تم إرسال بريد إلكتروني للتحقق.',
                'success'            => 'نجاح: تم تسجيل العميل وتسجيل الدخول بنجاح.',
            ],

            'social-login' => [
                'disabled' => 'تحذير: تسجيل الدخول الاجتماعي معطل.',
            ],

            'login' => [
                'invalid-creds' => 'يرجى التحقق من بيانات الاعتماد الخاصة بك والمحاولة مرة أخرى.',
                'not-activated' => 'يتطلب تنشيط حسابك موافقة المشرف',
                'verify-first'  => 'يرجى التحقق من بريدك الإلكتروني أولاً.',
                'suspended'     => 'تم تعليق حسابك من قبل المسؤول.',

                'validation' => [
                    'required' => 'حقل :field مطلوب.',
                    'same'     => 'يجب أن تتطابق :field وكلمة المرور.',
                    'unique'   => 'تم أخذ هذا :field بالفعل.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'تم إرسال رابط إعادة تعيين كلمة المرور بالفعل إلى بريدك الإلكتروني.',
                'email-not-exist' => 'البريد الإلكتروني غير موجود.',
                'reset-link-sent' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'نجاح: تم جلب تفاصيل العميل بنجاح.',
                    'delete-success'   => 'نجاح: تم حذف الحساب بنجاح.',
                    'password-unmatch' => 'كلمة المرور غير متطابقة.',
                    'update-fail'      => 'تحذير: لم يتم تحديث الملف الشخصي.',
                    'update-success'   => 'نجاح: تم تحديث الملف الشخصي بنجاح.',
                    'wrong-password'   => 'تحذير: تم تقديم كلمة مرور خاطئة.',
                    'order-pending'    => 'لا يمكنك حذف الحساب لأن لديك بعض الطلبات المعلقة.',
                ],

                'addresses' => [
                    'create-success'         => 'تم إنشاء العنوان بنجاح.',
                    'default-update-success' => 'تم تعيين العنوان كافتراضي',
                    'delete-success'         => 'تم حذف عنوان العميل بنجاح',
                    'not-found'              => 'تحذير: لم يتم العثور على العنوان.',
                    'update-success'         => 'تم تحديث العنوان بنجاح.',
                    'already-default'        => 'تحذير: هذا العنوان تم تعيينه كافتراضي بالفعل.',
                ],

                'wishlist' => [
                    'product-removed' => 'تحذير: المنتج غير موجود.',
                    'success'         => 'تمت إضافة المنتج إلى قائمة الرغبات بنجاح.',
                    'already-exist'   => 'تحذير: تمت إضافته بالفعل إلى قائمة الرغبات.',
                    'remove-success'  => 'تمت إزالة العنصر بنجاح من قائمة الرغبات.',
                    'not-found'       => 'تحذير: لا توجد منتجات في قائمة الرغبات.',
                    'moved-to-cart'   => 'تم نقل العناصر المحددة إلى سلة التسوق بنجاح.',
                ],

                'orders' => [
                    'not-found'      => 'تحذير: لا توجد طلبات موجودة.',
                    'cancel-error'   => 'تحذير: لم يتم إلغاء الطلب.',
                    'cancel-success' => 'تم إلغاء الطلب بنجاح.',

                    'shipment' => [
                        'not-found' => 'تحذير: لم يتم العثور على الشحنة.',
                    ],

                    'invoice' => [
                        'not-found' => 'تحذير: لم يتم العثور على الفاتورة.',
                    ],

                    'refund' => [
                        'not-found' => 'تحذير: لم يتم العثور على المرتجع.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'تحذير: المنتج القابل للتنزيل غير موجود.',
                    'not-auth'       => 'تحذير: ليس لديك الصلاحية لأداء هذا الإجراء.',
                    'payment-error'  => 'لم يتم الدفع لهذا التنزيل.',
                    'download-error' => 'انتهت صلاحية رابط التنزيل.',
                ],

                'gdpr' => [
                    'create-success'       => 'نجاح: تم إنشاء طلب GDPR بنجاح.',
                    'revoke-failed'        => 'تحذير: لم يتم إلغاء طلب GDPR.',
                    'revoked-successfully' => 'نجاح: تم إلغاء طلب GDPR بنجاح.',
                    'not-enabled'          => 'تحذير: حماية البيانات غير مفعلة.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'تحذير: لم يتم العثور على منتج المقارنة.',
                'product-not-found'   => 'تحذير: لم يتم العثور على المنتج.',
                'already-added'       => 'تحذير: تم إضافة المنتج بالفعل إلى قائمة المقارنة.',
                'item-add-success'    => 'نجاح: تم إضافة المنتج إلى قائمة المقارنة بنجاح.',
                'remove-success'      => 'نجاح: تم إزالة العنصر بنجاح من قائمة المقارنة.',
                'mass-remove-success' => 'نجاح: تم حذف العناصر المحددة بنجاح.',
                'not-auth'            => 'تحذير: ليس لديك الصلاحية لأداء هذا الإجراء.',
            ],

            'reviews' => [
                'create-success'      => 'تم إنشاء المراجعة بنجاح.',
                'delete-success'      => 'تم حذف المراجعة بنجاح.',
                'mass-delete-success' => 'تم حذف المراجعات المحددة بنجاح.',
                'not-found'           => 'تحذير: المراجعة غير موجودة.',
                'product-not-found'   => 'تحذير: لم يتم العثور على المنتج.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'تحذير: لا يمكنك تنزيل الروابط المنتهية.',
                        'invalid-parameter'  => 'تحذير: المعلمات غير صالحة المقدمة.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'تمت إضافة المنتج إلى السلة بنجاح.',
                        'update-to-cart'   => 'تم تحديث المنتج في السلة بنجاح.',
                        'delete-cart-item' => 'تمت إزالة العنصر بنجاح من السلة.',
                        'all-remove'       => 'تمت إزالة جميع العناصر من السلة بنجاح.',
                        'move-to-wishlist' => 'تم نقل العناصر المحددة إلى قائمة الرغبات بنجاح.',
                    ],

                    'fail' => [
                        'all-remove'       => 'تحذير: لم يتم إزالة جميع العناصر من السلة.',
                        'update-to-cart'   => 'تحذير: لم يتم تحديث المنتج في السلة.',
                        'delete-cart-item' => 'تحذير: لم يتم إزالة العنصر من السلة.',
                        'not-found'        => 'تحذير: السلة غير موجودة.',
                        'item-not-found'   => 'تحذير: العنصر غير موجود.',
                        'move-to-wishlist' => 'تحذير: لم يتم نقل العناصر المحددة إلى قائمة الرغبات.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'تحذير: لا يمكن للمستخدم الضيف إضافة عنوان.',
                'guest-checkout-warning'    => 'تحذير: لا يمكن للمستخدم الضيف الخروج.',
                'no-billing-address-found'  => 'تحذير: لا يوجد عنوان فوترة موجود.',
                'no-shipping-address-found' => 'تحذير: لا يوجد عنوان شحن موجود.',
                'address-save-success'      => 'تم حفظ العنوان بنجاح.',
            ],

            'shipping' => [
                'method-not-found' => 'تحذير: طريقة الشحن غير موجودة.',
                'method-fetched'   => 'تم جلب طريقة الشحن بنجاح.',
                'save-failed'      => 'تحذير: لم يتم حفظ طريقة الشحن.',
                'save-success'     => 'تم حفظ طريقة الشحن بنجاح.',
            ],

            'payment' => [
                'method-not-found' => 'تحذير: طريقة الدفع غير موجودة.',
                'method-fetched'   => 'تم جلب طريقة الدفع بنجاح.',
                'save-failed'      => 'تحذير: لم يتم حفظ طريقة الدفع.',
                'save-success'     => 'تم حفظ طريقة الدفع بنجاح.',
            ],

            'coupon' => [
                'apply-success'   => 'تم تطبيق رمز الكوبون بنجاح.',
                'already-applied' => 'تحذير: تم تطبيق رمز الكوبون بالفعل.',
                'invalid-code'    => 'تحذير: رمز الكوبون غير صالح.',
                'remove-success'  => 'تمت إزالة رمز الكوبون بنجاح.',
                'remove-failed'   => 'تحذير: لم يتم إزالة رمز الكوبون.',
            ],

            'something-wrong'          => 'تحذير: حدث خطأ ما.',
            'invalid-guest-user'       => 'تحذير: مستخدم ضيف غير صالح.',
            'empty-cart'               => 'تحذير: السلة فارغة.',
            'missing-billing-address'  => 'تحذير: عنوان الفاتورة مفقود.',
            'missing-shipping-address' => 'تحذير: عنوان الشحن مفقود.',
            'missing-shipping-method'  => 'تحذير: طريقة الشحن مفقودة.',
            'missing-payment-method'   => 'تحذير: طريقة الدفع مفقودة.',
            'no-address-found'         => 'تحذير: لم يتم العثور على عنوان الفاتورة والشحن.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'إنشاء',
            'delete'            => 'حذف',
            'edit'              => 'تعديل',
            'mass-delete'       => 'حذف جماعي',
            'mass-update'       => 'تحديث جماعي',
            'push-notification' => 'إشعار الدفع',
            'send'              => 'إرسال',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'إشعار الدفع',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'موضوع الإشعار',
                        'info'                            => 'إعدادات متعلقة بالإشعارات',
                        'push-notification-configuration' => 'إعدادات إشعار الدفع FCM',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'محتوى ملف JSON المفتاح الخاص',
                        'info-get-private-key'            => 'معلومة: للحصول على محتوى ملف JSON المفتاح الخاص بـ FCM: <a href="https://console.firebase.google.com/" target="_blank">انقر هنا</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'نجاح: تم تحديث النصوص المخصصة بنجاح.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'تحذير: لا يمكن إلغاء الطلب.',
                'cancel-success' => 'تم إلغاء الطلب بنجاح.',
                'not-found'      => 'تحذير: الطلب غير موجود.',
            ],

            'shipments' => [
                'creation-error'   => 'تحذير: لم يتم إنشاء الشحنة.',
                'not-found'        => 'تحذير: الشحنة غير موجودة.',
                'quantity-invalid' => 'تحذير: الكمية المقدمة غير صالحة.',
                'shipment-error'   => 'تحذير: لم يتم إنشاء الشحنة.',
                'create-success'   => 'تم إنشاء الشحنة بنجاح.',
            ],

            'invoices' => [
                'creation-error' => 'تحذير: لم يتم إنشاء الفاتورة.',
                'not-found'      => 'تحذير: الفاتورة غير موجودة.',
                'product-error'  => 'تحذير: المنتج المقدم غير صالح.',
                'create-success' => 'تم إنشاء الفاتورة بنجاح.',
                'invalid-qty'    => 'تحذير: وجدنا كمية غير صالحة لعناصر الفاتورة.',
            ],

            'refunds' => [
                'creation-error'      => 'تحذير: لم يتم إنشاء المرتجع.',
                'refund-amount-error' => 'تحذير: المبلغ المسترد غير صالح.',
                'refund-limit-error'  => 'تحذير: يتجاوز المبلغ المسترد الحد الأقصى لـ :amount',
                'not-found'           => 'تحذير: المرتجع غير موجود.',
                'create-success'      => 'تم إنشاء المرتجع بنجاح.',
            ],

            'transactions' => [
                'already-paid'   => 'تحذير: تم دفع الفاتورة بالفعل.',
                'amount-exceed'  => 'تحذير: يتجاوز مبلغ العملية الحد الأقصى.',
                'zero-amount'    => 'تحذير: يجب أن يكون مبلغ العملية أكبر من الصفر.',
                'create-success' => 'تم إنشاء العملية بنجاح.',
            ],

            'reorder' => [
                'customer-not-found'       => 'تحذير: العميل غير موجود.',
                'cart-not-found'           => 'تحذير: السلة غير موجودة.',
                'cart-item-not-found'      => 'تحذير: عنصر السلة غير موجود.',
                'cart-create-success'      => 'تم إنشاء السلة بنجاح.',
                'cart-item-add-success'    => 'تمت إضافة المنتج إلى السلة بنجاح.',
                'cart-item-remove-success' => 'تمت إزالة العنصر بنجاح من السلة.',
                'cart-item-update-success' => 'تم تحديث المنتج في السلة بنجاح.',
                'something-wrong'          => 'تحذير: حدث خطأ ما.',
                'address-save-success'     => 'تم حفظ العنوان بنجاح.',
                'shipping-save-success'    => 'تم حفظ طريقة الشحن بنجاح.',
                'payment-save-success'     => 'تم حفظ طريقة الدفع بنجاح.',
                'order-placed-success'     => 'تم تقديم الطلب بنجاح.',
                'payment-method-not-found' => 'تحذير: طريقة الدفع غير موجودة.',
                'minimum-order-amount-err' => 'تحذير: يجب أن يكون الحد الأدنى لمبلغ الطلب :amount',
                'check-shipping-address'   => 'تحذير: يرجى التحقق من عنوان الشحن.',
                'check-billing-address'    => 'تحذير: يرجى التحقق من عنوان الفواتير.',
                'specify-shipping-method'  => 'تحذير: يرجى تحديد طريقة الشحن.',
                'specify-payment-method'   => 'تحذير: يرجى تحديد طريقة الدفع.',
                'coupon-not-valid'         => 'تحذير: رمز الكوبون غير صالح.',
                'coupon-already-applied'   => 'تحذير: تم تطبيق رمز الكوبون بالفعل.',
                'coupon-applied'           => 'تم تطبيق رمز الكوبون بنجاح.',
                'coupon-removed'           => 'تمت إزالة رمز الكوبون بنجاح.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'تم إنشاء المنتج بنجاح.',
                'delete-success'            => 'تم حذف المنتج بنجاح',
                'not-found'                 => 'تحذير: المنتج غير موجود.',
                'update-success'            => 'تم تحديث المنتج بنجاح.',
                'configurable-attr-missing' => 'تحذير: السمة القابلة للتكوين مفقودة.',
                'simple-products-error'     => 'تحذير: المنتجات البسيطة مفقودة.',
            ],

            'categories' => [
                'already-taken'  => 'تحذير: تم استخدام الاسم المستعار بالفعل.',
                'create-success' => 'تم إنشاء الفئة بنجاح.',
                'delete-success' => 'تم حذف الفئة بنجاح',
                'not-found'      => 'تحذير: الفئة غير موجودة.',
                'update-success' => 'تم تحديث الفئة بنجاح.',
                'root-delete'    => 'تحذير: لا يمكن حذف الفئة الجذر.',
            ],

            'attributes' => [
                'create-success'    => 'تم إنشاء السمة بنجاح.',
                'delete-success'    => 'تم حذف السمة بنجاح',
                'not-found'         => 'تحذير: السمة غير موجودة.',
                'update-success'    => 'تم تحديث السمة بنجاح.',
                'user-define-error' => 'تحذير: ليس لديك إذن لحذف السمة التي تم إنشاؤها من قبل النظام.',
            ],

            'attribute-groups' => [
                'create-success'    => 'تم إنشاء مجموعة السمات بنجاح.',
                'delete-success'    => 'تم حذف مجموعة السمات بنجاح',
                'not-found'         => 'تحذير: مجموعة السمات غير موجودة.',
                'update-success'    => 'تم تحديث مجموعة السمات بنجاح.',
                'user-define-error' => 'تحذير: ليس لديك إذن لحذف مجموعة السمات التي تم إنشاؤها من قبل النظام.',
            ],

            'attribute-families' => [
                'create-success'          => 'تم إنشاء عائلة السمات بنجاح.',
                'delete-success'          => 'تم حذف عائلة السمات بنجاح',
                'not-found'               => 'تحذير: عائلة السمات غير موجودة.',
                'update-success'          => 'تم تحديث عائلة السمات بنجاح.',
                'last-delete-error'       => 'تحذير: لا يمكن حذف آخر عائلة السمات.',
                'attribute-product-error' => 'تحذير: يتم ربط بعض المنتجات بعائلة السمات هذه.',
                'user-define-error'       => 'تحذير: ليس لديك إذن لحذف عائلة السمات التي تم إنشاؤها من قبل النظام.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'تم إنشاء العميل بنجاح.',
                'delete-order-pending' => 'لا يمكن حذف حساب العميل لأن بعض الطلبات قيد الانتظار أو في حالة معالجة.',
                'delete-success'       => 'تم حذف العميل بنجاح',
                'not-found'            => 'تحذير: العميل غير موجود.',
                'note-created-success' => 'تم إنشاء الملاحظة بنجاح',
                'update-success'       => 'تم تحديث العميل بنجاح.',
                'login-success'        => 'تم تسجيل الدخول بنجاح.',
            ],

            'addresses' => [
                'create-success'         => 'تم إنشاء عنوان العميل بنجاح.',
                'default-update-success' => 'تم تعيين العنوان كافتراضي.',
                'delete-success'         => 'تم حذف عنوان العميل بنجاح.',
                'not-found'              => 'تحذير: عنوان العميل غير موجود.',
                'update-success'         => 'تم تحديث عنوان العميل بنجاح.',
                'already-default'        => 'تحذير: هذا العنوان تم تعيينه كافتراضي بالفعل.',
            ],

            'groups' => [
                'create-success'     => 'تم إنشاء مجموعة العملاء بنجاح.',
                'customer-associate' => 'تحذير: لا يمكن حذف المجموعة. العميل مرتبط بها.',
                'delete-success'     => 'تم حذف مجموعة العملاء بنجاح',
                'not-found'          => 'تحذير: مجموعة العملاء غير موجودة.',
                'update-success'     => 'تم تحديث مجموعة العملاء بنجاح.',
                'user-define-error'  => 'تحذير: ليس لديك إذن لحذف مجموعة العملاء التي تم إنشاؤها من قبل النظام.',
            ],

            'reviews' => [
                'delete-success' => 'تم حذف التقييم بنجاح',
                'not-found'      => 'تحذير: التقييم غير موجود.',
                'update-success' => 'تم تحديث التقييم بنجاح.',
            ],

            'gdpr' => [
                'delete-success' => 'نجاح: تم حذف طلب حماية البيانات بنجاح.',
                'not-found'      => 'تحذير: لم يتم العثور على طلب حماية البيانات.',
                'update-success' => 'تم تحديث طلب حماية البيانات بنجاح.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'تحذير: تم استخدام الاسم المستعار بالفعل.',
            'create-success' => 'تم إنشاء صفحة CMS بنجاح.',
            'delete-success' => 'تم حذف صفحة CMS بنجاح',
            'not-found'      => 'تحذير: صفحة CMS غير موجودة.',
            'update-success' => 'تم تحديث صفحة CMS بنجاح.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'تم إنشاء قاعدة الكتالوج بنجاح.',
                    'delete-failed'  => 'تحذير: لم يتم حذف قاعدة الكتالوج',
                    'delete-success' => 'تم حذف قاعدة الكتالوج بنجاح',
                    'not-found'      => 'تحذير: قاعدة الكتالوج غير موجودة.',
                    'update-success' => 'تم تحديث قاعدة الكتالوج بنجاح.',
                ],

                'cart-rules' => [
                    'create-success' => 'تم إنشاء قاعدة السلة بنجاح.',
                    'delete-failed'  => 'تحذير: لم يتم حذف قاعدة السلة',
                    'delete-success' => 'تم حذف قاعدة السلة بنجاح',
                    'not-found'      => 'قاعدة السلة غير موجودة',
                    'update-success' => 'تم تحديث قاعدة السلة بنجاح.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'تم إنشاء قالب البريد الإلكتروني بنجاح.',
                    'delete-success' => 'تم حذف قالب البريد الإلكتروني بنجاح',
                    'not-found'      => 'تحذير: قالب البريد الإلكتروني غير موجود.',
                    'update-success' => 'تم تحديث قالب البريد الإلكتروني بنجاح.',
                ],

                'events' => [
                    'create-success' => 'تم إنشاء الحدث بنجاح.',
                    'delete-success' => 'تم حذف الحدث بنجاح',
                    'not-found'      => 'تحذير: الحدث غير موجود.',
                    'update-success' => 'تم تحديث الحدث بنجاح.',
                ],

                'campaigns' => [
                    'create-success' => 'تم إنشاء الحملة بنجاح.',
                    'delete-success' => 'تم حذف الحملة بنجاح',
                    'not-found'      => 'تحذير: الحملة غير موجودة.',
                    'update-success' => 'تم تحديث الحملة بنجاح.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'تم حذف الاشتراك بنجاح',
                    'not-found'           => 'تحذير: الاشتراك غير موجود.',
                    'unsubscribe-success' => 'تم إلغاء الاشتراك بنجاح.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'تم إنشاء إعادة كتابة عنوان URL بنجاح.',
                    'delete-success' => 'تم حذف إعادة كتابة عنوان URL بنجاح',
                    'not-found'      => 'تحذير: إعادة كتابة عنوان URL غير موجودة.',
                    'update-success' => 'تم تحديث إعادة كتابة عنوان URL بنجاح.',
                ],

                'search-terms' => [
                    'create-success' => 'تم إنشاء مصطلح البحث بنجاح.',
                    'delete-success' => 'تم حذف مصطلح البحث بنجاح',
                    'not-found'      => 'تحذير: مصطلح البحث غير موجود.',
                    'update-success' => 'تم تحديث مصطلح البحث بنجاح.',
                ],

                'search-synonyms' => [
                    'create-success' => 'تم إنشاء مرادف البحث بنجاح.',
                    'delete-success' => 'تم حذف مرادف البحث بنجاح',
                    'not-found'      => 'تحذير: مرادف البحث غير موجود.',
                    'update-success' => 'تم تحديث مرادف البحث بنجاح.',
                ],

                'sitemaps' => [
                    'create-success' => 'تم إنشاء خريطة الموقع بنجاح.',
                    'delete-success' => 'تم حذف خريطة الموقع بنجاح',
                    'not-found'      => 'تحذير: خريطة الموقع غير موجودة.',
                    'update-success' => 'تم تحديث خريطة الموقع بنجاح.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'تم إنشاء اللغة بنجاح.',
                'default-delete-error' => 'لا يمكن حذف اللغة الافتراضية.',
                'delete-error'         => 'فشل حذف اللغة.',
                'delete-success'       => 'تم حذف اللغة بنجاح.',
                'last-delete-error'    => 'فشل حذف آخر لغة.',
                'not-found'            => 'تحذير: اللغة غير موجودة.',
                'update-success'       => 'تم تحديث اللغة بنجاح.',
            ],

            'currencies' => [
                'create-success'       => 'تم إنشاء العملة بنجاح.',
                'default-delete-error' => 'لا يمكن حذف العملة الافتراضية.',
                'delete-error'         => 'فشل حذف العملة.',
                'delete-success'       => 'تم حذف العملة بنجاح.',
                'last-delete-error'    => 'فشل حذف آخر عملة.',
                'not-found'            => 'تحذير: العملة غير موجودة.',
                'update-success'       => 'تم تحديث العملة بنجاح.',
            ],

            'exchange-rates' => [
                'create-success'          => 'تم إنشاء سعر الصرف بنجاح.',
                'delete-error'            => 'فشل حذف سعر الصرف.',
                'delete-success'          => 'تم حذف سعر الصرف بنجاح.',
                'invalid-target-currency' => 'تحذير: العملة المستهدفة غير صالحة.',
                'last-delete-error'       => 'فشل حذف آخر سعر صرف.',
                'not-found'               => 'تحذير: سعر الصرف غير موجود.',
                'update-success'          => 'تم تحديث سعر الصرف بنجاح.',
            ],

            'inventory-sources' => [
                'create-success'    => 'تم إنشاء المخزون بنجاح.',
                'delete-error'      => 'فشل حذف المخزون.',
                'delete-success'    => 'تم حذف المخزون بنجاح.',
                'last-delete-error' => 'فشل حذف آخر مخزون.',
                'not-found'         => 'تحذير: المخزون غير موجود.',
                'update-success'    => 'تم تحديث المخزون بنجاح.',
            ],

            'channels' => [
                'create-success'       => 'تم إنشاء القناة بنجاح.',
                'default-delete-error' => 'لا يمكن حذف القناة الافتراضية.',
                'delete-error'         => 'فشل حذف القناة.',
                'delete-success'       => 'تم حذف القناة بنجاح.',
                'last-delete-error'    => 'فشل حذف آخر قناة.',
                'not-found'            => 'تحذير: القناة غير موجودة.',
                'update-success'       => 'تم تحديث القناة بنجاح.',
            ],

            'users' => [
                'activate-warning'  => 'حسابك لم يتم تفعيله بعد، يرجى الاتصال بالمسؤول.',
                'create-success'    => 'تم إنشاء المستخدم بنجاح.',
                'delete-error'      => 'فشل حذف المستخدم.',
                'delete-success'    => 'تم حذف المستخدم بنجاح.',
                'last-delete-error' => 'فشل حذف آخر مستخدم.',
                'login-error'       => 'يرجى التحقق من بيانات الاعتماد الخاصة بك والمحاولة مرة أخرى.',
                'not-found'         => 'تحذير: المستخدم غير موجود.',
                'success-login'     => 'تم تسجيل الدخول بنجاح.',
                'success-logout'    => 'تم تسجيل الخروج بنجاح.',
                'update-success'    => 'تم تحديث المستخدم بنجاح.',
            ],

            'roles' => [
                'create-success'    => 'تم إنشاء الدور بنجاح.',
                'delete-error'      => 'فشل حذف الدور.',
                'delete-success'    => 'تم حذف الدور بنجاح.',
                'last-delete-error' => 'لا يمكن حذف آخر دور.',
                'not-found'         => 'تحذير: الدور غير موجود.',
                'update-success'    => 'تم تحديث الدور بنجاح.',
            ],

            'themes' => [
                'create-success' => 'تم إنشاء السمة بنجاح.',
                'delete-success' => 'تم حذف السمة بنجاح.',
                'not-found'      => 'تحذير: السمة غير موجودة.',
                'update-success' => 'تم تحديث السمة بنجاح.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'معرف التصنيف المحدد غير موجود.',
                        'invalid-boolean-value' => 'يجب أن تكون قيمة :key إما 0 أو 1.',
                        'invalid-filter-key'    => 'مفتاح الفلتر ":key" غير مسموح به.',
                        'invalid-limit-value'   => 'يجب أن تكون قيمة الحد واحدة من الخيارات التالية: :options.',
                        'invalid-select-option' => 'قيمة :key غير صالحة. الخيارات الصالحة هي: :options.',
                        'invalid-sort-value'    => 'يجب أن تكون قيمة الترتيب واحدة من الخيارات التالية: :options.',
                        'missing-limit-key'     => 'يجب أن يحتوي filtersInput على مفتاح "limit".',
                        'missing-sort-key'      => 'يجب أن يحتوي filtersInput على مفتاح "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'تم إنشاء معدل الضريبة بنجاح.',
                'delete-error'   => 'فشل حذف معدل الضريبة.',
                'delete-success' => 'تم حذف معدل الضريبة بنجاح.',
                'not-found'      => 'تحذير: معدل الضريبة غير موجود.',
                'update-success' => 'تم تحديث معدل الضريبة بنجاح.',
            ],

            'tax-category' => [
                'create-success'     => 'تم إنشاء فئة الضريبة بنجاح.',
                'delete-error'       => 'فشل حذف فئة الضريبة.',
                'delete-success'     => 'تم حذف فئة الضريبة بنجاح.',
                'not-found'          => 'تحذير: فئة الضريبة غير موجودة.',
                'tax-rate-not-found' => 'المعرفات المعطاة غير موجودة. المعرفات: - :ids',
                'update-success'     => 'تم تحديث فئة الضريبة بنجاح.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'إضافة إشعار',
                    'general'   => 'عام',
                    'title'     => 'إشعار الدفع',

                    'datagrid' => [
                        'channel-name'         => 'اسم القناة',
                        'created-at'           => 'وقت الإنشاء',
                        'delete'               => 'حذف',
                        'id'                   => 'المعرف',
                        'image'                => 'الصورة',
                        'notification-content' => 'محتوى الإشعار',
                        'notification-status'  => 'حالة الإشعار',
                        'notification-type'    => 'نوع الإشعار',
                        'text-title'           => 'العنوان',
                        'update'               => 'تحديث',
                        'updated-at'           => 'وقت التحديث',

                        'status' => [
                            'disabled' => 'معطل',
                            'enabled'  => 'مفعل',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'رجوع',
                    'content-and-image'    => 'محتوى الإشعار والصورة',
                    'create-btn-title'     => 'حفظ الإشعار',
                    'general'              => 'عام',
                    'image'                => 'الصورة',
                    'new-notification'     => 'إشعار جديد',
                    'notification-content' => 'محتوى الإشعار',
                    'notification-type'    => 'نوع الإشعار',
                    'product-cat-id'       => 'معرف المنتج / الفئة',
                    'settings'             => 'الإعدادات',
                    'status'               => 'الحالة',
                    'store-view'           => 'القنوات',
                    'title'                => 'إشعار الدفع',

                    'option-type' => [
                        'category' => 'فئة',
                        'others'   => 'عادي',
                        'product'  => 'منتج',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'رجوع',
                    'content-and-image'    => 'محتوى الإشعار والصورة',
                    'edit-notification'    => 'تعديل الإشعار',
                    'general'              => 'عام',
                    'image'                => 'الصورة',
                    'notification-content' => 'محتوى الإشعار',
                    'notification-type'    => 'نوع الإشعار',
                    'product-cat-id'       => 'معرف المنتج / الفئة',
                    'send-title'           => 'إرسال الإشعار',
                    'settings'             => 'الإعدادات',
                    'status'               => 'الحالة',
                    'store-view'           => 'القنوات',
                    'title'                => 'إشعار الدفع',
                    'update-btn-title'     => 'تحديث',

                    'option-type' => [
                        'category' => 'فئة',
                        'others'   => 'عادي',
                        'product'  => 'منتج',
                    ],
                ],

                'not-found'           => 'تحذير: الإشعار غير موجود.',
                'create-success'      => 'تم إنشاء الإشعار بنجاح.',
                'delete-failed'       => 'فشل حذف الإشعار.',
                'delete-success'      => 'تم حذف الإشعار بنجاح.',
                'mass-update-success' => 'تم تحديث الإشعارات المحددة بنجاح.',
                'mass-delete-success' => 'تم حذف الإشعارات المحددة بنجاح.',
                'no-value-selected'   => 'لا توجد قيمة موجودة.',
                'send-success'        => 'تم إرسال الإشعار بنجاح.',
                'update-success'      => 'تم تحديث الإشعار بنجاح.',
                'configuration-error' => 'تحذير: تكوين FCM غير موجود.',
                'product-not-found'   => 'تحذير: المنتج غير موجود.',
                'category-not-found'  => 'تحذير: الفئة غير موجودة.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'تحذير: المعلمة غير صالحة.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'تحذير: لم يتم العثور على إعدادات البريد الإلكتروني.',
    ],
];
