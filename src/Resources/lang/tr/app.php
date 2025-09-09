<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Bültenimize zaten abone oldunuz.',
            'subscribe-success'  => 'Bültenimize başarıyla abone oldunuz.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Bizimle iletişime geçtiğiniz için teşekkür ederiz. Size en kısa sürede geri döneceğiz.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Uyarı: İndirilebilir bağlantı bulunamadı.',
                'sample-not-found' => 'Uyarı: İndirilebilir örnek bulunamadı.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Uyarı: Giriş yapmış müşteri bulunamadı.',
            'success-login'     => 'Başarılı: Müşteri girişi başarılı.',
            'success-logout'    => 'Başarılı: Müşteri çıkışı başarılı.',

            'signup' => [
                'error-registration' => 'Uyarı: Müşteri kaydı başarısız oldu.',
                'success-verify'     => 'Hesap başarıyla oluşturuldu, doğrulama için bir e-posta gönderildi.',
                'success'            => 'Başarılı: Müşteri başarıyla kaydedildi ve giriş yaptı.',
            ],

            'social-login' => [
                'disabled' => 'Uyarı: Sosyal giriş devre dışı bırakıldı.',
            ],

            'login' => [
                'invalid-creds' => 'Lütfen kimlik bilgilerinizi kontrol edin ve tekrar deneyin.',
                'not-activated' => 'Aktivasyonunuz yönetici onayı gerektirir',
                'verify-first'  => 'Lütfen önce e-postanızı doğrulayın.',
                'suspended'     => 'Hesabınız yönetici tarafından askıya alındı.',

                'validation' => [
                    'required' => ':field alanı gereklidir.',
                    'same'     => ':field ve şifre eşleşmelidir.',
                    'unique'   => 'Bu :field zaten alınmıştır.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Şifre sıfırlama bağlantısı zaten e-postanıza gönderildi.',
                'email-not-exist' => 'E-posta mevcut değil.',
                'reset-link-sent' => 'Şifre sıfırlama bağlantısı e-postanıza gönderildi.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Başarı: Müşteri detayları başarıyla getirildi.',
                    'delete-success'   => 'Başarı: Hesap başarıyla silindi.',
                    'password-unmatch' => 'Şifre eşleşmiyor.',
                    'update-fail'      => 'Uyarı: Profil güncellenmedi.',
                    'update-success'   => 'Başarı: Profil başarıyla güncellendi.',
                    'wrong-password'   => 'Uyarı: Yanlış şifre girildi.',
                    'order-pending'    => 'Bekleyen siparişleriniz olduğu için hesabı silemezsiniz.',
                ],

                'addresses' => [
                    'create-success'         => 'Adres başarıyla oluşturuldu.',
                    'default-update-success' => 'Adres varsayılan olarak ayarlandı',
                    'delete-success'         => 'Adres başarıyla silindi',
                    'not-found'              => 'Uyarı: Adres bulunamadı.',
                    'update-success'         => 'Adres başarıyla güncellendi.',
                    'already-default'        => 'Uyarı: Bu adres zaten varsayılan olarak ayarlandı.',
                ],

                'wishlist' => [
                    'product-removed' => 'Uyarı: Ürün bulunamadı.',
                    'success'         => 'Başarılı: Ürün başarıyla favorilere eklendi.',
                    'already-exist'   => 'Uyarı: Zaten favorilere eklenmiş.',
                    'remove-success'  => 'Başarılı: Ürün favorilerden başarıyla kaldırıldı.',
                    'not-found'       => 'Uyarı: Favorilerde ürün bulunamadı.',
                    'moved-to-cart'   => 'Başarılı: Ürün başarıyla sepete taşındı.',
                ],

                'orders' => [
                    'not-found'      => 'Uyarı: Sipariş bulunamadı.',
                    'cancel-error'   => 'Uyarı: Sipariş iptal edilemedi.',
                    'cancel-success' => 'Başarılı: Sipariş başarıyla iptal edildi.',

                    'shipment' => [
                        'not-found' => 'Uyarı: Sevkiyat bulunamadı.',
                    ],

                    'invoice' => [
                        'not-found' => 'Uyarı: Fatura bulunamadı.',
                    ],

                    'refund' => [
                        'not-found' => 'Uyarı: İade bulunamadı.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Uyarı: İndirilebilir ürün bulunamadı.',
                    'not-auth'       => 'Uyarı: Bu işlemi gerçekleştirmek için yetkili değilsiniz.',
                    'payment-error'  => 'Bu indirme için ödeme yapılmadı.',
                    'download-error' => 'İndirme bağlantısı süresi dolmuş.',
                ],

                'gdpr' => [
                    'create-success'       => 'Başarılı: GDPR isteği başarıyla oluşturuldu.',
                    'revoke-failed'        => 'Uyarı: GDPR isteği iptal edilemedi.',
                    'revoked-successfully' => 'Başarılı: GDPR isteği başarıyla iptal edildi.',
                    'not-enabled'          => 'Uyarı: GDPR etkin değil.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Uyarı: Karşılaştırma ürünü bulunamadı.',
                'product-not-found'   => 'Uyarı: Ürün bulunamadı.',
                'already-added'       => 'Uyarı: Ürün zaten karşılaştırma listesine eklendi.',
                'item-add-success'    => 'Başarı: Ürün başarıyla karşılaştırma listesine eklendi.',
                'remove-success'      => 'Başarı: Öğe başarıyla karşılaştırma listesinden çıkarıldı.',
                'mass-remove-success' => 'Başarı: Seçilen öğeler başarıyla silindi.',
                'not-auth'            => 'Uyarı: Bu işlemi gerçekleştirmek için yetkili değilsiniz.',
            ],

            'reviews' => [
                'create-success'      => 'Başarılı: İnceleme başarıyla oluşturuldu.',
                'delete-success'      => 'Başarılı: İnceleme başarıyla silindi.',
                'mass-delete-success' => 'Başarılı: Seçilen incelemeler başarıyla silindi.',
                'not-found'           => 'Uyarı: İnceleme bulunamadı.',
                'product-not-found'   => 'Uyarı: Ürün bulunamadı.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Uyarı: İndirilebilir ürünler için indirme bağlantıları sağlanmadı.',
                        'invalid-parameter'  => 'Uyarı: Geçersiz parametreler sağlandı.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Başarılı: Ürün başarıyla sepete eklendi.',
                        'update-to-cart'   => 'Başarılı: Ürün başarıyla sepete güncellendi.',
                        'delete-cart-item' => 'Başarılı: Ürün sepetten başarıyla kaldırıldı.',
                        'all-remove'       => 'Başarılı: Tüm ürünler sepetten kaldırıldı.',
                        'move-to-wishlist' => 'Başarılı: Seçilen ürünler başarıyla favorilere taşındı.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Uyarı: Tüm ürünler sepetten kaldırılamadı.',
                        'update-to-cart'   => 'Uyarı: Ürün sepete eklenemedi.',
                        'delete-cart-item' => 'Uyarı: Ürün sepetten kaldırılamadı.',
                        'not-found'        => 'Uyarı: Sepet bulunamadı.',
                        'item-not-found'   => 'Uyarı: Ürün bulunamadı.',
                        'move-to-wishlist' => 'Uyarı: Seçilen ürünler favorilere taşınamadı.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Uyarı: Misafir kullanıcı adres ekleyemez.',
                'guest-checkout-warning'    => 'Uyarı: Misafir kullanıcı ödeme yapamaz.',
                'no-billing-address-found'  => 'Uyarı: Fatura adresi bulunamadı.',
                'no-shipping-address-found' => 'Uyarı: Kargo adresi bulunamadı.',
                'address-save-success'      => 'Başarılı: Adres başarıyla kaydedildi.',
            ],

            'shipping' => [
                'method-not-found' => 'Uyarı: Kargo yöntemi bulunamadı.',
                'method-fetched'   => 'Başarılı: Kargo yöntemi başarıyla alındı.',
                'save-failed'      => 'Uyarı: Kargo yöntemi kaydedilemedi.',
                'save-success'     => 'Başarılı: Kargo yöntemi başarıyla kaydedildi.',
            ],

            'payment' => [
                'method-not-found' => 'Uyarı: Ödeme yöntemi bulunamadı.',
                'method-fetched'   => 'Başarılı: Ödeme yöntemi başarıyla alındı.',
                'save-failed'      => 'Uyarı: Ödeme yöntemi kaydedilemedi.',
                'save-success'     => 'Başarılı: Ödeme yöntemi başarıyla kaydedildi.',
            ],

            'coupon' => [
                'apply-success'   => 'Başarılı: Kupon kodu başarıyla uygulandı.',
                'already-applied' => 'Uyarı: Kupon kodu zaten uygulandı.',
                'invalid-code'    => 'Uyarı: Kupon kodu geçersiz.',
                'remove-success'  => 'Başarılı: Kupon kodu başarıyla kaldırıldı.',
                'remove-failed'   => 'Uyarı: Kupon kodu kaldırılamadı.',
            ],

            'something-wrong'          => 'Uyarı: Bir şeyler yanlış gitti.',
            'invalid-guest-user'       => 'Uyarı: Geçersiz misafir kullanıcı.',
            'empty-cart'               => 'Uyarı: Sepet boş.',
            'missing-billing-address'  => 'Uyarı: Fatura adresi eksik.',
            'missing-shipping-address' => 'Uyarı: Kargo adresi eksik.',
            'missing-shipping-method'  => 'Uyarı: Kargo yöntemi eksik.',
            'missing-payment-method'   => 'Uyarı: Ödeme yöntemi eksik.',
            'no-address-found'         => 'Uyarı: Fatura ve kargo adresi bulunamadı.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Oluştur',
            'delete'            => 'Sil',
            'edit'              => 'Düzenle',
            'mass-delete'       => 'Toplu Sil',
            'mass-update'       => 'Toplu Güncelleme',
            'push-notification' => 'Bildirim Gönder',
            'send'              => 'Gönder',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Bildirim Gönder',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Bildirim Konusu',
                        'info'                            => 'Bildirimle ilgili yapılandırmalar',
                        'push-notification-configuration' => 'FCM Anlık Bildirim Yapılandırması',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Özel Anahtar JSON Dosya İçeriği',
                        'info-get-private-key'            => 'Bilgi: FCM Özel Anahtar JSON Dosya İçeriğini Almak İçin: <a href="https://console.firebase.google.com/" target="_blank">Buraya tıklayın</a>',
                    ],
                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Başarılı: Özel komut dosyaları başarıyla güncellendi.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Uyarı: Sipariş iptal edilemedi.',
                'cancel-success' => 'Başarılı: Sipariş başarıyla iptal edildi.',
                'not-found'      => 'Uyarı: Sipariş bulunamadı.',
            ],

            'shipments' => [
                'creation-error'   => 'Uyarı: Sevkiyat oluşturulamadı.',
                'not-found'        => 'Uyarı: Sevkiyat bulunamadı.',
                'quantity-invalid' => 'Uyarı: Geçersiz miktar sağlandı.',
                'shipment-error'   => 'Uyarı: Sevkiyat oluşturulamadı.',
                'create-success'   => 'Başarılı: Sevkiyat başarıyla oluşturuldu.',
            ],

            'invoices' => [
                'creation-error' => 'Uyarı: Fatura oluşturulamadı.',
                'not-found'      => 'Uyarı: Fatura bulunamadı.',
                'product-error'  => 'Uyarı: Geçersiz ürün sağlandı.',
                'create-success' => 'Başarılı: Fatura başarıyla oluşturuldu.',
                'invalid-qty'    => 'Uyarı: Fatura öğeleri için geçersiz bir miktar bulundu.',
            ],

            'refunds' => [
                'creation-error'      => 'Uyarı: İade oluşturulamadı.',
                'refund-amount-error' => 'Uyarı: Geçersiz iade tutarı sağlandı.',
                'refund-limit-error'  => 'Uyarı: İade tutarı :amount limitini aşıyor.',
                'not-found'           => 'Uyarı: İade bulunamadı.',
                'create-success'      => 'Başarılı: İade başarıyla oluşturuldu.',
            ],

            'transactions' => [
                'already-paid'   => 'Uyarı: Fatura zaten ödendi.',
                'amount-exceed'  => 'Uyarı: İşlem tutarı limiti aşıyor.',
                'zero-amount'    => 'Uyarı: İşlem tutarı sıfırdan büyük olmalıdır.',
                'create-success' => 'Başarılı: İşlem başarıyla oluşturuldu.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Uyarı: Müşteri bulunamadı.',
                'cart-not-found'           => 'Uyarı: Sepet bulunamadı.',
                'cart-item-not-found'      => 'Uyarı: Sepet öğesi bulunamadı.',
                'cart-create-success'      => 'Başarılı: Sepet başarıyla oluşturuldu.',
                'cart-item-add-success'    => 'Başarılı: Ürün sepete başarıyla eklendi.',
                'cart-item-remove-success' => 'Başarılı: Öğe sepetten başarıyla kaldırıldı.',
                'cart-item-update-success' => 'Başarılı: Ürün sepete başarıyla güncellendi.',
                'something-wrong'          => 'Uyarı: Bir şeyler yanlış gitti.',
                'address-save-success'     => 'Başarılı: Adres başarıyla kaydedildi.',
                'shipping-save-success'    => 'Başarılı: Kargo yöntemi başarıyla kaydedildi.',
                'payment-save-success'     => 'Başarılı: Ödeme yöntemi başarıyla kaydedildi.',
                'order-placed-success'     => 'Başarılı: Sipariş başarıyla yerleştirildi.',
                'payment-method-not-found' => 'Uyarı: Ödeme yöntemi bulunamadı.',
                'minimum-order-amount-err' => 'Uyarı: Minimum sipariş tutarı :amount olmalıdır',
                'check-shipping-address'   => 'Uyarı: Lütfen teslimat adresini kontrol edin.',
                'check-billing-address'    => 'Uyarı: Lütfen fatura adresini kontrol edin.',
                'specify-shipping-method'  => 'Uyarı: Lütfen kargo yöntemini belirtin.',
                'specify-payment-method'   => 'Uyarı: Lütfen ödeme yöntemini belirtin.',
                'coupon-not-valid'         => 'Uyarı: Kupon kodu geçerli değil.',
                'coupon-already-applied'   => 'Uyarı: Kupon kodu zaten uygulandı.',
                'coupon-applied'           => 'Başarılı: Kupon kodu başarıyla uygulandı.',
                'coupon-removed'           => 'Başarılı: Kupon kodu başarıyla kaldırıldı.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Ürün başarıyla oluşturuldu.',
                'delete-success'            => 'Ürün başarıyla silindi',
                'not-found'                 => 'Uyarı: Ürün bulunamadı.',
                'update-success'            => 'Ürün başarıyla güncellendi.',
                'configurable-attr-missing' => 'Uyarı: Yapılandırılabilir özellik eksik.',
                'simple-products-error'     => 'Uyarı: Basit ürünler eksik.',
            ],

            'categories' => [
                'already-taken'  => 'Uyarı: Bu slug zaten kullanılmış.',
                'create-success' => 'Kategori başarıyla oluşturuldu.',
                'delete-success' => 'Kategori başarıyla silindi',
                'not-found'      => 'Uyarı: Kategori bulunamadı.',
                'update-success' => 'Kategori başarıyla güncellendi.',
                'root-delete'    => 'Uyarı: Kök kategori silinemez.',
            ],

            'attributes' => [
                'create-success'    => 'Özellik başarıyla oluşturuldu.',
                'delete-success'    => 'Özellik başarıyla silindi',
                'not-found'         => 'Uyarı: Özellik bulunamadı.',
                'update-success'    => 'Özellik başarıyla güncellendi.',
                'user-define-error' => 'Uyarı: Sistem tarafından oluşturulan özelliği silme yetkiniz yok.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Özellik Grubu başarıyla oluşturuldu.',
                'delete-success'    => 'Özellik Grubu başarıyla silindi',
                'not-found'         => 'Uyarı: Özellik Grubu bulunamadı.',
                'update-success'    => 'Özellik Grubu başarıyla güncellendi.',
                'user-define-error' => 'Uyarı: Sistem tarafından oluşturulan özellik grubunu silme yetkiniz yok.',
            ],

            'attribute-families' => [
                'create-success'          => 'Özellik Ailesi başarıyla oluşturuldu.',
                'delete-success'          => 'Özellik Ailesi başarıyla silindi',
                'not-found'               => 'Uyarı: Özellik Ailesi bulunamadı.',
                'update-success'          => 'Özellik Ailesi başarıyla güncellendi.',
                'last-delete-error'       => 'Uyarı: Son Özellik Ailesi silinemez.',
                'attribute-product-error' => 'Uyarı: Bu özellik ailesiyle ilişkili bazı ürün(ler) bulunmaktadır.',
                'user-define-error'       => 'Uyarı: Sistem tarafından oluşturulan özellik ailesini silme yetkiniz yok.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Müşteri başarıyla oluşturuldu.',
                'delete-order-pending' => 'Müşteri hesabı silinemedi çünkü bazı Sipariş(ler) bekliyor veya işlem durumunda.',
                'delete-success'       => 'Müşteri başarıyla silindi',
                'not-found'            => 'Uyarı: Müşteri bulunamadı.',
                'note-created-success' => 'Not başarıyla oluşturuldu',
                'update-success'       => 'Müşteri başarıyla güncellendi.',
                'login-success'        => 'Müşteri başarıyla giriş yaptı.',
            ],

            'addresses' => [
                'create-success'         => 'Müşterinin adresi başarıyla oluşturuldu.',
                'default-update-success' => 'Adres varsayılan olarak ayarlandı.',
                'delete-success'         => 'Müşterinin adresi başarıyla silindi.',
                'not-found'              => 'Uyarı: Müşterinin adresi bulunamadı.',
                'update-success'         => 'Müşterinin adresi başarıyla güncellendi.',
                'already-default'        => 'Uyarı: Bu adres zaten varsayılan olarak ayarlandı.',
            ],

            'groups' => [
                'create-success'     => 'Müşteri Grubu başarıyla oluşturuldu.',
                'customer-associate' => 'Uyarı: Grup silinemez. Müşteri ile ilişkilendirilmiş.',
                'delete-success'     => 'Müşteri Grubu başarıyla silindi',
                'not-found'          => 'Uyarı: Müşteri Grubu bulunamadı.',
                'update-success'     => 'Müşteri Grubu başarıyla güncellendi.',
                'user-define-error'  => 'Uyarı: Sistem tarafından oluşturulan Müşteri Grubunu silme yetkiniz yok.',
            ],

            'reviews' => [
                'delete-success' => 'İnceleme başarıyla silindi',
                'not-found'      => 'Uyarı: İnceleme bulunamadı.',
                'update-success' => 'İnceleme başarıyla güncellendi.',
            ],

            'gdpr' => [
                'delete-success' => 'Başarılı: GDPR isteği başarıyla silindi.',
                'not-found'      => 'Uyarı: GDPR isteği bulunamadı.',
                'update-success' => 'GDPR isteği başarıyla güncellendi.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Uyarı: Bu slug zaten kullanılmış.',
            'create-success' => 'CMS başarıyla oluşturuldu.',
            'delete-success' => 'CMS başarıyla silindi',
            'not-found'      => 'Uyarı: CMS bulunamadı.',
            'update-success' => 'CMS başarıyla güncellendi.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Katalog Kuralı başarıyla oluşturuldu.',
                    'delete-failed'  => 'Uyarı: Katalog Kuralı silinemedi',
                    'delete-success' => 'Katalog Kuralı başarıyla silindi',
                    'not-found'      => 'Uyarı: Katalog Kuralı bulunamadı.',
                    'update-success' => 'Katalog Kuralı başarıyla güncellendi.',
                ],

                'cart-rules' => [
                    'create-success' => 'Sepet Kuralı başarıyla oluşturuldu.',
                    'delete-failed'  => 'Uyarı: Sepet Kuralı silinemedi',
                    'delete-success' => 'Sepet Kuralı başarıyla silindi',
                    'not-found'      => 'Sepet kuralı bulunamadı',
                    'update-success' => 'Sepet Kuralı başarıyla güncellendi.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'E-posta Şablonu başarıyla oluşturuldu.',
                    'delete-success' => 'E-posta Şablonu başarıyla silindi',
                    'not-found'      => 'Uyarı: E-posta Şablonu bulunamadı.',
                    'update-success' => 'E-posta Şablonu başarıyla güncellendi.',
                ],

                'events' => [
                    'create-success' => 'Etkinlik başarıyla oluşturuldu.',
                    'delete-success' => 'Etkinlik başarıyla silindi',
                    'not-found'      => 'Uyarı: Etkinlik bulunamadı.',
                    'update-success' => 'Etkinlik başarıyla güncellendi.',
                ],

                'campaigns' => [
                    'create-success' => 'Kampanya başarıyla oluşturuldu.',
                    'delete-success' => 'Kampanya başarıyla silindi',
                    'not-found'      => 'Uyarı: Kampanya bulunamadı.',
                    'update-success' => 'Kampanya başarıyla güncellendi.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Abonelik başarıyla silindi',
                    'not-found'           => 'Uyarı: Abonelik bulunamadı.',
                    'unsubscribe-success' => 'Başarılı: Abonelik başarıyla iptal edildi.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL Yeniden Yazma başarıyla oluşturuldu.',
                    'delete-success' => 'URL Yeniden Yazma başarıyla silindi',
                    'not-found'      => 'Uyarı: URL Yeniden Yazma bulunamadı.',
                    'update-success' => 'URL Yeniden Yazma başarıyla güncellendi.',
                ],

                'search-terms' => [
                    'create-success' => 'Arama Terimi başarıyla oluşturuldu.',
                    'delete-success' => 'Arama Terimi başarıyla silindi',
                    'not-found'      => 'Uyarı: Arama Terimi bulunamadı.',
                    'update-success' => 'Arama Terimi başarıyla güncellendi.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Arama Eşanlamlısı başarıyla oluşturuldu.',
                    'delete-success' => 'Arama Eşanlamlısı başarıyla silindi',
                    'not-found'      => 'Uyarı: Arama Eşanlamlısı bulunamadı.',
                    'update-success' => 'Arama Eşanlamlısı başarıyla güncellendi.',
                ],

                'sitemaps' => [
                    'create-success' => 'Site Haritası başarıyla oluşturuldu.',
                    'delete-success' => 'Site Haritası başarıyla silindi',
                    'not-found'      => 'Uyarı: Site Haritası bulunamadı.',
                    'update-success' => 'Site Haritası başarıyla güncellendi.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Dil başarıyla oluşturuldu.',
                'default-delete-error' => 'Varsayılan dil silinemez.',
                'delete-error'         => 'Dil silme başarısız.',
                'delete-success'       => 'Dil başarıyla silindi.',
                'last-delete-error'    => 'Son dil silme başarısız.',
                'not-found'            => 'Uyarı: Dil bulunamadı.',
                'update-success'       => 'Dil başarıyla güncellendi.',
            ],

            'currencies' => [
                'create-success'       => 'Para birimi başarıyla oluşturuldu.',
                'default-delete-error' => 'Varsayılan para birimi silinemez.',
                'delete-error'         => 'Para birimi silme başarısız.',
                'delete-success'       => 'Para birimi başarıyla silindi.',
                'last-delete-error'    => 'Son para birimi silme başarısız.',
                'not-found'            => 'Uyarı: Para birimi bulunamadı.',
                'update-success'       => 'Para birimi başarıyla güncellendi.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Döviz kuru başarıyla oluşturuldu.',
                'delete-error'            => 'Döviz kuru silme başarısız.',
                'delete-success'          => 'Döviz kuru başarıyla silindi.',
                'invalid-target-currency' => 'Uyarı: Geçersiz hedef para birimi sağlandı.',
                'last-delete-error'       => 'Son döviz kuru silme başarısız.',
                'not-found'               => 'Uyarı: Döviz kuru bulunamadı.',
                'update-success'          => 'Döviz kuru başarıyla güncellendi.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Envanter başarıyla oluşturuldu.',
                'delete-error'      => 'Envanter silme başarısız.',
                'delete-success'    => 'Envanter başarıyla silindi.',
                'last-delete-error' => 'Son envanter silme başarısız.',
                'not-found'         => 'Uyarı: Envanter bulunamadı.',
                'update-success'    => 'Envanter başarıyla güncellendi.',
            ],

            'channels' => [
                'create-success'       => 'Kanal başarıyla oluşturuldu.',
                'default-delete-error' => 'Varsayılan kanal silinemez.',
                'delete-error'         => 'Kanal silme başarısız.',
                'delete-success'       => 'Kanal başarıyla silindi.',
                'last-delete-error'    => 'Son kanal silme başarısız.',
                'not-found'            => 'Uyarı: Kanal bulunamadı.',
                'update-success'       => 'Kanal başarıyla güncellendi.',
            ],

            'users' => [
                'activate-warning'  => 'Hesabınız henüz etkinleştirilmedi, lütfen yöneticiyle iletişime geçin.',
                'create-success'    => 'Kullanıcı başarıyla oluşturuldu.',
                'delete-error'      => 'Kullanıcı silme başarısız.',
                'delete-success'    => 'Kullanıcı başarıyla silindi.',
                'last-delete-error' => 'Son kullanıcı silme başarısız.',
                'login-error'       => 'Lütfen kimlik bilgilerinizi kontrol edin ve tekrar deneyin.',
                'not-found'         => 'Uyarı: Kullanıcı bulunamadı.',
                'success-login'     => 'Başarılı: Kullanıcı girişi başarılı.',
                'success-logout'    => 'Başarılı: Kullanıcı çıkışı başarılı.',
                'update-success'    => 'Kullanıcı başarıyla güncellendi.',
            ],

            'roles' => [
                'create-success'    => 'Rol başarıyla oluşturuldu.',
                'delete-error'      => 'Rol silme başarısız.',
                'delete-success'    => 'Rol başarıyla silindi.',
                'last-delete-error' => 'Son rol silinemez.',
                'not-found'         => 'Uyarı: Rol bulunamadı.',
                'update-success'    => 'Rol başarıyla güncellendi.',
            ],

            'themes' => [
                'create-success' => 'Tema başarıyla oluşturuldu.',
                'delete-success' => 'Tema başarıyla silindi.',
                'not-found'      => 'Uyarı: Tema bulunamadı.',
                'update-success' => 'Tema başarıyla güncellendi.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'Belirtilen category_id mevcut değil.',
                        'invalid-boolean-value' => ':key değeri ya 0 ya da 1 olmalıdır.',
                        'invalid-filter-key'    => '":key" filtre anahtarı izin verilmiyor.',
                        'invalid-limit-value'   => 'limit değeri aşağıdakilerden biri olmalıdır: :options.',
                        'invalid-select-option' => ':key değeri geçersizdir. Geçerli seçenekler: :options.',
                        'invalid-sort-value'    => 'Sıralama değeri aşağıdakilerden biri olmalıdır: :options.',
                        'missing-limit-key'     => 'filtersInput "limit" anahtarını içermelidir.',
                        'missing-sort-key'      => 'filtersInput "sort" anahtarını içermelidir.',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Vergi oranı başarıyla oluşturuldu.',
                'delete-error'   => 'Vergi oranı silme başarısız.',
                'delete-success' => 'Vergi oranı başarıyla silindi.',
                'not-found'      => 'Uyarı: Vergi oranı bulunamadı.',
                'update-success' => 'Vergi oranı başarıyla güncellendi.',
            ],

            'tax-category' => [
                'create-success'     => 'Vergi kategorisi başarıyla oluşturuldu.',
                'delete-error'       => 'Vergi kategorisi silme başarısız.',
                'delete-success'     => 'Vergi kategorisi başarıyla silindi.',
                'not-found'          => 'Uyarı: Vergi kategorisi bulunamadı.',
                'tax-rate-not-found' => 'Verilen kimlikler bulunamadı. Kimlikler: :ids',
                'update-success'     => 'Vergi kategorisi başarıyla güncellendi.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Bildirim Ekle',
                    'general'   => 'Genel',
                    'title'     => 'Bildirim Gönder',

                    'datagrid' => [
                        'channel-name'         => 'Kanal Adı',
                        'created-at'           => 'Oluşturulma Zamanı',
                        'delete'               => 'Sil',
                        'id'                   => 'Kimlik',
                        'image'                => 'Resim',
                        'notification-content' => 'Bildirim İçeriği',
                        'notification-status'  => 'Bildirim Durumu',
                        'notification-type'    => 'Bildirim Türü',
                        'text-title'           => 'Başlık',
                        'update'               => 'Güncelle',
                        'updated-at'           => 'Güncellenme Zamanı',

                        'status' => [
                            'disabled' => 'Devre Dışı',
                            'enabled'  => 'Etkin',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Geri',
                    'content-and-image'    => 'Bildirim İçeriği ve Resim',
                    'create-btn-title'     => 'Bildirimi Kaydet',
                    'general'              => 'Genel',
                    'image'                => 'Resim',
                    'new-notification'     => 'Yeni Bildirim',
                    'notification-content' => 'Bildirim İçeriği',
                    'notification-type'    => 'Bildirim Türü',
                    'product-cat-id'       => 'Ürün/Kategori Kimliği',
                    'settings'             => 'Ayar',
                    'status'               => 'Durum',
                    'store-view'           => 'Kanallar',
                    'title'                => 'Bildirim Gönder',

                    'option-type' => [
                        'category' => 'Kategori',
                        'others'   => 'Basit',
                        'product'  => 'Ürün',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Geri',
                    'content-and-image'    => 'Bildirim İçeriği ve Resim',
                    'edit-notification'    => 'Bildirimi Düzenle',
                    'general'              => 'Genel',
                    'image'                => 'Resim',
                    'notification-content' => 'Bildirim İçeriği',
                    'notification-type'    => 'Bildirim Türü',
                    'product-cat-id'       => 'Ürün/Kategori Kimliği',
                    'send-title'           => 'Bildirimi Gönder',
                    'settings'             => 'Ayar',
                    'status'               => 'Durum',
                    'store-view'           => 'Kanallar',
                    'title'                => 'Bildirim Gönder',
                    'update-btn-title'     => 'Güncelle',

                    'option-type' => [
                        'category' => 'Kategori',
                        'others'   => 'Basit',
                        'product'  => 'Ürün',
                    ],
                ],

                'not-found'           => 'Uyarı: Bildirim bulunamadı.',
                'create-success'      => 'Bildirim başarıyla oluşturuldu.',
                'delete-failed'       => 'Bildirim silme başarısız.',
                'delete-success'      => 'Bildirim başarıyla silindi.',
                'mass-update-success' => 'Seçilen bildirimler başarıyla güncellendi.',
                'mass-delete-success' => 'Seçilen bildirimler başarıyla silindi.',
                'no-value-selected'   => 'mevcut değer yok.',
                'send-success'        => 'Bildirim başarıyla gönderildi.',
                'update-success'      => 'Bildirim başarıyla güncellendi.',
                'configuration-error' => 'Uyarı: FCM yapılandırması bulunamadı.',
                'product-not-found'   => 'Uyarı: Ürün bulunamadı.',
                'category-not-found'  => 'Uyarı: Kategori bulunamadı.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Предупреждение: Указаны неверные параметры.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Uyarı: E-posta yapılandırması bulunamadı.',
    ],
];
