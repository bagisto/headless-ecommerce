<?php

return [
    'admin' => [
        'menu' => [
            'push-notification' => 'Bildirim Gönderme',
        ],

        'acl' => [
            'push-notification' => 'Bildirim Gönderme',
            'send'              => 'Gönder',
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Bildirim Konusu',
                        'info'                            => 'Bildirim ile ilgili yapılandırmalar',
                        'push-notification-configuration' => 'FCM Anlık Bildirim Yapılandırması',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Özel Anahtar JSON Dosya İçeriği',
                        'info-get-private-key'            => 'Bilgi: FCM Özel Anahtar JSON Dosya İçeriğini Almak İçin: <a href="https://console.firebase.google.com/" target="_blank">Buraya Tıklayın</a>',
                    ],
                ],
            ],
        ],

        'settings' => [
            'notification' => [
                'index' => [
                    'title'               => 'Notification Push',
                    'add-title'           => 'Ajouter une notification',
                    'delete-success'      => 'Notification supprimée avec succès',
                    'mass-update-success' => 'Notifications sélectionnées mises à jour avec succès',
                    'mass-delete-success' => 'Notifications sélectionnées supprimées avec succès',

                    'datagrid' => [
                        'id'                   => 'ID',
                        'image'                => 'Image',
                        'text-title'           => 'Titre',
                        'notification-content' => 'Contenu de la notification',
                        'notification-type'    => 'Type de notification',
                        'store-view'           => 'Chaînes',
                        'notification-status'  => 'Statut de la notification',
                        'created-at'           => 'Créé le',
                        'updated-at'           => 'Mis à jour le',
                        'delete'               => 'Supprimer',
                        'update'               => 'Mettre à jour',

                        'status' => [
                            'enabled'  => 'Activé',
                            'disabled' => 'Désactivé',
                        ],
                    ],
                ],

                'create' => [
                    'new-notification'     => 'Nouvelle notification',
                    'back-btn'             => 'Retour',
                    'create-btn-title'     => 'Enregistrer la notification',
                    'general'              => 'Général',
                    'title'                => 'Notification Push',
                    'content-and-image'    => 'Contenu et image de la notification',
                    'notification-content' => 'Contenu de la notification',
                    'image'                => 'Image',
                    'settings'             => 'Paramètres',
                    'status'               => 'Statut',
                    'store-view'           => 'Chaînes',
                    'notification-type'    => 'Type de notification',
                    'product-cat-id'       => 'ID Produit/Catégorie',
                    'success'              => 'Notification créée avec succès',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Produit',
                        'category' => 'Catégorie',
                    ],
                ],

                'edit' => [
                    'edit-notification'         => 'Modifier la notification',
                    'back-btn'                  => 'Retour',
                    'send-title'                => 'Envoyer la notification',
                    'update-btn-title'          => 'Mettre à jour la notification',
                    'general'                   => 'Général',
                    'title'                     => 'Notification Push',
                    'content-and-image'         => 'Contenu et image de la notification',
                    'notification-content'      => 'Contenu de la notification',
                    'image'                     => 'Image',
                    'settings'                  => 'Paramètres',
                    'status'                    => 'Statut',
                    'store-view'                => 'Chaînes',
                    'notification-type'         => 'Type de notification',
                    'product-cat-id'            => 'ID Produit/Catégorie',
                    'success'                   => 'Notification mise à jour avec succès',
                    'notification-send-success' => 'Notification envoyée avec succès pour Android et iOS.',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Produit',
                        'category' => 'Catégorie',
                    ],
                ],
            ],

            'exchange_rates' => [
                'error-invalid-target-currency' => 'Avertissement : Devise cible invalide fournie.',
                'delete-success'                => 'Succès : Taux de change supprimé avec succès.',
            ],
        ],

        'customer' => [
            'no-customer-found' => 'Aucun client trouvé',
        ],

        'response'      => [
            'delete-success'          => 'Éxito: Usuario eliminado correctamente.',
            'last-delete-error'       => 'Advertencia: Se requiere al menos un usuario.',
            'delete-failed'           => 'Advertencia: El usuario administrador no se ha eliminado.',
            'error.invalid-parameter' => 'Advertencia: Parámetros inválidos proporcionados.',
            'success-login'           => 'Éxito: Inicio de sesión de usuario exitoso.',
            'error-login'             => 'Advertencia: El usuario administrador no ha iniciado sesión.',
            'session-expired'         => 'Advertencia: La sesión ha expirado. Por favor, vuelve a iniciar sesión en tu cuenta.',
            'invalid-header'          => 'Advertencia: Token de encabezado inválido.',
            'success-logout'          => 'Éxito: Cierre de sesión de usuario exitoso.',
            'no-login-user'           => 'Advertencia: No se encontró ningún usuario conectado.',
            'error-customer-group'    => 'Advertencia: No tienes autorización para eliminar el grupo de atributos creado por el sistema.',
            'password-invalid'        => 'Advertencia: Por favor, introduce la contraseña correcta.',
            'password-match'          => 'Advertencia: Las contraseñas no coinciden.',
            'success-registered'      => 'Éxito: Usuario creado correctamente.',
            'cancel-error'            => 'No se puede cancelar el pedido.',
            'creation-error'          => 'No se puede crear el reembolso para este pedido.',
            'channel-failure'         => 'Canal no encontrado.',
            'script-delete-success'   => 'Script eliminado correctamente.',
        ],

        'shop'          => [
            'response' => [
                'no-address-found'         => 'Advertencia: No se encontró ninguna dirección.',
                'invalid-address'          => 'Advertencia: No se encontró ninguna dirección para el ID de dirección proporcionado.',
                'invalid-product'          => 'Advertencia: Estás solicitando un producto no válido.',
                'already-exist-inwishlist' => 'Información: Este producto ya existe en la lista de deseos.',
                'un-authorized-access'     => 'Advertencia: No tienes autorización para usar esta sección.',
            ],
        ],

        'validation'    => [
            'unique'   => 'Este :field ya ha sido tomado.',
            'required' => 'El campo :field es obligatorio.',
            'same'     => 'El campo :field y la contraseña deben coincidir.',
        ],

        'mail'          => [
            'customer' => [
                'password' => [
                    'heading' => config('app.name').' - Restablecimiento de contraseña',
                    'reset'   => 'Correo electrónico de restablecimiento de contraseña',
                    'summary' => 'Este correo electrónico está relacionado con el restablecimiento de la contraseña de tu cuenta. Tu contraseña se ha cambiado correctamente.
                    Inicia sesión en tu cuenta utilizando la contraseña mencionada a continuación.',
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => 'Éxito: Dirección del carrito guardada correctamente.',
            'error-payment-selection'   => 'Advertencia: Hay un error al obtener los métodos de pago.',
            'selected-shipment'         => 'Éxito: Envío seleccionado correctamente.',
            'warning-empty-cart'        => 'Advertencia: No hay ningún producto agregado al carrito.',
            'billing-address-missing'   => 'Advertencia: Falta la dirección de facturación para finalizar la compra.',
            'shipping-address-missing'  => 'Advertencia: Falta la dirección de envío para finalizar la compra.',
            'invalid-guest-access'      => 'Advertencia: Los clientes invitados no pueden obtener direcciones con el identificador de dirección de facturación/envío.',
            'guest-address-warning'     => 'Advertencia: Si estás intentando como invitado, intenta sin el token de autorización.',
            'wrong-error'               => 'Advertencia: Hay un error con tu carrito, inténtalo de nuevo.',
            'no-billing-address-found'  => 'Advertencia: No se encontró ningún registro de dirección de facturación con el ID de facturación :address_id.',
            'no-shipping-address-found' => 'Advertencia: No se encontró ningún registro de dirección de envío con el ID de envío :address_id.',
            'error.invalid-parameter'   => 'Advertencia: Se han proporcionado parámetros inválidos.',
            'already-applied'           => 'El código de cupón ya ha sido aplicado.',
            'success-apply'             => 'Código de cupón aplicado correctamente.',
            'coupon-removed'            => 'Éxito: cupón eliminado del carrito correctamente.',
            'coupon-remove-failed'      => 'Advertencia: hay algunos errores al eliminar el cupón del carrito o no se encontró el cupón.',
            'error-placing-order'       => 'Advertencia: Hay un error al realizar el pedido.',
            'selected-payment'          => 'Éxito: Método de pago seleccionado correctamente.',
            'error-payment-save'        => 'Advertencia: Hay un error al guardar el método de pago.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'Todos los artículos se han eliminado correctamente del carrito.',
                    'fail-all-remove'          => 'Error al eliminar los artículos del carrito.',
                    'error.invalid-parameter'  => 'Advertencia: Se han proporcionado parámetros inválidos.',
                    'success-moved-cart-item'  => 'Éxito: El artículo del carrito se ha movido a la lista de deseos correctamente.',
                    'fail-moved-cart-item'     => 'Error: El artículo del carrito no se ha movido a la lista de deseos.',
                    'success-add-to-cart'      => 'Éxito: Producto agregado al carrito correctamente.',
                    'fail-add-to-cart'         => 'Error: El producto no se ha agregado al carrito.',
                    'success-update-to-cart'   => 'Éxito: El artículo del carrito se ha actualizado correctamente.',
                    'fail-update-to-cart'      => 'Error: El artículo del carrito no se ha actualizado.',
                    'success-delete-cart-item' => 'Éxito: El artículo del carrito se ha eliminado correctamente.',
                    'fail-delete-cart-item'    => 'Error: No se ha encontrado el artículo del carrito.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'Éxito: Inicio de sesión del cliente exitoso.',
            'success-logout'        => 'Éxito: Cierre de sesión del cliente exitoso.',
            'no-login-customer'     => 'Advertencia: No se encontró ningún cliente conectado.',
            'address-list'          => 'Éxito: Detalles de direcciones del cliente obtenidos.',
            'not-authorized'        => 'Advertencia: No estás autorizado para actualizar esta dirección.',
            'no-address-list'       => 'Advertencia: No se encontraron direcciones de cliente.',
            'text-password'         => 'Tu contraseña es: :password',
            'not-exists'            => 'Advertencia: No se encontró ningún cliente para los datos proporcionados.',
            'success-address-list'  => 'Éxito: Direcciones del cliente obtenidas con éxito.',
            'reset-link-sent'       => 'Éxito: El correo electrónico de restablecimiento de contraseña se ha enviado correctamente.',
            'password-reset-failed' => 'Advertencia: Ya te enviamos un correo electrónico de restablecimiento de contraseña, intenta nuevamente más tarde.',
            'no-login-user'         => 'Advertencia: No se encontró ningún usuario conectado.',
            'customer-details'      => 'Éxito: Detalles del cliente obtenidos correctamente.',

            'account'               => [
                'not-found' => 'Advertencia: No se encontró ningún :name.',

                'profile'   => [
                    'edit-success'   => 'Perfil actualizado exitosamente',
                    'edit-fail'      => 'Perfil no actualizado',
                    'unmatch'        => 'La contraseña antigua no coincide.',
                    'order-pending'  => 'No se puede eliminar la cuenta del cliente porque hay uno o varios pedidos pendientes o en proceso.',
                    'delete-success' => 'Cliente eliminado exitosamente',
                    'wrong-password' => '¡Contraseña incorrecta!',
                ],

                'order' => [
                    'no-order-found' => 'Advertencia: No se encontraron pedidos.',
                    'cancel-success' => 'Pedido cancelado exitosamente',
                ],

                'review'    => [
                    'success' => 'Éxito: La reseña se envió correctamente, por favor espera la aprobación.',
                ],

                'wishlist' => [
                    'removed'            => 'Elemento eliminado correctamente de la lista de deseos',
                    'remove-fail'        => 'El elemento no se puede eliminar de la lista de deseos',
                    'remove-all-success' => 'Todos los elementos de tu lista de deseos se han eliminado',
                    'success'            => 'Elemento agregado correctamente a la lista de deseos',
                    'already-exist'      => 'El producto ya existe en la lista de deseos',
                    'move-to-cart'       => 'Mover al carrito',
                    'moved-success'      => 'Elemento movido correctamente al carrito',
                    'error-move-to-cart' => 'Advertencia: Este producto puede tener algunas opciones requeridas, no se puede mover al carrito.',
                    'no-item-found'      => 'Advertencia: No se encontró ningún producto.',
                ],

                'addresses' => [
                    'delete-success' => 'Dirección del cliente eliminada correctamente',
                ],
            ],

            'signup-form' => [
                'error-registration'       => 'Advertencia: falló el registro del cliente.',
                'warning-num-already-used' => 'Advertencia: Este :phone número está registrado con una dirección de correo electrónico diferente.',
                'success-verify'           => 'Cuenta creada con éxito, se ha enviado un correo electrónico para verificación.',
                'invalid-creds'            => 'Por favor, verifica tus credenciales e intenta nuevamente.',

                'validation' => [
                    'unique'   => 'Este :field ya ha sido tomado.',
                    'required' => 'El campo :field es obligatorio.',
                    'same'     => 'El campo :field y la contraseña deben coincidir.',
                ],
            ],

            'login-form' => [
                'not-activated' => 'Tu activación requiere la aprobación del administrador',
                'invalid-creds' => 'Por favor, verifica tus credenciales e intenta nuevamente.',
            ],
        ],

        'response' => [
            'error.invalid-parameter' => 'Advertencia: Se han proporcionado parámetros no válidos.',
            'invalid-header'          => 'Advertencia: Token de encabezado inválido.',
            'cancel-error'            => 'No se puede cancelar el pedido.',
        ],
    ],
];
