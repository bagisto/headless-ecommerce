<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'すでにニュースレターに登録されています。',
            'subscribe-success'  => 'ニュースレターに正常に登録されました。',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'お問い合わせいただきありがとうございます。 近日中にご連絡いたします。',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => '警告: ダウンロードリンクが見つかりません。',
                'sample-not-found' => '警告: ダウンロード可能なサンプルが見つかりません。',
            ],
        ],

        'customers' => [
            'no-login-customer' => '注意: ログインした顧客が見つかりません。',
            'success-login'     => '成功: 顧客が正常にログインしました。',
            'success-logout'    => '成功: 顧客が正常にログアウトしました。',

            'signup' => [
                'error-registration' => '注意: 顧客の登録に失敗しました。',
                'success-verify'     => 'アカウントが正常に作成され、確認のためのメールが送信されました。',
                'success'            => '成功: 顧客が正常に登録され、ログインしました。',
            ],

            'social-login' => [
                'disabled' => '警告: ソーシャルログインは無効です。',
            ],

            'login' => [
                'invalid-creds' => '資格情報を確認して、もう一度お試しください。',
                'not-activated' => 'アクティベーションには管理者の承認が必要です。',
                'verify-first'  => 'まずメールを確認してください。',
                'suspended'     => 'アカウントが管理者によって停止されています。',

                'validation' => [
                    'required' => ':field は必須項目です。',
                    'same'     => ':field とパスワードは一致している必要があります。',
                    'unique'   => 'この :field は既に使用されています。',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'パスワードリセットリンクが既にメールに送信されています。',
                'email-not-exist' => 'メールアドレスが存在しません。',
                'reset-link-sent' => 'パスワードリセットリンクがメールに送信されました。',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => '成功: 顧客の詳細が正常に取得されました。',
                    'delete-success'   => '成功: アカウントが正常に削除されました。',
                    'password-unmatch' => 'パスワードが一致しません。',
                    'update-fail'      => '警告: プロファイルが更新されませんでした。',
                    'update-success'   => '成功: プロファイルが正常に更新されました。',
                    'wrong-password'   => '警告: 間違ったパスワードが入力されました。',
                    'order-pending'    => '保留中の注文があるため、アカウントを削除できません。',
                ],

                'addresses' => [
                    'create-success'         => '住所が正常に作成されました。',
                    'default-update-success' => '住所がデフォルトとして設定されました。',
                    'delete-success'         => '住所が正常に削除されました。',
                    'not-found'              => '注意: 住所が見つかりません。',
                    'update-success'         => '住所が正常に更新されました。',
                    'already-default'        => '注意: この住所はすでにデフォルトに設定されています。',
                ],

                'wishlist' => [
                    'product-removed' => '注意: 商品が見つかりませんでした。',
                    'success'         => '成功: 商品が正常にウィッシュリストに追加されました。',
                    'already-exist'   => '注意: 既にウィッシュリストに追加されています。',
                    'remove-success'  => '成功: 商品が正常にウィッシュリストから削除されました。',
                    'not-found'       => '注意: ウィッシュリストに商品が見つかりません。',
                    'moved-to-cart'   => '成功: 商品が正常にカートに移動しました。',
                ],

                'orders' => [
                    'not-found'      => '注意: 注文が見つかりません。',
                    'cancel-error'   => '注意: 注文がキャンセルされませんでした。',
                    'cancel-success' => '成功: 注文が正常にキャンセルされました。',

                    'shipment' => [
                        'not-found' => '注意: 配送が見つかりません。',
                    ],

                    'invoice' => [
                        'not-found' => '注意: 請求書が見つかりません。',
                    ],

                    'refund' => [
                        'not-found' => '注意: 返金が見つかりません。',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => '注意: ダウンロード可能な商品が見つかりません。',
                    'not-auth'       => '注意: この操作を実行する権限がありません。',
                    'payment-error'  => 'このダウンロードに対して支払いが行われていません。',
                    'download-error' => 'ダウンロードリンクが期限切れです。',
                ],

                'gdpr' => [
                    'create-success'       => '成功：GDPRリクエストが正常に作成されました。',
                    'revoke-failed'        => '警告：GDPRリクエストの取り消しに失敗しました。',
                    'revoked-successfully' => '成功：GDPRリクエストが正常に取り消されました。',
                    'not-enabled'          => '警告：GDPRは有効になっていません。',
                ],
            ],

            'compare-product' => [
                'not-found'           => '警告: 比較商品が見つかりません。',
                'product-not-found'   => '警告: 商品が見つかりません。',
                'already-added'       => '警告: 商品はすでに比較リストに追加されています。',
                'item-add-success'    => '成功: 商品が正常に比較リストに追加されました。',
                'remove-success'      => '成功: アイテムが正常に比較リストから削除されました。',
                'mass-remove-success' => '成功: 選択されたアイテムが正常に削除されました。',
                'not-auth'            => '警告: この操作を実行する権限がありません。',
            ],

            'reviews' => [
                'create-success'      => '成功: レビューが正常に作成されました。',
                'delete-success'      => '成功: レビューが正常に削除されました。',
                'mass-delete-success' => '成功: 選択したレビューが正常に削除されました。',
                'not-found'           => '注意: レビューが見つかりません。',
                'product-not-found'   => '警告: 商品が見つかりません。',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => '注意: ダウンロード可能なリンクはカートに追加できません。',
                        'invalid-parameter'  => '注意: 無効なパラメータが提供されました。',
                    ],

                    'success' => [
                        'add-to-cart'      => '成功: 商品が正常にカートに追加されました。',
                        'update-to-cart'   => '成功: 商品が正常にカートに更新されました。',
                        'delete-cart-item' => '成功: 商品が正常にカートから削除されました。',
                        'all-remove'       => '成功: すべてのアイテムがカートから削除されました。',
                        'move-to-wishlist' => '成功: 選択したアイテムが正常にウィッシュリストに移動されました。',
                    ],

                    'fail' => [
                        'all-remove'       => '注意: すべてのアイテムがカートから削除されませんでした。',
                        'update-to-cart'   => '注意: 商品がカートに更新されませんでした。',
                        'delete-cart-item' => '注意: 商品がカートから削除されませんでした。',
                        'not-found'        => '注意: カートが見つかりません。',
                        'item-not-found'   => '注意: 商品が見つかりません。',
                        'move-to-wishlist' => '注意: 選択したアイテムがウィッシュリストに移動されませんでした。',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => '注意: ゲストユーザーは住所を追加できません。',
                'guest-checkout-warning'    => '注意: ゲストユーザーはチェックアウトできません。',
                'no-billing-address-found'  => '注意: 請求先住所が見つかりません。',
                'no-shipping-address-found' => '注意: 配送先住所が見つかりません。',
                'address-save-success'      => '成功: 住所が正常に保存されました。',
            ],

            'shipping' => [
                'method-not-found' => '注意: 配送方法が見つかりません。',
                'method-fetched'   => '成功: 配送方法が正常に取得されました。',
                'save-failed'      => '注意: 配送方法が保存されませんでした。',
                'save-success'     => '成功: 配送方法が正常に保存されました。',
            ],

            'payment' => [
                'method-not-found' => '注意: 支払い方法が見つかりません。',
                'method-fetched'   => '成功: 支払い方法が正常に取得されました。',
                'save-failed'      => '注意: 支払い方法が保存されませんでした。',
                'save-success'     => '成功: 支払い方法が正常に保存されました。',
            ],

            'coupon' => [
                'apply-success'   => '成功: クーポンコードが正常に適用されました。',
                'already-applied' => '注意: クーポンコードが既に適用されています。',
                'invalid-code'    => '注意: クーポンコードが無効です。',
                'remove-success'  => '成功: クーポンコードが正常に削除されました。',
                'remove-failed'   => '注意: クーポンコードが削除されませんでした。',
            ],

            'something-wrong'          => '注意: 何かがうまくいきませんでした。',
            'invalid-guest-user'       => '注意: 無効なゲストユーザーです。',
            'empty-cart'               => '注意: カートが空です。',
            'missing-billing-address'  => '注意: 請求先住所がありません。',
            'missing-shipping-address' => '注意: 配送先住所がありません。',
            'missing-shipping-method'  => '注意: 配送方法がありません。',
            'missing-payment-method'   => '注意: 支払い方法がありません。',
            'no-address-found'         => '注意: 請求先住所と配送先住所が見つかりません。',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => '作成',
            'delete'            => '削除',
            'edit'              => '編集',
            'mass-delete'       => '一括削除',
            'mass-update'       => '一括更新',
            'push-notification' => 'プッシュ通知',
            'send'              => '送信',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'プッシュ通知',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => '通知トピック',
                        'info'                            => '通知関連の設定',
                        'push-notification-configuration' => 'FCMプッシュ通知設定',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'プライベートキーJSONファイルの内容',
                        'info-get-private-key'            => '情報: FCMプライベートキーJSONファイルの内容を取得するには、<a href="https://console.firebase.google.com/" target="_blank">こちらをクリック</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => '成功: カスタムスクリプトが正常に更新されました。',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => '注意: 注文をキャンセルできません。',
                'cancel-success' => '成功: 注文が正常にキャンセルされました。',
                'not-found'      => '注意: 注文が見つかりません。',
            ],

            'shipments' => [
                'creation-error'   => '注意: 出荷が作成されませんでした。',
                'not-found'        => '注意: 出荷が見つかりません。',
                'quantity-invalid' => '注意: 無効な数量が指定されました。',
                'shipment-error'   => '注意: 出荷が作成されませんでした。',
                'create-success'   => '成功: 出荷が正常に作成されました。',
            ],

            'invoices' => [
                'creation-error' => '注意: 請求書が作成されませんでした。',
                'not-found'      => '注意: 請求書が見つかりません。',
                'product-error'  => '注意: 無効な製品が指定されました。',
                'create-success' => '成功: 請求書が正常に作成されました。',
                'invalid-qty'    => '警告: 請求書アイテムに無効な数量が見つかりました。',
            ],

            'refunds' => [
                'creation-error'      => '注意: 返金が作成されませんでした。',
                'refund-amount-error' => '注意: 無効な返金額が指定されました。',
                'refund-limit-error'  => '注意: 返金額が上限 :amount を超えています。',
                'not-found'           => '注意: 返金が見つかりません。',
                'create-success'      => '成功: 返金が正常に作成されました。',
            ],

            'transactions' => [
                'already-paid'   => '注意: 請求書はすでに支払われています。',
                'amount-exceed'  => '注意: 取引額が上限を超えています。',
                'zero-amount'    => '注意: 取引額はゼロより大きくなければなりません。',
                'create-success' => '成功: 取引が正常に作成されました。',
            ],

            'reorder' => [
                'customer-not-found'       => '注意: 顧客が見つかりません。',
                'cart-not-found'           => '注意: カートが見つかりません。',
                'cart-item-not-found'      => '注意: カート内の商品が見つかりません。',
                'cart-create-success'      => '成功: カートが正常に作成されました。',
                'cart-item-add-success'    => '成功: 商品がカートに正常に追加されました。',
                'cart-item-remove-success' => '成功: 商品がカートから正常に削除されました。',
                'cart-item-update-success' => '成功: カート内の商品が正常に更新されました。',
                'something-wrong'          => '注意: 何か問題が発生しました。',
                'address-save-success'     => '成功: 住所が正常に保存されました。',
                'shipping-save-success'    => '成功: 配送方法が正常に保存されました。',
                'payment-save-success'     => '成功: 支払い方法が正常に保存されました。',
                'order-placed-success'     => '成功: 注文が正常に行われました。',
                'payment-method-not-found' => '注意: 支払い方法が見つかりません。',
                'minimum-order-amount-err' => '注意: 最低注文額は :amount でなければなりません。',
                'check-shipping-address'   => '注意: 配送先住所を確認してください。',
                'check-billing-address'    => '注意: 請求先住所を確認してください。',
                'specify-shipping-method'  => '注意: 配送方法を指定してください。',
                'specify-payment-method'   => '注意: 支払い方法を指定してください。',
                'coupon-not-valid'         => '注意: クーポンコードが無効です。',
                'coupon-already-applied'   => '注意: クーポンコードはすでに適用されています。',
                'coupon-applied'           => '成功: クーポンコードが正常に適用されました。',
                'coupon-removed'           => '成功: クーポンコードが正常に削除されました。',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => '製品が正常に作成されました。',
                'delete-success'            => '製品が正常に削除されました。',
                'not-found'                 => '注意: 製品が見つかりません。',
                'update-success'            => '製品が正常に更新されました。',
                'configurable-attr-missing' => '注意: 設定可能な属性が見つかりません。',
                'simple-products-error'     => '注意: 単純な製品が見つかりません。',
            ],

            'categories' => [
                'already-taken'  => '注意: スラッグは既に使用されています。',
                'create-success' => 'カテゴリが正常に作成されました。',
                'delete-success' => 'カテゴリが正常に削除されました。',
                'not-found'      => '注意: カテゴリが見つかりません。',
                'update-success' => 'カテゴリが正常に更新されました。',
                'root-delete'    => '注意: ルートカテゴリは削除できません。',
            ],

            'attributes' => [
                'create-success'    => '属性が正常に作成されました。',
                'delete-success'    => '属性が正常に削除されました。',
                'not-found'         => '注意: 属性が見つかりません。',
                'update-success'    => '属性が正常に更新されました。',
                'user-define-error' => '注意: システムによって作成された属性を削除する権限がありません。',
            ],

            'attribute-groups' => [
                'create-success'    => '属性グループが正常に作成されました。',
                'delete-success'    => '属性グループが正常に削除されました。',
                'not-found'         => '注意: 属性グループが見つかりません。',
                'update-success'    => '属性グループが正常に更新されました。',
                'user-define-error' => '注意: システムによって作成された属性グループを削除する権限がありません。',
            ],

            'attribute-families' => [
                'create-success'          => '属性ファミリが正常に作成されました。',
                'delete-success'          => '属性ファミリが正常に削除されました。',
                'not-found'               => '注意: 属性ファミリが見つかりません。',
                'update-success'          => '属性ファミリが正常に更新されました。',
                'last-delete-error'       => '注意: 最後の属性ファミリは削除できません。',
                'attribute-product-error' => '注意: 一部の製品がこの属性ファミリに関連付けられています。',
                'user-define-error'       => '注意: システムによって作成された属性ファミリを削除する権限がありません。',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => '顧客が正常に作成されました。',
                'delete-order-pending' => '注文が保留中または処理中のため、顧客アカウントを削除することはできません。',
                'delete-success'       => '顧客が正常に削除されました。',
                'not-found'            => '注意: 顧客が見つかりません。',
                'note-created-success' => 'ノートが正常に作成されました。',
                'update-success'       => '顧客が正常に更新されました。',
                'login-success'        => '顧客が正常にログインしました。',
            ],

            'addresses' => [
                'create-success'         => '顧客の住所が正常に作成されました。',
                'default-update-success' => '住所がデフォルトに設定されました。',
                'delete-success'         => '顧客の住所が正常に削除されました。',
                'not-found'              => '注意: 顧客の住所が見つかりません。',
                'update-success'         => '顧客の住所が正常に更新されました。',
                'already-default'        => '注意: この住所はすでにデフォルトに設定されています。',
            ],

            'groups' => [
                'create-success'     => '顧客グループが正常に作成されました。',
                'customer-associate' => '注意: グループは削除できません。顧客が関連付けられています。',
                'delete-success'     => '顧客グループが正常に削除されました。',
                'not-found'          => '注意: 顧客グループが見つかりません。',
                'update-success'     => '顧客グループが正常に更新されました。',
                'user-define-error'  => '注意: システムによって作成された顧客グループを削除する権限がありません。',
            ],

            'reviews' => [
                'delete-success' => 'レビューが正常に削除されました。',
                'not-found'      => '注意: レビューが見つかりません。',
                'update-success' => 'レビューが正常に更新されました。',
            ],

            'gdpr' => [
                'delete-success' => '成功：GDPRリクエストが正常に削除されました。',
                'not-found'      => '警告：GDPRリクエストが見つかりません。',
                'update-success' => 'GDPRリクエストが正常に更新されました。',
            ],
        ],

        'cms' => [
            'already-taken'  => '注意: スラッグは既に使用されています。',
            'create-success' => 'CMSが正常に作成されました。',
            'delete-success' => 'CMSが正常に削除されました。',
            'not-found'      => '注意: CMSが見つかりません。',
            'update-success' => 'CMSが正常に更新されました。',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'カタログルールが正常に作成されました。',
                    'delete-failed'  => '注意: カタログルールの削除に失敗しました。',
                    'delete-success' => 'カタログルールが正常に削除されました。',
                    'not-found'      => '注意: カタログルールが見つかりません。',
                    'update-success' => 'カタログルールが正常に更新されました。',
                ],

                'cart-rules' => [
                    'create-success' => 'カートルールが正常に作成されました。',
                    'delete-failed'  => '注意: カートルールの削除に失敗しました。',
                    'delete-success' => 'カートルールが正常に削除されました。',
                    'not-found'      => 'カートルールが見つかりません。',
                    'update-success' => 'カートルールが正常に更新されました。',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'メールテンプレートが正常に作成されました。',
                    'delete-success' => 'メールテンプレートが正常に削除されました。',
                    'not-found'      => '注意: メールテンプレートが見つかりません。',
                    'update-success' => 'メールテンプレートが正常に更新されました。',
                ],

                'events' => [
                    'create-success' => 'イベントが正常に作成されました。',
                    'delete-success' => 'イベントが正常に削除されました。',
                    'not-found'      => '注意: イベントが見つかりません。',
                    'update-success' => 'イベントが正常に更新されました。',
                ],

                'campaigns' => [
                    'create-success' => 'キャンペーンが正常に作成されました。',
                    'delete-success' => 'キャンペーンが正常に削除されました。',
                    'not-found'      => '注意: キャンペーンが見つかりません。',
                    'update-success' => 'キャンペーンが正常に更新されました。',
                ],

                'subscriptions' => [
                    'delete-success'      => '購読が正常に削除されました。',
                    'not-found'           => '注意: 購読が見つかりません。',
                    'unsubscribe-success' => '成功: 購読が正常に解除されました。',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URLリライトが正常に作成されました。',
                    'delete-success' => 'URLリライトが正常に削除されました。',
                    'not-found'      => '注意: URLリライトが見つかりません。',
                    'update-success' => 'URLリライトが正常に更新されました。',
                ],

                'search-terms' => [
                    'create-success' => '検索用語が正常に作成されました。',
                    'delete-success' => '検索用語が正常に削除されました。',
                    'not-found'      => '注意: 検索用語が見つかりません。',
                    'update-success' => '検索用語が正常に更新されました。',
                ],

                'search-synonyms' => [
                    'create-success' => '検索シノニムが正常に作成されました。',
                    'delete-success' => '検索シノニムが正常に削除されました。',
                    'not-found'      => '注意: 検索シノニムが見つかりません。',
                    'update-success' => '検索シノニムが正常に更新されました。',
                ],

                'sitemaps' => [
                    'create-success' => 'サイトマップが正常に作成されました。',
                    'delete-success' => 'サイトマップが正常に削除されました。',
                    'not-found'      => '注意: サイトマップが見つかりません。',
                    'update-success' => 'サイトマップが正常に更新されました。',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'ロケールが正常に作成されました。',
                'default-delete-error' => 'デフォルトの言語を削除することはできません。',
                'delete-error'         => '言語の削除に失敗しました。',
                'delete-success'       => '言語が正常に削除されました。',
                'last-delete-error'    => '最後の言語を削除することはできません。',
                'not-found'            => '注意: 言語が見つかりません。',
                'update-success'       => '言語が正常に更新されました。',
            ],

            'currencies' => [
                'create-success'       => '通貨が正常に作成されました。',
                'default-delete-error' => 'デフォルトの通貨を削除することはできません。',
                'delete-error'         => '通貨の削除に失敗しました。',
                'delete-success'       => '通貨が正常に削除されました。',
                'last-delete-error'    => '最後の通貨を削除することはできません。',
                'not-found'            => '注意: 通貨が見つかりません。',
                'update-success'       => '通貨が正常に更新されました。',
            ],

            'exchange-rates' => [
                'create-success'          => '為替レートが正常に作成されました。',
                'delete-error'            => '為替レートの削除に失敗しました。',
                'delete-success'          => '為替レートが正常に削除されました。',
                'invalid-target-currency' => '注意: 無効な対象通貨です。',
                'last-delete-error'       => '最後の為替レートを削除することはできません。',
                'not-found'               => '注意: 為替レートが見つかりません。',
                'update-success'          => '為替レートが正常に更新されました。',
            ],

            'inventory-sources' => [
                'create-success'    => '在庫が正常に作成されました。',
                'delete-error'      => '在庫の削除に失敗しました。',
                'delete-success'    => '在庫が正常に削除されました。',
                'last-delete-error' => '最後の在庫を削除することはできません。',
                'not-found'         => '注意: 在庫が見つかりません。',
                'update-success'    => '在庫が正常に更新されました。',
            ],

            'channels' => [
                'create-success'       => 'チャネルが正常に作成されました。',
                'default-delete-error' => 'デフォルトのチャネルを削除することはできません。',
                'delete-error'         => 'チャネルの削除に失敗しました。',
                'delete-success'       => 'チャネルが正常に削除されました。',
                'last-delete-error'    => '最後のチャネルを削除することはできません。',
                'not-found'            => '注意: チャネルが見つかりません。',
                'update-success'       => 'チャネルが正常に更新されました。',
            ],

            'users' => [
                'activate-warning'  => 'アカウントはまだアクティブ化されていません。管理者に連絡してください。',
                'create-success'    => 'ユーザーが正常に作成されました。',
                'delete-error'      => 'ユーザーの削除に失敗しました。',
                'delete-success'    => 'ユーザーが正常に削除されました。',
                'last-delete-error' => '最後のユーザーを削除することはできません。',
                'login-error'       => '資格情報を確認してもう一度お試しください。',
                'not-found'         => '注意: ユーザーが見つかりません。',
                'success-login'     => 'ユーザーが正常にログインしました。',
                'success-logout'    => 'ユーザーが正常にログアウトしました。',
                'update-success'    => 'ユーザーが正常に更新されました。',
            ],

            'roles' => [
                'create-success'    => 'ロールが正常に作成されました。',
                'delete-error'      => 'ロールの削除に失敗しました。',
                'delete-success'    => 'ロールが正常に削除されました。',
                'last-delete-error' => '最後のロールを削除することはできません。',
                'not-found'         => '注意: ロールが見つかりません。',
                'update-success'    => 'ロールが正常に更新されました。',
            ],

            'themes' => [
                'create-success' => 'テーマが正常に作成されました。',
                'delete-success' => 'テーマが正常に削除されました。',
                'not-found'      => '注意: テーマが見つかりません。',
                'update-success' => 'テーマが正常に更新されました。',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => '指定された category_id は存在しません。',
                        'invalid-boolean-value' => ':key の値は 0 または 1 でなければなりません。',
                        'invalid-filter-key'    => 'フィルターキー ":key" は許可されていません。',
                        'invalid-limit-value'   => 'limit の値は次のいずれかでなければなりません: :options。',
                        'invalid-select-option' => ':key の値が無効です。有効なオプションは次の通りです: :options。',
                        'invalid-sort-value'    => 'sort の値は次のいずれかでなければなりません: :options。',
                        'missing-limit-key'     => 'filtersInput に "limit" キーを含める必要があります。',
                        'missing-sort-key'      => 'filtersInput に "sort" キーを含める必要があります。',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => '税率が正常に作成されました。',
                'delete-error'   => '税率の削除に失敗しました。',
                'delete-success' => '税率が正常に削除されました。',
                'not-found'      => '注意: 税率が見つかりません。',
                'update-success' => '税率が正常に更新されました。',
            ],

            'tax-category' => [
                'create-success'     => '税カテゴリが正常に作成されました。',
                'delete-error'       => '税カテゴリの削除に失敗しました。',
                'delete-success'     => '税カテゴリが正常に削除されました。',
                'not-found'          => '注意: 税カテゴリが見つかりません。',
                'tax-rate-not-found' => '指定されたIDが見つかりませんでした。ID: :ids',
                'update-success'     => '税カテゴリが正常に更新されました。',
            ],

            'notification' => [
                'index' => [
                    'add-title' => '通知を追加',
                    'general'   => '一般',
                    'title'     => 'プッシュ通知',

                    'datagrid' => [
                        'channel-name'         => 'チャネル名',
                        'created-at'           => '作成日時',
                        'delete'               => '削除',
                        'id'                   => 'ID',
                        'image'                => '画像',
                        'notification-content' => '通知内容',
                        'notification-status'  => '通知ステータス',
                        'notification-type'    => '通知タイプ',
                        'text-title'           => 'タイトル',
                        'update'               => '更新',
                        'updated-at'           => '更新日時',

                        'status' => [
                            'disabled' => '無効',
                            'enabled'  => '有効',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => '戻る',
                    'content-and-image'    => '通知の内容と画像',
                    'create-btn-title'     => '通知を保存',
                    'general'              => '一般',
                    'image'                => '画像',
                    'new-notification'     => '新しい通知',
                    'notification-content' => '通知内容',
                    'notification-type'    => '通知タイプ',
                    'product-cat-id'       => '製品/カテゴリID',
                    'settings'             => '設定',
                    'status'               => 'ステータス',
                    'store-view'           => 'チャネル',
                    'title'                => 'プッシュ通知',

                    'option-type' => [
                        'category' => 'カテゴリ',
                        'others'   => 'その他',
                        'product'  => '製品',
                    ],
                ],

                'edit' => [
                    'back-btn'             => '戻る',
                    'content-and-image'    => '通知の内容と画像',
                    'edit-notification'    => '通知の編集',
                    'general'              => '一般',
                    'image'                => '画像',
                    'notification-content' => '通知内容',
                    'notification-type'    => '通知タイプ',
                    'product-cat-id'       => '製品/カテゴリID',
                    'send-title'           => '通知を送信',
                    'settings'             => '設定',
                    'status'               => 'ステータス',
                    'store-view'           => 'チャネル',
                    'title'                => 'プッシュ通知',
                    'update-btn-title'     => '更新',

                    'option-type' => [
                        'category' => 'カテゴリ',
                        'others'   => 'その他',
                        'product'  => '製品',
                    ],
                ],

                'not-found'           => '注意: 通知が見つかりません。',
                'create-success'      => '通知が正常に作成されました。',
                'delete-failed'       => '通知の削除に失敗しました。',
                'delete-success'      => '通知が正常に削除されました。',
                'mass-update-success' => '選択した通知が正常に更新されました。',
                'mass-delete-success' => '選択した通知が正常に削除されました。',
                'no-value-selected'   => '選択された値がありません。',
                'send-success'        => '通知が正常に送信されました。',
                'update-success'      => '通知が正常に更新されました。',
                'configuration-error' => '注意: FCMの設定が見つかりません。',
                'product-not-found'   => '注意: 製品が見つかりません。',
                'category-not-found'  => '注意: カテゴリが見つかりません。',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => '警告: 提供されたパラメータが無効です。',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => '警告: メール設定が見つかりません。',
    ],
];
