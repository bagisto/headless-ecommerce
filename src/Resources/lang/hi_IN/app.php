<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'आप पहले से ही हमारे न्यूज़लेटर के लिए सब्सक्राइब कर चुके हैं।',
            'subscribe-success'  => 'आपने सफलतापूर्वक हमारे न्यूज़लेटर के लिए सब्सक्राइब कर लिया है।',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'हमसे संपर्क करने के लिए धन्यवाद। हम जल्द ही आपसे संपर्क करेंगे।',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'चेतावनी: डाउनलोड लिंक नहीं मिला।',
                'sample-not-found' => 'चेतावनी: डाउनलोड करने योग्य नमूना नहीं मिला।',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'चेतावनी: कोई लॉगिन ग्राहक नहीं मिला।',
            'success-login'     => 'सफलतापूर्वक ग्राहक लॉगिन।',
            'success-logout'    => 'सफलतापूर्वक ग्राहक लॉगआउट।',

            'signup' => [
                'error-registration' => 'चेतावनी: ग्राहक पंजीकरण विफल हुआ।',
                'success-verify'     => 'सफलता: खाता सफलतापूर्वक बनाया गया है, सत्यापन के लिए एक ईमेल भेजा गया है।',
                'success'            => 'ग्राहक सफलतापूर्वक पंजीकृत और लॉगिन हुआ।',
            ],

            'social-login' => [
                'disabled' => 'चेतावनी: सोशल लॉगिन अक्षम है।',
            ],

            'login' => [
                'invalid-creds' => 'कृपया अपने क्रेडेंशियल्स की जांच करें और पुनः प्रयास करें।',
                'not-activated' => 'आपकी सक्रियण के लिए व्यवस्थापक की मंजूरी की आवश्यकता है',
                'verify-first'  => 'कृपया पहले अपना ईमेल सत्यापित करें।',
                'suspended'     => 'व्यवस्थापक द्वारा आपका खाता निलंबित कर दिया गया है।',

                'validation' => [
                    'required' => ':field फ़ील्ड आवश्यक है।',
                    'same'     => ':field और पासवर्ड मेल खाने चाहिए।',
                    'unique'   => 'इस :field को पहले से ही ले लिया गया है।',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'आपके ईमेल पर पासवर्ड रीसेट लिंक पहले से ही भेज दिया गया है।',
                'email-not-exist' => 'ईमेल मौजूद नहीं है।',
                'reset-link-sent' => 'आपके ईमेल पर पासवर्ड रीसेट लिंक भेज दिया गया है।',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'सफलता: ग्राहक विवरण सफलतापूर्वक प्राप्त किए गए।',
                    'delete-success'   => 'सफलता: खाता सफलतापूर्वक हटा दिया गया।',
                    'password-unmatch' => 'पासवर्ड मेल नहीं खाता।',
                    'update-fail'      => 'चेतावनी: प्रोफ़ाइल अपडेट नहीं हुआ।',
                    'update-success'   => 'सफलता: प्रोफ़ाइल सफलतापूर्वक अपडेट हो गया।',
                    'wrong-password'   => 'चेतावनी: गलत पासवर्ड दिया गया है।',
                    'order-pending'    => 'आप खाता नहीं हटा सकते क्योंकि आपके पास कुछ लंबित ऑर्डर हैं।',
                ],

                'addresses' => [
                    'create-success'         => 'सफलतापूर्वक पता बनाया गया।',
                    'default-update-success' => 'पता डिफ़ॉल्ट के रूप में सेट किया गया है',
                    'delete-success'         => 'सफलतापूर्वक पता हटा दिया गया।',
                    'not-found'              => 'चेतावनी: पता नहीं मिला।',
                    'update-success'         => 'सफलतापूर्वक पता अपडेट किया गया।',
                    'already-default'        => 'चेतावनी: यह पता पहले से ही डिफ़ॉल्ट के रूप में सेट है।',
                ],

                'wishlist' => [
                    'product-removed' => 'चेतावनी: उत्पाद नहीं मिला।',
                    'success'         => 'सफलतापूर्वक उत्पाद विशलिस्ट में जोड़ा गया।',
                    'already-exist'   => 'चेतावनी: पहले से ही विशलिस्ट में जोड़ दिया गया है।',
                    'remove-success'  => 'सफलतापूर्वक आइटम विशलिस्ट से हटा दिया गया है।',
                    'not-found'       => 'चेतावनी: विशलिस्ट में कोई उत्पाद नहीं मिला।',
                    'moved-to-cart'   => 'सफलतापूर्वक उत्पाद कार्ट में स्थानांतरित किया गया है।',
                ],

                'orders' => [
                    'not-found'      => 'चेतावनी: कोई आदेश नहीं मिला।',
                    'cancel-error'   => 'चेतावनी: आदेश रद्द नहीं हुआ।',
                    'cancel-success' => 'सफलतापूर्वक आदेश रद्द किया गया।',

                    'shipment' => [
                        'not-found' => 'चेतावनी: शिपमेंट नहीं मिली।',
                    ],

                    'invoice' => [
                        'not-found' => 'चेतावनी: चालान नहीं मिला।',
                    ],

                    'refund' => [
                        'not-found' => 'चेतावनी: रिफंड नहीं मिला।',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'चेतावनी: डाउनलोड करने योग्य उत्पाद नहीं मिला।',
                    'not-auth'       => 'चेतावनी: आपको इस कार्रवाई को करने की अनुमति नहीं है।',
                    'payment-error'  => 'इस डाउनलोड के लिए भुगतान नहीं किया गया है।',
                    'download-error' => 'डाउनलोड लिंक समाप्त हो गया है।',
                ],

                'gdpr' => [
                    'create-success'       => 'सफलता: GDPR अनुरोध सफलतापूर्वक बनाया गया।',
                    'revoke-failed'        => 'चेतावनी: GDPR अनुरोध रद्द नहीं किया गया।',
                    'revoked-successfully' => 'सफलता: GDPR अनुरोध सफलतापूर्वक रद्द किया गया।',
                    'not-enabled'          => 'चेतावनी: GDPR सक्षम नहीं है।',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'चेतावनी: तुलना उत्पाद नहीं मिला।',
                'product-not-found'   => 'चेतावनी: उत्पाद नहीं मिला।',
                'already-added'       => 'चेतावनी: उत्पाद पहले ही तुलना सूची में जोड़ा जा चुका है।',
                'item-add-success'    => 'सफलता: उत्पाद को सफलतापूर्वक तुलना सूची में जोड़ा गया।',
                'remove-success'      => 'सफलता: आइटम को सफलतापूर्वक तुलना सूची से हटा दिया गया।',
                'mass-remove-success' => 'सफलता: चयनित आइटम सफलतापूर्वक हटा दिए गए।',
                'not-auth'            => 'चेतावनी: आप इस कार्रवाई को करने के लिए अधिकृत नहीं हैं।',
            ],

            'reviews' => [
                'create-success'      => 'सफलतापूर्वक समीक्षा बनाई गई।',
                'delete-success'      => 'सफलतापूर्वक समीक्षा हटा दी गई।',
                'mass-delete-success' => 'सफलतापूर्वक चयनित समीक्षाएं हटा दी गईं।',
                'not-found'           => 'चेतावनी: समीक्षा नहीं मिली।',
                'product-not-found'   => 'चेतावनी: उत्पाद नहीं मिला।',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'चेतावनी: डाउनलोड लिंक उपलब्ध नहीं हैं।',
                        'invalid-parameter'  => 'चेतावनी: अमान्य पैरामीटर प्रदान किए गए।',
                    ],

                    'success' => [
                        'add-to-cart'      => 'सफलतापूर्वक उत्पाद कार्ट में जोड़ा गया।',
                        'update-to-cart'   => 'सफलतापूर्वक उत्पाद कार्ट में अपडेट किया गया।',
                        'delete-cart-item' => 'सफलतापूर्वक आइटम कार्ट से हटा दिया गया है।',
                        'all-remove'       => 'सफलतापूर्वक सभी आइटम कार्ट से हटा दिए गए हैं।',
                        'move-to-wishlist' => 'सफलतापूर्वक चयनित आइटम विशलिस्ट में स्थानांतरित किए गए हैं।',
                    ],

                    'fail' => [
                        'all-remove'       => 'चेतावनी: सभी आइटम कार्ट से हटाए नहीं गए हैं।',
                        'update-to-cart'   => 'चेतावनी: उत्पाद कार्ट में अपडेट नहीं हुआ।',
                        'delete-cart-item' => 'चेतावनी: आइटम कार्ट से हटाया नहीं गया है।',
                        'not-found'        => 'चेतावनी: कार्ट नहीं मिला।',
                        'item-not-found'   => 'चेतावनी: आइटम नहीं मिला।',
                        'move-to-wishlist' => 'चेतावनी: चयनित आइटम विशलिस्ट में स्थानांतरित नहीं हुए हैं।',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'चेतावनी: मेहमान उपयोगकर्ता पता नहीं जोड़ सकता।',
                'guest-checkout-warning'    => 'चेतावनी: मेहमान उपयोगकर्ता चेकआउट नहीं कर सकता।',
                'no-billing-address-found'  => 'चेतावनी: कोई बिलिंग पता नहीं मिला।',
                'no-shipping-address-found' => 'चेतावनी: कोई शिपिंग पता नहीं मिला।',
                'address-save-success'      => 'सफलतापूर्वक पता सहेजा गया।',
            ],

            'shipping' => [
                'method-not-found' => 'चेतावनी: शिपिंग विधि नहीं मिली।',
                'method-fetched'   => 'सफलतापूर्वक शिपिंग विधि प्राप्त की गई।',
                'save-failed'      => 'चेतावनी: शिपिंग विधि सहेजी नहीं गई।',
                'save-success'     => 'सफलतापूर्वक शिपिंग विधि सहेजी गई।',
            ],

            'payment' => [
                'method-not-found' => 'चेतावनी: भुगतान विधि नहीं मिली।',
                'method-fetched'   => 'सफलतापूर्वक भुगतान विधि प्राप्त की गई।',
                'save-failed'      => 'चेतावनी: भुगतान विधि सहेजी नहीं गई।',
                'save-success'     => 'सफलतापूर्वक भुगतान विधि सहेजी गई।',
            ],

            'coupon' => [
                'apply-success'   => 'सफलतापूर्वक कूपन कोड लागू किया गया।',
                'already-applied' => 'चेतावनी: कूपन कोड पहले से ही लागू किया गया है।',
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
            'create'            => 'बनाएं',
            'delete'            => 'हटाएं',
            'edit'              => 'संपादित करें',
            'mass-delete'       => 'मास हटाना',
            'mass-update'       => 'मास अपडेट',
            'push-notification' => 'पुश सूचना',
            'send'              => 'भेजें',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'पुश सूचना',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'सूचना विषय',
                        'info'                            => 'सूचना संबंधित कॉन्फ़िगरेशन',
                        'push-notification-configuration' => 'FCM पुश सूचना कॉन्फ़िगरेशन',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'प्राइवेट की JSON फ़ाइल सामग्री',
                        'info-get-private-key'            => 'जानकारी: FCM प्राइवेट की JSON फ़ाइल सामग्री प्राप्त करने के लिए: <a href="https://console.firebase.google.com/" target="_blank">यहाँ क्लिक करें</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'सफलता: कस्टम स्क्रिप्ट्स सफलतापूर्वक अपडेट किए गए।',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'चेतावनी: आदेश रद्द नहीं किया जा सकता।',
                'cancel-success' => 'सफलता: आदेश सफलतापूर्वक रद्द कर दिया गया।',
                'not-found'      => 'चेतावनी: आदेश नहीं मिला।',
            ],

            'shipments' => [
                'creation-error'   => 'चेतावनी: शिपमेंट नहीं बना।',
                'not-found'        => 'चेतावनी: शिपमेंट नहीं मिला।',
                'quantity-invalid' => 'चेतावनी: गलत मात्रा प्रदान की गई।',
                'shipment-error'   => 'चेतावनी: शिपमेंट नहीं बना।',
                'create-success'   => 'सफलता: शिपमेंट सफलतापूर्वक बनाया गया।',
            ],

            'invoices' => [
                'creation-error' => 'चेतावनी: चालान नहीं बना।',
                'not-found'      => 'चेतावनी: चालान नहीं मिला।',
                'product-error'  => 'चेतावनी: गलत उत्पाद प्रदान किया गया।',
                'create-success' => 'सफलता: चालान सफलतापूर्वक बनाया गया।',
                'invalid-qty'    => 'चेतावनी: चालान आइटम के लिए अमान्य मात्रा पाई गई।',
            ],

            'refunds' => [
                'creation-error'      => 'चेतावनी: रिफंड नहीं बना।',
                'refund-amount-error' => 'चेतावनी: गलत रिफंड राशि प्रदान की गई।',
                'refund-limit-error'  => 'चेतावनी: रिफंड राशि सीमा से अधिक है: :amount',
                'not-found'           => 'चेतावनी: रिफंड नहीं मिला।',
                'create-success'      => 'सफलता: रिफंड सफलतापूर्वक बनाया गया।',
            ],

            'transactions' => [
                'already-paid'   => 'चेतावनी: चालान पहले ही भुगतान किया जा चुका है।',
                'amount-exceed'  => 'चेतावनी: लेनदेन राशि सीमा से अधिक है।',
                'zero-amount'    => 'चेतावनी: लेनदेन राशि शून्य से अधिक होनी चाहिए।',
                'create-success' => 'सफलता: लेनदेन सफलतापूर्वक बनाया गया।',
            ],

            'reorder' => [
                'customer-not-found'       => 'चेतावनी: ग्राहक नहीं मिला।',
                'cart-not-found'           => 'चेतावनी: कार्ट नहीं मिली।',
                'cart-item-not-found'      => 'चेतावनी: कार्ट आइटम नहीं मिला।',
                'cart-create-success'      => 'सफलता: कार्ट सफलतापूर्वक बनाई गई।',
                'cart-item-add-success'    => 'सफलता: उत्पाद कार्ट में सफलतापूर्वक जोड़ा गया।',
                'cart-item-remove-success' => 'सफलता: आइटम को कार्ट से सफलतापूर्वक हटा दिया गया।',
                'cart-item-update-success' => 'सफलता: उत्पाद को कार्ट में सफलतापूर्वक अपडेट किया गया।',
                'something-wrong'          => 'चेतावनी: कुछ गलत हो गया।',
                'address-save-success'     => 'सफलता: पता सफलतापूर्वक सहेजा गया।',
                'shipping-save-success'    => 'सफलता: शिपिंग विधि सफलतापूर्वक सहेजी गई।',
                'payment-save-success'     => 'सफलता: भुगतान विधि सफलतापूर्वक सहेजी गई।',
                'order-placed-success'     => 'सफलता: आदेश सफलतापूर्वक लगाया गया।',
                'payment-method-not-found' => 'चेतावनी: भुगतान विधि नहीं मिली।',
                'minimum-order-amount-err' => 'चेतावनी: न्यूनतम आदेश राशि :amount होनी चाहिए।',
                'check-shipping-address'   => 'चेतावनी: कृपया शिपिंग पते की जांच करें।',
                'check-billing-address'    => 'चेतावनी: कृपया बिलिंग पते की जांच करें।',
                'specify-shipping-method'  => 'चेतावनी: कृपया शिपिंग विधि निर्दिष्ट करें।',
                'specify-payment-method'   => 'चेतावनी: कृपया भुगतान विधि निर्दिष्ट करें।',
                'coupon-not-valid'         => 'चेतावनी: कूपन कोड अमान्य है।',
                'coupon-already-applied'   => 'चेतावनी: कूपन कोड पहले ही लागू किया गया है।',
                'coupon-applied'           => 'सफलता: कूपन कोड सफलतापूर्वक लागू किया गया।',
                'coupon-removed'           => 'सफलता: कूपन कोड सफलतापूर्वक हटा दिया गया।',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'उत्पाद सफलतापूर्वक बनाया गया।',
                'delete-success'            => 'उत्पाद सफलतापूर्वक हटा दिया गया।',
                'not-found'                 => 'चेतावनी: उत्पाद नहीं मिला।',
                'update-success'            => 'उत्पाद सफलतापूर्वक अपडेट किया गया।',
                'configurable-attr-missing' => 'चेतावनी: कॉन्फ़िगर करने योग्य विशेषता गायब है।',
                'simple-products-error'     => 'चेतावनी: साधारण उत्पाद गायब हैं।',
            ],

            'categories' => [
                'already-taken'  => 'चेतावनी: स्लग पहले ही लिया जा चुका है।',
                'create-success' => 'श्रेणी सफलतापूर्वक बनाई गई।',
                'delete-success' => 'श्रेणी सफलतापूर्वक हटा दी गई।',
                'not-found'      => 'चेतावनी: श्रेणी नहीं मिली।',
                'update-success' => 'श्रेणी सफलतापूर्वक अपडेट की गई।',
                'root-delete'    => 'चेतावनी: रूट श्रेणी को नहीं हटाया जा सकता।',
            ],

            'attributes' => [
                'create-success'    => 'विशेषता सफलतापूर्वक बनाई गई।',
                'delete-success'    => 'विशेषता सफलतापूर्वक हटा दी गई।',
                'not-found'         => 'चेतावनी: विशेषता नहीं मिली।',
                'update-success'    => 'विशेषता सफलतापूर्वक अपडेट की गई।',
                'user-define-error' => 'चेतावनी: आप सिस्टम द्वारा बनाई गई विशेषता को हटाने के लिए अधिकृत नहीं हैं।',
            ],

            'attribute-groups' => [
                'create-success'    => 'विशेषता समूह सफलतापूर्वक बनाया गया।',
                'delete-success'    => 'विशेषता समूह सफलतापूर्वक हटा दिया गया।',
                'not-found'         => 'चेतावनी: विशेषता समूह नहीं मिला।',
                'update-success'    => 'विशेषता समूह सफलतापूर्वक अपडेट किया गया।',
                'user-define-error' => 'चेतावनी: आप सिस्टम द्वारा बनाए गए विशेषता समूह को हटाने के लिए अधिकृत नहीं हैं।',
            ],

            'attribute-families' => [
                'create-success'          => 'विशेषता परिवार सफलतापूर्वक बनाया गया।',
                'delete-success'          => 'विशेषता परिवार सफलतापूर्वक हटा दिया गया।',
                'not-found'               => 'चेतावनी: विशेषता परिवार नहीं मिला।',
                'update-success'          => 'विशेषता परिवार सफलतापूर्वक अपडेट किया गया।',
                'last-delete-error'       => 'चेतावनी: विशेषता परिवार को नहीं हटाया जा सकता।',
                'attribute-family-error'  => 'चेतावनी: विशेषता परिवार की ज़रूरतें पूरी नहीं हो रही हैं।',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'ग्राहक सफलतापूर्वक बनाया गया।',
                'delete-order-pending' => 'ग्राहक खाता नहीं हटाया जा सकता क्योंकि कुछ आदेश लंबित या प्रक्रिया में हैं।',
                'delete-success'       => 'ग्राहक सफलतापूर्वक हटा दिया गया।',
                'not-found'            => 'चेतावनी: ग्राहक नहीं मिला।',
                'note-created-success' => 'नोट सफलतापूर्वक बनाया गया।',
                'update-success'       => 'ग्राहक सफलतापूर्वक अपडेट किया गया।',
                'login-success'        => 'ग्राहक सफलतापूर्वक लॉगिन हुआ।',
            ],

            'addresses' => [
                'create-success'         => 'ग्राहक का पता सफलतापूर्वक बनाया गया।',
                'default-update-success' => 'पता डिफ़ॉल्ट के रूप में सेट किया गया।',
                'delete-success'         => 'ग्राहक का पता सफलतापूर्वक हटा दिया गया।',
                'not-found'              => 'चेतावनी: ग्राहक का पता नहीं मिला।',
                'update-success'         => 'ग्राहक का पता सफलतापूर्वक अपडेट किया गया।',
                'already-default'        => 'चेतावनी: यह पता पहले से ही डिफ़ॉल्ट के रूप में सेट है।',
            ],

            'groups' => [
                'create-success'     => 'ग्राहक समूह सफलतापूर्वक बनाया गया।',
                'customer-associate' => 'चेतावनी: समूह को नहीं हटाया जा सकता। ग्राहक इससे जुड़ा है।',
                'delete-success'     => 'ग्राहक समूह सफलतापूर्वक हटा दिया गया।',
                'not-found'          => 'चेतावनी: ग्राहक समूह नहीं मिला।',
                'update-success'     => 'ग्राहक समूह सफलतापूर्वक अपडेट किया गया।',
                'user-define-error'  => 'चेतावनी: आप सिस्टम द्वारा बनाए गए ग्राहक समूह को हटाने के लिए अधिकृत नहीं हैं।',
            ],

            'reviews' => [
                'delete-success' => 'समीक्षा सफलतापूर्वक हटा दी गई।',
                'not-found'      => 'चेतावनी: समीक्षा नहीं मिली।',
                'update-success' => 'समीक्षा सफलतापूर्वक अपडेट की गई।',
            ],

            'gdpr' => [
                'delete-success' => 'सफलता: GDPR अनुरोध सफलतापूर्वक हटा दिया गया।',
                'not-found'      => 'चेतावनी: GDPR अनुरोध नहीं मिला।',
                'update-success' => 'GDPR अनुरोध सफलतापूर्वक अपडेट किया गया।',
            ],
        ],

        'cms' => [
            'already-taken'  => 'चेतावनी: स्लग पहले ही लिया गया है।',
            'create-success' => 'CMS सफलतापूर्वक बनाया गया।',
            'delete-success' => 'CMS सफलतापूर्वक हटा दिया गया।',
            'not-found'      => 'चेतावनी: CMS नहीं मिला।',
            'update-success' => 'CMS सफलतापूर्वक अपडेट किया गया।',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'कैटलॉग नियम सफलतापूर्वक बनाया गया।',
                    'delete-failed'  => 'चेतावनी: कैटलॉग नियम को हटाया नहीं जा सका।',
                    'delete-success' => 'कैटलॉग नियम सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: कैटलॉग नियम नहीं मिला।',
                    'update-success' => 'कैटलॉग नियम सफलतापूर्वक अपडेट किया गया।',
                ],

                'cart-rules' => [
                    'create-success' => 'कार्ट नियम सफलतापूर्वक बनाया गया।',
                    'delete-failed'  => 'चेतावनी: कार्ट नियम को हटाया नहीं जा सका।',
                    'delete-success' => 'कार्ट नियम सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: कार्ट नियम नहीं मिला।',
                    'update-success' => 'कार्ट नियम सफलतापूर्वक अपडेट किया गया।',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'ईमेल टेम्पलेट सफलतापूर्वक बनाया गया।',
                    'delete-success' => 'ईमेल टेम्पलेट सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: ईमेल टेम्पलेट नहीं मिला।',
                    'update-success' => 'ईमेल टेम्पलेट सफलतापूर्वक अपडेट किया गया।',
                ],

                'events' => [
                    'create-success' => 'इवेंट सफलतापूर्वक बनाया गया।',
                    'delete-success' => 'इवेंट सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: इवेंट नहीं मिला।',
                    'update-success' => 'इवेंट सफलतापूर्वक अपडेट किया गया।',
                ],

                'campaigns' => [
                    'create-success' => 'कैम्पेन सफलतापूर्वक बनाया गया।',
                    'delete-success' => 'कैम्पेन सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: कैम्पेन नहीं मिला।',
                    'update-success' => 'कैम्पेन सफलतापूर्वक अपडेट किया गया।',
                ],

                'subscriptions' => [
                    'delete-success'      => 'सदस्यता सफलतापूर्वक हटा दी गई।',
                    'not-found'           => 'चेतावनी: सदस्यता नहीं मिली।',
                    'unsubscribe-success' => 'सफलता: सदस्यता सफलतापूर्वक रद्द की गई।',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL रीराइट सफलतापूर्वक बनाया गया।',
                    'delete-success' => 'URL रीराइट सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: URL रीराइट नहीं मिला।',
                    'update-success' => 'URL रीराइट सफलतापूर्वक अपडेट किया गया।',
                ],

                'search-terms' => [
                    'create-success' => 'सर्च टर्म सफलतापूर्वक बनाया गया।',
                    'delete-success' => 'सर्च टर्म सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: सर्च टर्म नहीं मिला।',
                    'update-success' => 'सर्च टर्म सफलतापूर्वक अपडेट किया गया।',
                ],

                'search-synonyms' => [
                    'create-success' => 'सर्च पर्यायवाची सफलतापूर्वक बनाया गया।',
                    'delete-success' => 'सर्च पर्यायवाची सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: सर्च पर्यायवाची नहीं मिला।',
                    'update-success' => 'सर्च पर्यायवाची सफलतापूर्वक अपडेट किया गया।',
                ],

                'sitemaps' => [
                    'create-success' => 'साइटमैप सफलतापूर्वक बनाया गया।',
                    'delete-success' => 'साइटमैप सफलतापूर्वक हटा दिया गया।',
                    'not-found'      => 'चेतावनी: साइटमैप नहीं मिला।',
                    'update-success' => 'साइटमैप सफलतापूर्वक अपडेट किया गया।',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'स्थानीयता सफलतापूर्वक बनाई गई।',
                'default-delete-error' => 'डिफ़ॉल्ट स्थानीयता को हटाया नहीं जा सकता।',
                'delete-error'         => 'स्थानीयता हटाना विफल हुआ।',
                'delete-success'       => 'स्थानीयता सफलतापूर्वक हटा दी गई।',
                'last-delete-error'    => 'अंतिम स्थानीयता हटाना विफल हुआ।',
                'not-found'            => 'चेतावनी: स्थानीयता नहीं मिली।',
                'update-success'       => 'स्थानीयता सफलतापूर्वक अपडेट की गई।',
            ],

            'currencies' => [
                'create-success'       => 'मुद्रा सफलतापूर्वक बनाई गई।',
                'default-delete-error' => 'डिफ़ॉल्ट मुद्रा को हटाया नहीं जा सकता।',
                'delete-error'         => 'मुद्रा हटाना विफल हुआ।',
                'delete-success'       => 'मुद्रा सफलतापूर्वक हटा दी गई।',
                'last-delete-error'    => 'अंतिम मुद्रा हटाना विफल हुआ।',
                'not-found'            => 'चेतावनी: मुद्रा नहीं मिली।',
                'update-success'       => 'मुद्रा सफलतापूर्वक अपडेट की गई।',
            ],

            'exchange-rates' => [
                'create-success'          => 'एक्सचेंज दर सफलतापूर्वक बनाई गई।',
                'delete-error'            => 'एक्सचेंज दर हटाना विफल हुआ।',
                'delete-success'          => 'सफलता: एक्सचेंज दर सफलतापूर्वक हटा दी गई।',
                'invalid-target-currency' => 'चेतावनी: प्रदान की गई लक्ष्य मुद्रा अमान्य है।',
                'last-delete-error'       => 'अंतिम एक्सचेंज दर हटाना विफल हुआ।',
                'not-found'               => 'चेतावनी: एक्सचेंज दर नहीं मिली।',
                'update-success'          => 'एक्सचेंज दर सफलतापूर्वक अपडेट की गई।',
            ],

            'inventory-sources' => [
                'create-success'    => 'इन्वेंट्री सफलतापूर्वक बनाई गई।',
                'delete-error'      => 'इन्वेंट्री हटाना विफल हुआ।',
                'delete-success'    => 'इन्वेंट्री सफलतापूर्वक हटा दी गई।',
                'last-delete-error' => 'अंतिम इन्वेंट्री हटाना विफल हुआ।',
                'not-found'         => 'चेतावनी: इन्वेंट्री नहीं मिली।',
                'update-success'    => 'इन्वेंट्री सफलतापूर्वक अपडेट की गई।',
            ],

            'channels' => [
                'create-success'       => 'चैनल सफलतापूर्वक बनाया गया।',
                'default-delete-error' => 'डिफ़ॉल्ट चैनल को हटाया नहीं जा सकता।',
                'delete-error'         => 'चैनल हटाना विफल हुआ।',
                'delete-success'       => 'चैनल सफलतापूर्वक हटा दिया गया।',
                'last-delete-error'    => 'अंतिम चैनल हटाना विफल हुआ।',
                'not-found'            => 'चेतावनी: चैनल नहीं मिला।',
                'update-success'       => 'चैनल सफलतापूर्वक अपडेट किया गया।',
            ],

            'users' => [
                'activate-warning'  => 'आपका खाता अभी सक्रिय नहीं है, कृपया व्यवस्थापक से संपर्क करें।',
                'create-success'    => 'उपयोगकर्ता सफलतापूर्वक बनाया गया।',
                'delete-error'      => 'उपयोगकर्ता हटाना विफल हुआ।',
                'delete-success'    => 'उपयोगकर्ता सफलतापूर्वक हटा दिया गया।',
                'last-delete-error' => 'अंतिम उपयोगकर्ता हटाना विफल हुआ।',
                'login-error'       => 'कृपया अपने क्रेडेंशियल्स जांचें और पुनः प्रयास करें।',
                'not-found'         => 'चेतावनी: उपयोगकर्ता नहीं मिला।',
                'success-login'     => 'सफलता: उपयोगकर्ता सफलतापूर्वक लॉगिन हुआ।',
                'success-logout'    => 'सफलता: उपयोगकर्ता सफलतापूर्वक लॉगआउट हुआ।',
                'update-success'    => 'उपयोगकर्ता सफलतापूर्वक अपडेट किया गया।',
            ],

            'roles' => [
                'create-success'    => 'भूमिका सफलतापूर्वक बनाई गई।',
                'delete-error'      => 'भूमिका हटाना विफल हुआ।',
                'delete-success'    => 'भूमिका सफलतापूर्वक हटा दी गई।',
                'last-delete-error' => 'अंतिम भूमिका को हटाया नहीं जा सकता।',
                'not-found'         => 'चेतावनी: भूमिका नहीं मिली।',
                'update-success'    => 'भूमिका सफलतापूर्वक अपडेट की गई।',
            ],

            'themes' => [
                'create-success' => 'थीम सफलतापूर्वक बनाई गई।',
                'delete-success' => 'थीम सफलतापूर्वक हटा दी गई।',
                'not-found'      => 'चेतावनी: थीम नहीं मिली।',
                'update-success' => 'थीम सफलतापूर्वक अपडेट की गई।',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'निर्दिष्ट category_id मौजूद नहीं है।',
                        'invalid-boolean-value' => ':key मान केवल 0 या 1 होना चाहिए।',
                        'invalid-filter-key'    => 'फ़िल्टर कुंजी ":key" अनुमत नहीं है।',
                        'invalid-limit-value'   => 'लिमिट मान निम्नलिखित में से एक होना चाहिए: :options।',
                        'invalid-select-option' => ':key मान अमान्य है। मान्य विकल्प हैं: :options।',
                        'invalid-sort-value'    => 'सॉर्ट मान निम्नलिखित में से एक होना चाहिए: :options।',
                        'missing-limit-key'     => 'filtersInput में "limit" कुंजी शामिल होनी चाहिए।',
                        'missing-sort-key'      => 'filtersInput में "sort" कुंजी शामिल होनी चाहिए।',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'कर दर सफलतापूर्वक बनाई गई।',
                'delete-error'   => 'कर दर हटाना विफल हुआ।',
                'delete-success' => 'कर दर सफलतापूर्वक हटा दी गई।',
                'not-found'      => 'चेतावनी: कर दर नहीं मिली।',
                'update-success' => 'कर दर सफलतापूर्वक अपडेट की गई।',
            ],

            'tax-category' => [
                'create-success'     => 'कर श्रेणी सफलतापूर्वक बनाई गई।',
                'delete-error'       => 'कर श्रेणी हटाना विफल हुआ।',
                'delete-success'     => 'कर श्रेणी सफलतापूर्वक हटा दी गई।',
                'not-found'          => 'चेतावनी: कर श्रेणी नहीं मिली।',
                'tax-rate-not-found' => 'दिए गए आईडी नहीं मिले। आईडी:- :ids',
                'update-success'     => 'कर श्रेणी सफलतापूर्वक अपडेट की गई।',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'सूचना जोड़ें',
                    'general'   => 'सामान्य',
                    'title'     => 'पुश सूचना',

                    'datagrid' => [
                        'channel-name'         => 'चैनल का नाम',
                        'created-at'           => 'निर्माण समय',
                        'delete'               => 'हटाएं',
                        'id'                   => 'आईडी',
                        'image'                => 'छवि',
                        'notification-content' => 'सूचना सामग्री',
                        'notification-status'  => 'सूचना स्थिति',
                        'notification-type'    => 'सूचना प्रकार',
                        'text-title'           => 'शीर्षक',
                        'update'               => 'अपडेट',
                        'updated-at'           => 'अपडेट समय',

                        'status' => [
                            'disabled' => 'अक्षम',
                            'enabled'  => 'सक्षम',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'वापस',
                    'content-and-image'    => 'सूचना सामग्री और छवि',
                    'create-btn-title'     => 'सूचना सहेजें',
                    'general'              => 'सामान्य',
                    'image'                => 'छवि',
                    'new-notification'     => 'नई सूचना',
                    'notification-content' => 'सूचना सामग्री',
                    'notification-type'    => 'सूचना प्रकार',
                    'product-cat-id'       => 'उत्पाद/श्रेणी आईडी',
                    'settings'             => 'सेटिंग',
                    'status'               => 'स्थिति',
                    'store-view'           => 'चैनल',
                    'title'                => 'पुश सूचना',

                    'option-type' => [
                        'category' => 'श्रेणी',
                        'others'   => 'साधारण',
                        'product'  => 'उत्पाद',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'वापस',
                    'content-and-image'    => 'सूचना सामग्री और छवि',
                    'edit-notification'    => 'सूचना संपादित करें',
                    'general'              => 'सामान्य',
                    'image'                => 'छवि',
                    'notification-content' => 'सूचना सामग्री',
                    'notification-type'    => 'सूचना प्रकार',
                    'product-cat-id'       => 'उत्पाद/श्रेणी आईडी',
                    'send-title'           => 'सूचना भेजें',
                    'settings'             => 'सेटिंग',
                    'status'               => 'स्थिति',
                    'store-view'           => 'चैनल',
                    'title'                => 'पुश सूचना',
                    'update-btn-title'     => 'अपडेट',

                    'option-type' => [
                        'category' => 'श्रेणी',
                        'others'   => 'साधारण',
                        'product'  => 'उत्पाद',
                    ],
                ],

                'not-found'           => 'चेतावनी: सूचना नहीं मिली।',
                'create-success'      => 'सूचना सफलतापूर्वक बनाई गई।',
                'delete-failed'       => 'सूचना को हटाना विफल रहा।',
                'delete-success'      => 'सूचना सफलतापूर्वक हटा दी गई।',
                'mass-update-success' => 'चयनित सूचनाएँ सफलतापूर्वक अपडेट की गईं।',
                'mass-delete-success' => 'चयनित सूचनाएँ सफलतापूर्वक हटा दी गईं।',
                'no-value-selected'   => 'कोई मान मौजूद नहीं है।',
                'send-success'        => 'सूचना सफलतापूर्वक भेजी गई।',
                'update-success'      => 'सूचना सफलतापूर्वक अपडेट की गई।',
                'configuration-error' => 'चेतावनी: FCM कॉन्फ़िगरेशन नहीं मिली।',
                'product-not-found'   => 'चेतावनी: उत्पाद नहीं मिला।',
                'category-not-found'  => 'चेतावनी: श्रेणी नहीं मिली।',

            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'चेतावनी: अमान्य पैरामीटर प्रदान किए गए हैं।',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'चेतावनी: ईमेल कॉन्फ़िगरेशन नहीं मिला।',
    ],
];
