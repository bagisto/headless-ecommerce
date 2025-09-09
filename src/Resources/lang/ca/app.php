<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Ja estàs subscrit al nostre butlletí.',
            'subscribe-success'  => 'T\'has subscrit amb èxit al nostre butlletí.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Gràcies per contactar amb nosaltres. Ens posarem en contacte amb tu aviat.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Advertència: Enllaç de descàrrega no trobat.',
                'sample-not-found' => 'Advertència: Mostra de descàrrega no trobada.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Advertència: No s\'ha trobat cap client connectat.',
            'success-login'     => 'Èxit: Connexió del client amb èxit.',
            'success-logout'    => 'Èxit: Desconnexió del client amb èxit.',

            'signup' => [
                'error-registration' => 'Advertència: El registre del client ha fallat.',
                'success-verify'     => 'Compte creat amb èxit, s\'ha enviat un correu electrònic per a la verificació.',
                'success'            => 'Èxit: Client registrat i connectat amb èxit.',
            ],

            'social-login' => [
                'disabled' => 'Advertència: L\'inici de sessió social està desactivat.',
            ],

            'login' => [
                'invalid-creds' => 'Si us plau, comprova les teves credencials i torna-ho a intentar.',
                'not-activated' => 'La teva activació requereix l\'aprovació de l\'administrador.',
                'verify-first'  => 'Si us plau, verifica el teu correu electrònic primer.',
                'suspended'     => 'El teu compte ha estat suspès per l\'administrador.',

                'validation' => [
                    'required' => 'El camp :field és obligatori.',
                    'same'     => 'El camp :field i la contrasenya han de coincidir.',
                    'unique'   => 'Aquest :field ja ha estat pres.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'L\'enllaç per restablir la contrasenya ja s\'ha enviat al teu correu electrònic.',
                'email-not-exist' => 'El correu electrònic no existeix.',
                'reset-link-sent' => 'L\'enllaç per restablir la contrasenya s\'ha enviat al teu correu electrònic.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Èxit: Detalls del client obtinguts amb èxit.',
                    'delete-success'   => 'Èxit: Compte eliminat amb èxit.',
                    'password-unmatch' => 'La contrasenya no coincideix.',
                    'update-fail'      => 'Advertència: El perfil no s\'ha actualitzat.',
                    'update-success'   => 'Èxit: Perfil actualitzat amb èxit.',
                    'wrong-password'   => 'Advertència: Contrasenya incorrecta proporcionada.',
                    'order-pending'    => 'No pots eliminar el compte perquè tens algunes comandes pendents.',
                ],

                'addresses' => [
                    'create-success'         => 'Adreça creada amb èxit.',
                    'default-update-success' => 'L\'adreça s\'ha establert com a predeterminada.',
                    'delete-success'         => 'Adreça eliminada amb èxit.',
                    'not-found'              => 'Advertència: Adreça no trobada.',
                    'update-success'         => 'Adreça actualitzada amb èxit.',
                    'already-default'        => 'Advertència: Aquesta adreça ja està establerta com a predeterminada.',
                ],

                'wishlist' => [
                    'product-removed' => 'Advertència: Producte no trobat.',
                    'success'         => 'Èxit: Producte afegit a la llista de desitjos amb èxit.',
                    'already-exist'   => 'Advertència: Ja s\'ha afegit a la llista de desitjos.',
                    'remove-success'  => 'Èxit: L\'element s\'ha eliminat amb èxit de la llista de desitjos.',
                    'not-found'       => 'Advertència: No s\'han trobat productes a la llista de desitjos.',
                    'moved-to-cart'   => 'Èxit: Producte mogut al carret amb èxit.',
                ],

                'orders' => [
                    'not-found'      => 'Advertència: No s\'han trobat comandes.',
                    'cancel-error'   => 'Advertència: La comanda no s\'ha cancel·lat.',
                    'cancel-success' => 'Èxit: Comanda cancel·lada amb èxit.',

                    'shipment' => [
                        'not-found' => 'Advertència: Enviament no trobat.',
                    ],

                    'invoice' => [
                        'not-found' => 'Advertència: Factura no trobada.',
                    ],

                    'refund' => [
                        'not-found' => 'Advertència: Reemborsament no trobat.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Advertència: Producte descarregable no trobat.',
                    'not-auth'       => 'Advertència: No estàs autoritzat a realitzar aquesta acció.',
                    'payment-error'  => 'El pagament no s\'ha realitzat per aquesta descàrrega.',
                    'download-error' => 'L\'enllaç de descàrrega ha caducat.',
                ],

                'gdpr' => [
                    'create-success'       => 'Èxit: Sol·licitud GDPR creada amb èxit.',
                    'revoke-failed'        => 'Advertència: La sol·licitud GDPR no s\'ha revocat.',
                    'revoked-successfully' => 'Èxit: Sol·licitud GDPR revocada amb èxit.',
                    'not-enabled'          => 'Advertència: El GDPR no està habilitat.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Advertència: Producte de comparació no trobat.',
                'product-not-found'   => 'Advertència: Producte no trobat.',
                'already-added'       => 'Advertència: Producte ja afegit a la llista de comparació.',
                'item-add-success'    => 'Èxit: Producte afegit a la llista de comparació amb èxit.',
                'remove-success'      => 'Èxit: L\'element s\'ha eliminat amb èxit de la llista de comparació.',
                'mass-remove-success' => 'Èxit: Els elements seleccionats s\'han eliminat amb èxit.',
                'not-auth'            => 'Advertència: No estàs autoritzat a realitzar aquesta acció.',
            ],

            'reviews' => [
                'create-success'      => 'Èxit: Ressenya creada amb èxit.',
                'delete-success'      => 'Èxit: Ressenya eliminada amb èxit.',
                'mass-delete-success' => 'Èxit: Les ressenyes seleccionades s\'han eliminat amb èxit.',
                'not-found'           => 'Advertència: Ressenya no trobada.',
                'product-not-found'   => 'Advertència: Producte no trobat.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Advertència: Enllaç descarregable no vàlid proporcionat.',
                        'invalid-parameter'  => 'Advertència: Paràmetres no vàlids proporcionats.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Èxit: Producte afegit al carret amb èxit.',
                        'update-to-cart'   => 'Èxit: Producte actualitzat al carret amb èxit.',
                        'delete-cart-item' => 'Èxit: L\'element s\'ha eliminat amb èxit del carret.',
                        'all-remove'       => 'Èxit: Tots els elements s\'han eliminat del carret.',
                        'move-to-wishlist' => 'Èxit: Els elements seleccionats s\'han mogut amb èxit a la llista de desitjos.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Advertència: No s\'han eliminat tots els elements del carret.',
                        'update-to-cart'   => 'Advertència: El producte no s\'ha actualitzat al carret.',
                        'delete-cart-item' => 'Advertència: L\'element no s\'ha eliminat del carret.',
                        'not-found'        => 'Advertència: Carret no trobat.',
                        'item-not-found'   => 'Advertència: Element no trobat.',
                        'move-to-wishlist' => 'Advertència: Els elements seleccionats no s\'han mogut a la llista de desitjos.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Advertència: L\'usuari convidat no pot afegir adreça.',
                'guest-checkout-warning'    => 'Advertència: L\'usuari convidat no pot realitzar el pagament.',
                'no-billing-address-found'  => 'Advertència: No s\'ha trobat cap adreça de facturació.',
                'no-shipping-address-found' => 'Advertència: No s\'ha trobat cap adreça d\'enviament.',
                'address-save-success'      => 'Èxit: Adreça desada amb èxit.',
            ],

            'shipping' => [
                'method-not-found' => 'Advertència: Mètode d\'enviament no trobat.',
                'method-fetched'   => 'Èxit: Mètode d\'enviament obtingut amb èxit.',
                'save-failed'      => 'Advertència: El mètode d\'enviament no s\'ha desat.',
                'save-success'     => 'Èxit: Mètode d\'enviament desat amb èxit.',
            ],

            'payment' => [
                'method-not-found' => 'Advertència: Mètode de pagament no trobat.',
                'method-fetched'   => 'Èxit: Mètode de pagament obtingut amb èxit.',
                'save-failed'      => 'Advertència: El mètode de pagament no s\'ha desat.',
                'save-success'     => 'Èxit: Mètode de pagament desat amb èxit.',
            ],

            'coupon' => [
                'apply-success'   => 'Èxit: Codi de cupó aplicat amb èxit.',
                'already-applied' => 'Advertència: El codi de cupó ja s\'ha aplicat.',
                'invalid-code'    => 'Advertència: El codi de cupó no és vàlid.',
                'remove-success'  => 'Èxit: Codi de cupó eliminat amb èxit.',
                'remove-failed'   => 'Advertència: El codi de cupó no s\'ha eliminat.',
            ],

            'something-wrong'          => 'Advertència: Alguna cosa ha anat malament.',
            'invalid-guest-user'       => 'Advertència: Usuari convidat no vàlid.',
            'empty-cart'               => 'Advertència: El carret està buit.',
            'missing-billing-address'  => 'Advertència: Falta l\'adreça de facturació.',
            'missing-shipping-address' => 'Advertència: Falta l\'adreça d\'enviament.',
            'missing-shipping-method'  => 'Advertència: Falta el mètode d\'enviament.',
            'missing-payment-method'   => 'Advertència: Falta el mètode de pagament.',
            'no-address-found'         => 'Advertència: No s\'ha trobat cap adreça de facturació i enviament.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Crear',
            'delete'            => 'Eliminar',
            'edit'              => 'Editar',
            'mass-delete'       => 'Eliminació massiva',
            'mass-update'       => 'Actualització massiva',
            'push-notification' => 'Notificació push',
            'send'              => 'Enviar',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Notificació push',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Tema de notificació',
                        'info'                            => 'Configuracions relacionades amb les notificacions',
                        'push-notification-configuration' => 'Configuració de notificació push FCM',
                        'title'                           => 'API GraphQL',
                        'private-key'                     => 'Contingut del fitxer JSON de clau privada',
                        'info-get-private-key'            => 'Info: Per obtenir el contingut del fitxer JSON de clau privada FCM: <a href="https://console.firebase.google.com/" target="_blank">Fes clic aquí</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Èxit: Scripts personalitzats actualitzats amb èxit.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Advertència: La comanda no es pot cancel·lar.',
                'cancel-success' => 'Èxit: Comanda cancel·lada amb èxit.',
                'not-found'      => 'Advertència: Comanda no trobada.',
            ],

            'shipments' => [
                'creation-error'   => 'Advertència: L\'enviament no s\'ha creat.',
                'not-found'        => 'Advertència: Enviament no trobat.',
                'quantity-invalid' => 'Advertència: Quantitat no vàlida proporcionada.',
                'shipment-error'   => 'Advertència: L\'enviament no s\'ha creat.',
                'create-success'   => 'Èxit: Enviament creat amb èxit.',
            ],

            'invoices' => [
                'creation-error' => 'Advertència: La factura no s\'ha creat.',
                'not-found'      => 'Advertència: Factura no trobada.',
                'product-error'  => 'Advertència: Producte no vàlid proporcionat.',
                'create-success' => 'Èxit: Factura creada amb èxit.',
                'invalid-qty'    => 'Advertència: Hem trobat una quantitat no vàlida per facturar els articles.',
            ],

            'refunds' => [
                'creation-error'      => 'Advertència: El reemborsament no s\'ha creat.',
                'refund-amount-error' => 'Advertència: Import de reemborsament no vàlid proporcionat.',
                'refund-limit-error'  => 'Advertència: L\'import del reemborsament supera el límit de :amount',
                'not-found'           => 'Advertència: Reemborsament no trobat.',
                'create-success'      => 'Èxit: Reemborsament creat amb èxit.',
            ],

            'transactions' => [
                'already-paid'   => 'Advertència: La factura ja està pagada.',
                'amount-exceed'  => 'Advertència: L\'import de la transacció supera el límit.',
                'zero-amount'    => 'Advertència: L\'import de la transacció ha de ser superior a zero.',
                'create-success' => 'Èxit: Transacció creada amb èxit.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Advertència: Client no trobat.',
                'cart-not-found'           => 'Advertència: Carret no trobat.',
                'cart-item-not-found'      => 'Advertència: Element del carret no trobat.',
                'cart-create-success'      => 'Èxit: Carret creat amb èxit.',
                'cart-item-add-success'    => 'Èxit: Producte afegit al carret amb èxit.',
                'cart-item-remove-success' => 'Èxit: Element eliminat del carret amb èxit.',
                'cart-item-update-success' => 'Èxit: Producte actualitzat al carret amb èxit.',
                'something-wrong'          => 'Advertència: Alguna cosa ha anat malament.',
                'address-save-success'     => 'Èxit: Adreça desada amb èxit.',
                'shipping-save-success'    => 'Èxit: Mètode d\'enviament desat amb èxit.',
                'payment-save-success'     => 'Èxit: Mètode de pagament desat amb èxit.',
                'order-placed-success'     => 'Èxit: Comanda realitzada amb èxit.',
                'payment-method-not-found' => 'Advertència: Mètode de pagament no trobat.',
                'minimum-order-amount-err' => 'Advertència: L\'import mínim de la comanda ha de ser :amount',
                'check-shipping-address'   => 'Advertència: Si us plau, comprova l\'adreça d\'enviament.',
                'check-billing-address'    => 'Advertència: Si us plau, comprova l\'adreça de facturació.',
                'specify-shipping-method'  => 'Advertència: Si us plau, especifica el mètode d\'enviament.',
                'specify-payment-method'   => 'Advertència: Si us plau, especifica el mètode de pagament.',
                'coupon-not-valid'         => 'Advertència: El codi de cupó no és vàlid.',
                'coupon-already-applied'   => 'Advertència: El codi de cupó ja s\'ha aplicat.',
                'coupon-applied'           => 'Èxit: Codi de cupó aplicat amb èxit.',
                'coupon-removed'           => 'Èxit: Codi de cupó eliminat amb èxit.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Producte creat amb èxit.',
                'delete-success'            => 'Producte eliminat amb èxit.',
                'not-found'                 => 'Advertència: Producte no trobat.',
                'update-success'            => 'Producte actualitzat amb èxit.',
                'configurable-attr-missing' => 'Advertència: Falta l\'atribut configurable.',
                'simple-products-error'     => 'Advertència: Falten productes simples.',
            ],

            'categories' => [
                'already-taken'  => 'Advertència: L\'slug ja està en ús.',
                'create-success' => 'Categoria creada amb èxit.',
                'delete-success' => 'Categoria eliminada amb èxit.',
                'not-found'      => 'Advertència: Categoria no trobada.',
                'update-success' => 'Categoria actualitzada amb èxit.',
                'root-delete'    => 'Advertència: La categoria arrel no es pot eliminar.',
            ],

            'attributes' => [
                'create-success'    => 'Atribut creat amb èxit.',
                'delete-success'    => 'Atribut eliminat amb èxit.',
                'not-found'         => 'Advertència: Atribut no trobat.',
                'update-success'    => 'Atribut actualitzat amb èxit.',
                'user-define-error' => 'Advertència: No estàs autoritzat a eliminar un atribut creat pel sistema.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Grup d\'atributs creat amb èxit.',
                'delete-success'    => 'Grup d\'atributs eliminat amb èxit.',
                'not-found'         => 'Advertència: Grup d\'atributs no trobat.',
                'update-success'    => 'Grup d\'atributs actualitzat amb èxit.',
                'user-define-error' => 'Advertència: No estàs autoritzat a eliminar un grup d\'atributs creat pel sistema.',
            ],

            'attribute-families' => [
                'create-success'          => 'Família d\'atributs creada amb èxit.',
                'delete-success'          => 'Família d\'atributs eliminada amb èxit.',
                'not-found'               => 'Advertència: Família d\'atributs no trobada.',
                'update-success'          => 'Família d\'atributs actualitzada amb èxit.',
                'last-delete-error'       => 'Advertència: No es pot eliminar l\'última família d\'atributs.',
                'attribute-product-error' => 'Advertència: Alguns productes estan associats amb aquesta família d\'atributs.',
                'user-define-error'       => 'Advertència: No estàs autoritzat a eliminar una família d\'atributs creada pel sistema.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Client créé avec succès.',
                'delete-order-pending' => 'Impossible de supprimer le compte client car certaines commandes sont en attente ou en cours de traitement.',
                'delete-success'       => 'Client supprimé avec succès.',
                'not-found'            => 'Avertissement : Client non trouvé.',
                'note-created-success' => 'Note créée avec succès.',
                'update-success'       => 'Client mis à jour avec succès.',
                'login-success'        => 'Client connecté avec succès.',
            ],

            'addresses' => [
                'create-success'         => 'Adreça del client creada amb èxit.',
                'default-update-success' => 'Adreça establerta com a predeterminada.',
                'delete-success'         => 'Adreça del client eliminada amb èxit.',
                'not-found'              => 'Advertència: Adreça del client no trobada.',
                'update-success'         => 'Adreça del client actualitzada amb èxit.',
                'already-default'        => 'Advertència: Aquesta adreça ja està establerta com a predeterminada.',
            ],

            'groups' => [
                'create-success'     => 'Groupe de clients créé avec succès.',
                'customer-associate' => 'Avertissement : Le groupe ne peut pas être supprimé. Un client y est associé.',
                'delete-success'     => 'Groupe de clients supprimé avec succès.',
                'not-found'          => 'Avertissement : Groupe de clients non trouvé.',
                'update-success'     => 'Groupe de clients mis à jour avec succès.',
                'user-define-error'  => 'Avertissement : Vous n\'êtes pas autorisé à supprimer un groupe de clients créé par le système.',
            ],

            'reviews' => [
                'delete-success' => 'Avis supprimé avec succès.',
                'not-found'      => 'Avertissement : Avis non trouvé.',
                'update-success' => 'Avis mis à jour avec succès.',
            ],

            'gdpr' => [
                'delete-success' => 'Succès : Demande GDPR supprimée avec succès.',
                'not-found'      => 'Avertissement : Demande GDPR non trouvée.',
                'update-success' => 'Demande GDPR mise à jour avec succès.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Avertissement : Le slug est déjà utilisé.',
            'create-success' => 'CMS créé avec succès.',
            'delete-success' => 'CMS supprimé avec succès.',
            'not-found'      => 'Avertissement : CMS non trouvé.',
            'update-success' => 'CMS mis à jour avec succès.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Règle de catalogue créée avec succès.',
                    'delete-failed'  => 'Avertissement : La règle de catalogue n\'a pas été supprimée.',
                    'delete-success' => 'Règle de catalogue supprimée avec succès.',
                    'not-found'      => 'Avertissement : Règle de catalogue non trouvée.',
                    'update-success' => 'Règle de catalogue mise à jour avec succès.',
                ],

                'cart-rules' => [
                    'create-success' => 'Règle de panier créée avec succès.',
                    'delete-failed'  => 'Avertissement : La règle de panier n\'a pas été supprimée.',
                    'delete-success' => 'Règle de panier supprimée avec succès.',
                    'not-found'      => 'Règle de panier non trouvée.',
                    'update-success' => 'Règle de panier mise à jour avec succès.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Modèle d\'email créé avec succès.',
                    'delete-success' => 'Modèle d\'email supprimé avec succès.',
                    'not-found'      => 'Avertissement : Modèle d\'email non trouvé.',
                    'update-success' => 'Modèle d\'email mis à jour avec succès.',
                ],

                'events' => [
                    'create-success' => 'Événement créé avec succès.',
                    'delete-success' => 'Événement supprimé avec succès.',
                    'not-found'      => 'Avertissement : Événement non trouvé.',
                    'update-success' => 'Événement mis à jour avec succès.',
                ],

                'campaigns' => [
                    'create-success' => 'Campagne créée avec succès.',
                    'delete-success' => 'Campagne supprimée avec succès.',
                    'not-found'      => 'Avertissement : Campagne non trouvée.',
                    'update-success' => 'Campagne mise à jour avec succès.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Abonnement supprimé avec succès.',
                    'not-found'           => 'Avertissement : Abonnement non trouvé.',
                    'unsubscribe-success' => 'Succès : Désabonnement effectué avec succès.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'Réécriture d\'URL créée avec succès.',
                    'delete-success' => 'Réécriture d\'URL supprimée avec succès.',
                    'not-found'      => 'Avertissement : Réécriture d\'URL non trouvée.',
                    'update-success' => 'Réécriture d\'URL mise à jour avec succès.',
                ],

                'search-terms' => [
                    'create-success' => 'Terme de recherche créé avec succès.',
                    'delete-success' => 'Terme de recherche supprimé avec succès.',
                    'not-found'      => 'Avertissement : Terme de recherche non trouvé.',
                    'update-success' => 'Terme de recherche mis à jour avec succès.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Synonyme de recherche créé avec succès.',
                    'delete-success' => 'Synonyme de recherche supprimé avec succès.',
                    'not-found'      => 'Avertissement : Synonyme de recherche non trouvé.',
                    'update-success' => 'Synonyme de recherche mis à jour avec succès.',
                ],

                'sitemaps' => [
                    'create-success' => 'Plan de site créé avec succès.',
                    'delete-success' => 'Plan de site supprimé avec succès.',
                    'not-found'      => 'Avertissement : Plan de site non trouvé.',
                    'update-success' => 'Plan de site mis à jour avec succès.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Langue créée avec succès.',
                'default-delete-error' => 'La langue par défaut ne peut pas être supprimée.',
                'delete-error'         => 'Échec de la suppression de la langue.',
                'delete-success'       => 'Langue supprimée avec succès.',
                'last-delete-error'    => 'Échec de la suppression de la dernière langue.',
                'not-found'            => 'Avertissement : Langue non trouvée.',
                'update-success'       => 'Langue mise à jour avec succès.',
            ],

            'currencies' => [
                'create-success'       => 'Devise créée avec succès.',
                'default-delete-error' => 'La devise par défaut ne peut pas être supprimée.',
                'delete-error'         => 'Échec de la suppression de la devise.',
                'delete-success'       => 'Devise supprimée avec succès.',
                'last-delete-error'    => 'Échec de la suppression de la dernière devise.',
                'not-found'            => 'Avertissement : Devise non trouvée.',
                'update-success'       => 'Devise mise à jour avec succès.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Taux de change créé avec succès.',
                'delete-error'            => 'Échec de la suppression du taux de change.',
                'delete-success'          => 'Taux de change supprimé avec succès.',
                'invalid-target-currency' => 'Avertissement : Devise cible invalide fournie.',
                'last-delete-error'       => 'Échec de la suppression du dernier taux de change.',
                'not-found'               => 'Avertissement : Taux de change non trouvé.',
                'update-success'          => 'Taux de change mis à jour avec succès.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Source d\'inventaire créée avec succès.',
                'delete-error'      => 'Échec de la suppression de la source d\'inventaire.',
                'delete-success'    => 'Source d\'inventaire supprimée avec succès.',
                'last-delete-error' => 'Échec de la suppression de la dernière source d\'inventaire.',
                'not-found'         => 'Avertissement : Source d\'inventaire non trouvée.',
                'update-success'    => 'Source d\'inventaire mise à jour avec succès.',
            ],

            'channels' => [
                'create-success'       => 'Canal créé avec succès.',
                'default-delete-error' => 'Le canal par défaut ne peut pas être supprimé.',
                'delete-error'         => 'Échec de la suppression du canal.',
                'delete-success'       => 'Canal supprimé avec succès.',
                'last-delete-error'    => 'Échec de la suppression du dernier canal.',
                'not-found'            => 'Avertissement : Canal non trouvé.',
                'update-success'       => 'Canal mis à jour avec succès.',
            ],

            'users' => [
                'activate-warning'  => 'Votre compte doit encore être activé, veuillez contacter l\'administrateur.',
                'create-success'    => 'Utilisateur créé avec succès.',
                'delete-error'      => 'Échec de la suppression de l\'utilisateur.',
                'delete-success'    => 'Utilisateur supprimé avec succès.',
                'last-delete-error' => 'Échec de la suppression du dernier utilisateur.',
                'login-error'       => 'Veuillez vérifier vos identifiants et réessayer.',
                'not-found'         => 'Avertissement : Utilisateur non trouvé.',
                'success-login'     => 'Succès : Connexion de l\'utilisateur réussie.',
                'success-logout'    => 'Succès : Déconnexion de l\'utilisateur réussie.',
                'update-success'    => 'Utilisateur mis à jour avec succès.',
            ],

            'roles' => [
                'create-success'    => 'Rôle créé avec succès.',
                'delete-error'      => 'Échec de la suppression du rôle.',
                'delete-success'    => 'Rôle supprimé avec succès.',
                'last-delete-error' => 'Le dernier rôle ne peut pas être supprimé.',
                'not-found'         => 'Avertissement : Rôle non trouvé.',
                'update-success'    => 'Rôle mis à jour avec succès.',
            ],

            'themes' => [
                'create-success' => 'Thème créé avec succès.',
                'delete-success' => 'Thème supprimé avec succès.',
                'not-found'      => 'Avertissement : Thème non trouvé.',
                'update-success' => 'Thème mis à jour avec succès.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'El category_id especificat no existeix.',
                        'invalid-boolean-value' => 'El valor de :key ha de ser 0 o 1.',
                        'invalid-filter-key'    => 'La clau del filtre ":key" no està permesa.',
                        'invalid-limit-value'   => 'El valor del límit ha de ser una de les següents opcions: :options.',
                        'invalid-select-option' => 'El valor :key no és vàlid. Les opcions vàlides són: :options.',
                        'invalid-sort-value'    => 'El valor d\'ordenació ha de ser una de les següents opcions: :options.',
                        'missing-limit-key'     => 'El filtersInput ha d\'incloure una clau "limit".',
                        'missing-sort-key'      => 'El filtersInput ha d\'incloure una clau "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Taux de taxe créé avec succès.',
                'delete-error'   => 'Échec de la suppression du taux de taxe.',
                'delete-success' => 'Taux de taxe supprimé avec succès.',
                'not-found'      => 'Avertissement : Taux de taxe non trouvé.',
                'update-success' => 'Taux de taxe mis à jour avec succès.',
            ],

            'tax-category' => [
                'create-success'     => 'Catégorie de taxe créée avec succès.',
                'delete-error'       => 'Échec de la suppression de la catégorie de taxe.',
                'delete-success'     => 'Catégorie de taxe supprimée avec succès.',
                'not-found'          => 'Avertissement : Catégorie de taxe non trouvée.',
                'tax-rate-not-found' => 'Les identifiants donnés ne sont pas trouvés. Identifiants : :ids',
                'update-success'     => 'Catégorie de taxe mise à jour avec succès.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Ajouter une notification',
                    'general'   => 'Général',
                    'title'     => 'Notification Push',

                    'datagrid' => [
                        'channel-name'         => 'Nom du canal',
                        'created-at'           => 'Heure de création',
                        'delete'               => 'Supprimer',
                        'id'                   => 'Id',
                        'image'                => 'Image',
                        'notification-content' => 'Contenu de la notification',
                        'notification-status'  => 'Statut de la notification',
                        'notification-type'    => 'Type de notification',
                        'text-title'           => 'Titre',
                        'update'               => 'Mettre à jour',
                        'updated-at'           => 'Heure de mise à jour',

                        'status' => [
                            'disabled' => 'Désactivé',
                            'enabled'  => 'Activé',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Retour',
                    'content-and-image'    => 'Contenu et image de la notification',
                    'create-btn-title'     => 'Enregistrer la notification',
                    'general'              => 'Général',
                    'image'                => 'Image',
                    'new-notification'     => 'Nouvelle notification',
                    'notification-content' => 'Contenu de la notification',
                    'notification-type'    => 'Type de notification',
                    'product-cat-id'       => 'Id Produit/Catégorie',
                    'settings'             => 'Paramètres',
                    'status'               => 'Statut',
                    'store-view'           => 'Canaux',
                    'title'                => 'Notification Push',

                    'option-type' => [
                        'category' => 'Catégorie',
                        'others'   => 'Simple',
                        'product'  => 'Produit',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Retour',
                    'content-and-image'    => 'Contenu et image de la notification',
                    'edit-notification'    => 'Modifier la notification',
                    'general'              => 'Général',
                    'image'                => 'Image',
                    'notification-content' => 'Contenu de la notification',
                    'notification-type'    => 'Type de notification',
                    'product-cat-id'       => 'Id Produit/Catégorie',
                    'send-title'           => 'Envoyer la notification',
                    'settings'             => 'Paramètres',
                    'status'               => 'Statut',
                    'store-view'           => 'Canaux',
                    'title'                => 'Notification Push',
                    'update-btn-title'     => 'Mettre à jour',

                    'option-type' => [
                        'category' => 'Catégorie',
                        'others'   => 'Simple',
                        'product'  => 'Produit',
                    ],
                ],

                'not-found'           => 'Avertissement : Notification non trouvée.',
                'create-success'      => 'Notification créée avec succès.',
                'delete-failed'       => 'Échec de la suppression de la notification.',
                'delete-success'      => 'Notification supprimée avec succès.',
                'mass-update-success' => 'Notifications sélectionnées mises à jour avec succès.',
                'mass-delete-success' => 'Notifications sélectionnées supprimées avec succès.',
                'no-value-selected'   => 'Aucune valeur existante sélectionnée.',
                'send-success'        => 'Notification envoyée avec succès.',
                'update-success'      => 'Notification mise à jour avec succès.',
                'configuration-error' => 'Avertissement : Configuration FCM non trouvée.',
                'product-not-found'   => 'Avertissement : Produit non trouvé.',
                'category-not-found'  => 'Avertissement : Catégorie non trouvée.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Avertissement : Paramètres invalides fournis.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Avertissement : Configuration de l\'email non trouvée.',
    ],
];
