<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Você já está inscrito em nosso boletim informativo.',
            'subscribe-success'  => 'Você se inscreveu com sucesso em nosso boletim informativo.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Obrigado por nos contactar. Entraremos em contato em breve.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Aviso: Link de download não encontrado.',
                'sample-not-found' => 'Aviso: Amostra para download não encontrada.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Aviso: Nenhum cliente logado encontrado.',
            'success-login'     => 'Sucesso: Login do cliente realizado com sucesso.',
            'success-logout'    => 'Sucesso: Logout do cliente realizado com sucesso.',

            'signup' => [
                'error-registration' => 'Aviso: Falha no registro do cliente.',
                'success-verify'     => 'Conta criada com sucesso, um e-mail foi enviado para verificação.',
                'success'            => 'Sucesso: Cliente registrado e logado com sucesso.',
            ],

            'social-login' => [
                'disabled' => 'Aviso: Login social está desativado.',
            ],

            'login' => [
                'invalid-creds' => 'Verifique suas credenciais e tente novamente.',
                'not-activated' => 'Sua ativação requer aprovação do administrador',
                'verify-first'  => 'Por favor, verifique seu e-mail primeiro.',
                'suspended'     => 'Sua conta foi suspensa pelo administrador.',

                'validation' => [
                    'required' => 'O campo :field é obrigatório.',
                    'same'     => 'O campo :field e a senha devem ser iguais.',
                    'unique'   => 'Este :field já está em uso.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Link de redefinição de senha já enviado para o seu e-mail.',
                'email-not-exist' => 'E-mail não existe.',
                'reset-link-sent' => 'Link de redefinição de senha enviado para o seu e-mail.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Sucesso: Detalhes do cliente obtidos com sucesso.',
                    'delete-success'   => 'Sucesso: Conta excluída com sucesso.',
                    'password-unmatch' => 'A senha não corresponde.',
                    'update-fail'      => 'Aviso: Perfil não atualizado.',
                    'update-success'   => 'Sucesso: Perfil atualizado com sucesso.',
                    'wrong-password'   => 'Aviso: Senha incorreta fornecida.',
                    'order-pending'    => 'Você não pode excluir a conta porque tem alguns pedidos pendentes.',
                ],

                'addresses' => [
                    'create-success'         => 'Endereço criado com sucesso.',
                    'default-update-success' => 'O endereço foi definido como padrão',
                    'delete-success'         => 'Endereço excluído com sucesso',
                    'not-found'              => 'Aviso: Endereço não encontrado.',
                    'update-success'         => 'Endereço atualizado com sucesso.',
                    'already-default'        => 'Aviso: Este endereço já está definido como padrão.',
                ],

                'wishlist' => [
                    'product-removed' => 'Aviso: Produto não encontrado.',
                    'success'         => 'Sucesso: Produto adicionado à lista de desejos com sucesso.',
                    'already-exist'   => 'Aviso: Já adicionado à lista de desejos.',
                    'remove-success'  => 'Sucesso: Item removido com sucesso da lista de desejos.',
                    'not-found'       => 'Aviso: Nenhum produto encontrado na lista de desejos.',
                    'moved-to-cart'   => 'Sucesso: Produto movido com sucesso para o carrinho.',
                ],

                'orders' => [
                    'not-found'      => 'Aviso: Nenhum pedido encontrado.',
                    'cancel-error'   => 'Aviso: Pedido não cancelado.',
                    'cancel-success' => 'Sucesso: Pedido cancelado com sucesso.',

                    'shipment' => [
                        'not-found' => 'Aviso: Remessa não encontrada.',
                    ],

                    'invoice' => [
                        'not-found' => 'Aviso: Fatura não encontrada.',
                    ],

                    'refund' => [
                        'not-found' => 'Aviso: Reembolso não encontrado.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Aviso: Produto para download não encontrado.',
                    'not-auth'       => 'Aviso: Você não está autorizado a realizar esta ação.',
                    'payment-error'  => 'O pagamento não foi feito para este download.',
                    'download-error' => 'O link de download expirou.',
                ],

                'gdpr' => [
                    'create-success'       => 'Sucesso: Pedido de GDPR criado com sucesso.',
                    'revoke-failed'        => 'Aviso: Falha ao revogar o pedido de GDPR.',
                    'revoked-successfully' => 'Sucesso: Pedido de GDPR revogado com sucesso.',
                    'not-enabled'          => 'Aviso: GDPR não está ativado.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Aviso: Produto de comparação não encontrado.',
                'product-not-found'   => 'Aviso: Produto não encontrado.',
                'already-added'       => 'Aviso: Produto já adicionado à lista de comparação.',
                'item-add-success'    => 'Sucesso: Produto adicionado com sucesso à lista de comparação.',
                'remove-success'      => 'Sucesso: Item removido com sucesso da lista de comparação.',
                'mass-remove-success' => 'Sucesso: Itens selecionados excluídos com sucesso.',
                'not-auth'            => 'Aviso: Você não está autorizado a realizar esta ação.',
            ],

            'reviews' => [
                'create-success'      => 'Sucesso: Avaliação criada com sucesso.',
                'delete-success'      => 'Sucesso: Avaliação excluída com sucesso.',
                'mass-delete-success' => 'Sucesso: Avaliações selecionadas excluídas com sucesso.',
                'not-found'           => 'Aviso: Avaliação não encontrada.',
                'product-not-found'   => 'Aviso: Produto não encontrado.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Aviso: Os links de download não estão disponíveis.',
                        'invalid-parameter'  => 'Aviso: Parâmetros inválidos fornecidos.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Sucesso: Produto adicionado ao carrinho com sucesso.',
                        'update-to-cart'   => 'Sucesso: Produto atualizado no carrinho com sucesso.',
                        'delete-cart-item' => 'Sucesso: Item removido com sucesso do carrinho.',
                        'all-remove'       => 'Sucesso: Todos os itens removidos do carrinho.',
                        'move-to-wishlist' => 'Sucesso: Itens selecionados movidos com sucesso para a lista de desejos.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Aviso: Todos os itens não foram removidos do carrinho.',
                        'update-to-cart'   => 'Aviso: Produto não atualizado no carrinho.',
                        'delete-cart-item' => 'Aviso: Item não removido do carrinho.',
                        'not-found'        => 'Aviso: Carrinho não encontrado.',
                        'item-not-found'   => 'Aviso: Item não encontrado.',
                        'move-to-wishlist' => 'Aviso: Itens selecionados não foram movidos para a lista de desejos.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Aviso: Usuário convidado não pode adicionar endereço.',
                'guest-checkout-warning'    => 'Aviso: Usuário convidado não pode finalizar a compra.',
                'no-billing-address-found'  => 'Aviso: Nenhum endereço de cobrança encontrado.',
                'no-shipping-address-found' => 'Aviso: Nenhum endereço de entrega encontrado.',
                'address-save-success'      => 'Sucesso: Endereço salvo com sucesso.',
            ],

            'shipping' => [
                'method-not-found' => 'Aviso: Método de envio não encontrado.',
                'method-fetched'   => 'Sucesso: Método de envio obtido com sucesso.',
                'save-failed'      => 'Aviso: Método de envio não salvo.',
                'save-success'     => 'Sucesso: Método de envio salvo com sucesso.',
            ],

            'payment' => [
                'method-not-found' => 'Aviso: Método de pagamento não encontrado.',
                'method-fetched'   => 'Sucesso: Método de pagamento obtido com sucesso.',
                'save-failed'      => 'Aviso: Método de pagamento não salvo.',
                'save-success'     => 'Sucesso: Método de pagamento salvo com sucesso.',
            ],

            'coupon' => [
                'apply-success'   => 'Sucesso: Código do cupom aplicado com sucesso.',
                'already-applied' => 'Aviso: Código do cupom já aplicado.',
                'invalid-code'    => 'Aviso: Código do cupom é inválido.',
                'remove-success'  => 'Sucesso: Código do cupom removido com sucesso.',
                'remove-failed'   => 'Aviso: Código do cupom não removido.',
            ],

            'something-wrong'          => 'Aviso: Algo deu errado.',
            'invalid-guest-user'       => 'Aviso: Usuário convidado inválido.',
            'empty-cart'               => 'Aviso: O carrinho está vazio.',
            'missing-billing-address'  => 'Aviso: Endereço de cobrança ausente.',
            'missing-shipping-address' => 'Aviso: Endereço de entrega ausente.',
            'missing-shipping-method'  => 'Aviso: Método de envio ausente.',
            'missing-payment-method'   => 'Aviso: Método de pagamento ausente.',
            'no-address-found'         => 'Aviso: Nenhum endereço de cobrança e entrega encontrado.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Criar',
            'delete'            => 'Excluir',
            'edit'              => 'Editar',
            'mass-delete'       => 'Excluir em Massa',
            'mass-update'       => 'Atualizar em Massa',
            'push-notification' => 'Notificação Push',
            'send'              => 'Enviar',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Notificação Push',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Tópico de Notificação',
                        'info'                            => 'Configurações relacionadas a notificações',
                        'push-notification-configuration' => 'Configuração de Notificações Push FCM',
                        'title'                           => 'API GraphQL',
                        'private-key'                     => 'Conteúdo do Arquivo JSON de Chave Privada',
                        'info-get-private-key'            => 'Info: Para obter o conteúdo do arquivo JSON de Chave Privada FCM: <a href="https://console.firebase.google.com/" target="_blank">Clique aqui</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Sucesso: Scripts personalizados atualizados com sucesso.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Aviso: Não foi possível cancelar o pedido.',
                'cancel-success' => 'Sucesso: Pedido cancelado com sucesso.',
                'not-found'      => 'Aviso: Pedido não encontrado.',
            ],

            'shipments' => [
                'creation-error'   => 'Aviso: Não foi possível criar o envio.',
                'not-found'        => 'Aviso: Envio não encontrado.',
                'quantity-invalid' => 'Aviso: Quantidade inválida fornecida.',
                'shipment-error'   => 'Aviso: Não foi possível criar o envio.',
                'create-success'   => 'Sucesso: Envio criado com sucesso.',
            ],

            'invoices' => [
                'creation-error' => 'Aviso: Não foi possível criar a fatura.',
                'not-found'      => 'Aviso: Fatura não encontrada.',
                'product-error'  => 'Aviso: Produto inválido fornecido.',
                'create-success' => 'Sucesso: Fatura criada com sucesso.',
                'invalid-qty'    => 'Aviso: Encontramos uma quantidade inválida para itens da fatura.',
            ],

            'refunds' => [
                'creation-error'      => 'Aviso: Não foi possível criar o reembolso.',
                'refund-amount-error' => 'Aviso: Valor de reembolso inválido fornecido.',
                'refund-limit-error'  => 'Aviso: O valor de reembolso excede o limite de :amount',
                'not-found'           => 'Aviso: Reembolso não encontrado.',
                'create-success'      => 'Sucesso: Reembolso criado com sucesso.',
            ],

            'transactions' => [
                'already-paid'   => 'Aviso: A fatura já foi paga.',
                'amount-exceed'  => 'Aviso: O valor da transação excede o limite.',
                'zero-amount'    => 'Aviso: O valor da transação deve ser maior que zero.',
                'create-success' => 'Sucesso: Transação criada com sucesso.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Aviso: Cliente não encontrado.',
                'cart-not-found'           => 'Aviso: Carrinho não encontrado.',
                'cart-item-not-found'      => 'Aviso: Item do carrinho não encontrado.',
                'cart-create-success'      => 'Sucesso: Carrinho criado com sucesso.',
                'cart-item-add-success'    => 'Sucesso: Produto adicionado ao carrinho com sucesso.',
                'cart-item-remove-success' => 'Sucesso: Item removido com sucesso do carrinho.',
                'cart-item-update-success' => 'Sucesso: Produto atualizado no carrinho com sucesso.',
                'something-wrong'          => 'Aviso: Algo deu errado.',
                'address-save-success'     => 'Sucesso: Endereço salvo com sucesso.',
                'shipping-save-success'    => 'Sucesso: Método de envio salvo com sucesso.',
                'payment-save-success'     => 'Sucesso: Método de pagamento salvo com sucesso.',
                'order-placed-success'     => 'Sucesso: Pedido realizado com sucesso.',
                'payment-method-not-found' => 'Aviso: Método de pagamento não encontrado.',
                'minimum-order-amount-err' => 'Aviso: O valor mínimo do pedido deve ser :amount',
                'check-shipping-address'   => 'Aviso: Verifique o endereço de envio.',
                'check-billing-address'    => 'Aviso: Verifique o endereço de cobrança.',
                'specify-shipping-method'  => 'Aviso: Especifique o método de envio.',
                'specify-payment-method'   => 'Aviso: Especifique o método de pagamento.',
                'coupon-not-valid'         => 'Aviso: O código do cupom não é válido.',
                'coupon-already-applied'   => 'Aviso: O código do cupom já foi aplicado.',
                'coupon-applied'           => 'Sucesso: Código do cupom aplicado com sucesso.',
                'coupon-removed'           => 'Sucesso: Código do cupom removido com sucesso.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Produto criado com sucesso.',
                'delete-success'            => 'Produto excluído com sucesso.',
                'not-found'                 => 'Aviso: Produto não encontrado.',
                'update-success'            => 'Produto atualizado com sucesso.',
                'configurable-attr-missing' => 'Aviso: Atributo configurável está faltando.',
                'simple-products-error'     => 'Aviso: Produtos simples estão faltando.',
            ],

            'categories' => [
                'already-taken'  => 'Aviso: O slug já está sendo usado.',
                'create-success' => 'Categoria criada com sucesso.',
                'delete-success' => 'Categoria excluída com sucesso.',
                'not-found'      => 'Aviso: Categoria não encontrada.',
                'update-success' => 'Categoria atualizada com sucesso.',
                'root-delete'    => 'Aviso: A categoria raiz não pode ser excluída.',
            ],

            'attributes' => [
                'create-success'    => 'Atributo criado com sucesso.',
                'delete-success'    => 'Atributo excluído com sucesso.',
                'not-found'         => 'Aviso: Atributo não encontrado.',
                'update-success'    => 'Atributo atualizado com sucesso.',
                'user-define-error' => 'Aviso: Você não tem permissão para excluir atributos criados pelo sistema.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Grupo de atributos criado com sucesso.',
                'delete-success'    => 'Grupo de atributos excluído com sucesso.',
                'not-found'         => 'Aviso: Grupo de atributos não encontrado.',
                'update-success'    => 'Grupo de atributos atualizado com sucesso.',
                'user-define-error' => 'Aviso: Você não tem permissão para excluir grupos de atributos criados pelo sistema.',
            ],

            'attribute-families' => [
                'create-success'          => 'Família de atributos criada com sucesso.',
                'delete-success'          => 'Família de atributos excluída com sucesso.',
                'not-found'               => 'Aviso: Família de atributos não encontrada.',
                'update-success'          => 'Família de atributos atualizada com sucesso.',
                'last-delete-error'       => 'Aviso: A última família de atributos não pode ser excluída.',
                'attribute-product-error' => 'Aviso: Alguns produtos estão associados a esta família de atributos.',
                'user-define-error'       => 'Aviso: Você não tem permissão para excluir famílias de atributos criadas pelo sistema.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Cliente criado com sucesso.',
                'delete-order-pending' => 'Não é possível excluir a conta do cliente porque há pedido(s) pendente(s) ou em estado de processamento.',
                'delete-success'       => 'Cliente excluído com sucesso',
                'not-found'            => 'Aviso: Cliente não encontrado.',
                'note-created-success' => 'Nota criada com sucesso',
                'update-success'       => 'Cliente atualizado com sucesso.',
                'login-success'        => 'Cliente logado com sucesso.',
            ],

            'addresses' => [
                'create-success'         => 'Endereço do cliente criado com sucesso.',
                'default-update-success' => 'Endereço definido como padrão.',
                'delete-success'         => 'Endereço do cliente excluído com sucesso.',
                'not-found'              => 'Aviso: Endereço do cliente não encontrado.',
                'update-success'         => 'Endereço do cliente atualizado com sucesso.',
                'already-default'        => 'Aviso: Este endereço já está definido como padrão.',
            ],

            'groups' => [
                'create-success'     => 'Grupo de clientes criado com sucesso.',
                'customer-associate' => 'Aviso: O grupo não pode ser excluído. O cliente está associado a ele.',
                'delete-success'     => 'Grupo de clientes excluído com sucesso',
                'not-found'          => 'Aviso: Grupo de clientes não encontrado.',
                'update-success'     => 'Grupo de clientes atualizado com sucesso.',
                'user-define-error'  => 'Aviso: Você não tem permissão para excluir grupos de clientes criados pelo sistema.',
            ],

            'reviews' => [
                'delete-success' => 'Avaliação excluída com sucesso',
                'not-found'      => 'Aviso: Avaliação não encontrada.',
                'update-success' => 'Avaliação atualizada com sucesso.',
            ],

            'gdpr' => [
                'delete-success' => 'Sucesso: Solicitação de GDPR excluída com sucesso.',
                'not-found'      => 'Aviso: Solicitação de GDPR não encontrada.',
                'update-success' => 'Solicitação de GDPR atualizada com sucesso.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Aviso: O slug já está sendo usado.',
            'create-success' => 'CMS criado com sucesso.',
            'delete-success' => 'CMS excluído com sucesso',
            'not-found'      => 'Aviso: CMS não encontrado.',
            'update-success' => 'CMS atualizado com sucesso.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Regra de catálogo criada com sucesso.',
                    'delete-failed'  => 'Aviso: A regra de catálogo não foi excluída',
                    'delete-success' => 'Regra de catálogo excluída com sucesso',
                    'not-found'      => 'Aviso: Regra de catálogo não encontrada.',
                    'update-success' => 'Regra de catálogo atualizada com sucesso.',
                ],

                'cart-rules' => [
                    'create-success' => 'Regra de carrinho criada com sucesso.',
                    'delete-failed'  => 'Aviso: A regra de carrinho não foi excluída',
                    'delete-success' => 'Regra de carrinho excluída com sucesso',
                    'not-found'      => 'Regra de carrinho não encontrada',
                    'update-success' => 'Regra de carrinho atualizada com sucesso.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Modelo de e-mail criado com sucesso.',
                    'delete-success' => 'Modelo de e-mail excluído com sucesso',
                    'not-found'      => 'Aviso: Modelo de e-mail não encontrado.',
                    'update-success' => 'Modelo de e-mail atualizado com sucesso.',
                ],

                'events' => [
                    'create-success' => 'Evento criado com sucesso.',
                    'delete-success' => 'Evento excluído com sucesso',
                    'not-found'      => 'Aviso: Evento não encontrado.',
                    'update-success' => 'Evento atualizado com sucesso.',
                ],

                'campaigns' => [
                    'create-success' => 'Campanha criada com sucesso.',
                    'delete-success' => 'Campanha excluída com sucesso',
                    'not-found'      => 'Aviso: Campanha não encontrada.',
                    'update-success' => 'Campanha atualizada com sucesso.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Inscrição excluída com sucesso',
                    'not-found'           => 'Aviso: Inscrição não encontrada.',
                    'unsubscribe-success' => 'Sucesso: Inscrição cancelada com sucesso.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'Redirecionamento de URL criado com sucesso.',
                    'delete-success' => 'Redirecionamento de URL excluído com sucesso',
                    'not-found'      => 'Aviso: Redirecionamento de URL não encontrado.',
                    'update-success' => 'Redirecionamento de URL atualizado com sucesso.',
                ],

                'search-terms' => [
                    'create-success' => 'Termo de pesquisa criado com sucesso.',
                    'delete-success' => 'Termo de pesquisa excluído com sucesso',
                    'not-found'      => 'Aviso: Termo de pesquisa não encontrado.',
                    'update-success' => 'Termo de pesquisa atualizado com sucesso.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Sinônimo de pesquisa criado com sucesso.',
                    'delete-success' => 'Sinônimo de pesquisa excluído com sucesso',
                    'not-found'      => 'Aviso: Sinônimo de pesquisa não encontrado.',
                    'update-success' => 'Sinônimo de pesquisa atualizado com sucesso.',
                ],

                'sitemaps' => [
                    'create-success' => 'Mapa do site criado com sucesso.',
                    'delete-success' => 'Mapa do site excluído com sucesso',
                    'not-found'      => 'Aviso: Mapa do site não encontrado.',
                    'update-success' => 'Mapa do site atualizado com sucesso.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Local criado com sucesso.',
                'default-delete-error' => 'O local padrão não pode ser excluído.',
                'delete-error'         => 'Falha ao excluir o local.',
                'delete-success'       => 'Local excluído com sucesso.',
                'last-delete-error'    => 'Falha ao excluir o último local.',
                'not-found'            => 'Aviso: Local não encontrado.',
                'update-success'       => 'Local atualizado com sucesso.',
            ],

            'currencies' => [
                'create-success'       => 'Moeda criada com sucesso.',
                'default-delete-error' => 'A moeda padrão não pode ser excluída.',
                'delete-error'         => 'Falha ao excluir a moeda.',
                'delete-success'       => 'Moeda excluída com sucesso.',
                'last-delete-error'    => 'Falha ao excluir a última moeda.',
                'not-found'            => 'Aviso: Moeda não encontrada.',
                'update-success'       => 'Moeda atualizada com sucesso.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Taxa de câmbio criada com sucesso.',
                'delete-error'            => 'Falha ao excluir a taxa de câmbio.',
                'delete-success'          => 'Taxa de câmbio excluída com sucesso.',
                'invalid-target-currency' => 'Aviso: Moeda de destino inválida fornecida.',
                'last-delete-error'       => 'Falha ao excluir a última taxa de câmbio.',
                'not-found'               => 'Aviso: Taxa de câmbio não encontrada.',
                'update-success'          => 'Taxa de câmbio atualizada com sucesso.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Estoque criado com sucesso.',
                'delete-error'      => 'Falha ao excluir o estoque.',
                'delete-success'    => 'Estoque excluído com sucesso.',
                'last-delete-error' => 'Falha ao excluir o último estoque.',
                'not-found'         => 'Aviso: Estoque não encontrado.',
                'update-success'    => 'Estoque atualizado com sucesso.',
            ],

            'channels' => [
                'create-success'       => 'Canal criado com sucesso.',
                'default-delete-error' => 'O canal padrão não pode ser excluído.',
                'delete-error'         => 'Falha ao excluir o canal.',
                'delete-success'       => 'Canal excluído com sucesso.',
                'last-delete-error'    => 'Falha ao excluir o último canal.',
                'not-found'            => 'Aviso: Canal não encontrado.',
                'update-success'       => 'Canal atualizado com sucesso.',
            ],

            'users' => [
                'activate-warning'  => 'Sua conta ainda não foi ativada, entre em contato com o administrador.',
                'create-success'    => 'Usuário criado com sucesso.',
                'delete-error'      => 'Falha ao excluir o usuário.',
                'delete-success'    => 'Usuário excluído com sucesso.',
                'last-delete-error' => 'Falha ao excluir o último usuário.',
                'login-error'       => 'Verifique suas credenciais e tente novamente.',
                'not-found'         => 'Aviso: Usuário não encontrado.',
                'success-login'     => 'Sucesso: Usuário logado com sucesso.',
                'success-logout'    => 'Sucesso: Usuário desconectado com sucesso.',
                'update-success'    => 'Usuário atualizado com sucesso.',
            ],

            'roles' => [
                'create-success'    => 'Função criada com sucesso.',
                'delete-error'      => 'Falha ao excluir a função.',
                'delete-success'    => 'Função excluída com sucesso.',
                'last-delete-error' => 'A última função não pode ser excluída.',
                'not-found'         => 'Aviso: Função não encontrada.',
                'update-success'    => 'Função atualizada com sucesso.',
            ],

            'themes' => [
                'create-success' => 'Tema criado com sucesso.',
                'delete-success' => 'Tema excluído com sucesso.',
                'not-found'      => 'Aviso: Tema não encontrado.',
                'update-success' => 'Tema atualizado com sucesso.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'O category_id especificado não existe.',
                        'invalid-boolean-value' => 'O valor de :key deve ser 0 ou 1.',
                        'invalid-filter-key'    => 'A chave do filtro ":key" não é permitida.',
                        'invalid-limit-value'   => 'O valor do limite deve ser um dos seguintes: :options.',
                        'invalid-select-option' => 'O valor :key é inválido. As opções válidas são: :options.',
                        'invalid-sort-value'    => 'O valor de ordenação deve ser um dos seguintes: :options.',
                        'missing-limit-key'     => 'filtersInput deve incluir uma chave "limit".',
                        'missing-sort-key'      => 'filtersInput deve incluir uma chave "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Taxa de imposto criada com sucesso.',
                'delete-error'   => 'Falha ao excluir a taxa de imposto.',
                'delete-success' => 'Taxa de imposto excluída com sucesso.',
                'not-found'      => 'Aviso: Taxa de imposto não encontrada.',
                'update-success' => 'Taxa de imposto atualizada com sucesso.',
            ],

            'tax-category' => [
                'create-success'     => 'Categoria de imposto criada com sucesso.',
                'delete-error'       => 'Falha ao excluir a categoria de imposto.',
                'delete-success'     => 'Categoria de imposto excluída com sucesso.',
                'not-found'          => 'Aviso: Categoria de imposto não encontrada.',
                'tax-rate-not-found' => 'Os IDs fornecidos não foram encontrados. IDs: :ids',
                'update-success'     => 'Categoria de imposto atualizada com sucesso.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Adicionar Notificação',
                    'general'   => 'Geral',
                    'title'     => 'Notificação Push',

                    'datagrid' => [
                        'channel-name'         => 'Nome do Canal',
                        'created-at'           => 'Data de Criação',
                        'delete'               => 'Excluir',
                        'id'                   => 'ID',
                        'image'                => 'Imagem',
                        'notification-content' => 'Conteúdo da Notificação',
                        'notification-status'  => 'Status da Notificação',
                        'notification-type'    => 'Tipo de Notificação',
                        'text-title'           => 'Título',
                        'update'               => 'Atualizar',
                        'updated-at'           => 'Data de Atualização',

                        'status' => [
                            'disabled' => 'Desativado',
                            'enabled'  => 'Ativado',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Voltar',
                    'content-and-image'    => 'Conteúdo e Imagem da Notificação',
                    'create-btn-title'     => 'Salvar Notificação',
                    'general'              => 'Geral',
                    'image'                => 'Imagem',
                    'new-notification'     => 'Nova Notificação',
                    'notification-content' => 'Conteúdo da Notificação',
                    'notification-type'    => 'Tipo de Notificação',
                    'product-cat-id'       => 'ID do Produto/Categoria',
                    'settings'             => 'Configuração',
                    'status'               => 'Status',
                    'store-view'           => 'Canais',
                    'title'                => 'Notificação Push',

                    'option-type' => [
                        'category' => 'Categoria',
                        'others'   => 'Simples',
                        'product'  => 'Produto',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Voltar',
                    'content-and-image'    => 'Conteúdo e Imagem da Notificação',
                    'edit-notification'    => 'Editar Notificação',
                    'general'              => 'Geral',
                    'image'                => 'Imagem',
                    'notification-content' => 'Conteúdo da Notificação',
                    'notification-type'    => 'Tipo de Notificação',
                    'product-cat-id'       => 'ID do Produto/Categoria',
                    'send-title'           => 'Enviar Notificação',
                    'settings'             => 'Configuração',
                    'status'               => 'Status',
                    'store-view'           => 'Canais',
                    'title'                => 'Notificação Push',
                    'update-btn-title'     => 'Atualizar',

                    'option-type' => [
                        'category' => 'Categoria',
                        'others'   => 'Simples',
                        'product'  => 'Produto',
                    ],
                ],

                'not-found'           => 'Aviso: Notificação não encontrada.',
                'create-success'      => 'Notificação criada com sucesso.',
                'delete-failed'       => 'Falha ao excluir a notificação.',
                'delete-success'      => 'Notificação excluída com sucesso.',
                'mass-update-success' => 'Notificações selecionadas atualizadas com sucesso.',
                'mass-delete-success' => 'Notificações selecionadas excluídas com sucesso.',
                'no-value-selected'   => 'Não há valor selecionado.',
                'send-success'        => 'Notificação enviada com sucesso.',
                'update-success'      => 'Notificação atualizada com sucesso.',
                'configuration-error' => 'Aviso: Configuração FCM não encontrada.',
                'product-not-found'   => 'Aviso: Produto não encontrado.',
                'category-not-found'  => 'Aviso: Categoria não encontrada.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Aviso: Parâmetros inválidos fornecidos.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Aviso: Configuração de e-mail não encontrada.',
    ],
];
