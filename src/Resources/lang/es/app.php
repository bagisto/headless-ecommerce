<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Ya estás suscrito a nuestro boletín.',
            'subscribe-success'  => 'Te has suscrito con éxito a nuestro boletín.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Gracias por contactar con nosotros. Nos pondremos en contacto contigo pronto.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Advertencia: Enlace de descarga no encontrado.',
                'sample-not-found' => 'Advertencia: Muestra descargable no encontrada.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Advertencia: No se encontró ningún cliente registrado.',
            'success-login'     => 'Éxito: Sesión de cliente iniciada correctamente.',
            'success-logout'    => 'Éxito: Sesión de cliente cerrada correctamente.',

            'signup' => [
                'error-registration' => 'Advertencia: Error al registrar el cliente.',
                'success-verify'     => 'Cuenta creada correctamente, se ha enviado un correo electrónico para su verificación.',
                'success'            => 'Éxito: Cliente registrado e iniciado sesión correctamente.',
            ],

            'social-login' => [
                'disabled' => 'Advertencia: El inicio de sesión social está deshabilitado.',
            ],

            'login' => [
                'invalid-creds' => 'Por favor verifica tus credenciales e intenta nuevamente.',
                'not-activated' => 'Tu activación requiere la aprobación del administrador',
                'verify-first'  => 'Por favor verifica tu correo electrónico primero.',
                'suspended'     => 'Tu cuenta ha sido suspendida por el administrador.',

                'validation' => [
                    'required' => 'El campo :field es obligatorio.',
                    'same'     => 'El campo :field y la contraseña deben coincidir.',
                    'unique'   => 'Este :field ya ha sido tomado.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'El enlace para restablecer la contraseña ya se ha enviado a tu correo electrónico.',
                'email-not-exist' => 'El correo electrónico no existe.',
                'reset-link-sent' => 'Enlace para restablecer la contraseña enviado a tu correo electrónico.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Éxito: Detalles del cliente obtenidos con éxito.',
                    'delete-success'   => 'Éxito: Cuenta eliminada con éxito.',
                    'password-unmatch' => 'La contraseña no coincide.',
                    'update-fail'      => 'Advertencia: Perfil no actualizado.',
                    'update-success'   => 'Éxito: Perfil actualizado con éxito.',
                    'wrong-password'   => 'Advertencia: Contraseña incorrecta proporcionada.',
                    'order-pending'    => 'No puede eliminar la cuenta porque tiene algunos pedidos pendientes.',
                ],

                'addresses' => [
                    'create-success'         => 'Dirección creada correctamente.',
                    'default-update-success' => 'La dirección se ha establecido como predeterminada',
                    'delete-success'         => 'Dirección eliminada correctamente',
                    'not-found'              => 'Advertencia: No se encontró la dirección.',
                    'update-success'         => 'Dirección actualizada correctamente.',
                    'already-default'        => 'Advertencia: Esta dirección ya está establecida como predeterminada.',
                ],

                'wishlist' => [
                    'product-removed' => 'Advertencia: Producto no encontrado.',
                    'success'         => 'Éxito: Producto agregado a la lista de deseos correctamente.',
                    'already-exist'   => 'Advertencia: Ya se ha agregado a la lista de deseos.',
                    'remove-success'  => 'Éxito: El artículo se ha eliminado correctamente de la lista de deseos.',
                    'not-found'       => 'Advertencia: No se encontraron productos en la lista de deseos.',
                    'moved-to-cart'   => 'Éxito: Producto movido al carrito correctamente.',
                ],

                'orders' => [
                    'not-found'      => 'Advertencia: No se encontraron pedidos.',
                    'cancel-error'   => 'Advertencia: No se pudo cancelar el pedido.',
                    'cancel-success' => 'Éxito: Pedido cancelado correctamente.',

                    'shipment' => [
                        'not-found' => 'Advertencia: No se encontró el envío.',
                    ],

                    'invoice' => [
                        'not-found' => 'Advertencia: No se encontró la factura.',
                    ],

                    'refund' => [
                        'not-found' => 'Advertencia: No se encontró el reembolso.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Advertencia: No se encontró el producto descargable.',
                    'not-auth'       => 'Advertencia: No estás autorizado para realizar esta acción.',
                    'payment-error'  => 'No se ha realizado el pago de esta descarga.',
                    'download-error' => 'El enlace de descarga ha caducado.',
                ],

                'gdpr' => [
                    'create-success'       => 'Éxito: Solicitud de GDPR creada exitosamente.',
                    'revoke-failed'        => 'Advertencia: No se revocó la solicitud de GDPR.',
                    'revoked-successfully' => 'Éxito: Solicitud de GDPR revocada exitosamente.',
                    'not-enabled'          => 'Advertencia: GDPR no está habilitado.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Advertencia: Producto de comparación no encontrado.',
                'product-not-found'   => 'Advertencia: Producto no encontrado.',
                'already-added'       => 'Advertencia: Producto ya añadido a la lista de comparación.',
                'item-add-success'    => 'Éxito: Producto añadido con éxito a la lista de comparación.',
                'remove-success'      => 'Éxito: Elemento eliminado con éxito de la lista de comparación.',
                'mass-remove-success' => 'Éxito: Elementos seleccionados eliminados con éxito.',
                'not-auth'            => 'Advertencia: No estás autorizado para realizar esta acción.',
            ],

            'reviews' => [
                'create-success'      => 'Éxito: Reseña creada correctamente.',
                'delete-success'      => 'Éxito: Reseña eliminada correctamente.',
                'mass-delete-success' => 'Éxito: Reseñas seleccionadas eliminadas correctamente.',
                'not-found'           => 'Advertencia: No se encontró la reseña.',
                'product-not-found'   => 'Advertencia: Producto no encontrado.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Advertencia: No se pueden generar enlaces de descarga para este producto.',
                        'invalid-parameter'  => 'Advertencia: Parámetros inválidos proporcionados.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Éxito: Producto agregado al carrito correctamente.',
                        'update-to-cart'   => 'Éxito: Producto actualizado en el carrito correctamente.',
                        'delete-cart-item' => 'Éxito: El artículo se ha eliminado correctamente del carrito.',
                        'all-remove'       => 'Éxito: Todos los artículos se han eliminado del carrito.',
                        'move-to-wishlist' => 'Éxito: Los elementos seleccionados se han movido correctamente a la lista de deseos.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Advertencia: No se eliminaron todos los artículos del carrito.',
                        'update-to-cart'   => 'Advertencia: No se pudo actualizar el producto en el carrito.',
                        'delete-cart-item' => 'Advertencia: El artículo no se ha eliminado del carrito.',
                        'not-found'        => 'Advertencia: No se encontró el carrito.',
                        'item-not-found'   => 'Advertencia: No se encontró el artículo.',
                        'move-to-wishlist' => 'Advertencia: No se movieron los elementos seleccionados a la lista de deseos.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Advertencia: Los usuarios invitados no pueden agregar direcciones.',
                'guest-checkout-warning'    => 'Advertencia: Los usuarios invitados no pueden realizar el pago.',
                'no-billing-address-found'  => 'Advertencia: No se encontró ninguna dirección de facturación.',
                'no-shipping-address-found' => 'Advertencia: No se encontró ninguna dirección de envío.',
                'address-save-success'      => 'Éxito: Dirección guardada correctamente.',
            ],

            'shipping' => [
                'method-not-found' => 'Advertencia: No se encontró el método de envío.',
                'method-fetched'   => 'Éxito: Método de envío obtenido correctamente.',
                'save-failed'      => 'Advertencia: No se pudo guardar el método de envío.',
                'save-success'     => 'Éxito: Método de envío guardado correctamente.',
            ],

            'payment' => [
                'method-not-found' => 'Advertencia: No se encontró el método de pago.',
                'method-fetched'   => 'Éxito: Método de pago obtenido correctamente.',
                'save-failed'      => 'Advertencia: No se pudo guardar el método de pago.',
                'save-success'     => 'Éxito: Método de pago guardado correctamente.',
            ],

            'coupon' => [
                'apply-success'   => 'Éxito: Código de cupón aplicado correctamente.',
                'already-applied' => 'Advertencia: Código de cupón ya aplicado.',
                'invalid-code'    => 'Advertencia: Código de cupón no válido.',
                'remove-success'  => 'Éxito: Código de cupón eliminado correctamente.',
                'remove-failed'   => 'Advertencia: No se pudo eliminar el código de cupón.',
            ],

            'something-wrong'          => 'Advertencia: Algo salió mal.',
            'invalid-guest-user'       => 'Advertencia: Usuario invitado no válido.',
            'empty-cart'               => 'Advertencia: El carrito está vacío.',
            'missing-billing-address'  => 'Advertencia: Falta la dirección de facturación.',
            'missing-shipping-address' => 'Advertencia: Falta la dirección de envío.',
            'missing-shipping-method'  => 'Advertencia: Falta el método de envío.',
            'missing-payment-method'   => 'Advertencia: Falta el método de pago.',
            'no-address-found'         => 'Advertencia: No se encontró ninguna dirección de facturación y envío.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Crear',
            'delete'            => 'Eliminar',
            'edit'              => 'Editar',
            'mass-delete'       => 'Eliminar en masa',
            'mass-update'       => 'Actualizar en masa',
            'push-notification' => 'Notificación Push',
            'send'              => 'Enviar',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Notificación Push',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Tema de Notificación',
                        'info'                            => 'Configuraciones relacionadas con las notificaciones',
                        'push-notification-configuration' => 'Configuración de Notificación Push FCM',
                        'title'                           => 'API GraphQL',
                        'private-key'                     => 'Contenido del archivo JSON de clave privada',
                        'info-get-private-key'            => 'Info: Para obtener el contenido del archivo JSON de clave privada FCM: <a href="https://console.firebase.google.com/" target="_blank">Haga clic aquí</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Éxito: Scripts personalizados actualizados con éxito.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Advertencia: No se puede cancelar el pedido.',
                'cancel-success' => 'Éxito: Pedido cancelado correctamente.',
                'not-found'      => 'Advertencia: Pedido no encontrado.',
            ],

            'shipments' => [
                'creation-error'   => 'Advertencia: No se creó el envío.',
                'not-found'        => 'Advertencia: Envío no encontrado.',
                'quantity-invalid' => 'Advertencia: Cantidad no válida proporcionada.',
                'shipment-error'   => 'Advertencia: No se creó el envío.',
                'create-success'   => 'Éxito: Envío creado correctamente.',
            ],

            'invoices' => [
                'creation-error' => 'Advertencia: No se creó la factura.',
                'not-found'      => 'Advertencia: Factura no encontrada.',
                'product-error'  => 'Advertencia: Producto no válido proporcionado.',
                'create-success' => 'Éxito: Factura creada correctamente.',
                'invalid-qty'    => 'Advertencia: Encontramos una cantidad no válida para facturar artículos.',
            ],

            'refunds' => [
                'creation-error'      => 'Advertencia: No se creó el reembolso.',
                'refund-amount-error' => 'Advertencia: Cantidad de reembolso no válida proporcionada.',
                'refund-limit-error'  => 'Advertencia: La cantidad de reembolso supera el límite de :amount',
                'not-found'           => 'Advertencia: Reembolso no encontrado.',
                'create-success'      => 'Éxito: Reembolso creado correctamente.',
            ],

            'transactions' => [
                'already-paid'   => 'Advertencia: La factura ya está pagada.',
                'amount-exceed'  => 'Advertencia: La cantidad de transacción supera el límite.',
                'zero-amount'    => 'Advertencia: La cantidad de transacción debe ser mayor que cero.',
                'create-success' => 'Éxito: Transacción creada correctamente.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Advertencia: Cliente no encontrado.',
                'cart-not-found'           => 'Advertencia: Carrito no encontrado.',
                'cart-item-not-found'      => 'Advertencia: Elemento del carrito no encontrado.',
                'cart-create-success'      => 'Éxito: Carrito creado correctamente.',
                'cart-item-add-success'    => 'Éxito: Producto agregado al carrito correctamente.',
                'cart-item-remove-success' => 'Éxito: El artículo se ha eliminado correctamente del carrito.',
                'cart-item-update-success' => 'Éxito: Producto actualizado en el carrito correctamente.',
                'something-wrong'          => 'Advertencia: Algo salió mal.',
                'address-save-success'     => 'Éxito: Dirección guardada correctamente.',
                'shipping-save-success'    => 'Éxito: Método de envío guardado correctamente.',
                'payment-save-success'     => 'Éxito: Método de pago guardado correctamente.',
                'order-placed-success'     => 'Éxito: Pedido realizado correctamente.',
                'payment-method-not-found' => 'Advertencia: Método de pago no encontrado.',
                'minimum-order-amount-err' => 'Advertencia: El monto mínimo del pedido debe ser :amount',
                'check-shipping-address'   => 'Advertencia: Por favor, verifique la dirección de envío.',
                'check-billing-address'    => 'Advertencia: Por favor, verifique la dirección de facturación.',
                'specify-shipping-method'  => 'Advertencia: Por favor, especifique el método de envío.',
                'specify-payment-method'   => 'Advertencia: Por favor, especifique el método de pago.',
                'coupon-not-valid'         => 'Advertencia: El código de cupón no es válido.',
                'coupon-already-applied'   => 'Advertencia: El código de cupón ya ha sido aplicado.',
                'coupon-applied'           => 'Éxito: Código de cupón aplicado correctamente.',
                'coupon-removed'           => 'Éxito: Código de cupón eliminado correctamente.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Producto creado exitosamente.',
                'delete-success'            => 'Producto eliminado exitosamente',
                'not-found'                 => 'Advertencia: Producto no encontrado.',
                'update-success'            => 'Producto actualizado exitosamente.',
                'configurable-attr-missing' => 'Advertencia: Falta el atributo configurable.',
                'simple-products-error'     => 'Advertencia: Faltan productos simples.',
            ],

            'categories' => [
                'already-taken'  => 'Advertencia: El slug ya ha sido utilizado.',
                'create-success' => 'Categoría creada exitosamente.',
                'delete-success' => 'Categoría eliminada exitosamente',
                'not-found'      => 'Advertencia: Categoría no encontrada.',
                'update-success' => 'Categoría actualizada exitosamente.',
                'root-delete'    => 'Advertencia: No se puede eliminar la categoría raíz.',
            ],

            'attributes' => [
                'create-success'    => 'Atributo creado exitosamente.',
                'delete-success'    => 'Atributo eliminado exitosamente',
                'not-found'         => 'Advertencia: Atributo no encontrado.',
                'update-success'    => 'Atributo actualizado exitosamente.',
                'user-define-error' => 'Advertencia: No tienes autorización para eliminar atributos creados por el sistema.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Grupo de atributos creado exitosamente.',
                'delete-success'    => 'Grupo de atributos eliminado exitosamente',
                'not-found'         => 'Advertencia: Grupo de atributos no encontrado.',
                'update-success'    => 'Grupo de atributos actualizado exitosamente.',
                'user-define-error' => 'Advertencia: No tienes autorización para eliminar grupos de atributos creados por el sistema.',
            ],

            'attribute-families' => [
                'create-success'          => 'Familia de atributos creada exitosamente.',
                'delete-success'          => 'Familia de atributos eliminada exitosamente',
                'not-found'               => 'Advertencia: Familia de atributos no encontrada.',
                'update-success'          => 'Familia de atributos actualizada exitosamente.',
                'last-delete-error'       => 'Advertencia: No se puede eliminar la última familia de atributos.',
                'attribute-product-error' => 'Advertencia: Algunos productos están asociados con esta familia de atributos.',
                'user-define-error'       => 'Advertencia: No tienes autorización para eliminar familias de atributos creadas por el sistema.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Cliente creado exitosamente.',
                'delete-order-pending' => 'No se puede eliminar la cuenta del cliente porque hay pedidos pendientes o en estado de procesamiento.',
                'delete-success'       => 'Cliente eliminado exitosamente',
                'not-found'            => 'Advertencia: Cliente no encontrado.',
                'note-created-success' => 'Nota creada exitosamente',
                'update-success'       => 'Cliente actualizado exitosamente.',
                'login-success'        => 'Cliente ha iniciado sesión exitosamente.',
            ],

            'addresses' => [
                'create-success'         => 'Dirección del cliente creada exitosamente.',
                'default-update-success' => 'La dirección se ha establecido como predeterminada.',
                'delete-success'         => 'Dirección del cliente eliminada exitosamente.',
                'not-found'              => 'Advertencia: Dirección del cliente no encontrada.',
                'update-success'         => 'Dirección del cliente actualizada exitosamente.',
                'already-default'        => 'Advertencia: Esta dirección ya está establecida como predeterminada.',
            ],

            'groups' => [
                'create-success'     => 'Grupo de clientes creado exitosamente.',
                'customer-associate' => 'Advertencia: No se puede eliminar el grupo. El cliente está asociado a él.',
                'delete-success'     => 'Grupo de clientes eliminado exitosamente',
                'not-found'          => 'Advertencia: Grupo de clientes no encontrado.',
                'update-success'     => 'Grupo de clientes actualizado exitosamente.',
                'user-define-error'  => 'Advertencia: No tienes autorización para eliminar grupos de clientes creados por el sistema.',
            ],

            'reviews' => [
                'delete-success' => 'Reseña eliminada exitosamente',
                'not-found'      => 'Advertencia: Reseña no encontrada.',
                'update-success' => 'Reseña actualizada exitosamente.',
            ],

            'gdpr' => [
                'delete-success' => 'Éxito: Solicitud de GDPR eliminada con éxito.',
                'not-found'      => 'Advertencia: Solicitud de GDPR no encontrada.',
                'update-success' => 'Solicitud de GDPR actualizada con éxito.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Advertencia: El slug ya ha sido utilizado.',
            'create-success' => 'CMS creado exitosamente.',
            'delete-success' => 'CMS eliminado exitosamente',
            'not-found'      => 'Advertencia: CMS no encontrado.',
            'update-success' => 'CMS actualizado exitosamente.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Regla de catálogo creada exitosamente.',
                    'delete-failed'  => 'Advertencia: No se pudo eliminar la regla de catálogo',
                    'delete-success' => 'Regla de catálogo eliminada exitosamente',
                    'not-found'      => 'Advertencia: No se encontró la regla de catálogo.',
                    'update-success' => 'Regla de catálogo actualizada exitosamente.',
                ],

                'cart-rules' => [
                    'create-success' => 'Regla de carrito creada exitosamente.',
                    'delete-failed'  => 'Advertencia: No se pudo eliminar la regla de carrito',
                    'delete-success' => 'Regla de carrito eliminada exitosamente',
                    'not-found'      => 'Advertencia: No se encontró la regla de carrito.',
                    'update-success' => 'Regla de carrito actualizada exitosamente.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Plantilla de correo electrónico creada exitosamente.',
                    'delete-success' => 'Plantilla de correo electrónico eliminada exitosamente',
                    'not-found'      => 'Advertencia: No se encontró la plantilla de correo electrónico.',
                    'update-success' => 'Plantilla de correo electrónico actualizada exitosamente.',
                ],

                'events' => [
                    'create-success' => 'Evento creado exitosamente.',
                    'delete-success' => 'Evento eliminado exitosamente',
                    'not-found'      => 'Advertencia: No se encontró el evento.',
                    'update-success' => 'Evento actualizado exitosamente.',
                ],

                'campaigns' => [
                    'create-success' => 'Campaña creada exitosamente.',
                    'delete-success' => 'Campaña eliminada exitosamente',
                    'not-found'      => 'Advertencia: No se encontró la campaña.',
                    'update-success' => 'Campaña actualizada exitosamente.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Suscripción eliminada exitosamente',
                    'not-found'           => 'Advertencia: No se encontró la suscripción.',
                    'unsubscribe-success' => 'Éxito: Suscripción cancelada exitosamente.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL Rewrite creado exitosamente.',
                    'delete-success' => 'URL Rewrite eliminado exitosamente',
                    'not-found'      => 'Advertencia: No se encontró el URL Rewrite.',
                    'update-success' => 'URL Rewrite actualizado exitosamente.',
                ],

                'search-terms' => [
                    'create-success' => 'Término de búsqueda creado exitosamente.',
                    'delete-success' => 'Término de búsqueda eliminado exitosamente',
                    'not-found'      => 'Advertencia: No se encontró el término de búsqueda.',
                    'update-success' => 'Término de búsqueda actualizado exitosamente.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Sinónimo de búsqueda creado exitosamente.',
                    'delete-success' => 'Sinónimo de búsqueda eliminado exitosamente',
                    'not-found'      => 'Advertencia: No se encontró el sinónimo de búsqueda.',
                    'update-success' => 'Sinónimo de búsqueda actualizado exitosamente.',
                ],

                'sitemaps' => [
                    'create-success' => 'Mapa del sitio creado exitosamente.',
                    'delete-success' => 'Mapa del sitio eliminado exitosamente',
                    'not-found'      => 'Advertencia: No se encontró el mapa del sitio.',
                    'update-success' => 'Mapa del sitio actualizado exitosamente.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Locale creado exitosamente.',
                'default-delete-error' => 'No se puede eliminar el idioma predeterminado.',
                'delete-error'         => 'Error al eliminar el idioma.',
                'delete-success'       => 'Idioma eliminado exitosamente.',
                'last-delete-error'    => 'Error al eliminar el último idioma.',
                'not-found'            => 'Advertencia: Idioma no encontrado.',
                'update-success'       => 'Idioma actualizado exitosamente.',
            ],

            'currencies' => [
                'create-success'       => 'Moneda creada exitosamente.',
                'default-delete-error' => 'No se puede eliminar la moneda predeterminada.',
                'delete-error'         => 'Error al eliminar la moneda.',
                'delete-success'       => 'Moneda eliminada exitosamente.',
                'last-delete-error'    => 'Error al eliminar la última moneda.',
                'not-found'            => 'Advertencia: Moneda no encontrada.',
                'update-success'       => 'Moneda actualizada exitosamente.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Tasa de cambio creada exitosamente.',
                'delete-error'            => 'Error al eliminar la tasa de cambio.',
                'delete-success'          => 'Tasa de cambio eliminada exitosamente.',
                'invalid-target-currency' => 'Advertencia: Moneda de destino inválida proporcionada.',
                'last-delete-error'       => 'Error al eliminar la última tasa de cambio.',
                'not-found'               => 'Advertencia: Tasa de cambio no encontrada.',
                'update-success'          => 'Tasa de cambio actualizada exitosamente.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Inventario creado exitosamente.',
                'delete-error'      => 'Error al eliminar el inventario.',
                'delete-success'    => 'Inventario eliminado exitosamente.',
                'last-delete-error' => 'Error al eliminar el último inventario.',
                'not-found'         => 'Advertencia: Inventario no encontrado.',
                'update-success'    => 'Inventario actualizado exitosamente.',
            ],

            'channels' => [
                'create-success'       => 'Canal creado exitosamente.',
                'default-delete-error' => 'No se puede eliminar el canal predeterminado.',
                'delete-error'         => 'Error al eliminar el canal.',
                'delete-success'       => 'Canal eliminado exitosamente.',
                'last-delete-error'    => 'Error al eliminar el último canal.',
                'not-found'            => 'Advertencia: Canal no encontrado.',
                'update-success'       => 'Canal actualizado exitosamente.',
            ],

            'users' => [
                'activate-warning'  => 'Tu cuenta aún no ha sido activada, por favor contacta al administrador.',
                'create-success'    => 'Usuario creado exitosamente.',
                'delete-error'      => 'Error al eliminar el usuario.',
                'delete-success'    => 'Usuario eliminado exitosamente.',
                'last-delete-error' => 'Error al eliminar el último usuario.',
                'login-error'       => 'Por favor verifica tus credenciales e intenta nuevamente.',
                'not-found'         => 'Advertencia: Usuario no encontrado.',
                'success-login'     => 'Éxito: Usuario ha iniciado sesión exitosamente.',
                'success-logout'    => 'Éxito: Usuario ha cerrado sesión exitosamente.',
                'update-success'    => 'Usuario actualizado exitosamente.',
            ],

            'roles' => [
                'create-success'    => 'Rol creado exitosamente.',
                'delete-error'      => 'Error al eliminar el rol.',
                'delete-success'    => 'Rol eliminado exitosamente.',
                'last-delete-error' => 'No se puede eliminar el último rol.',
                'not-found'         => 'Advertencia: Rol no encontrado.',
                'update-success'    => 'Rol actualizado exitosamente.',
            ],

            'themes' => [
                'create-success' => 'Tema creado exitosamente.',
                'delete-success' => 'Tema eliminado exitosamente.',
                'not-found'      => 'Advertencia: Tema no encontrado.',
                'update-success' => 'Tema actualizado exitosamente.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'El category_id especificado no existe.',
                        'invalid-boolean-value' => 'El valor de :key debe ser 0 o 1.',
                        'invalid-filter-key'    => 'La clave del filtro ":key" no está permitida.',
                        'invalid-limit-value'   => 'El valor del límite debe ser una de las siguientes opciones: :options.',
                        'invalid-select-option' => 'El valor :key no es válido. Las opciones válidas son: :options.',
                        'invalid-sort-value'    => 'El valor de ordenamiento debe ser una de las siguientes opciones: :options.',
                        'missing-limit-key'     => 'filtersInput debe incluir una clave "limit".',
                        'missing-sort-key'      => 'filtersInput debe incluir una clave "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Tasa de impuesto creada exitosamente.',
                'delete-error'   => 'Error al eliminar la tasa de impuesto.',
                'delete-success' => 'Tasa de impuesto eliminada exitosamente.',
                'not-found'      => 'Advertencia: Tasa de impuesto no encontrada.',
                'update-success' => 'Tasa de impuesto actualizada exitosamente.',
            ],

            'tax-category' => [
                'create-success'     => 'Categoría de impuesto creada exitosamente.',
                'delete-error'       => 'Error al eliminar la categoría de impuesto.',
                'delete-success'     => 'Categoría de impuesto eliminada exitosamente.',
                'not-found'          => 'Advertencia: Categoría de impuesto no encontrada.',
                'tax-rate-not-found' => 'Los IDs proporcionados no se encontraron. IDs: :ids',
                'update-success'     => 'Categoría de impuesto actualizada exitosamente.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Agregar Notificación',
                    'general'   => 'General',
                    'title'     => 'Notificación Push',

                    'datagrid' => [
                        'channel-name'         => 'Nombre del Canal',
                        'created-at'           => 'Tiempo de Creación',
                        'delete'               => 'Eliminar',
                        'id'                   => 'ID',
                        'image'                => 'Imagen',
                        'notification-content' => 'Contenido de la Notificación',
                        'notification-status'  => 'Estado de la Notificación',
                        'notification-type'    => 'Tipo de Notificación',
                        'text-title'           => 'Título',
                        'update'               => 'Actualizar',
                        'updated-at'           => 'Tiempo de Actualización',

                        'status' => [
                            'disabled' => 'Desactivado',
                            'enabled'  => 'Activado',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Volver',
                    'content-and-image'    => 'Contenido e Imagen de la Notificación',
                    'create-btn-title'     => 'Guardar Notificación',
                    'general'              => 'General',
                    'image'                => 'Imagen',
                    'new-notification'     => 'Nueva Notificación',
                    'notification-content' => 'Contenido de la Notificación',
                    'notification-type'    => 'Tipo de Notificación',
                    'product-cat-id'       => 'ID de Producto/Categoría',
                    'settings'             => 'Configuración',
                    'status'               => 'Estado',
                    'store-view'           => 'Canales',
                    'title'                => 'Notificación Push',

                    'option-type' => [
                        'category' => 'Categoría',
                        'others'   => 'Simple',
                        'product'  => 'Producto',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Volver',
                    'content-and-image'    => 'Contenido e Imagen de la Notificación',
                    'edit-notification'    => 'Editar Notificación',
                    'general'              => 'General',
                    'image'                => 'Imagen',
                    'notification-content' => 'Contenido de la Notificación',
                    'notification-type'    => 'Tipo de Notificación',
                    'product-cat-id'       => 'ID de Producto/Categoría',
                    'send-title'           => 'Enviar Notificación',
                    'settings'             => 'Configuración',
                    'status'               => 'Estado',
                    'store-view'           => 'Canales',
                    'title'                => 'Notificación Push',
                    'update-btn-title'     => 'Actualizar',

                    'option-type' => [
                        'category' => 'Categoría',
                        'others'   => 'Simple',
                        'product'  => 'Producto',
                    ],
                ],

                'not-found'           => 'Advertencia: Notificación no encontrada.',
                'create-success'      => 'Notificación creada exitosamente.',
                'delete-failed'       => 'Error al eliminar la notificación.',
                'delete-success'      => 'Notificación eliminada exitosamente.',
                'mass-update-success' => 'Notificaciones seleccionadas actualizadas exitosamente.',
                'mass-delete-success' => 'Notificaciones seleccionadas eliminadas exitosamente.',
                'no-value-selected'   => 'no hay valor existente.',
                'send-success'        => 'Notificación enviada exitosamente.',
                'update-success'      => 'Notificación actualizada exitosamente.',
                'configuration-error' => 'Advertencia: Configuración de FCM no encontrada.',
                'product-not-found'   => 'Advertencia: Producto no encontrado.',
                'category-not-found'  => 'Advertencia: Categoría no encontrada.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Advertencia: Parámetros inválidos proporcionados.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Advertencia: Configuración de correo electrónico no encontrada.',
    ],
];
