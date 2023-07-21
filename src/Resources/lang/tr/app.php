<?php

return [
    'admin'     => [
        'menu'  => [
            'push-notification' => 'Bildirimleri Gönder',
        ],

        'acl'  => [
            'push-notification' => 'Bildirimleri Gönder',
            'send'              => 'Gönder',
        ],

        'system' => [
            'graphql-api'                       => 'GraphQL API',
            'push-notification-configuration'   => 'FCM Bildirim Ayarları',
            'server-key'                        => 'Sunucu Anahtarı',
            'info-get-server-key'               => 'Bilgi: FCM API kimlik bilgilerini almak için: <a href="https://console.firebase.google.com/" target="_blank">buraya tıklayın</a>',
            'android-topic'                     => 'Android Konusu',
            'ios-topic'                         => 'iOS Konusu',
        ],

        'notification'  => [
            'title'                 => 'Bildirimleri Gönder',
            'add-title'             => 'Bildirim Ekle',
            'general'               => 'Genel',

            'id'                    => 'ID',
            'image'                 => 'Resim',
            'text-title'            => 'Başlık',
            'edit-notification'     => 'Bildirimi Düzenle',
            'manage'                => 'Bildirimler',
            'new-notification'      => 'Yeni Bildirim',
            'create-btn-title'      => 'Bildirimi Kaydet',
            'notification-image'    => 'Bildirim Resmi',
            'notification-title'    => 'Bildirim Başlığı',
            'notification-content'  => 'Bildirim İçeriği',
            'notification-type'     => 'Bildirim Türü',
            'product-cat-id'        => 'Ürün/Kategori ID',
            'store-view'            => 'Kanallar',
            'notification-status'   => 'Bildirim Durumu',
            'created'               => 'Oluşturuldu',
            'modified'              => 'Düzenlendi',
            'collection-autocomplete'   => 'Özel Koleksiyon - (Otomatik Tamamlama)',
            'no-collection-found'       => 'Aynı adı taşıyan koleksiyonlar bulunamadı.',
            'collection-search-hint'    => 'Koleksiyon adını yazmaya başlayın',
            
            'Action'    => [
                'edit'      => 'Düzenle',
            ],

            'status'    => [
                'enabled'   => 'Etkin',
                'disabled'  => 'Devre Dışı',
            ],

            'notification-type-option'  => [
                'select'            => '-- Seçin --',
                'simple'            => 'Basit Tür',
                'product'           => 'Ürüne Dayalı',
                'category'          => 'Kategoriye Dayalı',
            ],
        ],

        'alert' => [
            'create-success'        => ':name başarıyla oluşturuldu',
            'update-success'        => ':name başarıyla güncellendi',
            'delete-success'        => ':name başarıyla silindi',
            'delete-failed'         => ':name silme başarısız',
            'sended-successfully'   => ':name başarıyla Android ve iOS için gönderildi.',
            'no-value-selected'     => 'mevcut değer yok',
        ],

        'settings'   => [
            'exchange_rates' => [
                'error-invalid-target-currency' => 'Uyarı: Geçersiz hedef para birimi sağlandı.',
                'delete-success'        => 'Başarı: Döviz kuru başarıyla silindi.',
            ]
        ],
        
        'response'  => [
            'error-invalid-parameter'   => 'Uyarı: Geçersiz parametreler sağlandı.',
            'success-login'             => 'Başarı: Kullanıcı başarıyla giriş yaptı.',
            'error-login'               => 'Uyarı: Yönetici kullanıcısı giriş yapmadı.',
            'session-expired'           => 'Uyarı: Oturum süresi doldu. Lütfen tekrar hesabınıza giriş yapın.',
            'invalid-header'            => 'Uyarı: Geçersiz başlık belirteci.',
            'success-logout'            => 'Başarı: Kullanıcı başarıyla çıkış yaptı.',
            'no-login-user'             => 'Uyarı: Giriş yapmış kullanıcı bulunamadı.',
            'error-customer-group'      => 'Uyarı: Sistem tarafından oluşturulan nitelik grubunu silmeye yetkiniz yok.',
            'password-invalid'          => 'Uyarı: Lütfen doğru şifreyi girin.',
            'password-match'            => 'Uyarı: Şifreler eşleşmiyor.',
            'success-registered'        => 'Başarı: Kullanıcı başarıyla oluşturuldu.',
            'cancel-error'              => 'Sipariş iptal edilemez.',
            'creation-error'            => 'Bu sipariş için iade oluşturulamaz.',
            'channel-failure'           => 'Kanal Bulunamadı.',
            'script-delete-success'     => 'Komut dosyası başarıyla silindi.'
        ]
    ],

    'shop'  => [
        'customer'  => [
            'success-login'         => 'Başarı: Müşteri başarıyla giriş yaptı.',
            'success-logout'        => 'Başarı: Müşteri başarıyla çıkış yaptı.',
            'no-login-customer'     => 'Uyarı: Giriş yapmış müşteri bulunamadı.',
            'address-list'          => 'Başarı: Müşteri adres ayrıntıları alındı',
            'not-authorized'        => 'Uyarı: Bu adresi güncelleme izniniz yok.',
            'success-address-list'  => 'Başarı: Müşteri adresleri başarıyla alındı.',
            'no-address-list'       => 'Uyarı: Hiçbir müşteri adresi bulunamadı.',
            'text-password'         => 'Şifreniz: :password',
            'not-exists'            => 'Uyarı: Sağlanan veriler için müşteri bulunamadı.',
        ],
        'response'  => [
            'error-registration'        => 'Uyarı: Müşteri kaydı başarısız oldu.',
            'password-reset-failed'     => 'Uyarı: Şifre sıfırlama e-postasını zaten gönderdik, bir süre sonra tekrar deneyin.',
            'customer-details'          => 'Başarı: Müşteri ayrıntıları başarıyla alındı.',
            'not-found'                 => 'Uyarı: :name bulunamadı.',
            'no-address-found'          => 'Uyarı: Adres bulunamadı.',
            'no-order-found'            => 'Uyarı: Sipariş bulunamadı.',
            'warning-empty-cart'        => 'Uyarı: Sepete eklenmiş ürün yok.',
            'success-add-to-cart'       => 'Başarı: Ürün başarıyla sepete eklendi.',
            'success-update-to-cart'    => 'Başarı: Sepet öğesi başarıyla güncellendi.',
            'success-delete-cart-item'  => 'Başarı: Sepet öğesi başarıyla kaldırıldı.',
            'success-moved-cart-item'   => 'Başarı: Sepet öğesi başarıyla dilek listesine taşındı.',
            'billing-address-missing'   => 'Uyarı: Ödeme için fatura adresi eksik.',
            'shipping-address-missing'  => 'Uyarı: Ödeme için teslimat adresi eksik.',
            'invalid-address'           => 'Uyarı: Sağlanan addressId için adres bulunamadı.',
            'wrong-error'               => 'Uyarı: Sepetinizle ilgili bir hata var, tekrar deneyin.',
            'save-cart-address'         => 'Başarı: Sepet adresi başarıyla kaydedildi.',
            'error-payment-selection'   => 'Uyarı: Ödeme yöntemleri alınırken bir hata oluştu.',
            'selected-shipment'         => 'Başarı: Gönderim başarıyla seçildi.',
            'error-payment-save'        => 'Uyarı: Ödeme yöntemi kaydedilirken bir hata oluştu.',
            'selected-payment'          => 'Başarı: Ödeme yöntemi başarıyla seçildi.',
            'error-placing-order'       => 'Uyarı: Sipariş verirken bir hata oluştu.',
            'invalid-product'           => 'Uyarı: Geçersiz ürün talep ediyorsunuz.',
            'already-exist-inwishlist'  => 'Bilgi: Bu ürün zaten dilek listesinde mevcut.',
            'error-move-to-cart'        => 'Uyarı: Bu ürünün bazı zorunlu seçenekleri olabilir, sepete taşınamaz.',
            'no-billing-address-found'  => 'Uyarı: Fatura adresi kaydı bulunamadı - :address_id fatura kimliği ile.',
            'no-shipping-address-found'  => 'Uyarı: Teslimat adresi kaydı bulunamadı - :address_id teslimat kimliği ile.',
            'invalid-guest-access'      => 'Uyarı: Misafir müşterilere fatura / teslimat adresi kimliği ile adres almak için izin verilmez.',
            'guest-address-warning'     => 'Uyarı: Misafir olarak deniyorsanız, yetki belirteci olmadan deneyin.',
            'warning-num-already-used'  => 'Uyarı: Bu :phone numarası farklı bir e-posta adresi kullanılarak kayıtlı.',
            'coupon-removed'            => 'Başarı: kupon başarıyla sepetten kaldırıldı.',
            'coupon-remove-failed'      => 'Uyarı: kuponu sepetten kaldırma veya kupon bulunamama konusunda bazı hatalar var.',
            'review-create-success'     => 'Başarı: İnceleme başarıyla gönderildi, onay için lütfen bekleyin.',
        ]
    ],
    
    'validation' => [
        'unique'    => 'Bu :field zaten alınmış.',
        'required'  => ':field alanı gereklidir.',
        'same'      => ':field ve şifre eşleşmelidir.'
    ],
    
    'mail' => [
        'customer'  => [
            'password' => [
                'heading'   => config('app.name') . ' - Şifre Sıfırlama',
                'reset'     => 'Şifre Sıfırlama E-postası',
                'summary' => 'Bu e-posta, hesabınızın şifresini sıfırlama ile ilgilidir. Şifreniz başarıyla değiştirildi.
                Aşağıdaki şifre kullanarak hesabınıza giriş yapın.',
            ]
        ]
    ]
];