<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Anda sudah berlangganan buletin kami.',
            'subscribe-success'  => 'Anda berhasil berlangganan buletin kami.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Terima kasih telah menghubungi kami. Kami akan segera membalas Anda.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Peringatan: Tautan unduhan tidak ditemukan.',
                'sample-not-found' => 'Peringatan: Contoh unduhan tidak ditemukan.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Peringatan: Tidak ada pelanggan yang login.',
            'success-login'     => 'Sukses: Login pelanggan berhasil.',
            'success-logout'    => 'Sukses: Logout pelanggan berhasil.',

            'signup' => [
                'error-registration' => 'Peringatan: Pendaftaran pelanggan gagal.',
                'success-verify'     => 'Akun berhasil dibuat, email telah dikirim untuk verifikasi.',
                'success'            => 'Sukses: Pendaftaran dan login pelanggan berhasil.',
            ],

            'social-login' => [
                'disabled' => 'Peringatan: Login sosial dinonaktifkan.',
            ],

            'login' => [
                'invalid-creds' => 'Silakan periksa kredensial Anda dan coba lagi.',
                'not-activated' => 'Aktivasi akun Anda memerlukan persetujuan admin.',
                'verify-first'  => 'Silakan verifikasi email Anda terlebih dahulu.',
                'suspended'     => 'Akun Anda telah ditangguhkan oleh administrator.',

                'validation' => [
                    'required' => 'Kolom :field wajib diisi.',
                    'same'     => ':field dan kata sandi harus sama.',
                    'unique'   => ':field ini sudah digunakan.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Tautan reset kata sandi sudah dikirim ke email Anda.',
                'email-not-exist' => 'Email tidak ditemukan.',
                'reset-link-sent' => 'Tautan reset kata sandi telah dikirim ke email Anda.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Sukses: Data pelanggan berhasil diambil.',
                    'delete-success'   => 'Sukses: Akun berhasil dihapus.',
                    'password-unmatch' => 'Kata sandi tidak cocok.',
                    'update-fail'      => 'Peringatan: Profil tidak diperbarui.',
                    'update-success'   => 'Sukses: Profil berhasil diperbarui.',
                    'wrong-password'   => 'Peringatan: Kata sandi salah.',
                    'order-pending'    => 'Anda tidak dapat menghapus akun karena masih ada pesanan yang tertunda.',
                ],

                'addresses' => [
                    'create-success'         => 'Alamat berhasil dibuat.',
                    'default-update-success' => 'Alamat berhasil diatur sebagai default.',
                    'delete-success'         => 'Alamat berhasil dihapus.',
                    'not-found'              => 'Peringatan: Alamat tidak ditemukan.',
                    'update-success'         => 'Alamat berhasil diperbarui.',
                    'already-default'        => 'Peringatan: Alamat ini sudah diatur sebagai default.',
                ],

                'wishlist' => [
                    'product-removed' => 'Peringatan: Produk tidak ditemukan.',
                    'success'         => 'Sukses: Produk berhasil ditambahkan ke wishlist.',
                    'already-exist'   => 'Peringatan: Produk sudah ada di wishlist.',
                    'remove-success'  => 'Sukses: Produk berhasil dihapus dari wishlist.',
                    'not-found'       => 'Peringatan: Tidak ada produk dalam wishlist.',
                    'moved-to-cart'   => 'Sukses: Produk berhasil dipindahkan ke keranjang.',
                ],

                'orders' => [
                    'not-found'      => 'Peringatan: Tidak ada pesanan ditemukan.',
                    'cancel-error'   => 'Peringatan: Pesanan tidak dibatalkan.',
                    'cancel-success' => 'Sukses: Pesanan berhasil dibatalkan.',

                    'shipment' => [
                        'not-found' => 'Peringatan: Pengiriman tidak ditemukan.',
                    ],

                    'invoice' => [
                        'not-found' => 'Peringatan: Faktur tidak ditemukan.',
                    ],

                    'refund' => [
                        'not-found' => 'Peringatan: Pengembalian dana tidak ditemukan.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Peringatan: Produk unduhan tidak ditemukan.',
                    'not-auth'       => 'Peringatan: Anda tidak memiliki izin untuk melakukan tindakan ini.',
                    'payment-error'  => 'Pembayaran belum dilakukan untuk unduhan ini.',
                    'download-error' => 'Tautan unduhan telah kedaluwarsa.',
                ],

                'gdpr' => [
                    'create-success'       => 'Sukses: Permintaan GDPR berhasil dibuat.',
                    'revoke-failed'        => 'Peringatan: Permintaan GDPR tidak dicabut.',
                    'revoked-successfully' => 'Sukses: Permintaan GDPR berhasil dicabut.',
                    'not-enabled'          => 'Peringatan: GDPR tidak diaktifkan.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Peringatan: Produk perbandingan tidak ditemukan.',
                'product-not-found'   => 'Peringatan: Produk tidak ditemukan.',
                'already-added'       => 'Peringatan: Produk sudah ada dalam daftar perbandingan.',
                'item-add-success'    => 'Sukses: Produk berhasil ditambahkan ke daftar perbandingan.',
                'remove-success'      => 'Sukses: Produk berhasil dihapus dari daftar perbandingan.',
                'mass-remove-success' => 'Sukses: Produk yang dipilih berhasil dihapus.',
                'not-auth'            => 'Peringatan: Anda tidak memiliki izin untuk melakukan tindakan ini.',
            ],

            'reviews' => [
                'create-success'      => 'Sukses: Ulasan berhasil dibuat.',
                'delete-success'      => 'Sukses: Ulasan berhasil dihapus.',
                'mass-delete-success' => 'Sukses: Ulasan yang dipilih berhasil dihapus.',
                'not-found'           => 'Peringatan: Ulasan tidak ditemukan.',
                'product-not-found'   => 'Peringatan: Produk tidak ditemukan.',
                'not-auth'            => 'Peringatan: Anda tidak memiliki izin untuk melakukan tindakan ini.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Peringatan: Tautan unduhan tidak valid.',
                        'invalid-parameter'  => 'Peringatan: Parameter tidak valid.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Sukses: Produk berhasil ditambahkan ke keranjang.',
                        'update-to-cart'   => 'Sukses: Produk berhasil diperbarui di keranjang.',
                        'delete-cart-item' => 'Sukses: Produk berhasil dihapus dari keranjang.',
                        'all-remove'       => 'Sukses: Semua produk berhasil dihapus dari keranjang.',
                        'move-to-wishlist' => 'Sukses: Produk yang dipilih berhasil dipindahkan ke wishlist.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Peringatan: Semua produk tidak berhasil dihapus dari keranjang.',
                        'update-to-cart'   => 'Peringatan: Produk tidak diperbarui di keranjang.',
                        'delete-cart-item' => 'Peringatan: Produk tidak dihapus dari keranjang.',
                        'not-found'        => 'Peringatan: Keranjang tidak ditemukan.',
                        'item-not-found'   => 'Peringatan: Produk tidak ditemukan.',
                        'move-to-wishlist' => 'Peringatan: Produk yang dipilih tidak berhasil dipindahkan ke wishlist.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Peringatan: Pengguna tamu tidak dapat menambahkan alamat.',
                'guest-checkout-warning'    => 'Peringatan: Pengguna tamu tidak dapat melakukan checkout.',
                'no-billing-address-found'  => 'Peringatan: Alamat penagihan tidak ditemukan.',
                'no-shipping-address-found' => 'Peringatan: Alamat pengiriman tidak ditemukan.',
                'address-save-success'      => 'Sukses: Alamat berhasil disimpan.',
            ],

            'shipping' => [
                'method-not-found' => 'Peringatan: Metode pengiriman tidak ditemukan.',
                'method-fetched'   => 'Sukses: Metode pengiriman berhasil diambil.',
                'save-failed'      => 'Peringatan: Metode pengiriman tidak berhasil disimpan.',
                'save-success'     => 'Sukses: Metode pengiriman berhasil disimpan.',
            ],

            'payment' => [
                'method-not-found' => 'Peringatan: Metode pembayaran tidak ditemukan.',
                'method-fetched'   => 'Sukses: Metode pembayaran berhasil diambil.',
                'save-failed'      => 'Peringatan: Metode pembayaran tidak berhasil disimpan.',
                'save-success'     => 'Sukses: Metode pembayaran berhasil disimpan.',
            ],

            'coupon' => [
                'apply-success'   => 'Sukses: Kode kupon berhasil diterapkan.',
                'already-applied' => 'Peringatan: Kode kupon sudah diterapkan.',
                'invalid-code'    => 'Peringatan: Kode kupon tidak valid.',
                'remove-success'  => 'Sukses: Kode kupon berhasil dihapus.',
                'remove-failed'   => 'Peringatan: Kode kupon tidak berhasil dihapus.',
            ],

            'something-wrong'          => 'Peringatan: Terjadi kesalahan.',
            'invalid-guest-user'       => 'Peringatan: Pengguna tamu tidak valid.',
            'empty-cart'               => 'Peringatan: Keranjang kosong.',
            'missing-billing-address'  => 'Peringatan: Alamat penagihan hilang.',
            'missing-shipping-address' => 'Peringatan: Alamat pengiriman hilang.',
            'missing-shipping-method'  => 'Peringatan: Metode pengiriman hilang.',
            'missing-payment-method'   => 'Peringatan: Metode pembayaran hilang.',
            'no-address-found'         => 'Peringatan: Alamat penagihan dan pengiriman tidak ditemukan.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Buat',
            'delete'            => 'Hapus',
            'edit'              => 'Ubah',
            'mass-delete'       => 'Hapus Massal',
            'mass-update'       => 'Perbarui Massal',
            'push-notification' => 'Notifikasi Push',
            'send'              => 'Kirim',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Notifikasi Push',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Topik Notifikasi',
                        'info'                            => 'Konfigurasi yang berhubungan dengan notifikasi',
                        'push-notification-configuration' => 'Konfigurasi Notifikasi Push FCM',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Isi File JSON Private Key',
                        'info-get-private-key'            => 'Info: Untuk mendapatkan isi File JSON Private Key FCM: <a href="https://console.firebase.google.com/" target="_blank">Klik di sini</a>',
                        'credentials'                     => 'Kredensial',
                        'credentials-info'                => 'Info: Digunakan untuk mendapatkan data penting seperti kunci metode pembayaran, client id, secret key, dll.',
                        'username'                        => 'Nama Pengguna',
                        'username-info'                   => 'Info: Digunakan untuk mendapatkan data penting seperti kunci metode pembayaran, client id, secret key, dll.',
                        'password'                        => 'Kata Sandi',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Sukses: Skrip kustom berhasil diperbarui.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Peringatan: Pesanan tidak dapat dibatalkan.',
                'cancel-success' => 'Sukses: Pesanan berhasil dibatalkan.',
                'not-found'      => 'Peringatan: Pesanan tidak ditemukan.',
            ],

            'shipments' => [
                'creation-error'   => 'Peringatan: Pengiriman tidak dibuat.',
                'not-found'        => 'Peringatan: Pengiriman tidak ditemukan.',
                'quantity-invalid' => 'Peringatan: Jumlah tidak valid.',
                'shipment-error'   => 'Peringatan: Pengiriman tidak dibuat.',
                'create-success'   => 'Sukses: Pengiriman berhasil dibuat.',
            ],

            'invoices' => [
                'creation-error' => 'Peringatan: Faktur tidak dibuat.',
                'not-found'      => 'Peringatan: Faktur tidak ditemukan.',
                'product-error'  => 'Peringatan: Produk tidak valid.',
                'create-success' => 'Sukses: Faktur berhasil dibuat.',
                'invalid-qty'    => 'Peringatan: Terdapat jumlah tidak valid pada item faktur.',
            ],

            'refunds' => [
                'creation-error'      => 'Peringatan: Pengembalian dana tidak dibuat.',
                'refund-amount-error' => 'Peringatan: Jumlah pengembalian dana tidak valid.',
                'refund-limit-error'  => 'Peringatan: Jumlah pengembalian dana melebihi batas :amount',
                'not-found'           => 'Peringatan: Pengembalian dana tidak ditemukan.',
                'create-success'      => 'Sukses: Pengembalian dana berhasil dibuat.',
            ],

            'transactions' => [
                'already-paid'   => 'Peringatan: Faktur sudah dibayar.',
                'amount-exceed'  => 'Peringatan: Jumlah transaksi melebihi batas.',
                'zero-amount'    => 'Peringatan: Jumlah transaksi harus lebih dari nol.',
                'create-success' => 'Sukses: Transaksi berhasil dibuat.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Peringatan: Pelanggan tidak ditemukan.',
                'cart-not-found'           => 'Peringatan: Keranjang tidak ditemukan.',
                'cart-item-not-found'      => 'Peringatan: Produk dalam keranjang tidak ditemukan.',
                'cart-create-success'      => 'Sukses: Keranjang berhasil dibuat.',
                'cart-item-add-success'    => 'Sukses: Produk berhasil ditambahkan ke keranjang.',
                'cart-item-remove-success' => 'Sukses: Produk berhasil dihapus dari keranjang.',
                'cart-item-update-success' => 'Sukses: Produk berhasil diperbarui di keranjang.',
                'something-wrong'          => 'Peringatan: Terjadi kesalahan.',
                'address-save-success'     => 'Sukses: Alamat berhasil disimpan.',
                'shipping-save-success'    => 'Sukses: Metode pengiriman berhasil disimpan.',
                'payment-save-success'     => 'Sukses: Metode pembayaran berhasil disimpan.',
                'order-placed-success'     => 'Sukses: Pesanan berhasil dibuat.',
                'payment-method-not-found' => 'Peringatan: Metode pembayaran tidak ditemukan.',
                'minimum-order-amount-err' => 'Peringatan: Jumlah minimum pesanan harus :amount',
                'check-shipping-address'   => 'Peringatan: Silakan periksa alamat pengiriman.',
                'check-billing-address'    => 'Peringatan: Silakan periksa alamat penagihan.',
                'specify-shipping-method'  => 'Peringatan: Silakan tentukan metode pengiriman.',
                'specify-payment-method'   => 'Peringatan: Silakan tentukan metode pembayaran.',
                'coupon-not-valid'         => 'Peringatan: Kode kupon tidak valid.',
                'coupon-already-applied'   => 'Peringatan: Kode kupon sudah diterapkan.',
                'coupon-applied'           => 'Sukses: Kode kupon berhasil diterapkan.',
                'coupon-removed'           => 'Sukses: Kode kupon berhasil dihapus.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Produk berhasil dibuat.',
                'delete-success'            => 'Produk berhasil dihapus.',
                'not-found'                 => 'Peringatan: Produk tidak ditemukan.',
                'update-success'            => 'Produk berhasil diperbarui.',
                'configurable-attr-missing' => 'Peringatan: Atribut konfigurable tidak ditemukan.',
                'simple-products-error'     => 'Peringatan: Produk sederhana tidak tersedia.',
            ],

            'categories' => [
                'already-taken'  => 'Peringatan: Slug sudah digunakan.',
                'create-success' => 'Kategori berhasil dibuat.',
                'delete-success' => 'Kategori berhasil dihapus.',
                'not-found'      => 'Peringatan: Kategori tidak ditemukan.',
                'update-success' => 'Kategori berhasil diperbarui.',
                'root-delete'    => 'Peringatan: Kategori root tidak dapat dihapus.',
            ],

            'attributes' => [
                'create-success'    => 'Atribut berhasil dibuat.',
                'delete-success'    => 'Atribut berhasil dihapus.',
                'not-found'         => 'Peringatan: Atribut tidak ditemukan.',
                'update-success'    => 'Atribut berhasil diperbarui.',
                'user-define-error' => 'Peringatan: Anda tidak diizinkan menghapus atribut yang dibuat oleh sistem.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Grup atribut berhasil dibuat.',
                'delete-success'    => 'Grup atribut berhasil dihapus.',
                'not-found'         => 'Peringatan: Grup atribut tidak ditemukan.',
                'update-success'    => 'Grup atribut berhasil diperbarui.',
                'user-define-error' => 'Peringatan: Anda tidak diizinkan menghapus grup atribut yang dibuat oleh sistem.',
            ],

            'attribute-families' => [
                'create-success'          => 'Keluarga atribut berhasil dibuat.',
                'delete-success'          => 'Keluarga atribut berhasil dihapus.',
                'not-found'               => 'Peringatan: Keluarga atribut tidak ditemukan.',
                'update-success'          => 'Keluarga atribut berhasil diperbarui.',
                'last-delete-error'       => 'Peringatan: Keluarga atribut terakhir tidak dapat dihapus.',
                'attribute-product-error' => 'Peringatan: Beberapa produk terkait dengan keluarga atribut ini.',
                'user-define-error'       => 'Peringatan: Anda tidak diizinkan menghapus keluarga atribut yang dibuat oleh sistem.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Pelanggan berhasil dibuat.',
                'delete-order-pending' => 'Akun pelanggan tidak dapat dihapus karena beberapa pesanan masih tertunda atau dalam proses.',
                'delete-success'       => 'Pelanggan berhasil dihapus.',
                'not-found'            => 'Peringatan: Pelanggan tidak ditemukan.',
                'note-created-success' => 'Catatan berhasil dibuat.',
                'update-success'       => 'Pelanggan berhasil diperbarui.',
                'login-success'        => 'Pelanggan berhasil masuk.',
            ],

            'addresses' => [
                'create-success'         => 'Alamat pelanggan berhasil dibuat.',
                'default-update-success' => 'Alamat telah dijadikan default.',
                'delete-success'         => 'Alamat pelanggan berhasil dihapus.',
                'not-found'              => 'Peringatan: Alamat pelanggan tidak ditemukan.',
                'update-success'         => 'Alamat pelanggan berhasil diperbarui.',
                'already-default'        => 'Peringatan: Alamat ini sudah dijadikan default.',
            ],

            'groups' => [
                'create-success'     => 'Grup pelanggan berhasil dibuat.',
                'customer-associate' => 'Peringatan: Grup tidak dapat dihapus. Ada pelanggan yang terasosiasi dengannya.',
                'delete-success'     => 'Grup pelanggan berhasil dihapus.',
                'not-found'          => 'Peringatan: Grup pelanggan tidak ditemukan.',
                'update-success'     => 'Grup pelanggan berhasil diperbarui.',
                'user-define-error'  => 'Peringatan: Anda tidak diizinkan menghapus grup pelanggan yang dibuat oleh sistem.',
            ],

            'reviews' => [
                'delete-success' => 'Ulasan berhasil dihapus.',
                'not-found'      => 'Peringatan: Ulasan tidak ditemukan.',
                'update-success' => 'Ulasan berhasil diperbarui.',
            ],

            'gdpr' => [
                'delete-success' => 'Sukses: Permintaan GDPR berhasil dihapus.',
                'not-found'      => 'Peringatan: Permintaan GDPR tidak ditemukan.',
                'update-success' => 'Permintaan GDPR berhasil diperbarui.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Peringatan: Slug sudah digunakan.',
            'create-success' => 'CMS berhasil dibuat.',
            'delete-success' => 'CMS berhasil dihapus.',
            'not-found'      => 'Peringatan: CMS tidak ditemukan.',
            'update-success' => 'CMS berhasil diperbarui.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Aturan Katalog berhasil dibuat.',
                    'delete-failed'  => 'Peringatan: Aturan Katalog tidak dapat dihapus.',
                    'delete-success' => 'Aturan Katalog berhasil dihapus.',
                    'not-found'      => 'Peringatan: Aturan Katalog tidak ditemukan.',
                    'update-success' => 'Aturan Katalog berhasil diperbarui.',
                ],

                'cart-rules' => [
                    'create-success' => 'Aturan Keranjang berhasil dibuat.',
                    'delete-failed'  => 'Peringatan: Aturan Keranjang tidak dapat dihapus.',
                    'delete-success' => 'Aturan Keranjang berhasil dihapus.',
                    'not-found'      => 'Peringatan: Aturan Keranjang tidak ditemukan.',
                    'update-success' => 'Aturan Keranjang berhasil diperbarui.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Template Email berhasil dibuat.',
                    'delete-success' => 'Template Email berhasil dihapus.',
                    'not-found'      => 'Peringatan: Template Email tidak ditemukan.',
                    'update-success' => 'Template Email berhasil diperbarui.',
                ],

                'events' => [
                    'create-success' => 'Event berhasil dibuat.',
                    'delete-success' => 'Event berhasil dihapus.',
                    'not-found'      => 'Peringatan: Event tidak ditemukan.',
                    'update-success' => 'Event berhasil diperbarui.',
                ],

                'campaigns' => [
                    'create-success' => 'Kampanye berhasil dibuat.',
                    'delete-success' => 'Kampanye berhasil dihapus.',
                    'not-found'      => 'Peringatan: Kampanye tidak ditemukan.',
                    'update-success' => 'Kampanye berhasil diperbarui.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Langganan berhasil dihapus.',
                    'not-found'           => 'Peringatan: Langganan tidak ditemukan.',
                    'unsubscribe-success' => 'Sukses: Berhasil berhenti berlangganan.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL Rewrite berhasil dibuat.',
                    'delete-success' => 'URL Rewrite berhasil dihapus.',
                    'not-found'      => 'Peringatan: URL Rewrite tidak ditemukan.',
                    'update-success' => 'URL Rewrite berhasil diperbarui.',
                ],

                'search-terms' => [
                    'create-success' => 'Kata Pencarian berhasil dibuat.',
                    'delete-success' => 'Kata Pencarian berhasil dihapus.',
                    'not-found'      => 'Peringatan: Kata Pencarian tidak ditemukan.',
                    'update-success' => 'Kata Pencarian berhasil diperbarui.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Sinonim Pencarian berhasil dibuat.',
                    'delete-success' => 'Sinonim Pencarian berhasil dihapus.',
                    'not-found'      => 'Peringatan: Sinonim Pencarian tidak ditemukan.',
                    'update-success' => 'Sinonim Pencarian berhasil diperbarui.',
                ],

                'sitemaps' => [
                    'create-success' => 'Peta Situs berhasil dibuat.',
                    'delete-success' => 'Peta Situs berhasil dihapus.',
                    'not-found'      => 'Peringatan: Peta Situs tidak ditemukan.',
                    'update-success' => 'Peta Situs berhasil diperbarui.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Locale berhasil dibuat.',
                'default-delete-error' => 'Locale default tidak dapat dihapus.',
                'delete-error'         => 'Gagal menghapus Locale.',
                'delete-success'       => 'Locale berhasil dihapus.',
                'last-delete-error'    => 'Gagal menghapus Locale terakhir.',
                'not-found'            => 'Peringatan: Locale tidak ditemukan.',
                'update-success'       => 'Locale berhasil diperbarui.',
            ],

            'currencies' => [
                'create-success'       => 'Mata uang berhasil dibuat.',
                'default-delete-error' => 'Mata uang default tidak dapat dihapus.',
                'delete-error'         => 'Gagal menghapus mata uang.',
                'delete-success'       => 'Mata uang berhasil dihapus.',
                'last-delete-error'    => 'Gagal menghapus mata uang terakhir.',
                'not-found'            => 'Peringatan: Mata uang tidak ditemukan.',
                'update-success'       => 'Mata uang berhasil diperbarui.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Kurs berhasil dibuat.',
                'delete-error'            => 'Gagal menghapus kurs.',
                'delete-success'          => 'Sukses: Kurs berhasil dihapus.',
                'invalid-target-currency' => 'Peringatan: Mata uang tujuan tidak valid.',
                'last-delete-error'       => 'Gagal menghapus kurs terakhir.',
                'not-found'               => 'Peringatan: Kurs tidak ditemukan.',
                'update-success'          => 'Kurs berhasil diperbarui.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Sumber inventaris berhasil dibuat.',
                'delete-error'      => 'Gagal menghapus sumber inventaris.',
                'delete-success'    => 'Sumber inventaris berhasil dihapus.',
                'last-delete-error' => 'Gagal menghapus sumber inventaris terakhir.',
                'not-found'         => 'Peringatan: Sumber inventaris tidak ditemukan.',
                'update-success'    => 'Sumber inventaris berhasil diperbarui.',
            ],

            'channels' => [
                'create-success'       => 'Channel berhasil dibuat.',
                'default-delete-error' => 'Channel default tidak dapat dihapus.',
                'delete-error'         => 'Gagal menghapus channel.',
                'delete-success'       => 'Channel berhasil dihapus.',
                'last-delete-error'    => 'Gagal menghapus channel terakhir.',
                'not-found'            => 'Peringatan: Channel tidak ditemukan.',
                'update-success'       => 'Channel berhasil diperbarui.',
            ],

            'users' => [
                'activate-warning'  => 'Akun Anda belum diaktifkan, silakan hubungi administrator.',
                'create-success'    => 'Pengguna berhasil dibuat.',
                'delete-error'      => 'Gagal menghapus pengguna.',
                'delete-success'    => 'Pengguna berhasil dihapus.',
                'last-delete-error' => 'Gagal menghapus pengguna terakhir.',
                'login-error'       => 'Silakan periksa kredensial Anda dan coba lagi.',
                'not-found'         => 'Peringatan: Pengguna tidak ditemukan.',
                'success-login'     => 'Sukses: Pengguna berhasil masuk.',
                'success-logout'    => 'Sukses: Pengguna berhasil keluar.',
                'update-success'    => 'Pengguna berhasil diperbarui.',
            ],

            'roles' => [
                'create-success'    => 'Peran berhasil dibuat.',
                'delete-error'      => 'Gagal menghapus peran.',
                'delete-success'    => 'Peran berhasil dihapus.',
                'last-delete-error' => 'Peran terakhir tidak dapat dihapus.',
                'not-found'         => 'Peringatan: Peran tidak ditemukan.',
                'update-success'    => 'Peran berhasil diperbarui.',
            ],

            'themes' => [
                'create-success' => 'Tema berhasil dibuat.',
                'delete-success' => 'Tema berhasil dihapus.',
                'not-found'      => 'Peringatan: Tema tidak ditemukan.',
                'update-success' => 'Tema berhasil diperbarui.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'category_id yang ditentukan tidak ada.',
                        'invalid-boolean-value' => 'Nilai :key harus 0 atau 1.',
                        'invalid-filter-key'    => 'Kunci filter ":key" tidak diizinkan.',
                        'invalid-limit-value'   => 'Nilai batas harus salah satu dari berikut: :options.',
                        'invalid-select-option' => 'Nilai :key tidak valid. Opsi yang valid adalah: :options.',
                        'invalid-sort-value'    => 'Nilai sortir harus salah satu dari berikut: :options.',
                        'missing-limit-key'     => 'filtersInput harus menyertakan kunci "limit".',
                        'missing-sort-key'      => 'filtersInput harus menyertakan kunci "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Tarif pajak berhasil dibuat.',
                'delete-error'   => 'Gagal menghapus tarif pajak.',
                'delete-success' => 'Tarif pajak berhasil dihapus.',
                'not-found'      => 'Peringatan: Tarif pajak tidak ditemukan.',
                'update-success' => 'Tarif pajak berhasil diperbarui.',
            ],

            'tax-category' => [
                'create-success'     => 'Kategori pajak berhasil dibuat.',
                'delete-error'       => 'Gagal menghapus kategori pajak.',
                'delete-success'     => 'Kategori pajak berhasil dihapus.',
                'not-found'          => 'Peringatan: Kategori pajak tidak ditemukan.',
                'tax-rate-not-found' => 'ID yang diberikan tidak ditemukan. ID:- :ids',
                'update-success'     => 'Kategori pajak berhasil diperbarui.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Tambah Notifikasi',
                    'general'   => 'Umum',
                    'title'     => 'Notifikasi Push',

                    'datagrid' => [
                        'channel-name'         => 'Nama Channel',
                        'created-at'           => 'Waktu Dibuat',
                        'delete'               => 'Hapus',
                        'id'                   => 'ID',
                        'image'                => 'Gambar',
                        'notification-content' => 'Konten Notifikasi',
                        'notification-status'  => 'Status Notifikasi',
                        'notification-type'    => 'Tipe Notifikasi',
                        'text-title'           => 'Judul',
                        'update'               => 'Perbarui',
                        'updated-at'           => 'Waktu Diperbarui',

                        'status' => [
                            'disabled' => 'Nonaktif',
                            'enabled'  => 'Aktif',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Kembali',
                    'content-and-image'    => 'Konten dan Gambar Notifikasi',
                    'create-btn-title'     => 'Simpan Notifikasi',
                    'general'              => 'Umum',
                    'image'                => 'Gambar',
                    'new-notification'     => 'Notifikasi Baru',
                    'notification-content' => 'Konten Notifikasi',
                    'notification-type'    => 'Tipe Notifikasi',
                    'product-cat-id'       => 'ID Produk/Kategori',
                    'settings'             => 'Pengaturan',
                    'status'               => 'Status',
                    'store-view'           => 'Channel',
                    'title'                => 'Notifikasi Push',

                    'option-type' => [
                        'category' => 'Kategori',
                        'others'   => 'Sederhana',
                        'product'  => 'Produk',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Kembali',
                    'content-and-image'    => 'Konten dan Gambar Notifikasi',
                    'edit-notification'    => 'Edit Notifikasi',
                    'general'              => 'Umum',
                    'image'                => 'Gambar',
                    'notification-content' => 'Konten Notifikasi',
                    'notification-type'    => 'Tipe Notifikasi',
                    'product-cat-id'       => 'ID Produk/Kategori',
                    'send-title'           => 'Kirim Notifikasi',
                    'settings'             => 'Pengaturan',
                    'status'               => 'Status',
                    'store-view'           => 'Channel',
                    'title'                => 'Notifikasi Push',
                    'update-btn-title'     => 'Perbarui',

                    'option-type' => [
                        'category' => 'Kategori',
                        'others'   => 'Sederhana',
                        'product'  => 'Produk',
                    ],
                ],

                'not-found'           => 'Peringatan: Notifikasi tidak ditemukan.',
                'create-success'      => 'Notifikasi berhasil dibuat.',
                'delete-failed'       => 'Gagal menghapus notifikasi.',
                'delete-success'      => 'Notifikasi berhasil dihapus.',
                'mass-update-success' => 'Notifikasi terpilih berhasil diperbarui.',
                'mass-delete-success' => 'Notifikasi terpilih berhasil dihapus.',
                'no-value-selected'   => 'Tidak ada nilai yang dipilih.',
                'send-success'        => 'Notifikasi berhasil dikirim.',
                'update-success'      => 'Notifikasi berhasil diperbarui.',
                'configuration-error' => 'Peringatan: Konfigurasi FCM tidak ditemukan.',
                'product-not-found'   => 'Peringatan: Produk tidak ditemukan.',
                'category-not-found'  => 'Peringatan: Kategori tidak ditemukan.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Peringatan: Parameter tidak valid diberikan.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Peringatan: Konfigurasi email tidak ditemukan.',
    ],
];
