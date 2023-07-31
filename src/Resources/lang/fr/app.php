<?php

return [
    'admin'     => [
        'menu'  => [
            'push-notification' => 'Notification Push',
        ],

        'acl'  => [
            'push-notification' => 'Notification Push',
            'send'              => 'Envoyer',
        ],

        'system' => [
            'graphql-api'                       => 'API GraphQL',
            'push-notification-configuration'   => 'Configuration des notifications push FCM',
            'server-key'                        => 'Clé du serveur',
            'info-get-server-key'               => 'Info: Pour obtenir les informations d\'identification API fcm: <a href="https://console.firebase.google.com/" target="_blank">Cliquez ici</a>',
            'android-topic'                     => 'Sujet Android',
            'ios-topic'                         => 'Sujet IOS',
        ],

        'notification'  => [
            'title'                 => 'Notification Push',
            'add-title'             => 'Ajouter une notification',
            'general'               => 'Général',

            'id'                    => 'Id',
            'image'                 => 'Image',
            'text-title'            => 'Titre',
            'edit-notification'     => 'Modifier la notification',
            'manage'                => 'Notifications',
            'new-notification'      => 'Nouvelle notification',
            'create-btn-title'      => 'Enregistrer la notification',
            'notification-image'    => 'Image de notification',
            'notification-title'    => 'Titre de la notification',
            'notification-content'  => 'Contenu de la notification',
            'notification-type'     => 'Type de notification',
            'product-cat-id'        => 'ID produit/catégorie',
            'store-view'            => 'Canaux',
            'notification-status'   => 'État de la notification',
            'created'               => 'Créé',
            'modified'              => 'Modifié',
            'collection-autocomplete'   => 'Collection personnalisée - (Autocomplétion)',
            'no-collection-found'       => 'Collections introuvables avec le même nom.',
            'collection-search-hint'    => 'Commencez à taper le nom de la collection',
            
            'Action'    => [
                'edit'      => 'Modifier',
            ],

            'status'    => [
                'enabled'   => 'Activé',
                'disabled'  => 'Désactivé',
            ],

            'notification-type-option'  => [
                'select'            => '-- Sélectionner --',
                'simple'            => 'Type simple',
                'product'           => 'Basé sur le produit',
                'category'          => 'Basé sur la catégorie',
            ],
        ],

        'alert' => [
            'create-success'        => ':name créé avec succès',
            'update-success'        => ':name mis à jour avec succès',
            'delete-success'        => ':name supprimé avec succès',
            'delete-failed'         => 'Échec de la suppression de :name',
            'sended-successfully'   => ':name envoyé avec succès pour Android et iOS.',
            'no-value-selected'     => 'Aucune valeur existante',
        ],

        'settings'   => [
            'exchange_rates' => [
                'error-invalid-target-currency' => 'Attention: Devise cible invalide fournie.',
                'delete-success'        => 'Succès: Taux de change supprimé avec succès.',
            ]
        ],
        
        'response'  => [
            'error-invalid-parameter'   => 'Attention: Paramètres invalides fournis.',
            'success-login'             => 'Succès: Connexion de l\'utilisateur réussie.',
            'error-login'               => 'Attention: L\'utilisateur administrateur n\'est pas connecté.',
            'session-expired'           => 'Attention: La session a expiré. Veuillez vous reconnecter à votre compte.',
            'invalid-header'            => 'Attention: En-tête du token invalide.',
            'success-logout'            => 'Succès: Déconnexion de l\'utilisateur réussie.',
            'no-login-user'             => 'Attention: Aucun utilisateur connecté trouvé.',
            'error-customer-group'      => 'Attention: Vous n\'êtes pas autorisé à supprimer le groupe d\'attributs créé par le système.',
            'password-invalid'          => 'Attention: Veuillez entrer le mot de passe correct.',
            'password-match'            => 'Attention: Le mot de passe ne correspond pas.',
            'success-registered'        => 'Succès: Utilisateur créé avec succès.',
            'cancel-error'              => 'La commande ne peut pas être annulée.',
            'creation-error'            => 'Le remboursement ne peut pas être créé pour cette commande.',
            'channel-failure'           => 'Chaîne introuvable.',
            'script-delete-success'     => 'Script supprimé avec succès.'
        ]
    ],

    'shop'  => [
        'customer'  => [
            'success-login'         => 'Succès: Connexion réussie du client.',
            'success-logout'        => 'Succès: Déconnexion réussie du client.',
            'no-login-customer'     => 'Attention: Aucun client connecté trouvé.',
            'address-list'          => 'Succès: Détails de l\'adresse du client récupérés',
            'not-authorized'        => 'Attention: Vous n\'êtes pas autorisé à mettre à jour cette adresse.',
            'success-address-list'  => 'Succès: Adresses du client récupérées avec succès.',
            'no-address-list'       => 'Attention: Aucune adresse de client trouvée.',
            'text-password'         => 'Votre mot de passe est :password',
            'not-exists'            => 'Attention: Aucun client trouvé pour les données fournies.',
        ],
        'response'  => [
            'error-registration'        => 'Attention: Échec de l\'inscription du client.',
            'password-reset-failed'     => 'Attention: Nous vous avons déjà envoyé un e-mail de réinitialisation de mot de passe, essayez après un certain temps.',
            'customer-details'          => 'Succès: Détails du client récupérés avec succès.',
            'not-found'                 => 'Attention: Aucun :name trouvé.',
            'no-address-found'          => 'Attention: Aucune adresse trouvée.',
            'no-order-found'            => 'Attention: Aucune commande trouvée.',
            'warning-empty-cart'        => 'Attention: Aucun produit ajouté au panier.',
            'success-add-to-cart'       => 'Succès: Produit ajouté au panier avec succès.',
            'success-update-to-cart'    => 'Succès: L\'élément du panier a été mis à jour avec succès.',
            'success-delete-cart-item'  => 'Succès: L\'élément du panier a été supprimé avec succès.',
            'success-moved-cart-item'   => 'Succès: L\'élément du panier a été déplacé avec succès vers la liste de souhaits.',
            'billing-address-missing'   => 'Attention: Adresse de facturation manquante pour le paiement.',
            'shipping-address-missing'  => 'Attention: Adresse de livraison manquante pour le paiement.',
            'invalid-address'           => 'Attention: Aucune adresse trouvée pour l\'adresseId fournie.',
            'wrong-error'               => 'Attention: Il y a une erreur avec votre panier, réessayez.',
            'save-cart-address'         => 'Succès: Adresse du panier enregistrée avec succès.',
            'error-payment-selection'   => 'Attention: Il y a une erreur lors de la récupération des modes de paiement.',
            'selected-shipment'         => 'Succès: L\'expédition a été sélectionnée avec succès.',
            'error-payment-save'        => 'Attention: Il y a une erreur lors de l\'enregistrement de la méthode de paiement.',
            'selected-payment'          => 'Succès: La méthode de paiement a été sélectionnée avec succès.',
            'error-placing-order'       => 'Attention: Il y a une erreur lors de la passation de la commande.',
            'invalid-product'           => 'Attention: Vous demandez un produit invalide.',
            'already-exist-inwishlist'  => 'Information: Ce produit existe déjà dans la liste de souhaits.',
            'error-move-to-cart'        => 'Attention: Ce produit pourrait avoir certaines options requises, impossible de le déplacer vers le panier.',
            'no-billing-address-found'  => 'Attention: Aucun enregistrement d\'adresse de facturation trouvé avec l\'ID de facturation :address_id.',
            'no-shipping-address-found'  => 'Attention: Aucun enregistrement d\'adresse de livraison trouvé avec l\'ID d\'expédition :address_id.',
            'invalid-guest-access'      => 'Attention: Les clients invités ne sont pas autorisés à obtenir des adresses à l\'aide de l\'ID d\'adresse de facturation / livraison.',
            'guest-address-warning'     => 'Attention: Si vous essayez en tant qu\'invité, essayez sans jeton d\'autorisation.',
            'warning-num-already-used'  => 'Attention: Ce numéro de :phone est enregistré avec une autre adresse e-mail.',
            'coupon-removed'            => 'Succès: coupon retiré du panier avec succès.',
            'coupon-remove-failed'      => 'Attention: il y a quelques erreurs lors de la suppression du coupon du panier ou le coupon n\'a pas été trouvé.',
            'review-create-success'     => 'Succès: L\'avis est soumis avec succès, veuillez attendre l\'approbation.',
            'un-authorized-access'     => 'Warning: You are not authorized to use this section.',
        ]
    ],
    
    'validation' => [
        'unique'    => 'Ce :field est déjà utilisé.',
        'required'  => 'Le champ :field est obligatoire.',
        'same'      => 'Le champ :field et le mot de passe doivent correspondre.'
    ],
    
    'mail' => [
        'customer'  => [
            'password' => [
                'heading'   => config('app.name') . ' - Réinitialisation du mot de passe',
                'reset'     => 'E-mail de réinitialisation du mot de passe',
                'summary' => 'Cet e-mail concerne la réinitialisation du mot de passe de votre compte. Votre mot de passe a été changé avec succès.
                Connectez-vous à votre compte en utilisant le mot de passe mentionné ci-dessous.',
            ]
        ]
    ]
];