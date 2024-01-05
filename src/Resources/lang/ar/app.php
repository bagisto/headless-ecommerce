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

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'title'                           => 'واجهة برمجة التطبيقات GraphQL',
                        'info'                            => 'تكوينات ذات صلة بالإشعارات',
                        'push-notification-configuration' => 'تكوين إشعار FCM للدفع',
                        'server-key'                      => 'مفتاح الخادم',
                        'info-get-server-key'             => 'معلومات: للحصول على بيانات اعتماد API FCM: <a href="https://console.firebase.google.com/" target="_blank">انقر هنا</a>',
                        'android-topic'                   => 'موضوع Android',
                        'ios-topic'                       => 'موضوع iOS',
                    ],
                ],
            ],
        ],

        'settings' => [
            'notification' => [
                'index' => [
                    'title'               => 'إشعار الدفع',
                    'add-title'           => 'إضافة إشعار',
                    'delete-success'      => 'تم حذف الإشعار بنجاح',
                    'mass-update-success' => 'تم تحديث الإشعارات المحددة بنجاح',
                    'mass-delete-success' => 'تم حذف الإشعارات المحددة بنجاح',

                    'datagrid' => [
                        'id'                   => 'الرقم التعريفي',
                        'image'                => 'صورة',
                        'text-title'           => 'العنوان',
                        'notification-content' => 'محتوى الإشعار',
                        'notification-type'    => 'نوع الإشعار',
                        'store-view'           => 'القنوات',
                        'notification-status'  => 'حالة الإشعار',
                        'created-at'           => 'وقت الإنشاء',
                        'updated-at'           => 'وقت التحديث',
                        'delete'               => 'حذف',
                        'update'               => 'تحديث',

                        'status' => [
                            'enabled'  => 'مُمكّن',
                            'disabled' => 'مُعطّل',
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
                    'image'                => 'صورة',
                    'settings'             => 'الإعدادات',
                    'status'               => 'الحالة',
                    'store-view'           => 'القنوات',
                    'notification-type'    => 'نوع الإشعار',
                    'product-cat-id'       => 'هوية المنتج / الفئة',
                    'success'              => 'تم إنشاء الإشعار بنجاح',

                    'option-type' => [
                        'others'   => 'بسيط',
                        'product'  => 'منتج',
                        'category' => 'فئة',
                    ],
                ],

                'edit' => [
                    'edit-notification'         => 'تعديل الإشعار',
                    'back-btn'                  => 'رجوع',
                    'send-title'                => 'إرسال الإشعار',
                    'update-btn-title'          => 'تحديث الإشعار',
                    'general'                   => 'عام',
                    'title'                     => 'إشعار الدفع',
                    'content-and-image'         => 'محتوى الإشعار والصورة',
                    'notification-content'      => 'محتوى الإشعار',
                    'image'                     => 'صورة',
                    'settings'                  => 'الإعدادات',
                    'status'                    => 'الحالة',
                    'store-view'                => 'القنوات',
                    'notification-type'         => 'نوع الإشعار',
                    'product-cat-id'            => 'هوية المنتج / الفئة',
                    'success'                   => 'تم تحديث الإشعار بنجاح',
                    'notification-send-success' => 'تم إرسال الإشعار بنجاح لنظامي Android و iOS.',

                    'option-type' => [
                        'others'   => 'بسيط',
                        'product'  => 'منتج',
                        'category' => 'فئة'
                    ],
                ],
            ],

            'exchange_rates' => [
                'error-invalid-target-currency' => 'تحذير: العملة المستهدفة غير صالحة.',
                'delete-success'                => 'نجاح: تم حذف سعر الصرف بنجاح.',
            ],
        ],

        'customer' => [
            'no-customer-found' => 'لم يتم العثور على عميل',
        ],

        'response' => [
            'delete-success'          => 'نجاح: تم حذف المستخدم بنجاح.',
            'last-delete-error'       => 'تحذير: يجب أن يكون هناك مستخدم واحد على الأقل',
            'delete-failed'           => 'تحذير: لم يتم حذف مستخدم الإدارة',
            'error-invalid-parameter' => 'تحذير: تم توفير معلمات غير صالحة.',
            'success-login'           => 'نجاح: تم تسجيل دخول المستخدم بنجاح.',
            'error-login'             => 'تحذير: مستخدم الإدارة غير مسجل الدخول.',
            'session-expired'         => 'تحذير: انتهت الجلسة. يرجى تسجيل الدخول مرة أخرى إلى حسابك.',
            'invalid-header'          => 'تحذير: رمز العنوان غير صالح.',
            'success-logout'          => 'نجاح: تم تسجيل خروج المستخدم بنجاح.',
            'no-login-user'           => 'تحذير: لم يتم العثور على مستخدم مسجل الدخول.',
            'error-customer-group'    => 'تحذير: ليس لديك الإذن لحذف مجموعة السمات التي تم إنشاؤها من النظام.',
            'password-invalid'        => 'تحذير: يرجى إدخال كلمة مرور صحيحة.',
            'password-match'          => 'تحذير: كلمات المرور غير متطابقة.',
            'success-registered'      => 'نجاح: تم إنشاء المستخدم بنجاح.',
            'cancel-error'            => 'تحذير: لا يمكن إلغاء الطلب.',
            'creation-error'          => 'تحذير: لا يمكن إنشاء استرداد لهذا الطلب.',
            'channel-failure'         => 'القناة غير موجودة.',
            'script-delete-success'   => 'تم حذف النص بنجاح.',
        ],

        'shop' => [
            'response' => [
                'no-address-found'         => 'تحذير: لا يوجد عنوان.',
                'invalid-address'          => 'تحذير: لا يوجد عنوان للهوية المقدمة.',
                'invalid-product'          => 'تحذير: أنت تطلب منتجًا غير صالح.',
                'already-exist-inwishlist' => 'معلومات: هذا المنتج موجود بالفعل في قائمة الأماني.',
                'un-authorized-access'     => 'تحذير: ليس لديك الإذن لاستخدام هذا القسم.',
            ],

            'validation' => [
                'unique'   => 'تم اتخاذ :field هذا بالفعل.',
                'required' => 'حقل :field مطلوب.',
                'same'     => 'يجب أن تتطابق :field مع كلمة المرور.',
            ],

            'mail' => [
                'customer' => [
                    'password' => [
                        'heading' => config('app.name') . ' - إعادة تعيين كلمة المرور',
                        'reset'   => 'بريد إلكتروني لإعادة تعيين كلمة المرور',
                        'summary' => 'هذا البريد الإلكتروني متعلق بإعادة تعيين كلمة مرور حسابك. تم تغيير كلمة المرور الخاصة بك بنجاح.
                        يرجى تسجيل الدخول إلى حسابك باستخدام كلمة المرور المذكورة أدناه.',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => 'نجاح: تم حفظ عنوان السلة بنجاح.',
            'error-payment-selection'   => 'تحذير: هناك خطأ في جلب طرق الدفع.',
            'selected-shipment'         => 'نجاح: تم اختيار الشحن بنجاح.',
            'warning-empty-cart'        => 'تحذير: لا توجد منتجات مضافة إلى السلة.',
            'billing-address-missing'   => 'تحذير: عنوان الفواتير مفقود للدفع.',
            'shipping-address-missing'  => 'تحذير: عنوان الشحن مفقود للدفع.',
            'invalid-guest-access'      => 'تحذير: لا يُسمح للعملاء الضيوف بالحصول على العناوين باستخدام معرف العنوان للفواتير/الشحن.',
            'guest-address-warning'     => 'تحذير: إذا كنت تحاول كضيف، جرب بدون رمز التفويض.',
            'wrong-error'               => 'تحذير: هناك خطأ في سلة التسوق، حاول مرة أخرى.',
            'no-billing-address-found'  => 'تحذير: لم يتم العثور على سجل عنوان الفواتير بمعرف الفاتورة :address_id.',
            'no-shipping-address-found' => 'تحذير: لم يتم العثور على سجل عنوان الشحن بمعرف الشحن :address_id.',
            'error-invalid-parameter'   => 'تحذير: توجد معلمات غير صالحة.',
            'already-applied'           => 'تم تطبيق رمز الكوبون بالفعل.',
            'success-apply'             => 'تم تطبيق رمز الكوبون بنجاح.',
            'coupon-removed'            => 'نجاح: تمت إزالة الكوبون من السلة بنجاح.',
            'coupon-remove-failed'      => 'تحذير: هناك بعض الأخطاء في إزالة الكوبون من السلة أو الكوبون غير موجود.',
            'error-placing-order'       => 'تحذير: هناك خطأ في تقديم الطلب.',
            'selected-payment'          => 'نجاح: تم اختيار طريقة الدفع بنجاح.',
            'error-payment-save'        => 'تحذير: هناك خطأ في حفظ طريقة الدفع.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'تمت إزالة جميع العناصر بنجاح من السلة.',
                    'fail-all-remove'          => 'خطأ في إزالة العناصر من السلة.',
                    'error-invalid-parameter'  => 'تحذير: توجد معلمات غير صالحة.',
                    'success-moved-cart-item'  => 'نجاح: تم نقل عنصر السلة إلى قائمة الأمنيات بنجاح.',
                    'fail-moved-cart-item'     => 'فشل: لم يتم نقل عنصر السلة إلى قائمة الأمنيات.',
                    'success-add-to-cart'      => 'نجاح: تمت إضافة المنتج إلى السلة بنجاح.',
                    'fail-add-to-cart'         => 'فشل: لم يتم إضافة المنتج إلى السلة.',
                    'success-update-to-cart'   => 'نجاح: تم تحديث عنصر السلة بنجاح.',
                    'fail-update-to-cart'      => 'فشل: لم يتم تحديث عنصر السلة.',
                    'success-delete-cart-item' => 'نجاح: تم حذف عنصر السلة بنجاح.',
                    'fail-delete-cart-item'    => 'فشل: لم يتم العثور على عنصر السلة.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'نجاح: تسجيل دخول العميل بنجاح.',
            'success-logout'        => 'نجاح: تسجيل خروج العميل بنجاح.',
            'no-login-customer'     => 'تحذير: لم يتم العثور على عميل مسجّل.',
            'address-list'          => 'نجاح: جلب تفاصيل عناوين العميل.',
            'not-authorized'        => 'تحذير: ليس لديك الإذن لتحديث هذا العنوان.',
            'no-address-list'       => 'تحذير: لم يتم العثور على عناوين للعميل.',
            'text-password'         => 'كلمة المرور الخاصة بك هي: :password',
            'not-exists'            => 'تحذير: لم يتم العثور على عميل باستخدام البيانات المقدمة.',
            'success-address-list'  => 'نجاح: جلب عناوين العميل بنجاح.',
            'reset-link-sent'       => 'نجاح: تم إرسال بريد إلكتروني لإعادة تعيين كلمة المرور بنجاح.',
            'password-reset-failed' => 'تحذير: لقد قمنا بإرسال بريد إلكتروني لإعادة تعيين كلمة المرور بالفعل، حاول مرة أخرى بعد فترة من الزمن.',
            'no-login-user'         => 'تحذير: لم يتم العثور على مستخدم مسجّل.',
            'customer-details'      => 'نجاح: جلب تفاصيل العميل بنجاح.',

            'account' => [
                'not-found' => 'تحذير: لم يتم العثور على :name.',

                'profile' => [
                    'edit-success'   => 'تم تحديث الملف الشخصي بنجاح',
                    'edit-fail'      => 'لم يتم تحديث الملف الشخصي',
                    'unmatch'        => 'كلمة المرور القديمة غير متطابقة.',
                    'order-pending'  => 'لا يمكن حذف حساب العميل لأن بعض الطلبات قيد الانتظار أو في حالة معالجة.',
                    'delete-success' => 'تم حذف العميل بنجاح',
                    'wrong-password' => 'كلمة المرور خاطئة!',
                ],

                'order' => [
                    'no-order-found' => 'تحذير: لا يوجد أمر موجود.',
                    'cancel-success' => 'تم إلغاء الطلب بنجاح',
                ],

                'review' => [
                    'success' => 'نجاح: تم إرسال المراجعة بنجاح، يرجى الانتظار للموافقة عليها.',
                ],

                'wishlist' => [
                    'removed'            => 'تمت إزالة العنصر بنجاح من قائمة الرغبات',
                    'remove-fail'        => 'لا يمكن إزالة العنصر من قائمة الرغبات',
                    'remove-all-success' => 'تمت إزالة جميع العناصر من قائمة الرغبات الخاصة بك',
                    'success'            => 'تمت إضافة العنصر بنجاح إلى قائمة الرغبات',
                    'already-exist'      => 'المنتج موجود بالفعل في قائمة الرغبات',
                    'move-to-cart'       => 'انتقال إلى السلة',
                    'moved-success'      => 'تم نقل العنصر بنجاح إلى السلة',
                    'error-move-to-cart' => 'تحذير: قد يحتوي هذا المنتج على بعض الخيارات المطلوبة، لا يمكن نقله إلى السلة.',
                    'no-item-found'      => 'تحذير: لا يوجد منتجات موجودة.',
                ],

                'addressess' => [
                    'delete-success' => 'تم حذف عنوان العميل بنجاح',
                ]
            ],

            'signup-form' => [
                'error-registration'       => 'تحذير: فشل تسجيل العميل.',
                'warning-num-already-used' => 'تحذير: تم تسجيل هذا :phone الهاتف باستخدام عنوان بريد إلكتروني مختلف.',
                'success-verify'           => 'تم إنشاء الحساب بنجاح، تم إرسال بريد إلكتروني للتحقق.',
                'invalid-creds'            => 'يرجى التحقق من بيانات الاعتماد الخاصة بك والمحاولة مرة أخرى.',

                'validation' => [
                    'unique'   => 'هذا :field تم أخذه بالفعل.',
                    'required' => 'حقل :field مطلوب.',
                    'same'     => 'يجب أن تتطابق الحقول :field وكلمة المرور.',
                ],
            ],

            'login-form' => [
                'not-activated' => 'يتطلب تنشيطك موافقة المسؤول',
                'invalid-creds' => 'يرجى التحقق من بيانات الاعتماد الخاصة بك والمحاولة مرة أخرى.',
            ],
        ],

        'response' => [
            'error-invalid-parameter' => 'تحذير: توجد معلمات غير صالحة.',
            'invalid-header'          => 'تحذير: رمز الرأس غير صالح.',
            'cancel-error'            => 'لا يمكن إلغاء الطلب.',
        ],
    ],
];
