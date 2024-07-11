<?php

return [
    'admin' => [
        'menu' => [
            'push-notification' => 'プッシュ通知',
        ],

        'acl' => [
            'push-notification' => 'プッシュ通知',
            'send'              => '送信',
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'title'                           => 'GraphQL API',
                        'info'                            => '通知関連の設定',
                        'push-notification-configuration' => 'FCMプッシュ通知の設定',
                        'server-key'                      => 'サーバーキー',
                        'info-get-server-key'             => '情報：FCM API資格情報を取得するには：<a href="https://console.firebase.google.com/" target="_blank">こちらをクリック</a>',
                        'android-topic'                   => 'Androidトピック',
                        'ios-topic'                       => 'iOSトピック',
                        'private-key'                     => 'プライベートキーのJSONファイルの内容',
                        'info-get-private-key'            => '情報: FCMプライベートキーのJSONファイルの内容を取得するには、<a href="https://console.firebase.google.com/" target="_blank">こちらをクリックしてください</a>',
                        'notification-topic'              => '通知トピック',
                    ],
                ],
            ],
        ],

        'settings' => [
            'notification' => [
                'index' => [
                    'title'               => 'プッシュ通知',
                    'add-title'           => '通知を追加',
                    'delete-success'      => '通知が正常に削除されました',
                    'mass-update-success' => '選択した通知が正常に更新されました',
                    'mass-delete-success' => '選択した通知が正常に削除されました',

                    'datagrid' => [
                        'id'                   => 'ID',
                        'image'                => '画像',
                        'text-title'           => 'タイトル',
                        'notification-content' => '通知内容',
                        'notification-type'    => '通知タイプ',
                        'store-view'           => 'チャンネル',
                        'notification-status'  => '通知ステータス',
                        'created-at'           => '作成日時',
                        'updated-at'           => '更新日時',
                        'delete'               => '削除',
                        'update'               => '更新',

                        'status' => [
                            'enabled'  => '有効',
                            'disabled' => '無効',
                        ],
                    ],
                ],

                'create' => [
                    'new-notification'     => '新しい通知',
                    'back-btn'             => '戻る',
                    'create-btn-title'     => '通知を保存',
                    'general'              => '一般',
                    'title'                => 'プッシュ通知',
                    'content-and-image'    => '通知内容と画像',
                    'notification-content' => '通知内容',
                    'image'                => '画像',
                    'settings'             => '設定',
                    'status'               => 'ステータス',
                    'store-view'           => 'チャンネル',
                    'notification-type'    => '通知タイプ',
                    'product-cat-id'       => '商品/カテゴリID',
                    'success'              => '通知が正常に作成されました',

                    'option-type' => [
                        'others'   => 'シンプル',
                        'product'  => '商品',
                        'category' => 'カテゴリ'
                    ],
                ],

                'edit' => [
                    'edit-notification'         => '通知を編集',
                    'back-btn'                  => '戻る',
                    'send-title'                => '通知を送信',
                    'update-btn-title'          => '通知を更新',
                    'general'                   => '一般',
                    'title'                     => 'プッシュ通知',
                    'content-and-image'         => '通知内容と画像',
                    'notification-content'      => '通知内容',
                    'image'                     => '画像',
                    'settings'                  => '設定',
                    'status'                    => 'ステータス',
                    'store-view'                => 'チャンネル',
                    'notification-type'         => '通知タイプ',
                    'product-cat-id'            => '商品/カテゴリID',
                    'success'                   => '通知が正常に更新されました',
                    'notification-send-success' => 'AndroidとiOSへの通知の送信に成功しました',

                    'option-type' => [
                        'others'   => 'シンプル',
                        'product'  => '商品',
                        'category' => 'カテゴリ'
                    ],
                ]
            ],

            'exchange_rates' => [
                'error-invalid-target-currency' => '警告: 無効なターゲット通貨が指定されました。',
                'delete-success'                => '成功: 通貨レートが正常に削除されました。',
            ]
        ],

        'customer' => [
            'no-customer-found' => '顧客が見つかりません',
        ],

        'response' => [
            'delete-success'          => '成功: ユーザーが正常に削除されました。',
            'last-delete-error'       => '警告: 少なくとも1人のユーザーが必要です',
            'delete-failed'           => '警告: 管理ユーザーは削除されていません',
            'error.invalid-parameter' => '警告: 無効なパラメータが提供されました。',
            'success-login'           => '成功: ユーザーが正常にログインしました。',
            'error-login'             => '警告: 管理ユーザーはログインしていません。',
            'session-expired'         => '警告: セッションが期限切れです。アカウントに再度ログインしてください。',
            'invalid-header'          => '警告: 無効なヘッダートークンです。',
            'success-logout'          => '成功: ユーザーが正常にログアウトしました。',
            'no-login-user'           => '警告: ログインしているユーザーが見つかりません。',
            'error-customer-group'    => '警告: システムで作成された属性グループを削除する権限がありません。',
            'password-invalid'        => '警告: 正しいパスワードを入力してください。',
            'password-match'          => '警告: パスワードが一致しません。',
            'success-registered'      => '成功: ユーザーが正常に作成されました。',
            'cancel-error'            => '注文をキャンセルできません。',
            'creation-error'          => 'この注文には返金を作成できません。',
            'channel-failure'         => 'チャンネルが見つかりません。',
            'script-delete-success'   => 'スクリプトが正常に削除されました。',
        ],

        'shop' => [
            'response' => [
                'no-address-found'         => '警告: 住所が見つかりません。',
                'invalid-address'          => '警告: 提供された住所IDに対する住所が見つかりません。',
                'invalid-product'          => '警告: 無効な商品をリクエストしています。',
                'already-exist-inwishlist' => '情報: この商品はすでにウィッシュリストに存在しています。',
                'un-authorized-access'     => '警告: このセクションを使用する権限がありません。',
            ],
        ],

        'validation' => [
            'unique'   => 'この :field は既に使用されています。',
            'required' => ':field フィールドは必須です。',
            'same'     => ':field とパスワードが一致する必要があります。',
        ],

        'mail' => [
            'customer' => [
                'password' => [
                    'heading' => config('app.name').' - パスワードリセット',
                    'reset'   => 'パスワードリセットメール',
                    'summary' => 'このメールはアカウントのパスワードリセットに関連しており、パスワードが正常に変更されました。
                    下記のパスワードを使用してアカウントにログインしてください。',
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => '成功: カートの住所が正常に保存されました。',
            'error-payment-selection'   => '警告: 支払い方法の取得にエラーがあります。',
            'selected-shipment'         => '成功: 配送方法が正常に選択されました。',
            'warning-empty-cart'        => '警告: カートに商品が追加されていません。',
            'billing-address-missing'   => '警告: チェックアウトのための請求先住所がありません。',
            'shipping-address-missing'  => '警告: チェックアウトのための配送先住所がありません。',
            'invalid-guest-access'      => '警告: ゲスト顧客は請求先/配送先住所IDを使用して住所を取得することはできません。',
            'guest-address-warning'     => '警告: ゲストとして試みている場合は、認証トークンなしで試みてください。',
            'wrong-error'               => '警告: カートにエラーがあります。もう一度お試しください。',
            'no-billing-address-found'  => '警告: :address_id 請求先IDで請求先住所レコードが見つかりませんでした。',
            'no-shipping-address-found' => '警告: :address_id 配送先IDで配送先住所レコードが見つかりませんでした。',
            'error.invalid-parameter'   => '警告: 無効なパラメータが提供されました。',
            'already-applied'           => 'クーポンコードはすでに適用されています。',
            'success-apply'             => 'クーポンコードが正常に適用されました。',
            'coupon-removed'            => '成功: カートからクーポンが正常に削除されました。',
            'coupon-remove-failed'      => '警告: クーポンをカートから削除する際にエラーが発生しました、またはクーポンが見つかりません。',
            'error-placing-order'       => '警告: 注文処理にエラーがあります。',
            'selected-payment'          => '成功: 支払い方法が正常に選択されました。',
            'error-payment-save'        => '警告: 支払い方法の保存にエラーがあります。',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'カートからすべての商品が正常に削除されました。',
                    'fail-all-remove'          => 'カートから商品を削除する際にエラーが発生しました。',
                    'error.invalid-parameter'  => '警告: 無効なパラメータが提供されました。',
                    'success-moved-cart-item'  => '成功: カートの商品がウィッシュリストに移動されました。',
                    'fail-moved-cart-item'     => '失敗: カートの商品はウィッシュリストに移動されていません。',
                    'success-add-to-cart'      => '成功: 商品がカートに追加されました。',
                    'fail-add-to-cart'         => '失敗: 商品はカートに追加されていません。',
                    'success-update-to-cart'   => '成功: カートの商品が正常に更新されました。',
                    'fail-update-to-cart'      => '失敗: カートの商品が更新されていません。',
                    'success-delete-cart-item' => '成功: カートの商品が正常に削除されました。',
                    'fail-delete-cart-item'    => '失敗: カートの商品が見つかりません。',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => '成功: 顧客がログインしました。',
            'success-logout'        => '成功: 顧客がログアウトしました。',
            'no-login-customer'     => '警告: ログインしている顧客が見つかりません。',
            'address-list'          => '成功: 顧客の住所詳細が取得されました。',
            'not-authorized'        => '警告: この住所を更新する権限がありません。',
            'no-address-list'       => '警告: 顧客の住所が見つかりません。',
            'text-password'         => 'パスワードは次のとおりです： :password',
            'not-exists'            => '警告: 提供されたデータに対する顧客が見つかりません。',
            'success-address-list'  => '成功: 顧客の住所が正常に取得されました。',
            'reset-link-sent'       => '成功: パスワードリセットメールが正常に送信されました。',
            'password-reset-failed' => '警告: 既にパスワードリセットメールを送信しました。しばらくしてからお試しください。',
            'no-login-user'         => '警告: ログインユーザーが見つかりません。',
            'customer-details'      => '成功: 顧客の詳細が正常に取得されました。',

            'account' => [
                'not-found' => '警告: :name が見つかりません。',

                'profile' => [
                    'edit-success'   => 'プロフィールが正常に更新されました',
                    'edit-fail'      => 'プロフィールが更新されていません',
                    'unmatch'        => '古いパスワードが一致しません。',
                    'order-pending'  => '一部の注文が保留中または処理中の状態であるため、顧客アカウントを削除できません。',
                    'delete-success' => '顧客が正常に削除されました',
                    'wrong-password' => '間違ったパスワード！',
                ],

                'order' => [
                    'no-order-found' => '警告: 注文が見つかりません。',
                    'cancel-success' => '注文が正常にキャンセルされました',
                ],

                'review' => [
                    'success' => '成功: レビューが正常に送信されました。承認をお待ちください。',
                ],

                'wishlist' => [
                    'removed'            => 'ウィッシュリストからアイテムが正常に削除されました',
                    'remove-fail'        => 'ウィッシュリストからアイテムを削除できません',
                    'remove-all-success' => 'ウィッシュリストからすべてのアイテムが削除されました',
                    'success'            => 'アイテムが正常にウィッシュリストに追加されました',
                    'already-exist'      => '製品はすでにウィッシュリストに存在します',
                    'move-to-cart'       => 'カートに移動',
                    'moved-success'      => 'アイテムが正常にカートに移動しました',
                    'error-move-to-cart' => '警告: この製品には必須のオプションがあるため、カートに移動できません。',
                    'no-item-found'      => '警告: 製品が見つかりません。',
                ],

                'addresses' => [
                    'delete-success' => '顧客の住所が正常に削除されました',
                ],
            ],

            'signup-form' => [
                'error-registration'       => '警告: 顧客登録に失敗しました。',
                'warning-num-already-used' => '警告: この :phone 番号は別のメールアドレスで登録されています。',
                'success-verify'           => 'アカウントが正常に作成されました。確認のためのメールが送信されました。',
                'invalid-creds'            => '資格情報を確認して、もう一度お試しください。',

                'validation' => [
                    'unique'   => 'この :field はすでに使用されています。',
                    'required' => ':field フィールドは必須です。',
                    'same'     => ':field とパスワードが一致する必要があります。',
                ],
            ],

            'login-form' => [
                'not-activated' => 'アクティベーションは管理者の承認が必要です',
                'invalid-creds' => '資格情報を確認して、もう一度お試しください。',
            ],
        ],

        'response' => [
            'error.invalid-parameter' => '警告: 無効なパラメータが提供されました。',
            'invalid-header'          => '警告: 無効なヘッダートークンです。',
            'cancel-error'            => '注文はキャンセルできません。',
        ],
    ]
];