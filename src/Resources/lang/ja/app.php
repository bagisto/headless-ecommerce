<?php

    return [
        'admin' => [
            'menu' => [
                'push-notification' => 'プッシュ通知',
            ],

            'acl' => [
                'push-notification' => 'プッシュ通知',
                'send' => '送信',
            ],

            'system' => [
                'graphql-api' => 'GraphQL API',
                'push-notification-configuration' => 'FCMプッシュ通知の設定',
                'server-key' => 'サーバーキー',
                'info-get-server-key' => '情報: FCM APIの資格情報を取得するには: <a href="https://console.firebase.google.com/" target="_blank">ここをクリック</a>',
                'android-topic' => 'Androidトピック',
                'ios-topic' => 'IOSトピック',
            ],

            'notification' => [
                'title' => 'プッシュ通知',
                'add-title' => '通知を追加',
                'general' => '一般',

                'id' => 'ID',
                'image' => '画像',
                'text-title' => 'タイトル',
                'edit-notification' => '通知の編集',
                'manage' => '通知',
                'new-notification' => '新しい通知',
                'create-btn-title' => '通知を保存',
                'notification-image' => '通知画像',
                'notification-title' => '通知タイトル',
                'notification-content' => '通知内容',
                'notification-type' => '通知タイプ',
                'product-cat-id' => '製品/カテゴリーID',
                'store-view' => 'チャンネル',
                'notification-status' => '通知のステータス',
                'created' => '作成日',
                'modified' => '更新日',
                'collection-autocomplete' => 'カスタムコレクション - (オートコンプリート)',
                'no-collection-found' => '同じ名前のコレクションは見つかりませんでした。',
                'collection-search-hint' => 'コレクション名を入力し始める',
                
                'Action' => [
                    'edit' => '編集',
                ],

                'status' => [
                    'enabled' => '有効',
                    'disabled' => '無効',
                ],

                'notification-type-option' => [
                    'select' => '-- 選択 --',
                    'simple' => 'シンプルタイプ',
                    'product' => '製品ベース',
                    'category' => 'カテゴリーベース',
                ],
            ],

            'alert' => [
                'create-success' => ':name が正常に作成されました',
                'update-success' => ':name が正常に更新されました',
                'delete-success' => ':name が正常に削除されました',
                'delete-failed' => ':name の削除に失敗しました',
                'sended-successfully' => ':name がAndroidとiOSに正常にプッシュされました。',
                'no-value-selected' => '既存の値はありません',
            ],

            'settings' => [
                'exchange_rates' => [
                    'error-invalid-target-currency' => '警告: 無効な対象通貨が指定されました。',
                    'delete-success' => '成功: 為替レートが正常に削除されました。',
                ]
            ],
            
            'response' => [
                'error-invalid-parameter' => '警告: 無効なパラメータが指定されました。',
                'success-login' => '成功: ユーザーのログインに成功しました。',
                'error-login' => '警告: 管理者ユーザーはログインしていません。',
                'session-expired' => '警告: セッションが切れました。アカウントに再度ログインしてください。',
                'invalid-header' => '警告: 無効なヘッダートークンです。',
                'success-logout' => '成功: ユーザーのログアウトに成功しました。',
                'no-login-user' => '警告: ログインユーザーが見つかりません。',
                'error-customer-group' => '警告: システムが作成した属性グループを削除する権限がありません。',
                'password-invalid' => '警告: 正しいパスワードを入力してください。',
                'password-match' => '警告: パスワードが一致しません。',
                'success-registered' => '成功: ユーザーの作成に成功しました。',
                'cancel-error' => '注文をキャンセルできません。',
                'creation-error' => 'この注文に対して返金を作成できません。',
                'channel-failure' => 'チャンネルが見つかりません。',
                'script-delete-success' => 'スクリプトが正常に削除されました。',
            ]
        ],

        'shop' => [
            'customer' => [
                'success-login' => '成功: 顧客のログインに成功しました。',
                'success-logout' => '成功: 顧客のログアウトに成功しました。',
                'no-login-customer' => '警告: ログイン顧客が見つかりません。',
                'address-list' => '成功: 顧客の住所詳細を取得しました。',
                'not-authorized' => '警告: この住所を更新する権限がありません。',
                'success-address-list' => '成功: 顧客の住所を正常に取得しました。',
                'no-address-list' => '警告: 顧客の住所が見つかりません。',
                'text-password' => 'あなたのパスワードは：:password',
                'not-exists' => '警告: 提供されたデータに対する顧客が見つかりません。',
            ],
            'response' => [
                'error-registration' => '警告: 顧客登録に失

敗しました。',
                'password-reset-failed' => '警告: すでにパスワードリセットのメールを送信しました。しばらくしてから再試行してください。',
                'customer-details' => '成功: 顧客詳細を正常に取得しました。',
                'not-found' => '警告: :name が見つかりません。',
                'no-address-found' => '警告: 住所が見つかりません。',
                'no-order-found' => '警告: 注文が見つかりません。',
                'warning-empty-cart' => '警告: カートに追加された商品はありません。',
                'success-add-to-cart' => '成功: 商品がカートに追加されました。',
                'success-update-to-cart' => '成功: カートアイテムが正常に更新されました。',
                'success-delete-cart-item' => '成功: カートアイテムが正常に削除されました。',
                'success-moved-cart-item' => '成功: カートアイテムがウィッシュリストに正常に移動されました。',
                'billing-address-missing' => '警告: チェックアウトのための請求先住所がありません。',
                'shipping-address-missing' => '警告: チェックアウトのための配送先住所がありません。',
                'invalid-address' => '警告: 提供されたアドレスIDの住所が見つかりません。',
                'wrong-error' => '警告: カートに何らかのエラーがあります。再試行してください。',
                'save-cart-address' => '成功: カートの住所が正常に保存されました。',
                'error-payment-selection' => '警告: 支払い方法を取得する際にエラーが発生しました。',
                'selected-shipment' => '成功: 送料が正常に選択されました。',
                'error-payment-save' => '警告: 支払い方法の保存中にエラーが発生しました。',
                'selected-payment' => '成功: 支払い方法が正常に選択されました。',
                'error-placing-order' => '警告: 注文を作成する際にエラーが発生しました。',
                'invalid-product' => '警告: 無効な商品をリクエストしています。',
                'already-exist-inwishlist' => '情報: この商品はすでにウィッシュリストに存在します。',
                'error-move-to-cart' => '警告: この商品にはいくつかの必須オプションがあるため、カートに移動できません。',
                'no-billing-address-found' => '警告: :address_id 請求IDで請求先住所のレコードが見つかりません。',
                'no-shipping-address-found' => '警告: :address_id 配送IDで配送先住所のレコードが見つかりません。',
                'invalid-guest-access' => '警告: ゲスト顧客は請求/配送先住所IDを使用して住所を取得できません。',
                'guest-address-warning' => '警告: ゲストとして試す場合は、Authorizationトークンなしで試してください。',
                'warning-num-already-used' => '警告: この :phone 番号は別の電子メールアドレスを使用して登録されています。',
                'coupon-removed' => '成功: カートからクーポンが正常に削除されました。',
                'coupon-remove-failed' => '警告: カートからクーポンを削除する際にエラーが発生しました、またはクーポンが見つかりませんでした。',
                'review-create-success' => '成功: レビューが正常に送信されました。承認をお待ちください。',
            ]
        ],
        
        'validation' => [
            'unique' => 'この :field は既に使用されています。',
            'required' => ':field フィールドが必要です。',
            'same' => ':field とパスワードが一致する必要があります。',
        ],
        
        'mail' => [
            'customer' => [
                'password' => [
                    'heading' => config('app.name') . ' - パスワードリセット',
                    'reset' => 'パスワードリセットメール',
                    'summary' => 'このメールは、アカウントのパスワードリセットに関連しています。パスワードは正常に変更されました。
                        下記のパスワードを使用してアカウントにログインしてください。',
                ]
            ]
        ]
    ];