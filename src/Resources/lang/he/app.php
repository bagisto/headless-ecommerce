<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'אתה כבר רשום לניוזלטר שלנו.',
            'subscribe-success'  => 'נרשמת בהצלחה לניוזלטר שלנו.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'תודה שפנית אלינו. נחזור אליך בקרוב.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'אזהרה: קישור להורדה לא נמצא.',
                'sample-not-found' => 'אזהרה: דוגמה להורדה לא נמצאה.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'אזהרה: לא נמצא לקוח מחובר.',
            'success-login'     => 'התחברות הלקוח בוצעה בהצלחה.',
            'success-logout'    => 'התנתקות הלקוח בוצעה בהצלחה.',

            'signup' => [
                'error-registration' => 'אזהרה: נכשלה הרשמת הלקוח.',
                'success-verify'     => 'החשבון נוצר בהצלחה, נשלחה הודעת דוא"ל לאימות.',
                'success'            => 'הצלחה: הלקוח נרשם והתחבר בהצלחה.',
            ],

            'social-login' => [
                'disabled' => 'אזהרה: התחברות חברתית מנוטרלת.',
            ],

            'login' => [
                'invalid-creds' => 'אנא בדוק את פרטי הכניסה שלך ונסה שוב.',
                'not-activated' => 'ההפעלה שלך דורשת אישור מנהל',
                'verify-first'  => 'אנא אמת את הדוא"ל שלך תחילה.',
                'suspended'     => 'החשבון שלך הושעה על ידי המנהל.',

                'validation' => [
                    'required' => 'שדה :field הוא שדה חובה.',
                    'same'     => 'השדה :field והסיסמה חייבים להתאים.',
                    'unique'   => 'כבר קיים :field כזה.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'קישור לאיפוס הסיסמה כבר נשלח לדוא"ל שלך.',
                'email-not-exist' => 'כתובת הדוא"ל אינה קיימת.',
                'reset-link-sent' => 'קישור לאיפוס הסיסמה נשלח לדוא"ל שלך.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'הצלחה: פרטי הלקוח נמשכו בהצלחה.',
                    'delete-success'   => 'הצלחה: החשבון נמחק בהצלחה.',
                    'password-unmatch' => 'הסיסמה אינה תואמת.',
                    'update-fail'      => 'אזהרה: הפרופיל לא עודכן.',
                    'update-success'   => 'הצלחה: הפרופיל עודכן בהצלחה.',
                    'wrong-password'   => 'אזהרה: ניתנה סיסמה שגויה.',
                    'order-pending'    => 'לא ניתן למחוק את החשבון מכיוון שיש לך הזמנות ממתינות.',
                ],

                'addresses' => [
                    'create-success'         => 'הצלחה: כתובת נוצרה בהצלחה.',
                    'default-update-success' => 'הצלחה: הכתובת הוגדרה כברירת מחדל',
                    'delete-success'         => 'הצלחה: הכתובת נמחקה בהצלחה',
                    'not-found'              => 'אזהרה: הכתובת לא נמצאה.',
                    'update-success'         => 'הצלחה: הכתובת עודכנה בהצלחה.',
                    'already-default'        => 'אזהרה: כתובת זו כבר מוגדרת כברירת מחדל.',
                ],

                'wishlist' => [
                    'product-removed' => 'אזהרה: המוצר לא נמצא.',
                    'success'         => 'הצלחה: המוצר נוסף לרשימת המשאלות בהצלחה.',
                    'already-exist'   => 'אזהרה: כבר נוסף לרשימת המשאלות.',
                    'remove-success'  => 'הצלחה: הפריט הוסר בהצלחה מרשימת המשאלות.',
                    'not-found'       => 'אזהרה: לא נמצאו מוצרים ברשימת המשאלות.',
                    'moved-to-cart'   => 'הצלחה: הפריט הועבר בהצלחה לעגלה.',
                ],

                'orders' => [
                    'not-found'      => 'אזהרה: לא נמצאו הזמנות.',
                    'cancel-error'   => 'אזהרה: ההזמנה לא בוטלה.',
                    'cancel-success' => 'הצלחה: ההזמנה בוטלה בהצלחה.',

                    'shipment' => [
                        'not-found' => 'אזהרה: המשלוח לא נמצא.',
                    ],

                    'invoice' => [
                        'not-found' => 'אזהרה: החשבונית לא נמצאה.',
                    ],

                    'refund' => [
                        'not-found' => 'אזהרה: ההחזר לא נמצא.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'אזהרה: המוצר הניתן להורדה לא נמצא.',
                    'not-auth'       => 'אזהרה: אין לך הרשאה לבצע פעולה זו.',
                    'payment-error'  => 'לא בוצע תשלום עבור ההורדה הזו.',
                    'download-error' => 'פג תוקף קישור ההורדה.',
                ],

                'gdpr' => [
                    'create-success'       => 'הצלחה: בקשת GDPR נוצרה בהצלחה.',
                    'revoke-failed'        => 'אזהרה: בקשת GDPR לא בוטלה.',
                    'revoked-successfully' => 'הצלחה: בקשת GDPR בוטלה בהצלחה.',
                    'not-enabled'          => 'אזהרה: GDPR אינו מופעל.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'אזהרה: מוצר להשוואה לא נמצא.',
                'product-not-found'   => 'אזהרה: מוצר לא נמצא.',
                'already-added'       => 'אזהרה: המוצר כבר נוסף לרשימת ההשוואה.',
                'item-add-success'    => 'הצלחה: המוצר נוסף בהצלחה לרשימת ההשוואה.',
                'remove-success'      => 'הצלחה: הפריט הוסר בהצלחה מרשימת ההשוואה.',
                'mass-remove-success' => 'הצלחה: הפריטים שנבחרו נמחקו בהצלחה.',
                'not-auth'            => 'אזהרה: אין לך הרשאה לבצע פעולה זו.',
            ],

            'reviews' => [
                'create-success'      => 'הצלחה: ביקורת נוצרה בהצלחה.',
                'delete-success'      => 'הצלחה: הביקורת נמחקה בהצלחה.',
                'mass-delete-success' => 'הצלחה: הביקורות שנבחרו נמחקו בהצלחה.',
                'not-found'           => 'אזהרה: הביקורת לא נמצאה.',
                'product-not-found'   => 'אזהרה: מוצר לא נמצא.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'אזהרה: לא ניתן להוסיף מוצרים לעגלה עבור מוצרים הניתנים להורדה.',
                        'invalid-parameter'  => 'אזהרה: פרמטרים לא תקינים.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'הצלחה: המוצר נוסף לעגלה בהצלחה.',
                        'update-to-cart'   => 'הצלחה: המוצר עודכן בהצלחה בעגלה.',
                        'delete-cart-item' => 'הצלחה: הפריט הוסר בהצלחה מהעגלה.',
                        'all-remove'       => 'הצלחה: כל הפריטים הוסרו מהעגלה.',
                        'move-to-wishlist' => 'הצלחה: הפריטים שנבחרו הועברו בהצלחה לרשימת המשאלות.',
                    ],

                    'fail' => [
                        'all-remove'       => 'אזהרה: לא הוסרו כל הפריטים מהעגלה.',
                        'update-to-cart'   => 'אזהרה: המוצר לא עודכן בעגלה.',
                        'delete-cart-item' => 'אזהרה: הפריט לא הוסר מהעגלה.',
                        'not-found'        => 'אזהרה: העגלה לא נמצאה.',
                        'item-not-found'   => 'אזהרה: הפריט לא נמצא.',
                        'move-to-wishlist' => 'אזהרה: הפריטים שנבחרו לא הועברו לרשימת המשאלות.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'אזהרה: לא ניתן להוסיף כתובת למשתמש אורח.',
                'guest-checkout-warning'    => 'אזהרה: לא ניתן לבצע הזמנה כמשתמש אורח.',
                'no-billing-address-found'  => 'אזהרה: לא נמצאה כתובת לחיוב.',
                'no-shipping-address-found' => 'אזהרה: לא נמצאה כתובת למשלוח.',
                'address-save-success'      => 'הצלחה: הכתובת נשמרה בהצלחה.',
            ],

            'shipping' => [
                'method-not-found' => 'אזהרה: שיטת המשלוח לא נמצאה.',
                'method-fetched'   => 'הצלחה: שיטת המשלוח נטענה בהצלחה.',
                'save-failed'      => 'אזהרה: שיטת המשלוח לא נשמרה.',
                'save-success'     => 'הצלחה: שיטת המשלוח נשמרה בהצלחה.',
            ],

            'payment' => [
                'method-not-found' => 'אזהרה: שיטת התשלום לא נמצאה.',
                'method-fetched'   => 'הצלחה: שיטת התשלום נטענה בהצלחה.',
                'save-failed'      => 'אזהרה: שיטת התשלום לא נשמרה.',
                'save-success'     => 'הצלחה: שיטת התשלום נשמרה בהצלחה.',
            ],

            'coupon' => [
                'apply-success'   => 'הצלחה: קוד הקופון הוחל בהצלחה.',
                'already-applied' => 'אזהרה: קוד הקופון כבר הוחל.',
                'invalid-code'    => 'אזהרה: קוד הקופון לא תקין.',
                'remove-success'  => 'הצלחה: קוד הקופון הוסר בהצלחה.',
                'remove-failed'   => 'אזהרה: קוד הקופון לא הוסר.',
            ],

            'something-wrong'          => 'אזהרה: משהו השתבש.',
            'invalid-guest-user'       => 'אזהרה: משתמש אורח לא תקין.',
            'empty-cart'               => 'אזהרה: העגלה ריקה.',
            'missing-billing-address'  => 'אזהרה: חסרה כתובת לחיוב.',
            'missing-shipping-address' => 'אזהרה: חסרה כתובת למשלוח.',
            'missing-shipping-method'  => 'אזהרה: חסרה שיטת משלוח.',
            'missing-payment-method'   => 'אזהרה: חסרה שיטת תשלום.',
            'no-address-found'         => 'אזהרה: לא נמצאו כתובת לחיוב ולמשלוח.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'יצירה',
            'delete'            => 'מחיקה',
            'edit'              => 'עריכה',
            'mass-delete'       => 'מחיקה מרובה',
            'mass-update'       => 'עדכון מרובה',
            'push-notification' => 'הודעת דחיפה',
            'send'              => 'שליחה',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'הודעת דחיפה',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'נושא הודעה',
                        'info'                            => 'הגדרות הקשורות להודעות',
                        'push-notification-configuration' => 'הגדרת הודעות פוש FCM',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'תוכן קובץ JSON של מפתח פרטי',
                        'info-get-private-key'            => 'מידע: לקבלת תוכן קובץ JSON של מפתח פרטי FCM: <a href="https://console.firebase.google.com/" target="_blank">לחץ כאן</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'הצלחה: סקריפטים מותאמים אישית עודכנו בהצלחה.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'אזהרה: לא ניתן לבטל הזמנה.',
                'cancel-success' => 'הצלחה: הזמנה בוטלה בהצלחה.',
                'not-found'      => 'אזהרה: הזמנה לא נמצאה.',
            ],

            'shipments' => [
                'creation-error'   => 'אזהרה: לא ניתן ליצור משלוח.',
                'not-found'        => 'אזהרה: משלוח לא נמצא.',
                'quantity-invalid' => 'אזהרה: כמות לא חוקית סופקה.',
                'shipment-error'   => 'אזהרה: לא ניתן ליצור משלוח.',
                'create-success'   => 'הצלחה: משלוח נוצר בהצלחה.',
            ],

            'invoices' => [
                'creation-error' => 'אזהרה: לא ניתן ליצור חשבונית.',
                'not-found'      => 'אזהרה: חשבונית לא נמצאה.',
                'product-error'  => 'אזהרה: מוצר לא חוקי סופק.',
                'create-success' => 'הצלחה: חשבונית נוצרה בהצלחה.',
                'invalid-qty'    => 'אזהרה: נמצאה כמות לא חוקית לפריטי חשבונית.',
            ],

            'refunds' => [
                'creation-error'      => 'אזהרה: לא ניתן ליצור החזר.',
                'refund-amount-error' => 'אזהרה: סכום החזר לא חוקי סופק.',
                'refund-limit-error'  => 'אזהרה: סכום החזר חורג מהמגבלה של :amount',
                'not-found'           => 'אזהרה: החזר לא נמצא.',
                'create-success'      => 'הצלחה: החזר נוצר בהצלחה.',
            ],

            'transactions' => [
                'already-paid'   => 'אזהרה: החשבונית כבר שולמה.',
                'amount-exceed'  => 'אזהרה: סכום העסקה חורג מהמגבלה.',
                'zero-amount'    => 'אזהרה: סכום העסקה צריך להיות גדול מאפס.',
                'create-success' => 'הצלחה: העסקה נוצרה בהצלחה.',
            ],

            'reorder' => [
                'customer-not-found'       => 'אזהרה: לקוח לא נמצא.',
                'cart-not-found'           => 'אזהרה: עגלה לא נמצאה.',
                'cart-item-not-found'      => 'אזהרה: פריט עגלה לא נמצא.',
                'cart-create-success'      => 'הצלחה: עגלה נוצרה בהצלחה.',
                'cart-item-add-success'    => 'הצלחה: מוצר נוסף לעגלה בהצלחה.',
                'cart-item-remove-success' => 'הצלחה: הפריט הוסר בהצלחה מהעגלה.',
                'cart-item-update-success' => 'הצלחה: מוצר עודכן בהצלחה בעגלה.',
                'something-wrong'          => 'אזהרה: משהו השתבש.',
                'address-save-success'     => 'הצלחה: כתובת נשמרה בהצלחה.',
                'shipping-save-success'    => 'הצלחה: שיטת משלוח נשמרה בהצלחה.',
                'payment-save-success'     => 'הצלחה: שיטת תשלום נשמרה בהצלחה.',
                'order-placed-success'     => 'הצלחה: הזמנה הוזמנה בהצלחה.',
                'payment-method-not-found' => 'אזהרה: שיטת התשלום לא נמצאה.',
                'minimum-order-amount-err' => 'אזהרה: סכום הזמנה מינימלי צריך להיות :amount',
                'check-shipping-address'   => 'אזהרה: נא לבדוק את כתובת המשלוח.',
                'check-billing-address'    => 'אזהרה: נא לבדוק את כתובת החיוב.',
                'specify-shipping-method'  => 'אזהרה: נא לציין את שיטת המשלוח.',
                'specify-payment-method'   => 'אזהרה: נא לציין את שיטת התשלום.',
                'coupon-not-valid'         => 'אזהרה: קוד קופון לא חוקי.',
                'coupon-already-applied'   => 'אזהרה: קוד קופון כבר הוחל.',
                'coupon-applied'           => 'הצלחה: קוד קופון הוחל בהצלחה.',
                'coupon-removed'           => 'הצלחה: קוד קופון הוסר בהצלחה.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'מוצר נוצר בהצלחה.',
                'delete-success'            => 'מוצר נמחק בהצלחה',
                'not-found'                 => 'אזהרה: מוצר לא נמצא.',
                'update-success'            => 'מוצר עודכן בהצלחה.',
                'configurable-attr-missing' => 'אזהרה: מאפיין ניתן להגדרה חסר.',
                'simple-products-error'     => 'אזהרה: מוצרים פשוטים חסרים.',
            ],

            'categories' => [
                'already-taken'  => 'אזהרה: הסלאג כבר תפוס.',
                'create-success' => 'קטגוריה נוצרה בהצלחה.',
                'delete-success' => 'קטגוריה נמחקה בהצלחה',
                'not-found'      => 'אזהרה: קטגוריה לא נמצאה.',
                'update-success' => 'קטגוריה עודכנה בהצלחה.',
                'root-delete'    => 'אזהרה: לא ניתן למחוק קטגוריה שורש.',
            ],

            'attributes' => [
                'create-success'    => 'מאפיין נוצר בהצלחה.',
                'delete-success'    => 'מאפיין נמחק בהצלחה',
                'not-found'         => 'אזהרה: מאפיין לא נמצא.',
                'update-success'    => 'מאפיין עודכן בהצלחה.',
                'user-define-error' => 'אזהרה: אין לך הרשאה למחוק מאפיין שנוצר על ידי המערכת.',
            ],

            'attribute-groups' => [
                'create-success'    => 'קבוצת מאפיינים נוצרה בהצלחה.',
                'delete-success'    => 'קבוצת מאפיינים נמחקה בהצלחה',
                'not-found'         => 'אזהרה: קבוצת מאפיינים לא נמצאה.',
                'update-success'    => 'קבוצת מאפיינים עודכנה בהצלחה.',
                'user-define-error' => 'אזהרה: אין לך הרשאה למחוק קבוצת מאפיינים שנוצרה על ידי המערכת.',
            ],

            'attribute-families' => [
                'create-success'          => 'משפחת מאפיינים נוצרה בהצלחה.',
                'delete-success'          => 'משפחת מאפיינים נמחקה בהצלחה',
                'not-found'               => 'אזהרה: משפחת מאפיינים לא נמצאה.',
                'update-success'          => 'משפחת מאפיינים עודכנה בהצלחה.',
                'last-delete-error'       => 'אזהרה: לא ניתן למחוק את משפחת המאפיינים האחרונה.',
                'attribute-product-error' => 'אזהרה: ישנם מוצרים מסוימים המשוייכים למשפחת המאפיינים הזו.',
                'user-define-error'       => 'אזהרה: אין לך הרשאה למחוק משפחת מאפיינים שנוצרה על ידי המערכת.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'לקוח נוצר בהצלחה.',
                'delete-order-pending' => 'לא ניתן למחוק את חשבון הלקוח מכיוון שישנם הזמנות ממתינות או בתהליך.',
                'delete-success'       => 'לקוח נמחק בהצלחה',
                'not-found'            => 'אזהרה: לקוח לא נמצא.',
                'note-created-success' => 'הערה נוצרה בהצלחה',
                'update-success'       => 'לקוח עודכן בהצלחה.',
                'login-success'        => 'הצלחה: הלקוח נכנס למערכת בהצלחה.',
            ],

            'addresses' => [
                'create-success'         => 'כתובת הלקוח נוצרה בהצלחה.',
                'default-update-success' => 'הכתובת הוגדרה כברירת מחדל.',
                'delete-success'         => 'כתובת הלקוח נמחקה בהצלחה.',
                'not-found'              => 'אזהרה: כתובת הלקוח לא נמצאה.',
                'update-success'         => 'כתובת הלקוח עודכנה בהצלחה.',
                'already-default'        => 'אזהרה: כתובת זו כבר מוגדרת כברירת מחדל.',
            ],

            'groups' => [
                'create-success'     => 'קבוצת לקוחות נוצרה בהצלחה.',
                'customer-associate' => 'אזהרה: לא ניתן למחוק קבוצה. לקוח משוייך אליה.',
                'delete-success'     => 'קבוצת לקוחות נמחקה בהצלחה',
                'not-found'          => 'אזהרה: קבוצת לקוחות לא נמצאה.',
                'update-success'     => 'קבוצת לקוחות עודכנה בהצלחה.',
                'user-define-error'  => 'אזהרה: אין לך הרשאה למחוק קבוצת לקוחות שנוצרה על ידי המערכת.',
            ],

            'reviews' => [
                'delete-success' => 'ביקורת נמחקה בהצלחה',
                'not-found'      => 'אזהרה: ביקורת לא נמצאה.',
                'update-success' => 'ביקורת עודכנה בהצלחה.',
            ],

            'gdpr' => [
                'delete-success' => 'הצלחה: בקשת GDPR נמחקה בהצלחה.',
                'not-found'      => 'אזהרה: בקשת GDPR לא נמצאה.',
                'update-success' => 'בקשת GDPR עודכנה בהצלחה.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'אזהרה: הסלאג כבר תפוס.',
            'create-success' => 'CMS נוצר בהצלחה.',
            'delete-success' => 'CMS נמחק בהצלחה',
            'not-found'      => 'אזהרה: CMS לא נמצא.',
            'update-success' => 'CMS עודכן בהצלחה.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'ה规则 קטלוג נוצר בהצלחה.',
                    'delete-failed'  => 'אזהרה: לא הצלחנו למחוק את כלל הקטלוג.',
                    'delete-success' => 'כלל הקטלוג נמחק בהצלחה.',
                    'not-found'      => 'אזהרה: כלל הקטלוג לא נמצא.',
                    'update-success' => 'כלל הקטלוג עודכן בהצלחה.',
                ],

                'cart-rules' => [
                    'create-success' => 'ה规则 עגלת קניות נוצר בהצלחה.',
                    'delete-failed'  => 'אזהרה: לא הצלחנו למחוק את כלל העגלה.',
                    'delete-success' => 'כלל העגלה נמחק בהצלחה.',
                    'not-found'      => 'לא נמצא כלל עגלה.',
                    'update-success' => 'כלל העגלה עודכן בהצלחה.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'תבנית האימייל נוצרה בהצלחה.',
                    'delete-success' => 'תבנית האימייל נמחקה בהצלחה.',
                    'not-found'      => 'אזהרה: תבנית האימייל לא נמצאה.',
                    'update-success' => 'תבנית האימייל עודכנה בהצלחה.',
                ],

                'events' => [
                    'create-success' => 'האירוע נוצר בהצלחה.',
                    'delete-success' => 'האירוע נמחק בהצלחה.',
                    'not-found'      => 'אזהרה: האירוע לא נמצא.',
                    'update-success' => 'האירוע עודכן בהצלחה.',
                ],

                'campaigns' => [
                    'create-success' => 'הקמפיין נוצר בהצלחה.',
                    'delete-success' => 'הקמפיין נמחק בהצלחה.',
                    'not-found'      => 'אזהרה: הקמפיין לא נמצא.',
                    'update-success' => 'הקמפיין עודכן בהצלחה.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'המנוי נמחק בהצלחה.',
                    'not-found'           => 'אזהרה: המנוי לא נמצא.',
                    'unsubscribe-success' => 'בהצלחה: הוסר מהמנוי.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'שכתוב כתובת URL נוצר בהצלחה.',
                    'delete-success' => 'שכתוב כתובת URL נמחק בהצלחה.',
                    'not-found'      => 'אזהרה: שכתוב כתובת URL לא נמצא.',
                    'update-success' => 'שכתוב כתובת URL עודכן בהצלחה.',
                ],

                'search-terms' => [
                    'create-success' => 'מונח חיפוש נוצר בהצלחה.',
                    'delete-success' => 'מונח חיפוש נמחק בהצלחה.',
                    'not-found'      => 'אזהרה: מונח חיפוש לא נמצא.',
                    'update-success' => 'מונח חיפוש עודכן בהצלחה.',
                ],

                'search-synonyms' => [
                    'create-success' => 'סינונימי חיפוש נוצרו בהצלחה.',
                    'delete-success' => 'סינונימי חיפוש נמחקו בהצלחה.',
                    'not-found'      => 'אזהרה: סינונימי חיפוש לא נמצאו.',
                    'update-success' => 'סינונימי חיפוש עודכנו בהצלחה.',
                ],

                'sitemaps' => [
                    'create-success' => 'מפת האתר נוצרה בהצלחה.',
                    'delete-success' => 'מפת האתר נמחקה בהצלחה.',
                    'not-found'      => 'אזהרה: מפת האתר לא נמצאה.',
                    'update-success' => 'מפת האתר עודכנה בהצלחה.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'השפה נוצרה בהצלחה.',
                'default-delete-error' => 'לא ניתן למחוק את השפה המוגדרת כברירת מחדל.',
                'delete-error'         => 'מחיקת השפה נכשלה.',
                'delete-success'       => 'השפה נמחקה בהצלחה.',
                'last-delete-error'    => 'מחיקת השפה האחרונה נכשלה.',
                'not-found'            => 'אזהרה: השפה לא נמצאה.',
                'update-success'       => 'השפה עודכנה בהצלחה.',
            ],

            'currencies' => [
                'create-success'       => 'המטבע נוצר בהצלחה.',
                'default-delete-error' => 'לא ניתן למחוק את המטבע המוגדר כברירת מחדל.',
                'delete-error'         => 'מחיקת המטבע נכשלה.',
                'delete-success'       => 'המטבע נמחק בהצלחה.',
                'last-delete-error'    => 'מחיקת המטבע האחרון נכשלה.',
                'not-found'            => 'אזהרה: המטבע לא נמצא.',
                'update-success'       => 'המטבע עודכן בהצלחה.',
            ],

            'exchange-rates' => [
                'create-success'          => 'שער החליפין נוצר בהצלחה.',
                'delete-error'            => 'מחיקת שער החליפין נכשלה.',
                'delete-success'          => 'שער החליפין נמחק בהצלחה.',
                'invalid-target-currency' => 'אזהרה: מטבע היעד שסופק אינו חוקי.',
                'last-delete-error'       => 'מחיקת שער החליפין האחרון נכשלה.',
                'not-found'               => 'אזהרה: שער החליפין לא נמצא.',
                'update-success'          => 'שער החליפין עודכן בהצלחה.',
            ],

            'inventory-sources' => [
                'create-success'    => 'מקור המלאי נוצר בהצלחה.',
                'delete-error'      => 'מחיקת מקור המלאי נכשלה.',
                'delete-success'    => 'מקור המלאי נמחק בהצלחה.',
                'last-delete-error' => 'מחיקת מקור המלאי האחרון נכשלה.',
                'not-found'         => 'אזהרה: מקור המלאי לא נמצא.',
                'update-success'    => 'מקור המלאי עודכן בהצלחה.',
            ],

            'channels' => [
                'create-success'       => 'הערוץ נוצר בהצלחה.',
                'default-delete-error' => 'לא ניתן למחוק את הערוץ המוגדר כברירת מחדל.',
                'delete-error'         => 'מחיקת הערוץ נכשלה.',
                'delete-success'       => 'הערוץ נמחק בהצלחה.',
                'last-delete-error'    => 'מחיקת הערוץ האחרון נכשלה.',
                'not-found'            => 'אזהרה: הערוץ לא נמצא.',
                'update-success'       => 'הערוץ עודכן בהצלחה.',
            ],

            'users' => [
                'activate-warning'  => 'החשבון שלך עדיין לא הופעל, נא ליצור קשר עם המנהל.',
                'create-success'    => 'המשתמש נוצר בהצלחה.',
                'delete-error'      => 'מחיקת המשתמש נכשלה.',
                'delete-success'    => 'המשתמש נמחק בהצלחה.',
                'last-delete-error' => 'מחיקת המשתמש האחרון נכשלה.',
                'login-error'       => 'נא לבדוק את פרטי הכניסה שלך ולנסות שוב.',
                'not-found'         => 'אזהרה: המשתמש לא נמצא.',
                'success-login'     => 'הצלחה: המשתמש נכנס למערכת בהצלחה.',
                'success-logout'    => 'הצלחה: המשתמש יצא מהמערכת בהצלחה.',
                'update-success'    => 'המשתמש עודכן בהצלחה.',
            ],

            'roles' => [
                'create-success'    => 'התפקיד נוצר בהצלחה.',
                'delete-error'      => 'מחיקת התפקיד נכשלה.',
                'delete-success'    => 'התפקיד נמחק בהצלחה.',
                'last-delete-error' => 'לא ניתן למחוק את התפקיד האחרון.',
                'not-found'         => 'אזהרה: התפקיד לא נמצא.',
                'update-success'    => 'התפקיד עודכן בהצלחה.',
            ],

            'themes' => [
                'create-success' => 'הערכת נושא נוצרה בהצלחה.',
                'delete-success' => 'הערכת נושא נמחקה בהצלחה.',
                'not-found'      => 'אזהרה: הערכת הנושא לא נמצאה.',
                'update-success' => 'הערכת נושא עודכנה בהצלחה.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'מזהה category_id שצוין אינו קיים.',
                        'invalid-boolean-value' => 'הערך של :key חייב להיות 0 או 1.',
                        'invalid-filter-key'    => 'מפתח הסינון ":key" אינו מותר.',
                        'invalid-limit-value'   => 'ערך המגבלה חייב להיות אחד מהבאים: :options.',
                        'invalid-select-option' => 'הערך :key אינו חוקי. אפשרויות חוקיות הן: :options.',
                        'invalid-sort-value'    => 'ערך המיון חייב להיות אחד מהבאים: :options.',
                        'missing-limit-key'     => 'filtersInput חייב לכלול את המפתח "limit".',
                        'missing-sort-key'      => 'filtersInput חייב לכלול את המפתח "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'שיעור המס נוצר בהצלחה.',
                'delete-error'   => 'מחיקת שיעור המס נכשלה.',
                'delete-success' => 'שיעור המס נמחק בהצלחה.',
                'not-found'      => 'אזהרה: שיעור המס לא נמצא.',
                'update-success' => 'שיעור המס עודכן בהצלחה.',
            ],

            'tax-category' => [
                'create-success'     => 'קטגוריית המס נוצרה בהצלחה.',
                'delete-error'       => 'מחיקת קטגוריית המס נכשלה.',
                'delete-success'     => 'קטגוריית המס נמחקה בהצלחה.',
                'not-found'          => 'אזהרה: קטגוריית המס לא נמצאה.',
                'tax-rate-not-found' => 'המזהה שסופק לא נמצא. מזהה: :ids',
                'update-success'     => 'קטגוריית המס עודכנה בהצלחה.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'הוסף התראה',
                    'general'   => 'כללי',
                    'title'     => 'התראת דחיפה',

                    'datagrid' => [
                        'channel-name'         => 'שם הערוץ',
                        'created-at'           => 'זמן יצירה',
                        'delete'               => 'מחק',
                        'id'                   => 'מזהה',
                        'image'                => 'תמונה',
                        'notification-content' => 'תוכן ההתראה',
                        'notification-status'  => 'מצב התראה',
                        'notification-type'    => 'סוג התראה',
                        'text-title'           => 'כותרת',
                        'update'               => 'עדכן',
                        'updated-at'           => 'זמן עדכון',

                        'status' => [
                            'disabled' => 'מנוטרל',
                            'enabled'  => 'מופעל',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'חזור',
                    'content-and-image'    => 'תוכן התראה ותמונה',
                    'create-btn-title'     => 'שמור התראה',
                    'general'              => 'כללי',
                    'image'                => 'תמונה',
                    'new-notification'     => 'התראה חדשה',
                    'notification-content' => 'תוכן התראה',
                    'notification-type'    => 'סוג התראה',
                    'product-cat-id'       => 'מזהה מוצר/קטגוריה',
                    'settings'             => 'הגדרות',
                    'status'               => 'מצב',
                    'store-view'           => 'ערוצים',
                    'title'                => 'התראת דחיפה',

                    'option-type' => [
                        'category' => 'קטגוריה',
                        'others'   => 'רגיל',
                        'product'  => 'מוצר',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'חזור',
                    'content-and-image'    => 'תוכן התראה ותמונה',
                    'edit-notification'    => 'ערוך התראה',
                    'general'              => 'כללי',
                    'image'                => 'תמונה',
                    'notification-content' => 'תוכן התראה',
                    'notification-type'    => 'סוג התראה',
                    'product-cat-id'       => 'מזהה מוצר/קטגוריה',
                    'send-title'           => 'שלח התראה',
                    'settings'             => 'הגדרות',
                    'status'               => 'מצב',
                    'store-view'           => 'ערוצים',
                    'title'                => 'התראת דחיפה',
                    'update-btn-title'     => 'עדכן',

                    'option-type' => [
                        'category' => 'קטגוריה',
                        'others'   => 'רגיל',
                        'product'  => 'מוצר',
                    ],
                ],

                'not-found'           => 'אזהרה: התראה לא נמצאה.',
                'create-success'      => 'התראה נוצרה בהצלחה.',
                'delete-failed'       => 'מחיקת התראה נכשלה.',
                'delete-success'      => 'התראה נמחקה בהצלחה.',
                'mass-update-success' => 'התראות נבחרות עודכנו בהצלחה.',
                'mass-delete-success' => 'התראות נבחרות נמחקו בהצלחה.',
                'no-value-selected'   => 'אין ערך קיים.',
                'send-success'        => 'התראה נשלחה בהצלחה.',
                'update-success'      => 'התראה עודכנה בהצלחה.',
                'configuration-error' => 'אזהרה: תצורת FCM לא נמצאה.',
                'product-not-found'   => 'אזהרה: מוצר לא נמצא.',
                'category-not-found'  => 'אזהרה: קטגוריה לא נמצאה.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'אזהרה: פרמטרים לא חוקיים הוזנו.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'אזהרה: הגדרת דוא"ל לא נמצאה.',
    ],
];
