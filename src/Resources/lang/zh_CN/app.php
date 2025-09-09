<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => '您已订阅我们的新闻通讯。',
            'subscribe-success'  => '您已成功订阅我们的新闻通讯。',
        ],

        'contact-us' => [
            'thanks-for-contact' => '感谢您联系我们。我们会尽快回复您。',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => '警告: 找不到下载链接。',
                'sample-not-found' => '警告: 找不到可下载的样本。',
            ],
        ],

        'customers' => [
            'no-login-customer' => '警告：未找到登录的客户。',
            'success-login'     => '成功：客户登录成功。',
            'success-logout'    => '成功：客户登出成功。',

            'signup' => [
                'error-registration' => '警告：客户注册失败。',
                'success-verify'     => '账户创建成功，已发送电子邮件进行验证。',
                'success'            => '成功：客户注册并成功登录。',
            ],

            'social-login' => [
                'disabled' => '警告：社交登录已禁用。',
            ],

            'login' => [
                'invalid-creds' => '请检查您的凭据并重试。',
                'not-activated' => '您的激活需要管理员批准',
                'verify-first'  => '请先验证您的电子邮件。',
                'suspended'     => '您的帐户已被管理员暂停。',

                'validation' => [
                    'required' => '字段 :field 是必填项。',
                    'same'     => '字段 :field 和密码必须匹配。',
                    'unique'   => '此 :field 已被使用。',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => '重置密码链接已发送到您的电子邮件。',
                'email-not-exist' => '电子邮件不存在。',
                'reset-link-sent' => '重置密码链接已发送到您的电子邮件。',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => '成功：客户详细信息获取成功。',
                    'delete-success'   => '成功：帐户删除成功。',
                    'password-unmatch' => '密码不匹配。',
                    'update-fail'      => '警告：个人资料未更新。',
                    'update-success'   => '成功：个人资料更新成功。',
                    'wrong-password'   => '警告：提供了错误的密码。',
                    'order-pending'    => '您无法删除账户，因为您有一些未完成的订单。',
                ],

                'addresses' => [
                    'create-success'         => '地址创建成功。',
                    'default-update-success' => '地址已设置为默认。',
                    'delete-success'         => '地址已成功删除。',
                    'not-found'              => '警告：未找到地址。',
                    'update-success'         => '地址已成功更新。',
                    'already-default'        => '警告：此地址已设置为默认。',
                ],

                'wishlist' => [
                    'product-removed' => '警告：未找到产品。',
                    'success'         => '成功：产品已成功添加到愿望清单。',
                    'already-exist'   => '警告：已添加到愿望清单。',
                    'remove-success'  => '成功：项目已成功从愿望清单中删除。',
                    'not-found'       => '警告：愿望清单中没有找到产品。',
                    'moved-to-cart'   => '成功：产品已成功移动到购物车。',
                ],

                'orders' => [
                    'not-found'      => '警告：未找到订单。',
                    'cancel-error'   => '警告：订单无法取消。',
                    'cancel-success' => '成功：订单已成功取消。',

                    'shipment' => [
                        'not-found' => '警告：未找到发货。',
                    ],

                    'invoice' => [
                        'not-found' => '警告：未找到发票。',
                    ],

                    'refund' => [
                        'not-found' => '警告：未找到退款。',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => '警告：未找到可下载产品。',
                    'not-auth'       => '警告：您无权执行此操作。',
                    'payment-error'  => '未为此下载进行付款。',
                    'download-error' => '下载链接已过期。',
                ],

                'gdpr' => [
                    'create-success'       => '成功：GDPR请求创建成功。',
                    'revoke-failed'        => '警告：未能撤销GDPR请求。',
                    'revoked-successfully' => '成功：GDPR请求撤销成功。',
                    'not-enabled'          => '警告：GDPR未启用。',
                ],
            ],

            'compare-product' => [
                'not-found'           => '警告: 比较产品未找到。',
                'product-not-found'   => '警告: 产品未找到。',
                'already-added'       => '警告: 产品已添加到比较列表。',
                'item-add-success'    => '成功: 产品已成功添加到比较列表。',
                'remove-success'      => '成功: 项目已成功从比较列表中删除。',
                'mass-remove-success' => '成功: 已成功删除所选项目。',
                'not-auth'            => '警告: 您无权执行此操作。',
            ],

            'reviews' => [
                'create-success'      => '成功：评论已成功创建。',
                'delete-success'      => '成功：评论已成功删除。',
                'mass-delete-success' => '成功：已成功删除选定的评论。',
                'not-found'           => '警告：未找到评论。',
                'product-not-found'   => '警告: 产品未找到。',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => '警告：无法生成可下载链接。',
                        'invalid-parameter'  => '警告：提供了无效的参数。',
                    ],

                    'success' => [
                        'add-to-cart'      => '成功：产品已成功添加到购物车。',
                        'update-to-cart'   => '成功：产品已成功更新到购物车。',
                        'delete-cart-item' => '成功：项目已成功从购物车中删除。',
                        'all-remove'       => '成功：所有项目已从购物车中删除。',
                        'move-to-wishlist' => '成功：已成功将选定的项目移动到愿望清单。',
                    ],

                    'fail' => [
                        'all-remove'       => '警告：未能从购物车中删除所有项目。',
                        'update-to-cart'   => '警告：未能将产品更新到购物车。',
                        'delete-cart-item' => '警告：未能从购物车中删除项目。',
                        'not-found'        => '警告：未找到购物车。',
                        'item-not-found'   => '警告：未找到项目。',
                        'move-to-wishlist' => '警告：未能将选定的项目移动到愿望清单。',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => '警告：访客用户无法添加地址。',
                'guest-checkout-warning'    => '警告：访客用户无法结账。',
                'no-billing-address-found'  => '警告：未找到账单地址。',
                'no-shipping-address-found' => '警告：未找到送货地址。',
                'address-save-success'      => '成功：地址已成功保存。',
            ],

            'shipping' => [
                'method-not-found' => '警告：未找到配送方式。',
                'method-fetched'   => '成功：成功获取配送方式。',
                'save-failed'      => '警告：未保存配送方式。',
                'save-success'     => '成功：配送方式已成功保存。',
            ],

            'payment' => [
                'method-not-found' => '警告：未找到付款方式。',
                'method-fetched'   => '成功：成功获取付款方式。',
                'save-failed'      => '警告：未保存付款方式。',
                'save-success'     => '成功：付款方式已成功保存。',
            ],

            'coupon' => [
                'apply-success'   => '成功：优惠券代码已成功应用。',
                'already-applied' => '警告：优惠券代码已经应用。',
                'invalid-code'    => '警告：优惠券代码无效。',
                'remove-success'  => '成功：优惠券代码已成功移除。',
                'remove-failed'   => '警告：优惠券代码未移除。',
            ],

            'something-wrong'          => '警告：出现了一些问题。',
            'invalid-guest-user'       => '警告：无效的访客用户。',
            'empty-cart'               => '警告：购物车为空。',
            'missing-billing-address'  => '警告：缺少账单地址。',
            'missing-shipping-address' => '警告：缺少送货地址。',
            'missing-shipping-method'  => '警告：缺少配送方式。',
            'missing-payment-method'   => '警告：缺少付款方式。',
            'no-address-found'         => '警告：未找到账单和送货地址。',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => '创建',
            'delete'            => '删除',
            'edit'              => '编辑',
            'mass-delete'       => '批量删除',
            'mass-update'       => '批量更新',
            'push-notification' => '推送通知',
            'send'              => '发送',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => '推送通知',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => '通知主题',
                        'info'                            => '与通知相关的配置',
                        'push-notification-configuration' => 'FCM推送通知配置',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => '私钥JSON文件内容',
                        'info-get-private-key'            => '信息: 获取FCM私钥JSON文件内容: <a href="https://console.firebase.google.com/" target="_blank">点击这里</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => '成功: 自定义脚本已成功更新。',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => '警告：订单无法取消。',
                'cancel-success' => '成功：订单取消成功。',
                'not-found'      => '警告：订单未找到。',
            ],

            'shipments' => [
                'creation-error'   => '警告：发货单未创建。',
                'not-found'        => '警告：发货单未找到。',
                'quantity-invalid' => '警告：提供的数量无效。',
                'shipment-error'   => '警告：发货单未创建。',
                'create-success'   => '成功：发货单创建成功。',
            ],

            'invoices' => [
                'creation-error' => '警告：发票未创建。',
                'not-found'      => '警告：发票未找到。',
                'product-error'  => '警告：提供的产品无效。',
                'create-success' => '成功：发票创建成功。',
                'invalid-qty'    => '警告：我们发现了无效的发票项目数量。',
            ],

            'refunds' => [
                'creation-error'      => '警告：退款未创建。',
                'refund-amount-error' => '警告：提供的退款金额无效。',
                'refund-limit-error'  => '警告：退款金额超过限制 :amount',
                'not-found'           => '警告：退款未找到。',
                'create-success'      => '成功：退款创建成功。',
            ],

            'transactions' => [
                'already-paid'   => '警告：发票已支付。',
                'amount-exceed'  => '警告：交易金额超过限制。',
                'zero-amount'    => '警告：交易金额应大于零。',
                'create-success' => '成功：交易创建成功。',
            ],

            'reorder' => [
                'customer-not-found'       => '警告：未找到客户。',
                'cart-not-found'           => '警告：购物车未找到。',
                'cart-item-not-found'      => '警告：购物车项未找到。',
                'cart-create-success'      => '成功：购物车创建成功。',
                'cart-item-add-success'    => '成功：产品成功添加到购物车。',
                'cart-item-remove-success' => '成功：项目已成功从购物车中删除。',
                'cart-item-update-success' => '成功：产品已成功更新到购物车。',
                'something-wrong'          => '警告：出现了一些问题。',
                'address-save-success'     => '成功：地址保存成功。',
                'shipping-save-success'    => '成功：运输方式保存成功。',
                'payment-save-success'     => '成功：支付方式保存成功。',
                'order-placed-success'     => '成功：订单已成功下单。',
                'payment-method-not-found' => '警告：未找到支付方式。',
                'minimum-order-amount-err' => '警告：最低订单金额应为 :amount',
                'check-shipping-address'   => '警告：请检查送货地址。',
                'check-billing-address'    => '警告：请检查账单地址。',
                'specify-shipping-method'  => '警告：请指定运输方式。',
                'specify-payment-method'   => '警告：请指定支付方式。',
                'coupon-not-valid'         => '警告：优惠券代码无效。',
                'coupon-already-applied'   => '警告：优惠券代码已应用。',
                'coupon-applied'           => '成功：优惠券代码已成功应用。',
                'coupon-removed'           => '成功：优惠券代码已成功移除。',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => '产品创建成功。',
                'delete-success'            => '产品删除成功。',
                'not-found'                 => '警告：未找到产品。',
                'update-success'            => '产品更新成功。',
                'configurable-attr-missing' => '警告：缺少可配置属性。',
                'simple-products-error'     => '警告：缺少简单产品。',
            ],

            'categories' => [
                'already-taken'  => '警告：该别名已被使用。',
                'create-success' => '分类创建成功。',
                'delete-success' => '分类删除成功。',
                'not-found'      => '警告：未找到分类。',
                'update-success' => '分类更新成功。',
                'root-delete'    => '警告：根分类不能被删除。',
            ],

            'attributes' => [
                'create-success'    => '属性创建成功。',
                'delete-success'    => '属性删除成功。',
                'not-found'         => '警告：未找到属性。',
                'update-success'    => '属性更新成功。',
                'user-define-error' => '警告：您无权删除系统创建的属性。',
            ],

            'attribute-groups' => [
                'create-success'    => '属性分组创建成功。',
                'delete-success'    => '属性分组删除成功。',
                'not-found'         => '警告：未找到属性分组。',
                'update-success'    => '属性分组更新成功。',
                'user-define-error' => '警告：您无权删除系统创建的属性分组。',
            ],

            'attribute-families' => [
                'create-success'          => '属性组创建成功。',
                'delete-success'          => '属性组删除成功。',
                'not-found'               => '警告：未找到属性组。',
                'update-success'          => '属性组更新成功。',
                'last-delete-error'       => '警告：最后一个属性组不能被删除。',
                'attribute-product-error' => '警告：有产品与该属性组关联。',
                'user-define-error'       => '警告：您无权删除系统创建的属性组。',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => '客户创建成功。',
                'delete-order-pending' => '无法删除客户账户，因为有一些订单处于待处理或处理中的状态。',
                'delete-success'       => '客户删除成功。',
                'not-found'            => '警告：未找到客户。',
                'note-created-success' => '备注创建成功。',
                'update-success'       => '客户更新成功。',
                'login-success'        => '客户登录成功。',
            ],

            'addresses' => [
                'create-success'         => '客户地址创建成功。',
                'default-update-success' => '地址已设置为默认。',
                'delete-success'         => '客户地址删除成功。',
                'not-found'              => '警告：未找到客户地址。',
                'update-success'         => '客户地址更新成功。',
                'already-default'        => '警告：此地址已设置为默认。',
            ],

            'groups' => [
                'create-success'     => '客户组创建成功。',
                'customer-associate' => '警告：无法删除该组，因为客户已关联。',
                'delete-success'     => '客户组删除成功。',
                'not-found'          => '警告：未找到客户组。',
                'update-success'     => '客户组更新成功。',
                'user-define-error'  => '警告：您无权删除系统创建的客户组。',
            ],

            'reviews' => [
                'delete-success' => '评论删除成功。',
                'not-found'      => '警告：未找到评论。',
                'update-success' => '评论更新成功。',
            ],

            'gdpr' => [
                'delete-success' => '成功：GDPR请求已成功删除。',
                'not-found'      => '警告：未找到GDPR请求。',
                'update-success' => 'GDPR请求已成功更新。',
            ],
        ],

        'cms' => [
            'already-taken'  => '警告：该别名已被使用。',
            'create-success' => '成功：CMS创建成功。',
            'delete-success' => '成功：CMS删除成功。',
            'not-found'      => '警告：未找到CMS。',
            'update-success' => '成功：CMS更新成功。',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => '成功：目录规则创建成功。',
                    'delete-failed'  => '警告：目录规则未删除。',
                    'delete-success' => '成功：目录规则删除成功。',
                    'not-found'      => '警告：未找到目录规则。',
                    'update-success' => '成功：目录规则更新成功。',
                ],

                'cart-rules' => [
                    'create-success' => '成功：购物车规则创建成功。',
                    'delete-failed'  => '警告：购物车规则未删除。',
                    'delete-success' => '成功：购物车规则删除成功。',
                    'not-found'      => '警告：未找到购物车规则。',
                    'update-success' => '成功：购物车规则更新成功。',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => '成功：电子邮件模板创建成功。',
                    'delete-success' => '成功：电子邮件模板删除成功。',
                    'not-found'      => '警告：未找到电子邮件模板。',
                    'update-success' => '成功：电子邮件模板更新成功。',
                ],

                'events' => [
                    'create-success' => '成功：事件创建成功。',
                    'delete-success' => '成功：事件删除成功。',
                    'not-found'      => '警告：未找到事件。',
                    'update-success' => '成功：事件更新成功。',
                ],

                'campaigns' => [
                    'create-success' => '成功：活动创建成功。',
                    'delete-success' => '成功：活动删除成功。',
                    'not-found'      => '警告：未找到活动。',
                    'update-success' => '成功：活动更新成功。',
                ],

                'subscriptions' => [
                    'delete-success'      => '成功：订阅删除成功。',
                    'not-found'           => '警告：未找到订阅。',
                    'unsubscribe-success' => '成功：订阅已成功取消。',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => '成功：URL重写创建成功。',
                    'delete-success' => '成功：URL重写删除成功。',
                    'not-found'      => '警告：未找到URL重写。',
                    'update-success' => '成功：URL重写更新成功。',
                ],

                'search-terms' => [
                    'create-success' => '成功：搜索词创建成功。',
                    'delete-success' => '成功：搜索词删除成功。',
                    'not-found'      => '警告：未找到搜索词。',
                    'update-success' => '成功：搜索词更新成功。',
                ],

                'search-synonyms' => [
                    'create-success' => '成功：搜索同义词创建成功。',
                    'delete-success' => '成功：搜索同义词删除成功。',
                    'not-found'      => '警告：未找到搜索同义词。',
                    'update-success' => '成功：搜索同义词更新成功。',
                ],

                'sitemaps' => [
                    'create-success' => '成功：站点地图创建成功。',
                    'delete-success' => '成功：站点地图删除成功。',
                    'not-found'      => '警告：未找到站点地图。',
                    'update-success' => '成功：站点地图更新成功。',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => '语言环境创建成功。',
                'default-delete-error' => '默认语言环境无法删除。',
                'delete-error'         => '语言环境删除失败。',
                'delete-success'       => '语言环境删除成功。',
                'last-delete-error'    => '最后一个语言环境删除失败。',
                'not-found'            => '警告：未找到语言环境。',
                'update-success'       => '语言环境更新成功。',
            ],

            'currencies' => [
                'create-success'       => '货币创建成功。',
                'default-delete-error' => '默认货币无法删除。',
                'delete-error'         => '货币删除失败。',
                'delete-success'       => '货币删除成功。',
                'last-delete-error'    => '最后一个货币删除失败。',
                'not-found'            => '警告：未找到货币。',
                'update-success'       => '货币更新成功。',
            ],

            'exchange-rates' => [
                'create-success'          => '汇率创建成功。',
                'delete-error'            => '汇率删除失败。',
                'delete-success'          => '汇率删除成功。',
                'invalid-target-currency' => '警告：提供的目标货币无效。',
                'last-delete-error'       => '最后一个汇率删除失败。',
                'not-found'               => '警告：未找到汇率。',
                'update-success'          => '汇率更新成功。',
            ],

            'inventory-sources' => [
                'create-success'    => '库存创建成功。',
                'delete-error'      => '库存删除失败。',
                'delete-success'    => '库存删除成功。',
                'last-delete-error' => '最后一个库存删除失败。',
                'not-found'         => '警告：未找到库存。',
                'update-success'    => '库存更新成功。',
            ],

            'channels' => [
                'create-success'       => '渠道创建成功。',
                'default-delete-error' => '默认渠道无法删除。',
                'delete-error'         => '渠道删除失败。',
                'delete-success'       => '渠道删除成功。',
                'last-delete-error'    => '最后一个渠道删除失败。',
                'not-found'            => '警告：未找到渠道。',
                'update-success'       => '渠道更新成功。',
            ],

            'users' => [
                'activate-warning'  => '您的帐户尚未激活，请联系管理员。',
                'create-success'    => '用户创建成功。',
                'delete-error'      => '用户删除失败。',
                'delete-success'    => '用户删除成功。',
                'last-delete-error' => '最后一个用户删除失败。',
                'login-error'       => '请检查您的凭据并重试。',
                'not-found'         => '警告：未找到用户。',
                'success-login'     => '成功：用户登录成功。',
                'success-logout'    => '成功：用户注销成功。',
                'update-success'    => '用户更新成功。',
            ],

            'roles' => [
                'create-success'    => '角色创建成功。',
                'delete-error'      => '角色删除失败。',
                'delete-success'    => '角色删除成功。',
                'last-delete-error' => '最后一个角色无法删除。',
                'not-found'         => '警告：未找到角色。',
                'update-success'    => '角色更新成功。',
            ],

            'themes' => [
                'create-success' => '主题创建成功。',
                'delete-success' => '主题删除成功。',
                'not-found'      => '警告：未找到主题。',
                'update-success' => '主题更新成功。',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => '指定的 category_id 不存在。',
                        'invalid-boolean-value' => ':key 的值必须是 0 或 1。',
                        'invalid-filter-key'    => '过滤键 ":key" 不被允许。',
                        'invalid-limit-value'   => '限制值必须是以下之一：:options。',
                        'invalid-select-option' => ':key 的值无效。有效选项为：:options。',
                        'invalid-sort-value'    => '排序值必须是以下之一：:options。',
                        'missing-limit-key'     => 'filtersInput 必须包含 "limit" 键。',
                        'missing-sort-key'      => 'filtersInput 必须包含 "sort" 键。',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => '税率创建成功。',
                'delete-error'   => '税率删除失败。',
                'delete-success' => '税率删除成功。',
                'not-found'      => '警告：未找到税率。',
                'update-success' => '税率更新成功。',
            ],

            'tax-category' => [
                'create-success'     => '税收分类创建成功。',
                'delete-error'       => '税收分类删除失败。',
                'delete-success'     => '税收分类删除成功。',
                'not-found'          => '警告：未找到税收分类。',
                'tax-rate-not-found' => '未找到给定的ID。ID：- :ids',
                'update-success'     => '税收分类更新成功。',
            ],

            'notification' => [
                'index' => [
                    'add-title' => '添加通知',
                    'general'   => '常规',
                    'title'     => '推送通知',

                    'datagrid' => [
                        'channel-name'         => '渠道名称',
                        'created-at'           => '创建时间',
                        'delete'               => '删除',
                        'id'                   => 'ID',
                        'image'                => '图片',
                        'notification-content' => '通知内容',
                        'notification-status'  => '通知状态',
                        'notification-type'    => '通知类型',
                        'text-title'           => '标题',
                        'update'               => '更新',
                        'updated-at'           => '更新时间',

                        'status' => [
                            'disabled' => '禁用',
                            'enabled'  => '启用',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => '返回',
                    'content-and-image'    => '通知内容和图片',
                    'create-btn-title'     => '保存通知',
                    'general'              => '常规',
                    'image'                => '图片',
                    'new-notification'     => '新通知',
                    'notification-content' => '通知内容',
                    'notification-type'    => '通知类型',
                    'product-cat-id'       => '产品/分类ID',
                    'settings'             => '设置',
                    'status'               => '状态',
                    'store-view'           => '渠道',
                    'title'                => '推送通知',

                    'option-type' => [
                        'category' => '分类',
                        'others'   => '普通',
                        'product'  => '产品',
                    ],
                ],

                'edit' => [
                    'back-btn'             => '返回',
                    'content-and-image'    => '通知内容和图片',
                    'edit-notification'    => '编辑通知',
                    'general'              => '常规',
                    'image'                => '图片',
                    'notification-content' => '通知内容',
                    'notification-type'    => '通知类型',
                    'product-cat-id'       => '产品/分类ID',
                    'send-title'           => '发送通知',
                    'settings'             => '设置',
                    'status'               => '状态',
                    'store-view'           => '渠道',
                    'title'                => '推送通知',
                    'update-btn-title'     => '更新',

                    'option-type' => [
                        'category' => '分类',
                        'others'   => '普通',
                        'product'  => '产品',
                    ],
                ],

                'not-found'           => '警告：未找到通知。',
                'create-success'      => '通知创建成功。',
                'delete-failed'       => '通知删除失败。',
                'delete-success'      => '通知删除成功。',
                'mass-update-success' => '所选通知更新成功。',
                'mass-delete-success' => '所选通知删除成功。',
                'no-value-selected'   => '没有现有的值。',
                'send-success'        => '通知发送成功。',
                'update-success'      => '通知更新成功。',
                'configuration-error' => '警告：未找到FCM配置。',
                'product-not-found'   => '警告：未找到产品。',
                'category-not-found'  => '警告：未找到分类。',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => '警告：提供了无效的参数。',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => '警告：未找到电子邮件配置。',
    ],
];
