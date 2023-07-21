<?php

return [
    'admin'     => [
        'menu'  => [
            'push-notification' => 'Notificación Push',
        ],

        'acl'  => [
            'push-notification' => 'Notificación Push',
            'send'              => 'Enviar',
        ],

        'system' => [
            'graphql-api'                       => 'API GraphQL',
            'push-notification-configuration'   => 'Configuración de notificación Push FCM',
            'server-key'                        => 'Clave del servidor',
            'info-get-server-key'               => 'Info: Para obtener las credenciales de API de FCM: <a href="https://console.firebase.google.com/" target="_blank">Haz clic aquí</a>',
            'android-topic'                     => 'Tema de Android',
            'ios-topic'                         => 'Tema de iOS',
        ],

        'notification'  => [
            'title'                 => 'Notificación Push',
            'add-title'             => 'Agregar notificación',
            'general'               => 'General',

            'id'                    => 'Id',
            'image'                 => 'Imagen',
            'text-title'            => 'Título',
            'edit-notification'     => 'Editar notificación',
            'manage'                => 'Notificaciones',
            'new-notification'      => 'Nueva notificación',
            'create-btn-title'      => 'Guardar notificación',
            'notification-image'    => 'Imagen de notificación',
            'notification-title'    => 'Título de la notificación',
            'notification-content'  => 'Contenido de la notificación',
            'notification-type'     => 'Tipo de notificación',
            'product-cat-id'        => 'ID de producto/categoría',
            'store-view'            => 'Canales',
            'notification-status'   => 'Estado de la notificación',
            'created'               => 'Creado',
            'modified'              => 'Modificado',
            'collection-autocomplete'   => 'Colección personalizada - (Autocompletar)',
            'no-collection-found'       => 'Colecciones no encontradas con el mismo nombre.',
            'collection-search-hint'    => 'Comienza a escribir el nombre de la colección',
            
            'Action'    => [
                'edit'      => 'Editar',
            ],

            'status'    => [
                'enabled'   => 'Habilitado',
                'disabled'  => 'Deshabilitado',
            ],

            'notification-type-option'  => [
                'select'            => '-- Seleccionar --',
                'simple'            => 'Tipo simple',
                'product'           => 'Basado en producto',
                'category'          => 'Basado en categoría',
            ],
        ],

        'alert' => [
            'create-success'        => ':name creado exitosamente',
            'update-success'        => ':name actualizado exitosamente',
            'delete-success'        => ':name eliminado exitosamente',
            'delete-failed'         => 'Error al eliminar :name',
            'sended-successfully'   => ':name enviado con éxito para Android e iOS.',
            'no-value-selected'     => 'no hay valor existente',
        ],

        'settings'   => [
            'exchange_rates' => [
                'error-invalid-target-currency' => 'Advertencia: Se proporcionó una moneda objetivo inválida.',
                'delete-success'        => 'Éxito: Tasa de cambio eliminada exitosamente.',
            ]
        ],
        
        'response'  => [
            'error-invalid-parameter'   => 'Advertencia: Se proporcionaron parámetros inválidos.',
            'success-login'             => 'Éxito: Inicio de sesión de usuario exitoso.',
            'error-login'               => 'Advertencia: El usuario administrador no ha iniciado sesión.',
            'session-expired'           => 'Advertencia: La sesión ha expirado. Por favor, inicie sesión nuevamente en su cuenta.',
            'invalid-header'            => 'Advertencia: Token de encabezado no válido.',
            'success-logout'            => 'Éxito: Cierre de sesión de usuario exitoso.',
            'no-login-user'             => 'Advertencia: No se encontró usuario conectado.',
            'error-customer-group'      => 'Advertencia: No está autorizado para eliminar el grupo de atributos creado por el sistema.',
            'password-invalid'          => 'Advertencia: Por favor, ingrese la contraseña correcta.',
            'password-match'            => 'Advertencia: La contraseña no coincide.',
            'success-registered'        => 'Éxito: Usuario creado exitosamente.',
            'cancel-error'              => 'No se puede cancelar la orden.',
            'creation-error'            => 'No se puede crear el reembolso para esta orden.',
            'channel-failure'           => 'Canal no encontrado.',
            'script-delete-success'     => 'Script eliminado exitosamente.'
        ]
    ],

    'shop'  => [
        'customer'  => [
            'success-login'         => 'Éxito: Cliente conectado exitosamente.',
            'success-logout'        => 'Éxito: Cliente desconectado exitosamente.',
            'no-login-customer'     => 'Advertencia: No se encontró cliente conectado.',
            'address-list'          => 'Éxito: Detalles de la dirección del cliente obtenidos',
            'not-authorized'        => 'Advertencia: No está autorizado para actualizar esta dirección.',
            'success-address-list'  => 'Éxito: Direcciones del cliente obtenidas exitosamente.',
            'no-address-list'       => 'Advertencia: No se encontró ninguna dirección de cliente.',
            'text-password'         => 'Tu contraseña es: :password',
            'not-exists'            => 'Advertencia: No se encontró ningún cliente para los datos proporcionados.',
        ],
        'response'  => [
            'error-registration'        => 'Advertencia: Registro de cliente fallido.',
            'password-reset-failed'     => 'Advertencia: Ya le hemos enviado un correo electrónico para restablecer la contraseña, intente después de un tiempo.',
            'customer-details'          => 'Éxito: Detalles del cliente obtenidos exitosamente.',
            'not-found'                 => 'Advertencia: No se encontró :name.',
            'no-address-found'          => 'Advertencia: No se encontró ninguna dirección.',
            'no-order-found'            => 'Advertencia: No se encontró ninguna orden.',
            'warning-empty-cart'        => 'Advertencia: No hay productos agregados al carrito.',
            'success-add-to-cart'       => 'Éxito: Producto agregado al carrito exitosamente.',
            'success-update-to-cart'    => 'Éxito: El artículo del carrito se ha actualizado exitosamente.',
            'success-delete-cart-item'  => 'Éxito: El artículo del carrito se ha eliminado exitosamente.',
            'success-moved-cart-item'   => 'Éxito: El artículo del carrito se ha movido exitosamente a la lista de deseos.',
            'billing-address-missing'   => 'Advertencia: Falta la dirección de facturación para realizar el pago.',
            'shipping-address-missing'  => 'Advertencia: Falta la dirección de envío para realizar el pago.',
            'invalid-address'           => 'Advertencia: No se encontró ninguna dirección para la direcciónId proporcionada.',
            'wrong-error'               => 'Advertencia: Hay un error en su carrito, inténtelo de nuevo.',
            'save-cart-address'         => 'Éxito: Dirección del carrito guardada exitosamente.',
            'error-payment-selection'   => 'Advertencia: Hay un error al obtener los métodos de pago.',
            'selected-shipment'         => 'Éxito: Seleccionado el envío exitosamente.',
            'error-payment-save'        => 'Advertencia: Hay un error al guardar el método de pago.',
            'selected-payment'          => 'Éxito: Método de pago seleccionado exitosamente.',
            'error-placing-order'       => 'Advertencia: Hay un error al realizar el pedido.',
            'invalid-product'           => 'Advertencia: Está solicitando un producto no válido.',
            'already-exist-inwishlist'  => 'Información: Este producto ya existe en la lista de deseos.',
            'error-move-to-cart'        => 'Advertencia: Este producto puede tener algunas opciones requeridas, no se puede mover al carrito.',
            'no-billing-address-found'  => 'Advertencia: No se encontró ningún registro de dirección de facturación con el id de facturación :address_id.',
            'no-shipping-address-found'  => 'Advertencia: No se encontró ningún registro de dirección de envío con el id de envío :address_id.',
            'invalid-guest-access'      => 'Advertencia: Los clientes invitados no pueden obtener direcciones con la ayuda del id de dirección de facturación / envío.',
            'guest-address-warning'     => 'Advertencia: Si está intentando como invitado, intente sin token de autorización.',
            'warning-num-already-used'  => 'Advertencia: Este número de :phone está registrado con una dirección de correo electrónico diferente.',
            'coupon-removed'            => 'Éxito: cupón eliminado del carrito con éxito.',
            'coupon-remove-failed'      => 'Advertencia: hay algunos errores al eliminar el cupón del carrito o el cupón no se encontró.',
            'review-create-success'     => 'Éxito: La reseña se envió correctamente, espere la aprobación.',
        ]
    ],
    
    'validation' => [
        'unique'    => 'Este :field ya ha sido tomado.',
        'required'  => 'El campo :field es obligatorio.',
        'same'      => 'El campo :field y la contraseña deben coincidir.'
    ],
    
    'mail' => [
        'customer'  => [
            'password' => [
                'heading'   => config('app.name') . ' - Restablecimiento de contraseña',
                'reset'     => 'Correo electrónico de restablecimiento de contraseña',
                'summary' => 'Este correo electrónico está relacionado con el restablecimiento de contraseña de su cuenta. Su contraseña ha sido cambiada con éxito.
                Inicie sesión en su cuenta utilizando la contraseña mencionada a continuación.',
            ]
        ]
    ]
];