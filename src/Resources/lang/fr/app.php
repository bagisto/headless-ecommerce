<?php

return [
    'admin' => [
        'menu' => [
            'push-notification' => 'Notification Push',
        ],

        'acl' => [
            'push-notification' => 'Notification Push',
            'send'              => 'Envoyer',
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'title'                           => 'API GraphQL',
                        'info'                            => 'Configurations liées aux notifications',
                        'push-notification-configuration' => 'Configuration de Notification Push FCM',
                        'server-key'                      => 'Clé du Serveur',
                        'info-get-server-key'             => 'Info : Pour obtenir les identifiants de l\'API FCM : <a href="https://console.firebase.google.com/" target="_blank">Cliquez ici</a>',
                        'android-topic'                   => 'Sujet Android',
                        'ios-topic'                       => 'Sujet iOS',
                    ],
                ],
            ],
        ],

        'settings' => [
            'notification' => [
                'index' => [
                    'title'               => 'Notification Push',
                    'add-title'           => 'Ajouter une Notification',
                    'delete-success'      => 'Notification supprimée avec succès',
                    'mass-update-success' => 'Notifications sélectionnées mises à jour avec succès',
                    'mass-delete-success' => 'Notifications sélectionnées supprimées avec succès',

                    'datagrid' => [
                        'id'                   => 'ID',
                        'image'                => 'Image',
                        'text-title'           => 'Titre',
                        'notification-content' => 'Contenu de la Notification',
                        'notification-type'    => 'Type de Notification',
                        'store-view'           => 'Canaux',
                        'notification-status'  => 'État de la Notification',
                        'created-at'           => 'Date de Création',
                        'updated-at'           => 'Date de Mise à Jour',
                        'delete'               => 'Supprimer',
                        'update'               => 'Mettre à Jour',

                        'status' => [
                            'enabled'  => 'Activé',
                            'disabled' => 'Désactivé',
                        ],
                    ],
                ],

                'create' => [
                    'new-notification'     => 'Nouvelle Notification',
                    'back-btn'             => 'Retour',
                    'create-btn-title'     => 'Enregistrer la Notification',
                    'general'              => 'Général',
                    'title'                => 'Notification Push',
                    'content-and-image'    => 'Contenu et Image de la Notification',
                    'notification-content' => 'Contenu de la Notification',
                    'image'                => 'Image',
                    'settings'             => 'Paramètres',
                    'status'               => 'État',
                    'store-view'           => 'Canaux',
                    'notification-type'    => 'Type de Notification',
                    'product-cat-id'       => 'ID de Produit/Catégorie',
                    'success'              => 'Notification créée avec succès',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Produit',
                        'category' => 'Catégorie',
                    ],
                ],

                'edit' => [
                    'edit-notification'         => 'Modifier la Notification',
                    'back-btn'                  => 'Retour',
                    'send-title'                => 'Envoyer la Notification',
                    'update-btn-title'          => 'Mettre à Jour la Notification',
                    'general'                   => 'Général',
                    'title'                     => 'Notification Push',
                    'content-and-image'         => 'Contenu et Image de la Notification',
                    'notification-content'      => 'Contenu de la Notification',
                    'image'                     => 'Image',
                    'settings'                  => 'Paramètres',
                    'status'                    => 'État',
                    'store-view'                => 'Canaux',
                    'notification-type'         => 'Type de Notification',
                    'product-cat-id'            => 'ID de Produit/Catégorie',
                    'success'                   => 'Notification mise à jour avec succès',
                    'notification-send-success' => 'Notification envoyée avec succès pour Android et iOS.',

                    'option-type' => [
                        'others'   => 'Simple',
                        'product'  => 'Produit',
                        'category' => 'Catégorie'
                    ],
                ],
            ],

            'exchange_rates' => [
                'error-invalid-target-currency' => 'Avertissement : Devise cible non valide fournie.',
                'delete-success'                => 'Succès : Taux de change supprimé avec succès.',
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
            'error-payment-selection'   => 'Advertencia: Hay algún error al obtener métodos de pago.',
            'selected-shipment'         => 'Éxito: Envío seleccionado correctamente.',
            'warning-empty-cart'        => 'Advertencia: No hay productos agregados al carrito.',
            'billing-address-missing'   => 'Advertencia: Falta la dirección de facturación para el proceso de pago.',
            'shipping-address-missing'  => 'Advertencia: Falta la dirección de envío para el proceso de pago.',
            'invalid-guest-access'      => 'Advertencia: Los clientes invitados no pueden obtener direcciones con la ayuda del ID de dirección de facturación/envío.',
            'guest-address-warning'     => 'Advertencia: Si estás intentando como invitado, intenta sin un token de autorización.',
            'wrong-error'               => 'Advertencia: Hay un error en tu carrito, inténtalo de nuevo.',
            'no-billing-address-found'  => 'Advertencia: No se encontró registro de dirección de facturación con el ID :address_id.',
            'no-shipping-address-found' => 'Advertencia: No se encontró registro de dirección de envío con el ID :address_id.',
            'error.invalid-parameter'   => 'Advertencia: Se proporcionaron parámetros no válidos.',
            'already-applied'           => 'El código de cupón ya ha sido aplicado.',
            'success-apply'             => 'Código de cupón aplicado correctamente.',
            'coupon-removed'            => 'Éxito: cupón eliminado del carrito correctamente.',
            'coupon-remove-failed'      => 'Advertencia: hay algún error al eliminar el cupón del carrito o el cupón no se encontró.',
            'error-placing-order'       => 'Advertencia: Hay algún error al realizar el pedido.',
            'selected-payment'          => 'Éxito: Método de pago seleccionado correctamente.',
            'error-payment-save'        => 'Advertencia: Hay algún error al guardar el método de pago.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'Todos los elementos eliminados correctamente del carrito.',
                    'fail-all-remove'          => 'Error al eliminar elementos del carrito.',
                    'error.invalid-parameter'  => 'Advertencia: Se proporcionaron parámetros no válidos.',
                    'success-moved-cart-item'  => 'Éxito: Elemento del carrito movido a la lista de deseos correctamente.',
                    'fail-moved-cart-item'     => 'Error: El elemento del carrito no se ha movido a la lista de deseos.',
                    'success-add-to-cart'      => 'Éxito: Producto agregado al carrito correctamente.',
                    'fail-add-to-cart'         => 'Error: El producto no se ha agregado al carrito.',
                    'success-update-to-cart'   => 'Éxito: El elemento del carrito se ha actualizado correctamente.',
                    'fail-update-to-cart'      => 'Error: El elemento del carrito no se ha actualizado.',
                    'success-delete-cart-item' => 'Éxito: El elemento del carrito se ha eliminado correctamente.',
                    'fail-delete-cart-item'    => 'Error: El elemento del carrito no se ha encontrado.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'Succès : Connexion du client réussie.',
            'success-logout'        => 'Succès : Déconnexion du client réussie.',
            'no-login-customer'     => 'Attention : Aucun client connecté trouvé.',
            'address-list'          => 'Succès : Détails de l\'adresse du client récupérés.',
            'not-authorized'        => 'Attention : Vous n\'êtes pas autorisé à mettre à jour cette adresse.',
            'no-address-list'       => 'Attention : Aucune adresse de client trouvée.',
            'text-password'         => 'Votre mot de passe est : :password',
            'not-exists'            => 'Attention : Aucun client trouvé pour les données fournies.',
            'success-address-list'  => 'Succès : Adresses du client récupérées avec succès.',
            'reset-link-sent'       => 'Succès : L\'e-mail de réinitialisation du mot de passe a été envoyé avec succès.',
            'password-reset-failed' => 'Attention : Nous vous avons déjà envoyé un e-mail de réinitialisation de mot de passe, réessayez plus tard.',
            'no-login-user'         => 'Attention : Aucun utilisateur connecté trouvé.',
            'customer-details'      => 'Succès : Détails du client récupérés avec succès.',

            'account' => [
                'not-found' => 'Advertencia: No se encontró ningún :name.',

                'profile' => [
                    'edit-success'   => 'Perfil actualizado correctamente',
                    'edit-fail'      => 'Error al actualizar el perfil',
                    'unmatch'        => 'La antigua contraseña no coincide.',
                    'order-pending'  => 'No se puede eliminar la cuenta del cliente porque hay algún(os) pedido(s) pendiente(s) o en estado de procesamiento.',
                    'delete-success' => 'Cliente eliminado correctamente',
                    'wrong-password' => '¡Contraseña incorrecta!',
                ],

                'order' => [
                    'no-order-found' => 'Advertencia: No se encontró ningún pedido.',
                    'cancel-success' => 'Pedido cancelado correctamente',
                ],

                'review' => [
                    'success' => 'Éxito: La reseña se envió correctamente, por favor espera la aprobación.',
                ],

                'wishlist' => [
                    'removed'            => 'Artículo eliminado correctamente de la lista de deseos',
                    'remove-fail'        => 'No se puede eliminar el artículo de la lista de deseos',
                    'remove-all-success' => 'Se han eliminado todos los artículos de tu lista de deseos',
                    'success'            => 'Artículo agregado correctamente a la lista de deseos',
                    'already-exist'      => 'El producto ya existe en la lista de deseos',
                    'move-to-cart'       => 'Mover al carrito',
                    'moved-success'      => 'Artículo movido correctamente al carrito',
                    'error-move-to-cart' => 'Advertencia: Este producto podría tener algunas opciones requeridas, no se puede mover al carrito.',
                    'no-item-found'      => 'Advertencia: No se encontró ningún producto.',
                ],

                'addresses' => [
                    'delete-success' => 'Dirección del cliente eliminada correctamente'
                ]
            ],

            'signup-form' => [
                'error-registration' => 'Attention : l\'inscription du client a échoué.',
                'warning-num-already-used' => 'Attention : Ce numéro de téléphone est déjà enregistré avec une adresse e-mail différente.',
                'success-verify' => 'Compte créé avec succès, un e-mail a été envoyé pour vérification.',
                'invalid-creds' => 'Veuillez vérifier vos informations de connexion et réessayer.',

                'validation' => [
                    'unique' => 'Ce :field est déjà utilisé.',
                    'required' => 'Le champ :field est requis.',
                    'same' => 'Le champ :field et le mot de passe doivent correspondre.',
                ],
            ],

            'login-form' => [
                'not-activated' => 'Votre activation requiert l\'approbation de l\'administrateur.',
                'invalid-creds' => 'Veuillez vérifier vos informations de connexion et réessayer.',
            ],
        ],

        'response' => [
            'error.invalid-parameter' => 'Attention : Paramètres invalides fournis.',
            'invalid-header'          => 'Attention : Jeton d\'en-tête invalide.',
            'cancel-error'            => 'La commande ne peut pas être annulée.',
        ],
    ]
];
