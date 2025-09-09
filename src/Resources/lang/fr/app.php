<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Vous êtes déjà abonné à notre newsletter.',
            'subscribe-success'  => 'Vous vous êtes abonné avec succès à notre newsletter.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Merci de nous avoir contactés. Nous vous répondrons sous peu.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Attention : Lien de téléchargement non trouvé.',
                'sample-not-found' => 'Attention : Échantillon téléchargeable non trouvé.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Avertissement: Aucun client connecté trouvé.',
            'success-login'     => 'Succès: Connexion du client réussie.',
            'success-logout'    => 'Succès: Déconnexion du client réussie.',

            'signup' => [
                'error-registration' => 'Avertissement: Échec de l\'inscription du client.',
                'success-verify'     => 'Compte créé avec succès, un e-mail a été envoyé pour vérification.',
                'success'            => 'Succès: Client enregistré et connecté avec succès.',
            ],

            'social-login' => [
                'disabled' => 'Avertissement : La connexion sociale est désactivée.',
            ],

            'login' => [
                'invalid-creds' => 'Veuillez vérifier vos informations d\'identification et réessayer.',
                'not-activated' => 'Votre activation nécessite l\'approbation de l\'administrateur',
                'verify-first'  => 'Veuillez d\'abord vérifier votre e-mail.',
                'suspended'     => 'Votre compte a été suspendu par l\'administrateur.',

                'validation' => [
                    'required' => 'Le champ :field est requis.',
                    'same'     => 'Le champ :field et le mot de passe doivent correspondre.',
                    'unique'   => 'Ce :field est déjà utilisé.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Le lien de réinitialisation du mot de passe a déjà été envoyé à votre adresse e-mail.',
                'email-not-exist' => 'L\'adresse e-mail n\'existe pas.',
                'reset-link-sent' => 'Le lien de réinitialisation du mot de passe a été envoyé à votre adresse e-mail.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Succès : Les détails du client ont été récupérés avec succès.',
                    'delete-success'   => 'Succès : Compte supprimé avec succès.',
                    'password-unmatch' => 'Le mot de passe ne correspond pas.',
                    'update-fail'      => 'Avertissement : Profil non mis à jour.',
                    'update-success'   => 'Succès : Profil mis à jour avec succès.',
                    'wrong-password'   => 'Avertissement : Mauvais mot de passe fourni.',
                    'order-pending'    => 'Vous ne pouvez pas supprimer le compte car vous avez des commandes en attente.',
                ],

                'addresses' => [
                    'create-success'         => 'Adresse créée avec succès.',
                    'default-update-success' => 'L\'adresse est définie par défaut',
                    'delete-success'         => 'Adresse supprimée avec succès',
                    'not-found'              => 'Avertissement: Adresse introuvable.',
                    'update-success'         => 'Adresse mise à jour avec succès.',
                    'already-default'        => 'Avertissement : Cette adresse est déjà définie comme adresse par défaut.',
                ],

                'wishlist' => [
                    'product-removed' => 'Avertissement: Produit introuvable.',
                    'success'         => 'Succès: Produit ajouté à la liste de souhaits avec succès.',
                    'already-exist'   => 'Avertissement: Déjà ajouté à la liste de souhaits.',
                    'remove-success'  => 'Succès: L\'élément est supprimé avec succès de la liste de souhaits.',
                    'not-found'       => 'Avertissement: Aucun produit trouvé dans la liste de souhaits.',
                    'moved-to-cart'   => 'Succès: Les éléments sélectionnés ont été déplacés avec succès vers le panier.',
                ],

                'orders' => [
                    'not-found'      => 'Avertissement: Aucune commande trouvée.',
                    'cancel-error'   => 'Avertissement: Commande non annulée.',
                    'cancel-success' => 'Succès: Commande annulée avec succès.',

                    'shipment' => [
                        'not-found' => 'Avertissement: Envoi introuvable.',
                    ],

                    'invoice' => [
                        'not-found' => 'Avertissement: Facture introuvable.',
                    ],

                    'refund' => [
                        'not-found' => 'Avertissement: Remboursement introuvable.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Avertissement: Produit téléchargeable introuvable.',
                    'not-auth'       => 'Avertissement: Vous n\'êtes pas autorisé à effectuer cette action.',
                    'payment-error'  => 'Le paiement n\'a pas été effectué pour ce téléchargement.',
                    'download-error' => 'Le lien de téléchargement a expiré.',
                ],

                'gdpr' => [
                    'create-success'       => 'Succès : Demande GDPR créée avec succès.',
                    'revoke-failed'        => 'Attention : La demande GDPR n’a pas été révoquée.',
                    'revoked-successfully' => 'Succès : Demande GDPR révoquée avec succès.',
                    'not-enabled'          => 'Attention : Le GDPR n\'est pas activé.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Avertissement: Produit de comparaison non trouvé.',
                'product-not-found'   => 'Avertissement: Produit non trouvé.',
                'already-added'       => 'Avertissement: Produit déjà ajouté à la liste de comparaison.',
                'item-add-success'    => 'Succès: Produit ajouté à la liste de comparaison avec succès.',
                'remove-success'      => 'Succès: Article retiré avec succès de la liste de comparaison.',
                'mass-remove-success' => 'Succès: Articles sélectionnés supprimés avec succès.',
                'not-auth'            => 'Avertissement : Vous n\'êtes pas autorisé à effectuer cette action.',
            ],

            'reviews' => [
                'create-success'      => 'Succès: Avis créé avec succès.',
                'delete-success'      => 'Succès: Avis supprimé avec succès.',
                'mass-delete-success' => 'Succès: Avis sélectionnés supprimés avec succès.',
                'not-found'           => 'Avertissement: Avis introuvable.',
                'product-not-found'   => 'Avertissement: Produit non trouvé.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Avertissement: Les liens de téléchargement ne sont pas disponibles.',
                        'invalid-parameter'  => 'Avertissement: Paramètres invalides fournis.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Succès: Produit ajouté au panier avec succès.',
                        'update-to-cart'   => 'Succès: Produit mis à jour dans le panier avec succès.',
                        'delete-cart-item' => 'Succès: L\'élément est supprimé avec succès du panier.',
                        'all-remove'       => 'Succès: Tous les articles supprimés du panier.',
                        'move-to-wishlist' => 'Succès: Les éléments sélectionnés ont été déplacés avec succès vers la liste de souhaits.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Avertissement: Tous les articles ne sont pas supprimés du panier.',
                        'update-to-cart'   => 'Avertissement: Produit non mis à jour dans le panier.',
                        'delete-cart-item' => 'Avertissement: L\'élément n\'est pas supprimé du panier.',
                        'not-found'        => 'Avertissement: Panier introuvable.',
                        'item-not-found'   => 'Avertissement: Article introuvable.',
                        'move-to-wishlist' => 'Avertissement: Les éléments sélectionnés ne sont pas déplacés vers la liste de souhaits.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Avertissement: L\'utilisateur invité ne peut pas ajouter d\'adresse.',
                'guest-checkout-warning'    => 'Avertissement: L\'utilisateur invité ne peut pas effectuer de paiement.',
                'no-billing-address-found'  => 'Avertissement: Aucune adresse de facturation trouvée.',
                'no-shipping-address-found' => 'Avertissement: Aucune adresse de livraison trouvée.',
                'address-save-success'      => 'Succès: Adresse enregistrée avec succès.',
            ],

            'shipping' => [
                'method-not-found' => 'Avertissement: Méthode d\'expédition introuvable.',
                'method-fetched'   => 'Succès: Méthode d\'expédition récupérée avec succès.',
                'save-failed'      => 'Avertissement: Méthode d\'expédition non enregistrée.',
                'save-success'     => 'Succès: Méthode d\'expédition enregistrée avec succès.',
            ],

            'payment' => [
                'method-not-found' => 'Avertissement: Méthode de paiement introuvable.',
                'method-fetched'   => 'Succès: Méthode de paiement récupérée avec succès.',
                'save-failed'      => 'Avertissement: Méthode de paiement non enregistrée.',
                'save-success'     => 'Succès: Méthode de paiement enregistrée avec succès.',
            ],

            'coupon' => [
                'apply-success'   => 'Succès: Code de coupon appliqué avec succès.',
                'already-applied' => 'Avertissement: Code de coupon déjà appliqué.',
                'invalid-code'    => 'Avertissement: Le code de coupon est invalide.',
                'remove-success'  => 'Succès: Code de coupon supprimé avec succès.',
                'remove-failed'   => 'Avertissement: Code de coupon non supprimé.',
            ],

            'something-wrong'          => 'Avertissement: Quelque chose s\'est mal passé.',
            'invalid-guest-user'       => 'Avertissement: Utilisateur invité invalide.',
            'empty-cart'               => 'Avertissement: Le panier est vide.',
            'missing-billing-address'  => 'Avertissement: Adresse de facturation manquante.',
            'missing-shipping-address' => 'Avertissement: Adresse de livraison manquante.',
            'missing-shipping-method'  => 'Avertissement: Méthode d\'expédition manquante.',
            'missing-payment-method'   => 'Avertissement: Méthode de paiement manquante.',
            'no-address-found'         => 'Avertissement: Aucune adresse de facturation et de livraison trouvée.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Créer',
            'delete'            => 'Supprimer',
            'edit'              => 'Modifier',
            'mass-delete'       => 'Supprimer en masse',
            'mass-update'       => 'Mise à jour en masse',
            'push-notification' => 'Notification Push',
            'send'              => 'Envoyer',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Notification Push',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Sujet de notification',
                        'info'                            => 'Configurations liées aux notifications',
                        'push-notification-configuration' => 'Configuration des notifications push FCM',
                        'title'                           => 'API GraphQL',
                        'private-key'                     => 'Contenu du fichier JSON de clé privée',
                        'info-get-private-key'            => 'Info : Pour obtenir le contenu du fichier JSON de clé privée FCM : <a href="https://console.firebase.google.com/" target="_blank">Cliquez ici</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Succès : Scripts personnalisés mis à jour avec succès.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Attention : la commande ne peut pas être annulée.',
                'cancel-success' => 'Succès : commande annulée avec succès.',
                'not-found'      => 'Attention : commande introuvable.',
            ],

            'shipments' => [
                'creation-error'   => 'Attention : l\'expédition n\'a pas été créée.',
                'not-found'        => 'Attention : expédition introuvable.',
                'quantity-invalid' => 'Attention : quantité invalide fournie.',
                'shipment-error'   => 'Attention : l\'expédition n\'a pas été créée.',
                'create-success'   => 'Succès : expédition créée avec succès.',
            ],

            'invoices' => [
                'creation-error' => 'Attention : la facture n\'a pas été créée.',
                'not-found'      => 'Attention : facture introuvable.',
                'product-error'  => 'Attention : produit invalide fourni.',
                'create-success' => 'Succès : facture créée avec succès.',
                'invalid-qty'    => 'Attention : Nous avons trouvé une quantité invalide pour les articles de la facture.',
            ],

            'refunds' => [
                'creation-error'      => 'Attention : le remboursement n\'a pas été créé.',
                'refund-amount-error' => 'Attention : montant de remboursement invalide fourni.',
                'refund-limit-error'  => 'Attention : le montant de remboursement dépasse la limite de :amount',
                'not-found'           => 'Attention : remboursement introuvable.',
                'create-success'      => 'Succès : remboursement créé avec succès.',
            ],

            'transactions' => [
                'already-paid'   => 'Attention : la facture est déjà payée.',
                'amount-exceed'  => 'Attention : le montant de la transaction dépasse la limite.',
                'zero-amount'    => 'Attention : le montant de la transaction doit être supérieur à zéro.',
                'create-success' => 'Succès : transaction créée avec succès.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Attention : client introuvable.',
                'cart-not-found'           => 'Attention : panier introuvable.',
                'cart-item-not-found'      => 'Attention : article du panier introuvable.',
                'cart-create-success'      => 'Succès : panier créé avec succès.',
                'cart-item-add-success'    => 'Succès : produit ajouté au panier avec succès.',
                'cart-item-remove-success' => 'Succès : l\'élément a été supprimé du panier avec succès.',
                'cart-item-update-success' => 'Succès : produit mis à jour dans le panier avec succès.',
                'something-wrong'          => 'Attention : quelque chose s\'est mal passé.',
                'address-save-success'     => 'Succès : adresse enregistrée avec succès.',
                'shipping-save-success'    => 'Succès : méthode d\'expédition enregistrée avec succès.',
                'payment-save-success'     => 'Succès : méthode de paiement enregistrée avec succès.',
                'order-placed-success'     => 'Succès : commande passée avec succès.',
                'payment-method-not-found' => 'Attention : méthode de paiement introuvable.',
                'minimum-order-amount-err' => 'Attention : le montant minimum de la commande doit être de :amount',
                'check-shipping-address'   => 'Attention : veuillez vérifier l\'adresse de livraison.',
                'check-billing-address'    => 'Attention : veuillez vérifier l\'adresse de facturation.',
                'specify-shipping-method'  => 'Attention : veuillez spécifier la méthode d\'expédition.',
                'specify-payment-method'   => 'Attention : veuillez spécifier la méthode de paiement.',
                'coupon-not-valid'         => 'Attention : le code de coupon n\'est pas valide.',
                'coupon-already-applied'   => 'Attention : le code de coupon a déjà été appliqué.',
                'coupon-applied'           => 'Succès : code de coupon appliqué avec succès.',
                'coupon-removed'           => 'Succès : code de coupon supprimé avec succès.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Produit créé avec succès.',
                'delete-success'            => 'Produit supprimé avec succès',
                'not-found'                 => 'Attention : produit introuvable.',
                'update-success'            => 'Produit mis à jour avec succès.',
                'configurable-attr-missing' => 'Attention : attribut configurable manquant.',
                'simple-products-error'     => 'Attention : produits simples manquants.',
            ],

            'categories' => [
                'already-taken'  => 'Attention : le slug est déjà utilisé.',
                'create-success' => 'Catégorie créée avec succès.',
                'delete-success' => 'Catégorie supprimée avec succès',
                'not-found'      => 'Attention : catégorie introuvable.',
                'update-success' => 'Catégorie mise à jour avec succès.',
                'root-delete'    => 'Attention : la catégorie racine ne peut pas être supprimée.',
            ],

            'attributes' => [
                'create-success'    => 'Attribut créé avec succès.',
                'delete-success'    => 'Attribut supprimé avec succès',
                'not-found'         => 'Attention : attribut introuvable.',
                'update-success'    => 'Attribut mis à jour avec succès.',
                'user-define-error' => 'Attention : vous n\'êtes pas autorisé à supprimer un attribut créé par le système.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Groupe d\'attributs créé avec succès.',
                'delete-success'    => 'Groupe d\'attributs supprimé avec succès',
                'not-found'         => 'Attention : groupe d\'attributs introuvable.',
                'update-success'    => 'Groupe d\'attributs mis à jour avec succès.',
                'user-define-error' => 'Attention : vous n\'êtes pas autorisé à supprimer un groupe d\'attributs créé par le système.',
            ],

            'attribute-families' => [
                'create-success'          => 'Famille d\'attributs créée avec succès.',
                'delete-success'          => 'Famille d\'attributs supprimée avec succès',
                'not-found'               => 'Attention : famille d\'attributs introuvable.',
                'update-success'          => 'Famille d\'attributs mise à jour avec succès.',
                'last-delete-error'       => 'Attention : la dernière famille d\'attributs ne peut pas être supprimée.',
                'attribute-product-error' => 'Attention : certains produits sont associés à cette famille d\'attributs.',
                'user-define-error'       => 'Attention : vous n\'êtes pas autorisé à supprimer une famille d\'attributs créée par le système.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Client créé avec succès.',
                'delete-order-pending' => 'Impossible de supprimer le compte client car certaines commandes sont en attente ou en cours de traitement.',
                'delete-success'       => 'Client supprimé avec succès',
                'not-found'            => 'Attention : client introuvable.',
                'note-created-success' => 'Note créée avec succès',
                'update-success'       => 'Client mis à jour avec succès.',
                'login-success'        => 'Client connecté avec succès.',
            ],

            'addresses' => [
                'create-success'         => 'Adresse du client créée avec succès.',
                'default-update-success' => 'L\'adresse est définie comme adresse par défaut',
                'delete-success'         => 'Adresse du client supprimée avec succès',
                'not-found'              => 'Attention : adresse du client introuvable.',
                'update-success'         => 'Adresse du client mise à jour avec succès.',
                'already-default'        => 'Attention : Cette adresse est déjà définie comme adresse par défaut.',
            ],

            'groups' => [
                'create-success'     => 'Groupe de clients créé avec succès.',
                'customer-associate' => 'Attention : le groupe ne peut pas être supprimé. Le client y est associé.',
                'delete-success'     => 'Groupe de clients supprimé avec succès',
                'not-found'          => 'Attention : groupe de clients introuvable.',
                'update-success'     => 'Groupe de clients mis à jour avec succès.',
                'user-define-error'  => 'Attention : vous n\'êtes pas autorisé à supprimer un groupe de clients créé par le système.',
            ],

            'reviews' => [
                'delete-success' => 'Avis supprimé avec succès',
                'not-found'      => 'Attention : avis introuvable.',
                'update-success' => 'Avis mis à jour avec succès.',
            ],

            'gdpr' => [
                'delete-success' => 'Succès : Demande de GDPR supprimée avec succès.',
                'not-found'      => 'Avertissement : Demande de GDPR introuvable.',
                'update-success' => 'Demande de GDPR mise à jour avec succès.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Attention : le slug est déjà utilisé.',
            'create-success' => 'CMS créé avec succès.',
            'delete-success' => 'CMS supprimé avec succès',
            'not-found'      => 'Attention : CMS introuvable.',
            'update-success' => 'CMS mis à jour avec succès.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Règle de catalogue créée avec succès.',
                    'delete-failed'  => 'Attention : la règle de catalogue n\'a pas été supprimée',
                    'delete-success' => 'Règle de catalogue supprimée avec succès',
                    'not-found'      => 'Attention : règle de catalogue introuvable.',
                    'update-success' => 'Règle de catalogue mise à jour avec succès.',
                ],

                'cart-rules' => [
                    'create-success' => 'Règle de panier créée avec succès.',
                    'delete-failed'  => 'Attention : la règle de panier n\'a pas été supprimée',
                    'delete-success' => 'Règle de panier supprimée avec succès',
                    'not-found'      => 'Règle de panier introuvable',
                    'update-success' => 'Règle de panier mise à jour avec succès.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Modèle d\'email créé avec succès.',
                    'delete-success' => 'Modèle d\'email supprimé avec succès',
                    'not-found'      => 'Attention : modèle d\'email introuvable.',
                    'update-success' => 'Modèle d\'email mis à jour avec succès.',
                ],

                'events' => [
                    'create-success' => 'Événement créé avec succès.',
                    'delete-success' => 'Événement supprimé avec succès',
                    'not-found'      => 'Attention : événement introuvable.',
                    'update-success' => 'Événement mis à jour avec succès.',
                ],

                'campaigns' => [
                    'create-success' => 'Campagne créée avec succès.',
                    'delete-success' => 'Campagne supprimée avec succès',
                    'not-found'      => 'Attention : campagne introuvable.',
                    'update-success' => 'Campagne mise à jour avec succès.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Abonnement supprimé avec succès',
                    'not-found'           => 'Attention : abonnement introuvable.',
                    'unsubscribe-success' => 'Succès : désabonnement réussi.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'Réécriture d\'URL créée avec succès.',
                    'delete-success' => 'Réécriture d\'URL supprimée avec succès',
                    'not-found'      => 'Attention : réécriture d\'URL introuvable.',
                    'update-success' => 'Réécriture d\'URL mise à jour avec succès.',
                ],

                'search-terms' => [
                    'create-success' => 'Terme de recherche créé avec succès.',
                    'delete-success' => 'Terme de recherche supprimé avec succès',
                    'not-found'      => 'Attention : terme de recherche introuvable.',
                    'update-success' => 'Terme de recherche mis à jour avec succès.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Synonyme de recherche créé avec succès.',
                    'delete-success' => 'Synonyme de recherche supprimé avec succès',
                    'not-found'      => 'Attention : synonyme de recherche introuvable.',
                    'update-success' => 'Synonyme de recherche mis à jour avec succès.',
                ],

                'sitemaps' => [
                    'create-success' => 'Plan du site créé avec succès.',
                    'delete-success' => 'Plan du site supprimé avec succès',
                    'not-found'      => 'Attention : plan du site introuvable.',
                    'update-success' => 'Plan du site mis à jour avec succès.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Locale créée avec succès.',
                'default-delete-error' => 'La locale par défaut ne peut pas être supprimée.',
                'delete-error'         => 'Échec de la suppression de la locale.',
                'delete-success'       => 'Locale supprimée avec succès.',
                'last-delete-error'    => 'Échec de la suppression de la dernière locale.',
                'not-found'            => 'Avertissement : Locale non trouvée.',
                'update-success'       => 'Locale mise à jour avec succès.',
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
                'delete-success'          => 'Succès : Taux de change supprimé avec succès.',
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
                'activate-warning'  => 'Votre compte n\'est pas encore activé, veuillez contacter l\'administrateur.',
                'create-success'    => 'Utilisateur créé avec succès.',
                'delete-error'      => 'Échec de la suppression de l\'utilisateur.',
                'delete-success'    => 'Utilisateur supprimé avec succès.',
                'last-delete-error' => 'Échec de la suppression du dernier utilisateur.',
                'login-error'       => 'Veuillez vérifier vos identifiants et réessayer.',
                'not-found'         => 'Avertissement : Utilisateur non trouvé.',
                'success-login'     => 'Succès : Connexion utilisateur réussie.',
                'success-logout'    => 'Succès : Déconnexion utilisateur réussie.',
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
                        'category-not-exist'    => "L'ID de catégorie spécifié n'existe pas.",
                        'invalid-boolean-value' => 'La valeur :key doit être 0 ou 1.',
                        'invalid-filter-key'    => 'La clé du filtre ":key" n\'est pas autorisée.',
                        'invalid-limit-value'   => 'La valeur de la limite doit être l\'une des suivantes : :options.',
                        'invalid-select-option' => 'La valeur :key est invalide. Les options valides sont : :options.',
                        'invalid-sort-value'    => 'La valeur de tri doit être l\'une des suivantes : :options.',
                        'missing-limit-key'     => 'filtersInput doit inclure une clé "limit".',
                        'missing-sort-key'      => 'filtersInput doit inclure une clé "sort".',
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
                'create-success'     => 'Catégorie fiscale créée avec succès.',
                'delete-error'       => 'Échec de la suppression de la catégorie fiscale.',
                'delete-success'     => 'Catégorie fiscale supprimée avec succès.',
                'not-found'          => 'Avertissement : Catégorie fiscale non trouvée.',
                'tax-rate-not-found' => 'Les identifiants donnés ne sont pas trouvés. Identifiants : :ids',
                'update-success'     => 'Catégorie fiscale mise à jour avec succès.',
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
                        'id'                   => 'Identifiant',
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
                    'content-and-image'    => 'Contenu de la notification et image',
                    'create-btn-title'     => 'Enregistrer la notification',
                    'general'              => 'Général',
                    'image'                => 'Image',
                    'new-notification'     => 'Nouvelle notification',
                    'notification-content' => 'Contenu de la notification',
                    'notification-type'    => 'Type de notification',
                    'product-cat-id'       => 'Identifiant du produit/catégorie',
                    'settings'             => 'Paramètre',
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
                    'content-and-image'    => 'Contenu de la notification et image',
                    'edit-notification'    => 'Modifier la notification',
                    'general'              => 'Général',
                    'image'                => 'Image',
                    'notification-content' => 'Contenu de la notification',
                    'notification-type'    => 'Type de notification',
                    'product-cat-id'       => 'Identifiant du produit/catégorie',
                    'send-title'           => 'Envoyer la notification',
                    'settings'             => 'Paramètre',
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
        'configuration-error' => 'Avertissement : Configuration de l\'e-mail introuvable.',
    ],
];
