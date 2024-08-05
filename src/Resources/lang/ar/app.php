<?php

return [
    'admin' => [
        'menu' => [
            'push-notification' => 'إشعار الدفع',
        ],

        'acl' => [
            'push-notification' => 'إشعار الدفع',
            'send'              => 'إرسال',
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'لا يمكن إلغاء الطلب.',
                'cancel-success' => 'تم إلغاء الطلب بنجاح',
                'not-found'      => 'تحذير: الطلب غير موجود.',
            ],

            'shipments' => [
                'not-found'        => 'تحذير: الشحنة غير موجودة.',
                'shipment-error'   => 'لا يُسمح بإنشاء شحنة الطلب.',
                'creation-error'   => 'لا يمكن إنشاء شحنة لهذا الطلب.',
                'quantity-invalid' => 'الكمية المطلوبة غير صالحة أو غير متاحة.',
            ],

            'invoices' => [
                'not-found'      => 'تحذير: الفاتورة غير موجودة.',
                'creation-error' => 'لا يُسمح بإنشاء فاتورة الطلب.',
                'product-error'  => 'لا يمكن إنشاء فاتورة بدون منتجات.',
            ],

            'refunds' => [
                'invalid-refund-amount-error' => 'يجب أن يكون مبلغ الاسترداد غير صفر.',
                'refund-limit-error'          => 'أقصى مبلغ متاح للاسترداد هو :amount.',
                'creation-error'              => 'لا يمكن إنشاء استرداد لهذا الطلب.',
                'create-success'              => 'تم إنشاء استرداد بنجاح لهذا الطلب.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create' => [
                    'configurable-error'      => 'يرجى تحديد عنصر واحد على الأقل قابل للتكوين.',
                    'grouped-error-not-added' => 'لم يتم إضافته إلى المنتج المجمع',
                    'grouped-error-not-added' => 'لم يتم إضافته إلى المنتج المجمع',
                ],

                'delete-success' => 'تم حذف المنتج بنجاح.',
                'delete-failed'  => 'تحذير: المنتج لم يتم حذفه',
            ],

            'categories' => [
                'already-taken'        => 'تم استخدام الفئة بالفعل.',
                'delete-category-root' => 'لا يمكن حذف الفئة الجذر.',
                'delete-success'       => 'تم حذف الفئة بنجاح.',
                'delete-failed'        => 'تحذير: الفئة لم تتم حذفها',
            ],

            'attributes' => [
                'delete-success'    => 'تم حذف السمة بنجاح.',
                'delete-failed'     => 'تحذير: السمة لم تتم حذفها',
                'user-define-error' => 'تحذير: ليس لديك إذن لحذف سمة تم إنشاؤها من قبل النظام.',
            ],

            'attribute-families' => [
                'last-delete-error'       => 'فشل حذف عائلة السمات الأخيرة',
                'attribute-product-error' => 'تم استخدام العائلة في المنتجات.',
                'delete-success'          => 'تم حذف العائلة بنجاح.',
                'delete-failed'           => 'تحذير: لم يتم حذف العائلة',
            ],

            'attribute-groups' => [
                'delete-success'       => 'تم حذف مجموعة العائلة بنجاح.',
                'delete-failed'        => 'تحذير: لم يتم حذف مجموعة العائلة',
                'error-customer-group' => 'تحذير: ليس لديك إذن لحذف مجموعة السمات التي تم إنشاؤها من قبل النظام.',
            ],
        ],

        'customers' => [
            'no-customer-found'      => 'لم يتم العثور على العميل',
            'address-delete-success' => 'تم حذف عنوان العميل بنجاح',
            'user-define-error'      => 'تحذير: ليس لديك إذن لحذف مجموعة العملاء التي تم إنشاؤها من قبل النظام.',
            'delete-order-pending'   => 'لا يمكن حذف حساب العميل لأن بعض الطلبات قيد الانتظار أو في حالة معالجة.',
            'delete-success'         => 'تم حذف العميل بنجاح',

            'groups' => [
                'user-define-error'  => 'تحذير: ليس لديك إذن لحذف مجموعة العملاء التي تم إنشاؤها من قبل النظام.',
                'customer-associate' => 'تحذير: لا يمكن حذف المجموعة. العميل مرتبط بها.',
                'delete-success'     => 'تم حذف العميل بنجاح',
            ],
        ],

        'cms' => [
            'already-taken'  => 'رابط صفحة CMS مستخدم بالفعل',
            'delete-success' => 'تم حذف صفحة CMS بنجاح.',
            'delete-failed'  => 'تحذير: لم يتم حذف صفحة CMS',
        ],

        'marketing' => [
            'communications' => [
                'campaigns' => [
                    'delete-success' => 'تم حذف الحملة بنجاح',
                    'delete-failed'  => 'تحذير: لم يتم حذف الحملة',
                ],

                'templates' => [
                    'delete-success' => 'تم حذف قالب البريد الإلكتروني بنجاح',
                    'delete-failed'  => 'تحذير: لم يتم حذف قالب البريد الإلكتروني',
                ],

                'events' => [
                    'delete-success' => 'تم حذف الحدث بنجاح',
                    'delete-failed'  => 'تحذير: لم يتم حذف الحدث',
                ],

                'subscriptions' => [
                    'no-subscriber-found'  => 'لم يتم العثور على المشترك',
                    'already-subscriber'   => 'أنت مشترك بالفعل في قائمة الاشتراك الخاصة بنا.',
                    'not-subscribed'       => 'لا يمكنك الاشتراك في رسائل الاشتراك ، يرجى المحاولة مرة أخرى في وقت لاحق.',
                    'already-unsubscribed' => 'لقد قمت بإلغاء الاشتراك بالفعل.',
                    'delete-success'       => 'تم حذف الاشتراك بنجاح',
                    'unsubscribe'          => 'إلغاء الاشتراك',
                    'subscribe'            => 'الاشتراك',
                    'subscribed-success'   => 'لقد اشتركت بنجاح في قائمة الاشتراك الخاصة بنا.',
                    'unsubscribed'         => 'لقد قمت بإلغاء الاشتراك بنجاح من قائمة الاشتراك الخاصة بنا.',
                ],
            ],

            'promotions' => [
                'cart-rules' => [
                    'delete-success'       => 'تم حذف قاعدة السلة بنجاح',
                    'delete-failed'        => 'تحذير: لم يتم حذف قاعدة السلة',
                    'cart-rule-not-defind' => 'قاعدة السلة غير محددة',
                ],

                'catalog-rules' => [
                    'delete-success' => 'تم حذف قاعدة الكتالوج بنجاح',
                    'delete-failed'  => 'تحذير: لم يتم حذف قاعدة الكتالوج',
                ],

                'sitemaps' => [
                    'delete-success' => 'تم حذف خريطة الموقع بنجاح',
                    'delete-failed'  => 'تحذير: لم يتم حذف خريطة الموقع',
                ],
            ],

            'sitemaps' => [
                'delete-success' => 'تم حذف خريطة الموقع بنجاح',
                'delete-failed'  => 'تحذير: لم يتم حذف خريطة الموقع',
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'title'                           => 'واجهة برمجة التطبيقات GraphQL',
                        'info'                            => 'إعدادات ذات صلة بالإشعارات',
                        'push-notification-configuration' => 'تكوين إشعار الدفع FCM',
                        'server-key'                      => 'مفتاح الخادم',
                        'info-get-server-key'             => 'معلومات: للحصول على بيانات اعتماد FCM API: <a href="https://console.firebase.google.com/" target="_blank">انقر هنا</a>',
                        'android-topic'                   => 'موضوع Android',
                        'ios-topic'                       => 'موضوع IOS',
                        'private-key'                     => 'محتوى ملف المفتاح الخاص JSON',
                        'info-get-private-key'            => 'معلومات: للحصول على محتوى ملف المفتاح الخاص JSON لـ FCM: <a href="https://console.firebase.google.com/" target="_blank">انقر هنا</a>',
                        'notification-topic'              => 'موضوع الإشعار',
                    ],
                ],
            ],

            'custom-scripts' => [
                'channel-not-found' => 'تحذير: القناة غير موجودة.',
                'create-success'    => 'تمت إضافة النص المخصص بنجاح.',
                'update-success'    => 'تم تحديث النص المخصص بنجاح.',
                'delete-success'    => 'تمت إزالة النص المخصص بنجاح.',
            ],
        ],

        'settings' => [
            'locales' => [
                'last-delete-error' => 'فشل حذف آخر لغة',
                'delete-success'    => 'تم حذف اللغة بنجاح.',
                'delete-error'      => 'فشل حذف اللغة.',
                'not-found'         => 'تحذير: اللغة غير موجودة.',
            ],

            'currencies' => [
                'last-delete-error' => 'فشل حذف آخر عملة',
                'delete-success'    => 'تم حذف العملة بنجاح.',
                'delete-error'      => 'فشل حذف العملة.',
                'not-found'         => 'تحذير: العملة غير موجودة.',
            ],

            'exchange-rates' => [
                'invalid-target-currency' => 'تحذير: العملة المستهدفة غير صالحة.',
                'delete-success'          => 'تم حذف سعر الصرف بنجاح.',
                'last-delete-error'       => 'فشل حذف آخر سعر صرف',
                'delete-error'            => 'فشل حذف سعر الصرف.',
                'not-found'               => 'تحذير: سعر الصرف غير موجود.',
            ],

            'inventory-sources' => [
                'last-delete-error' => 'فشل حذف آخر مصدر مخزون',
                'delete-success'    => 'تم حذف مصدر المخزون بنجاح.',
                'delete-error'      => 'فشل حذف مصدر المخزون.',
                'not-found'         => 'تحذير: مصدر المخزون غير موجود.',
            ],

            'channels' => [
                'last-delete-error' => 'فشل حذف آخر قناة',
                'delete-success'    => 'تم حذف القناة بنجاح.',
                'delete-error'      => 'فشل حذف القناة.',
                'not-found'         => 'تحذير: القناة غير موجودة.',
            ],

            'users' => [
                'login-error'       => 'يرجى التحقق من بيانات الاعتماد الخاصة بك والمحاولة مرة أخرى.',
                'activate-warning'  => 'حسابك لم يتم تنشيطه بعد ، يرجى الاتصال بالمسؤول.',
                'success-login'     => 'تم تسجيل الدخول بنجاح.',
                'success-logout'    => 'تم تسجيل الخروج بنجاح.',
                'last-delete-error' => 'فشل حذف آخر مستخدم',
                'delete-success'    => 'تم حذف المستخدم بنجاح.',
                'delete-error'      => 'فشل حذف المستخدم.',
                'create-success'    => 'تم إنشاء المستخدم بنجاح.',
                'not-found'         => 'تحذير: المستخدم غير موجود.',
            ],

            'roles' => [
                'last-delete-error' => 'فشل حذف آخر دور',
                'delete-success'    => 'تم حذف الدور بنجاح.',
                'delete-error'      => 'فشل حذف الدور.',
                'not-found'         => 'تحذير: الدور غير موجود.',
            ],

            'themes' => [
                'delete-success' => 'تم حذف السمة بنجاح.',
                'not-found'      => 'تحذير: السمة غير موجودة.',
            ],

            'tax-rate' => [
                'delete-success' => 'تم حذف معدل الضريبة بنجاح.',
                'delete-error'   => 'فشل حذف معدل الضريبة.',
                'not-found'      => 'تحذير: معدل الضريبة غير موجود.',
            ],

            'tax-category' => [
                'delete-success'     => 'تم حذف فئة الضريبة بنجاح.',
                'delete-error'       => 'فشل حذف فئة الضريبة.',
                'not-found'          => 'تحذير: فئة الضريبة غير موجودة.',
                'tax-rate-not-found' => 'المعرفات المعطاة غير موجودة. المعرفات: - :ids',
            ],

            'notification' => [
                'index' => [
                    'title'     => 'إشعار الدفع',
                    'add-title' => 'إضافة إشعار',
                    'general'   => 'عام',

                    'datagrid' => [
                        'id'                   => 'المعرف',
                        'image'                => 'الصورة',
                        'text-title'           => 'العنوان',
                        'notification-content' => 'محتوى الإشعار',
                        'notification-type'    => 'نوع الإشعار',
                        'notification-status'  => 'حالة الإشعار',
                        'created-at'           => 'وقت الإنشاء',
                        'updated-at'           => 'وقت التحديث',
                        'delete'               => 'حذف',
                        'update'               => 'تحديث',
                        'store-view'           => 'القنوات',

                        'status' => [
                            'enabled'  => 'مفعل',
                            'disabled' => 'معطل',
                        ],
                    ],
                ],

                'create' => [
                    'new-notification'     => 'إشعار جديد',
                    'back-btn'             => 'رجوع',
                    'create-btn-title'     => 'حفظ الإشعار',
                    'general'              => 'عام',
                    'title'                => 'إشعار الدفع',
                    'content-and-image'    => 'محتوى الإشعار والصورة',
                    'notification-content' => 'محتوى الإشعار',
                    'image'                => 'الصورة',
                    'settings'             => 'الإعدادات',
                    'status'               => 'الحالة',
                    'store-view'           => 'القنوات',
                    'notification-type'    => 'نوع الإشعار',
                    'product-cat-id'       => 'معرف المنتج / الفئة',

                    'option-type' => [
                        'others'   => 'بسيط',
                        'product'  => 'منتج',
                        'category' => 'فئة',
                    ],
                ],

                'edit' => [
                    'edit-notification'    => 'تعديل الإشعار',
                    'back-btn'             => 'رجوع',
                    'send-title'           => 'إرسال الإشعار',
                    'update-btn-title'     => 'تحديث',
                    'general'              => 'عام',
                    'title'                => 'إشعار الدفع',
                    'content-and-image'    => 'محتوى الإشعار والصورة',
                    'notification-content' => 'محتوى الإشعار',
                    'image'                => 'الصورة',
                    'settings'             => 'الإعدادات',
                    'status'               => 'الحالة',
                    'store-view'           => 'القنوات',
                    'notification-type'    => 'نوع الإشعار',
                    'product-cat-id'       => 'معرف المنتج / الفئة',

                    'option-type' => [
                        'others'   => 'بسيط',
                        'product'  => 'منتج',
                        'category' => 'فئة',
                    ],
                ],
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'تحذير: تم توفير معلمات غير صالحة.',
                'no-login-user'     => 'تحذير: لم يتم العثور على مستخدم مسجل الدخول.',
            ],
        ],

        'alerts' => [
            'notifications' => [
                'create-success'      => 'تم إنشاء الإشعارات بنجاح',
                'update-success'      => 'تم تحديث الإشعارات بنجاح',
                'delete-success'      => 'تم حذف الإشعارات بنجاح',
                'delete-failed'       => 'فشل حذف الإشعارات',
                'sended-successfully' => 'تم إرسال الإشعارات بنجاح لنظامي التشغيل Android و iOS.',
                'no-value-selected'   => 'لا توجد قيمة محددة',
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => 'تم حفظ عنوان السلة بنجاح.',
            'error-payment-selection'   => 'تحذير: هناك خطأ في استرداد طرق الدفع.',
            'selected-shipment'         => 'تم اختيار الشحن بنجاح.',
            'warning-empty-cart'        => 'تحذير: لا توجد منتجات مضافة إلى السلة.',
            'billing-address-missing'   => 'تحذير: عنوان الفوترة مفقود لإتمام الشراء.',
            'shipping-address-missing'  => 'تحذير: عنوان الشحن مفقود لإتمام الشراء.',
            'invalid-guest-access'      => 'تحذير: العملاء الزائرين غير مسموح لهم بالحصول على العناوين باستخدام معرف عنوان الفوترة / الشحن.',
            'guest-address-warning'     => 'تحذير: إذا كنت تحاول كضيف، فيرجى المحاولة بدون رمز مصادقة.',
            'wrong-error'               => 'تحذير: هناك خطأ في سلة التسوق الخاصة بك، يرجى المحاولة مرة أخرى.',
            'no-billing-address-found'  => 'تحذير: لم يتم العثور على سجل عنوان الفوترة بمعرف الفوترة :address_id.',
            'no-shipping-address-found' => 'تحذير: لم يتم العثور على سجل عنوان الشحن بمعرف الشحن :address_id.',
            'error-invalid-parameter'   => 'تحذير: تم توفير معلمات غير صالحة.',
            'already-applied'           => 'تم تطبيق رمز الكوبون بالفعل.',
            'success-apply'             => 'تم تطبيق رمز الكوبون بنجاح.',
            'coupon-removed'            => 'تمت إزالة الكوبون من السلة بنجاح.',
            'coupon-remove-failed'      => 'تحذير: هناك بعض الأخطاء في إزالة الكوبون من السلة أو الكوبون غير موجود.',
            'error-placing-order'       => 'تحذير: هناك خطأ في تقديم الطلب.',
            'selected-payment'          => 'تم اختيار طريقة الدفع بنجاح.',
            'error-payment-save'        => 'تحذير: هناك خطأ في حفظ طريقة الدفع.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'تمت إزالة جميع العناصر من السلة بنجاح.',
                    'fail-all-remove'          => 'خطأ في إزالة العناصر من السلة.',
                    'error-invalid-parameter'  => 'تحذير: تم توفير معلمات غير صالحة.',
                    'success-moved-cart-item'  => 'تم نقل عنصر السلة إلى قائمة الرغبات بنجاح.',
                    'fail-moved-cart-item'     => 'فشل: لم يتم نقل عنصر السلة إلى قائمة الرغبات.',
                    'success-add-to-cart'      => 'تمت إضافة المنتج إلى السلة بنجاح.',
                    'fail-add-to-cart'         => 'فشل: لم يتم إضافة المنتج إلى السلة.',
                    'success-update-to-cart'   => 'تم تحديث عنصر السلة بنجاح.',
                    'fail-update-to-cart'      => 'فشل: لم يتم تحديث عنصر السلة.',
                    'success-delete-cart-item' => 'تمت إزالة عنصر السلة بنجاح.',
                    'fail-delete-cart-item'    => 'فشل: لم يتم العثور على عنصر السلة.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'تم تسجيل الدخول بنجاح: تم تسجيل العميل بنجاح.',
            'success-logout'        => 'تم تسجيل الخروج بنجاح: تم تسجيل العميل الخروج بنجاح.',
            'no-login-customer'     => 'تحذير: لم يتم العثور على عميل مسجل الدخول.',
            'address-list'          => 'تم استرداد تفاصيل عنوان العميل بنجاح.',
            'not-authorized'        => 'تحذير: ليس لديك الصلاحية لتحديث هذا العنوان.',
            'no-address-list'       => 'تحذير: لم يتم العثور على عناوين العميل.',
            'text-password'         => 'كلمة المرور الخاصة بك هي: :password',
            'not-exists'            => 'تحذير: لم يتم العثور على عميل للبيانات المقدمة.',
            'success-address-list'  => 'تم استرداد عناوين العميل بنجاح.',
            'reset-link-sent'       => 'تم إرسال رابط إعادة تعيين كلمة المرور بنجاح.',
            'password-reset-failed' => 'تحذير: لقد أرسلنا بالفعل لك بريدًا إلكترونيًا لإعادة تعيين كلمة المرور، حاول مرة أخرى بعد فترة من الوقت.',
            'no-login-user'         => 'تحذير: لم يتم العثور على مستخدم مسجل الدخول.',
            'customer-details'      => 'تم استرداد تفاصيل العميل بنجاح.',

            'account' => [
                'not-found' => 'تحذير: لم يتم العثور على :name.',

                'profile' => [
                    'edit-success'   => 'تم تحديث الملف الشخصي بنجاح.',
                    'edit-fail'      => 'فشل تحديث الملف الشخصي.',
                    'unmatch'        => 'كلمة المرور القديمة غير متطابقة.',
                    'order-pending'  => 'لا يمكن حذف حساب العميل لأن بعض الطلبات قيد الانتظار أو في حالة معالجة.',
                    'delete-success' => 'تم حذف العميل بنجاح.',
                    'wrong-password' => 'كلمة المرور خاطئة!',
                ],

                'order' => [
                    'no-order-found' => 'تحذير: لم يتم العثور على أي طلب.',
                    'cancel-success' => 'تم إلغاء الطلب بنجاح.',
                ],

                'review' => [
                    'success'        => 'تم إرسال المراجعة بنجاح، يرجى الانتظار للموافقة.',
                    'success-delete' => 'تم حذف المراجعة بنجاح.',
                    'not-found'      => 'لم يتم العثور على المراجعة.',
                ],

                'wishlist' => [
                    'removed'            => 'تمت إزالة العنصر بنجاح من قائمة الرغبات.',
                    'remove-fail'        => 'لا يمكن إزالة العنصر من قائمة الرغبات.',
                    'remove-all-success' => 'تمت إزالة جميع العناصر من قائمة الرغبات الخاصة بك.',
                    'success'            => 'تمت إضافة العنصر بنجاح إلى قائمة الرغبات.',
                    'already-exist'      => 'المنتج موجود بالفعل في قائمة الرغبات.',
                    'move-to-cart'       => 'انتقل إلى السلة',
                    'moved-success'      => 'تم نقل العنصر بنجاح إلى السلة.',
                    'error-move-to-cart' => 'تحذير: قد يحتوي هذا المنتج على بعض الخيارات المطلوبة، ولا يمكن نقله إلى السلة.',
                    'no-item-found'      => 'تحذير: لا يوجد منتج موجود.',
                ],

                'addressess' => [
                    'delete-success' => 'تم حذف عنوان العميل بنجاح.',
                ],
            ],

            'signup-form' => [
                'error-registration'       => 'تحذير: فشل تسجيل العميل.',
                'warning-num-already-used' => 'تحذير: تم تسجيل هذا الرقم :phone باستخدام عنوان بريد إلكتروني مختلف.',
                'success-verify'           => 'تم إنشاء الحساب بنجاح، تم إرسال بريد إلكتروني للتحقق.',
                'invalid-creds'            => 'يرجى التحقق من بيانات الاعتماد الخاصة بك والمحاولة مرة أخرى.',

                'validation' => [
                    'unique'   => 'تم استخدام هذا :field بالفعل.',
                    'required' => 'حقل :field مطلوب.',
                    'same'     => 'يجب أن تتطابق :field وكلمة المرور.',
                ],
            ],

            'login-form' => [
                'not-activated' => 'تحتاج تنشيطك إلى موافقة المشرف',
                'invalid-creds' => 'يرجى التحقق من بيانات الاعتماد الخاصة بك والمحاولة مرة أخرى.',
            ],
        ],

        'response' => [
            'error-invalid-parameter' => 'تحذير: تم توفير معلمات غير صالحة.',
            'invalid-header'          => 'تحذير: رمز رأس غير صالح.',
            'cancel-error'            => 'لا يمكن إلغاء الطلب.',
        ],
    ],
];
