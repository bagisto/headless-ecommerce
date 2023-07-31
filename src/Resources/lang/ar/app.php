<?php

return [
    'admin'     => [
        'menu'  => [
            'push-notification' => 'إرسال التنبيهات',
        ],

        'acl'  => [
            'push-notification' => 'إرسال التنبيهات',
            'send'              => 'إرسال',
        ],

        'system' => [
            'graphql-api'                       => 'واجهة برمجة تطبيقات GraphQL',
            'push-notification-configuration'   => 'إعدادات إرسال التنبيهات عبر FCM',
            'server-key'                        => 'مفتاح الخادم',
            'info-get-server-key'               => 'معلومات: للحصول على بيانات اعتماد FCM API: <a href="https://console.firebase.google.com/" target="_blank">انقر هنا</a>',
            'android-topic'                     => 'موضوع Android',
            'ios-topic'                         => 'موضوع iOS',
        ],

        'notification'  => [
            'title'                 => 'إرسال التنبيهات',
            'add-title'             => 'إضافة تنبيه',
            'general'               => 'عام',

            'id'                    => 'المعرف',
            'image'                 => 'الصورة',
            'text-title'            => 'العنوان',
            'edit-notification'     => 'تعديل التنبيه',
            'manage'                => 'التنبيهات',
            'new-notification'      => 'تنبيه جديد',
            'create-btn-title'      => 'حفظ التنبيه',
            'notification-image'    => 'صورة التنبيه',
            'notification-title'    => 'عنوان التنبيه',
            'notification-content'  => 'محتوى التنبيه',
            'notification-type'     => 'نوع التنبيه',
            'product-cat-id'        => 'معرف المنتج/الفئة',
            'store-view'            => 'القنوات',
            'notification-status'   => 'حالة التنبيه',
            'created'               => 'تم الإنشاء',
            'modified'              => 'تم التعديل',
            'collection-autocomplete'   => 'مجموعة مخصصة - (إكمال تلقائي)',
            'no-collection-found'       => 'لم يتم العثور على مجموعات بها نفس الاسم.',
            'collection-search-hint'    => 'ابدأ الكتابة للبحث عن اسم المجموعة',
            
            'Action'    => [
                'edit'      => 'تعديل',
            ],

            'status'    => [
                'enabled'   => 'مُمكّن',
                'disabled'  => 'مُعطّل',
            ],

            'notification-type-option'  => [
                'select'            => '-- اختر --',
                'simple'            => 'نوع بسيط',
                'product'           => 'بناءً على المنتج',
                'category'          => 'بناءً على الفئة',
            ],
        ],

        'alert' => [
            'create-success'        => 'تم إنشاء :name بنجاح',
            'update-success'        => 'تم تحديث :name بنجاح',
            'delete-success'        => 'تم حذف :name بنجاح',
            'delete-failed'         => 'فشل حذف :name',
            'sended-successfully'   => 'تمت إرسال :name بنجاح لنظام Android ونظام iOS.',
            'no-value-selected'     => 'لا توجد قيمة موجودة',
        ],

        'settings'   => [
            'exchange_rates' => [
                'error-invalid-target-currency' => 'تحذير: توفر عملة هدف غير صالحة.',
                'delete-success'        => 'نجاح: تم حذف سعر الصرف بنجاح.',
            ]
        ],
        
        'response'  => [
            'error-invalid-parameter'   => 'تحذير: توفر معلمات غير صالحة.',
            'success-login'             => 'نجاح: تم تسجيل دخول المستخدم بنجاح.',
            'error-login'               => 'تحذير: مستخدم المسؤول غير مسجل دخوله.',
            'session-expired'           => 'تحذير: انتهت صلاحية الجلسة. يرجى تسجيل الدخول مرة أخرى إلى حسابك.',
            'invalid-header'            => 'تحذير: رمز رأس غير صالح.',
            'success-logout'            => 'نجاح: تم تسجيل خروج المستخدم بنجاح.',
            'no-login-user'             => 'تحذير: لم يتم العثور على مستخدم مسجل دخوله.',
            'error-customer-group'      => 'تحذير: ليس لديك صلاحية لحذف مجموعة السمات التي تم إنشاؤها بواسطة النظام.',
            'password-invalid'          => 'تحذير: يرجى إدخال كلمة المرور الصحيحة.',
            'password-match'            => 'تحذير: كلمات المرور غير متطابقة.',
            'success-registered'        => 'نجاح: تم إنشاء المستخدم بنجاح.',
            'cancel-error'              => 'لا يمكن إلغاء الطلب.',
            'creation-error'            => 'لا يمكن إنشاء استرداد لهذا الطلب.',
            'channel-failure'           => 'القناة غير موجودة.',
            'script-delete-success'     => 'تم حذف النص بنجاح.'
        ]
    ],

    'shop'  => [
        'customer'  => [
            'success-login'         => 'نجاح: تم تسجيل دخول العميل بنجاح.',
            'success-logout'        => 'نجاح: تم تسجيل خروج العميل بنجاح.',
            'no-login-customer'     => 'تحذير: لم يتم العثور على عميل مسجل دخوله.',
            'address-list'          => 'نجاح: تم جلب تفاصيل عناوين العميل بنجاح',
            'not-authorized'        => 'تحذير: ليس لديك الصلاحية لتحديث هذا العنوان.',
            'success-address-list'  => 'نجاح: تم جلب عناوين العميل بنجاح.',
            'no-address-list'       => 'تحذير: لم يتم العثور على عناوين العميل.',
            'text-password'         => 'كلمة المرور الخاصة بك هي: :password',
            'not-exists'            => 'تحذير: لم يتم العثور على عميل بناءً على البيانات المقدمة.',
        ],
        'response'  => [
            'error-registration'        => 'تحذير: فشل تسجيل العميل.',
            'password-reset-failed'     => 'تحذير: لقد أرسلنا بالفعل بريدًا إلكترونيًا لإعادة تعيين كلمة المرور، حاول بعد فترة من الزمن.',
            'customer-details'          => 'نجاح: تم جلب تفاصيل العميل بنجاح.',
            'not-found'                 => 'تحذير: لم يتم العثور على :name.',
            'no-address-found'          => 'تحذير: لم يتم العثور على عنوان.',
            'no-order-found'            => 'تحذير: لم يتم العثور على طلب.',
            'warning-empty-cart'        => 'تحذير: لا يوجد منتج مضاف إلى السلة.',
            'success-add-to-cart'       => 'نجاح: تمت إضافة المنتج إلى السلة بنجاح.',
            'success-update-to-cart'    => 'نجاح: تم تحديث عنصر السلة بنجاح.',
            'success-delete-cart-item'  => 'نجاح: تمت إزالة عنصر السلة بنجاح.',
            'success-moved-cart-item'   => 'نجاح: تم نقل عنصر السلة إلى قائمة الأماني بنجاح.',
            'billing-address-missing'   => 'تحذير: العنوان الفوترة مفقود لإتمام الشراء.',
            'shipping-address-missing'  => 'تحذير: العنوان التسليم مفقود لإتمام الشراء.',
            'invalid-address'           => 'تحذير: لم يتم العثور على عنوان بناءً على معرف العنوان المقدم.',
            'wrong-error'               => 'تحذير: هناك خطأ في سلة التسوق الخاصة بك، حاول مرة أخرى.',
            'save-cart-address'         => 'نجاح: تم حفظ عنوان السلة بنجاح.',
            'error-payment-selection'   => 'تحذير: هناك خطأ في جلب طرق الدفع.',
            'selected-shipment'         => 'نجاح: تم اختيار الشحنة بنجاح.',
            'error-payment-save'        => 'تحذير: هناك خطأ في حفظ طريقة الدفع.',
            'selected-payment'          => 'نجاح: تم اختيار طريقة الدفع بنجاح.',
            'error-placing-order'       => 'تحذير: هناك خطأ في تقديم الطلب.',
            'invalid-product'           => 'تحذير: أنت تطلب منتج غير صالح.',
            'already-exist-inwishlist'  => 'معلومات: هذا المنتج موجود بالفعل في قائمة الأماني.',
            'error-move-to-cart'        => 'تحذير: قد يكون لهذا المنتج بعض الخيارات المطلوبة، لا يمكن نقله إلى السلة.',
            'no-billing-address-found'  => 'تحذير: لم يتم العثور على سجل عنوان الفوترة بمعرف الفوترة :address_id.',
            'no-shipping-address-found'  => 'تحذير: لم يتم العثور على سجل عنوان الشحن بمعرف الشحن :address_id.',
            'invalid-guest-access'      => 'تحذير: غير مسموح للعملاء الضيوف بالحصول على العناوين باستخدام معرف عنوان الفوترة / الشحن.',
            'guest-address-warning'     => 'تحذير: إذا كنت تحاول كضيف، فجرب بدون الرمز المميز للتفويض.',
            'warning-num-already-used'  => 'تحذير: تم تسجيل هذا الرقم :phone باستخدام عنوان بريد إلكتروني مختلف.',
            'coupon-removed'            => 'نجاح: تمت إزالة القسيمة من السلة بنجاح.',
            'coupon-remove-failed'      => 'تحذير: هناك بعض الأخطاء في إزالة القسيمة من السلة أو لم يتم العثور على القسيمة.',
            'review-create-success'     => 'نجاح: تم إرسال المراجعة بنجاح، يرجى الانتظار للموافقة.',
            'un-authorized-access'     => 'Warning: You are not authorized to use this section.',
        ]
    ],
    
    'validation' => [
        'unique'    => 'هذا :field مأخوذ بالفعل.',
        'required'  => 'حقل :field مطلوب.',
        'same'      => 'يجب أن يتطابق :field وكلمة المرور.'
    ],
    
    'mail' => [
        'customer'  => [
            'password' => [
                'heading'   => 'إعادة تعيين كلمة المرور - ' . config('app.name'),
                'reset'     => 'رسالة إعادة تعيين كلمة المرور',
                'summary' => 'تتعلق هذه الرسالة بإعادة تعيين كلمة المرور لحسابك، تم تغيير كلمة المرور بنجاح.
                يرجى تسجيل الدخول إلى حسابك باستخدام كلمة المرور المذكورة أدناه.',
            ]
        ]
    ]
];