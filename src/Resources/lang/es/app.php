<?php

return [
    'admin' => [
        'menu' => [
            'push-notification' => 'Notificación Push',
        ],

        'acl' => [
            'push-notification' => 'Notificación Push',
            'send'              => 'Enviar',
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Tema de Notificación',
                        'info'                            => 'Configuraciones relacionadas con la notificación',
                        'push-notification-configuration' => 'Configuración de Notificaciones Push FCM',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Contenido del Archivo JSON de la Clave Privada',
                        'info-get-private-key'            => 'Información: Para Obtener el Contenido del Archivo JSON de la Clave Privada de FCM: <a href="https://console.firebase.google.com/" target="_blank">Haz clic aquí</a>',
                    ],
                ],
            ],
        ],

        'settings' => [
            'notification' => [
                'index' => [
                    'title'               => 'Notificación Push',
                    'add-title'           => 'Agregar Notificación',
                    'delete-success'      => 'Notificación eliminada exitosamente',
                    'mass-update-success' => 'Notificaciones seleccionadas actualizadas exitosamente',
                    'mass-delete-success' => 'Notificaciones seleccionadas eliminadas exitosamente',

                    'datagrid' => [
                        'id'                   => 'Id',
                        'image'                => 'Imagen',
                        'text-title'           => 'Título',
                        'notification-content' => 'Contenido de la Notificación',
                        'notification-type'    => 'Tipo de Notificación',
                        'store-view'           => 'Canales',
                        'notification-status'  => 'Estado de la Notificación',
                        'created-at'           => 'Tiempo de Creación',
                        'updated-at'           => 'Tiempo de Actualización',
                        'delete'               => 'Eliminar',
                        'update'               => 'Actualizar',

                        'status' => [
                            'enabled'  => 'Habilitado',
                            'disabled' => 'Deshabilitado',
                        ],
                    ],
                ],

                'create' => [
                    'new-notification'     => 'Nueva Notificación',
                    'back-btn'             => 'Atrás',
                    'create-btn-title'     => 'Guardar Notificación',
                    'general'              => 'General',
                    'title'                => 'Notificación Push',
                    'content-and-image'    => 'Contenido e Imagen de la Notificación',
                    'notification-content' => 'Contenido de la Notificación',
                    'image'                => 'Imagen',
                    'settings'             => 'Configuraciones',
                    'status'               => 'Estado',
                    'store-view'           => 'Canales',
                    'notification-type'    => 'Tipo de Notificación',
                    'product-cat-id'       => 'ID de Producto/Categoría',
                    'success'              => 'Notificación creada exitosamente',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Producto',
                        'category' => 'Categoría',
                    ],
                ],

                'edit' => [
                    'edit-notification'         => 'Editar Notificación',
                    'back-btn'                  => 'Atrás',
                    'send-title'                => 'Enviar Notificación',
                    'update-btn-title'          => 'Actualizar Notificación',
                    'general'                   => 'General',
                    'title'                     => 'Notificación Push',
                    'content-and-image'         => 'Contenido e Imagen de la Notificación',
                    'notification-content'      => 'Contenido de la Notificación',
                    'image'                     => 'Imagen',
                    'settings'                  => 'Configuraciones',
                    'status'                    => 'Estado',
                    'store-view'                => 'Canales',
                    'notification-type'         => 'Tipo de Notificación',
                    'product-cat-id'            => 'ID de Producto/Categoría',
                    'success'                   => 'Notificación actualizada exitosamente',
                    'notification-send-success' => 'Notificación enviada exitosamente para Android e iOS.',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Producto',
                        'category' => 'Categoría',
                    ],
                ],
            ],

            'exchange_rates' => [
                'error-invalid-target-currency' => 'Advertencia: Se proporcionó una moneda de destino no válida.',
                'delete-success'                => 'Éxito: Tipo de cambio eliminado correctamente.',
            ],
        ],

        'customer' => [
            'no-customer-found' => 'No se encontró ningún cliente',
        ],

        'response' => [
            'delete-success'          => 'Éxito: Usuario eliminado correctamente.',
            'last-delete-error'       => 'Advertencia: Se requiere al menos un usuario',
            'delete-failed'           => 'Advertencia: No se eliminó el usuario administrador',
            'error.invalid-parameter' => 'Advertencia: Se proporcionaron parámetros no válidos.',
            'success-login'           => 'Éxito: Usuario conectado exitosamente.',
            'error-login'             => 'Advertencia: El usuario administrador no ha iniciado sesión.',
            'session-expired'         => 'Advertencia: La sesión ha expirado. Por favor, vuelve a iniciar sesión en tu cuenta.',
            'invalid-header'          => 'Advertencia: Token de encabezado no válido.',
            'success-logout'          => 'Éxito: Usuario desconectado exitosamente.',
            'no-login-user'           => 'Advertencia: No se encontró usuario conectado.',
            'error-customer-group'    => 'Advertencia: No estás autorizado para eliminar el grupo de atributos creado por el sistema.',
            'password-invalid'        => 'Advertencia: Por favor, introduce la contraseña correcta.',
            'password-match'          => 'Advertencia: Las contraseñas no coinciden.',
            'success-registered'      => 'Éxito: Usuario creado exitosamente.',
            'cancel-error'            => 'No se puede cancelar el pedido.',
            'creation-error'          => 'No se puede crear un reembolso para este pedido.',
            'channel-failure'         => 'Canal no encontrado.',
            'script-delete-success'   => 'Script eliminado exitosamente.',
        ],

        'shop' => [
            'response' => [
                'no-address-found'         => 'Advertencia: No se encontró ninguna dirección.',
                'invalid-address'          => 'Advertencia: No se encontró ninguna dirección para el ID de dirección proporcionado.',
                'invalid-product'          => 'Advertencia: Estás solicitando un producto no válido.',
                'already-exist-inwishlist' => 'Información: Este producto ya existe en la lista de deseos.',
                'un-authorized-access'     => 'Advertencia: No estás autorizado para usar esta sección.',
            ],
        ],

        'validation' => [
            'unique'   => 'Este :field ya ha sido tomado.',
            'required' => 'El campo :field es obligatorio.',
            'same'     => 'El campo :field y la contraseña deben coincidir.',
        ],

        'mail' => [
            'customer' => [
                'password' => [
                    'heading' => config('app.name').' - Restablecimiento de contraseña',
                    'reset'   => 'Correo electrónico de restablecimiento de contraseña',
                    'summary' => 'Este correo electrónico está relacionado con el restablecimiento de la contraseña de tu cuenta. Tu contraseña se ha cambiado correctamente.
                    Por favor, inicia sesión en tu cuenta utilizando la contraseña mencionada a continuación.',
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => 'Éxito: Dirección del carrito guardada correctamente.',
            'error-payment-selection'   => 'Advertencia: Hay un error al obtener los métodos de pago.',
            'selected-shipment'         => 'Éxito: Envío seleccionado correctamente.',
            'warning-empty-cart'        => 'Advertencia: No hay productos agregados al carrito.',
            'billing-address-missing'   => 'Advertencia: Falta la dirección de facturación para el checkout.',
            'shipping-address-missing'  => 'Advertencia: Falta la dirección de envío para el checkout.',
            'invalid-guest-access'      => 'Advertencia: Los clientes invitados no pueden obtener direcciones con la ayuda del ID de dirección de facturación/envío.',
            'guest-address-warning'     => 'Advertencia: Si estás intentando como invitado, intenta sin un token de autorización.',
            'wrong-error'               => 'Advertencia: Hay un error en tu carrito, inténtalo de nuevo.',
            'no-billing-address-found'  => 'Advertencia: No se encontró registro de dirección de facturación con ID de facturación :address_id.',
            'no-shipping-address-found' => 'Advertencia: No se encontró registro de dirección de envío con ID de envío :address_id.',
            'error.invalid-parameter'   => 'Advertencia: Se han proporcionado parámetros inválidos.',
            'already-applied'           => 'El código de cupón ya ha sido aplicado.',
            'success-apply'             => 'Código de cupón aplicado correctamente.',
            'coupon-removed'            => 'Éxito: cupón eliminado del carrito con éxito.',
            'coupon-remove-failed'      => 'Advertencia: hay algunos errores al eliminar el cupón del carrito o el cupón no se encontró.',
            'error-placing-order'       => 'Advertencia: Hay un error al realizar el pedido.',
            'selected-payment'          => 'Éxito: Método de pago seleccionado correctamente.',
            'error-payment-save'        => 'Advertencia: Hay un error al guardar el método de pago.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'Todos los artículos se han eliminado correctamente del carrito.',
                    'fail-all-remove'          => 'Error al eliminar artículos del carrito.',
                    'error.invalid-parameter'  => 'Advertencia: Se han proporcionado parámetros inválidos.',
                    'success-moved-cart-item'  => 'Éxito: Artículo del carrito movido a la lista de deseos correctamente.',
                    'fail-moved-cart-item'     => 'Error: El artículo del carrito no se ha movido a la lista de deseos.',
                    'success-add-to-cart'      => 'Éxito: Producto agregado al carrito correctamente.',
                    'fail-add-to-cart'         => 'Error: El producto no se ha agregado al carrito.',
                    'success-update-to-cart'   => 'Éxito: El artículo del carrito se ha actualizado correctamente.',
                    'fail-update-to-cart'      => 'Error: El artículo del carrito no se ha actualizado.',
                    'success-delete-cart-item' => 'Éxito: El artículo del carrito se ha eliminado correctamente.',
                    'fail-delete-cart-item'    => 'Error: No se encontró el artículo del carrito.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'Éxito: Inicio de sesión del cliente exitoso.',
            'success-logout'        => 'Éxito: Cierre de sesión del cliente exitoso.',
            'no-login-customer'     => 'Advertencia: No se encontró ningún cliente logueado.',
            'address-list'          => 'Éxito: Detalles de direcciones del cliente obtenidos.',
            'not-authorized'        => 'Advertencia: No estás autorizado para actualizar esta dirección.',
            'no-address-list'       => 'Advertencia: No se encontraron direcciones del cliente.',
            'text-password'         => 'Tu contraseña es: :password',
            'not-exists'            => 'Advertencia: No se encontró ningún cliente con los datos proporcionados.',
            'success-address-list'  => 'Éxito: Direcciones del cliente obtenidas exitosamente.',
            'reset-link-sent'       => 'Éxito: Se ha enviado el correo electrónico de restablecimiento de contraseña correctamente.',
            'password-reset-failed' => 'Advertencia: Ya te enviamos un correo electrónico para restablecer la contraseña, intenta nuevamente después de un tiempo.',
            'no-login-user'         => 'Advertencia: No se encontró ningún usuario logueado.',
            'customer-details'      => 'Éxito: Detalles del cliente obtenidos exitosamente.',

            'account' => [
                'not-found' => 'Advertencia: No se encontró ningún :name.',

                'profile' => [
                    'edit-success'   => 'Perfil actualizado exitosamente',
                    'edit-fail'      => 'Perfil no actualizado',
                    'unmatch'        => 'La contraseña anterior no coincide.',
                    'order-pending'  => 'No se puede eliminar la cuenta del cliente porque hay Pedido(s) pendiente(s) o en estado de procesamiento.',
                    'delete-success' => 'Cliente eliminado exitosamente',
                    'wrong-password' => '¡Contraseña incorrecta!',
                ],

                'order' => [
                    'no-order-found' => 'Advertencia: No se encontraron pedidos.',
                    'cancel-success' => 'Pedido cancelado exitosamente',
                ],

                'review' => [
                    'success' => 'Éxito: La reseña se ha enviado correctamente, espera la aprobación.',
                ],

                'wishlist' => [
                    'removed'            => 'Artículo eliminado con éxito de la lista de deseos',
                    'remove-fail'        => 'No se pudo quitar el artículo de la lista de deseos',
                    'remove-all-success' => 'Se han eliminado todos los artículos de tu lista de deseos',
                    'success'            => 'Artículo agregado con éxito a la lista de deseos',
                    'already-exist'      => 'El producto ya existe en la lista de deseos',
                    'move-to-cart'       => 'Mover al carrito',
                    'moved-success'      => 'Artículo movido con éxito al carrito',
                    'error-move-to-cart' => 'Advertencia: Este producto puede tener algunas opciones requeridas, no se puede mover al carrito.',
                    'no-item-found'      => 'Advertencia: No se encontraron productos.',
                ],

                'addresses' => [
                    'delete-success' => 'Dirección del cliente eliminada exitosamente',
                ],
            ],

            'signup-form' => [
                'error-registration'       => 'Advertencia: Falló el registro del cliente.',
                'warning-num-already-used' => 'Advertencia: Este :phone número ya está registrado con una dirección de correo electrónico diferente.',
                'success-verify'           => 'Cuenta creada exitosamente, se ha enviado un correo electrónico para verificación.',
                'invalid-creds'            => 'Por favor verifica tus credenciales e inténtalo de nuevo.',

                'validation' => [
                    'unique'   => 'Este :field ya ha sido tomado.',
                    'required' => 'El campo :field es obligatorio.',
                    'same'     => 'El campo :field y la contraseña deben coincidir.',
                ],
            ],

            'login-form' => [
                'not-activated' => 'Tu activación requiere aprobación del administrador',
                'invalid-creds' => 'Por favor verifica tus credenciales e inténtalo de nuevo.',
            ],
        ],

        'response' => [
            'error.invalid-parameter' => 'Advertencia: Se han proporcionado parámetros inválidos.',
            'invalid-header'          => 'Advertencia: Token de encabezado inválido.',
            'cancel-error'            => 'No se puede cancelar el pedido.',
        ],
    ],
];
