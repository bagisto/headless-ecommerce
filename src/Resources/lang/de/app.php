<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Sie sind bereits für unseren Newsletter angemeldet.',
            'subscribe-success'  => 'Sie haben sich erfolgreich für unseren Newsletter angemeldet.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Vielen Dank, dass Sie uns kontaktiert haben. Wir werden uns bald bei Ihnen melden.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Warnung: Download-Link nicht gefunden.',
                'sample-not-found' => 'Warnung: Downloadbare Probe nicht gefunden.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Warnung: Kein eingeloggter Kunde gefunden.',
            'success-login'     => 'Erfolg: Kundenlogin erfolgreich.',
            'success-logout'    => 'Erfolg: Kundenlogout erfolgreich.',

            'signup' => [
                'error-registration' => 'Warnung: Kundenregistrierung fehlgeschlagen.',
                'success-verify'     => 'Konto erfolgreich erstellt, eine E-Mail zur Verifizierung wurde gesendet.',
                'success'            => 'Erfolg: Kunde erfolgreich registriert und eingeloggt.',
            ],

            'social-login' => [
                'disabled' => 'Warnung: Social Login ist deaktiviert.',
            ],

            'login' => [
                'invalid-creds' => 'Bitte überprüfen Sie Ihre Zugangsdaten und versuchen Sie es erneut.',
                'not-activated' => 'Ihre Aktivierung erfordert die Genehmigung durch den Administrator.',
                'verify-first'  => 'Bitte überprüfen Sie zuerst Ihre E-Mail.',
                'suspended'     => 'Ihr Konto wurde vom Administrator gesperrt.',

                'validation' => [
                    'required' => 'Das Feld :field ist erforderlich.',
                    'same'     => ':field und Passwort müssen übereinstimmen.',
                    'unique'   => 'Dieses :field ist bereits vergeben.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Link zum Zurücksetzen des Passworts wurde bereits an Ihre E-Mail gesendet.',
                'email-not-exist' => 'E-Mail existiert nicht.',
                'reset-link-sent' => 'Link zum Zurücksetzen des Passworts wurde an Ihre E-Mail gesendet.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Erfolg: Kundendaten erfolgreich abgerufen.',
                    'delete-success'   => 'Erfolg: Konto erfolgreich gelöscht.',
                    'password-unmatch' => 'Passwort stimmt nicht überein.',
                    'update-fail'      => 'Warnung: Profil wurde nicht aktualisiert.',
                    'update-success'   => 'Erfolg: Profil erfolgreich aktualisiert.',
                    'wrong-password'   => 'Warnung: Falsches Passwort angegeben.',
                    'order-pending'    => 'Sie können das Konto nicht löschen, da Sie einige ausstehende Bestellungen haben.',
                ],

                'addresses' => [
                    'create-success'         => 'Adresse erfolgreich erstellt.',
                    'default-update-success' => 'Adresse als Standard festgelegt.',
                    'delete-success'         => 'Adresse erfolgreich gelöscht.',
                    'not-found'              => 'Warnung: Adresse nicht gefunden.',
                    'update-success'         => 'Adresse erfolgreich aktualisiert.',
                    'already-default'        => 'Warnung: Diese Adresse ist bereits als Standard festgelegt.',
                ],

                'wishlist' => [
                    'product-removed' => 'Warnung: Produkt nicht gefunden.',
                    'success'         => 'Erfolg: Produkt erfolgreich zur Wunschliste hinzugefügt.',
                    'already-exist'   => 'Warnung: Bereits zur Wunschliste hinzugefügt.',
                    'remove-success'  => 'Erfolg: Artikel erfolgreich von der Wunschliste entfernt.',
                    'not-found'       => 'Warnung: Keine Produkte in der Wunschliste gefunden.',
                    'moved-to-cart'   => 'Erfolg: Produkt erfolgreich in den Warenkorb verschoben.',
                ],

                'orders' => [
                    'not-found'      => 'Warnung: Keine Bestellungen gefunden.',
                    'cancel-error'   => 'Warnung: Bestellung nicht storniert.',
                    'cancel-success' => 'Erfolg: Bestellung erfolgreich storniert.',

                    'shipment' => [
                        'not-found' => 'Warnung: Versand nicht gefunden.',
                    ],

                    'invoice' => [
                        'not-found' => 'Warnung: Rechnung nicht gefunden.',
                    ],

                    'refund' => [
                        'not-found' => 'Warnung: Rückerstattung nicht gefunden.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Warnung: Herunterladbares Produkt nicht gefunden.',
                    'not-auth'       => 'Warnung: Sie sind nicht berechtigt, diese Aktion durchzuführen.',
                    'payment-error'  => 'Die Zahlung für diesen Download wurde nicht durchgeführt.',
                    'download-error' => 'Der Download-Link ist abgelaufen.',
                ],

                'gdpr' => [
                    'create-success'       => 'Erfolg: GDPR-Anfrage erfolgreich erstellt.',
                    'revoke-failed'        => 'Warnung: GDPR-Anfrage konnte nicht widerrufen werden.',
                    'revoked-successfully' => 'Erfolg: GDPR-Anfrage erfolgreich widerrufen.',
                    'not-enabled'          => 'Warnung: GDPR ist nicht aktiviert.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Warnung: Vergleichsprodukt nicht gefunden.',
                'product-not-found'   => 'Warnung: Produkt nicht gefunden.',
                'already-added'       => 'Warnung: Produkt bereits zur Vergleichsliste hinzugefügt.',
                'item-add-success'    => 'Erfolg: Produkt erfolgreich zur Vergleichsliste hinzugefügt.',
                'remove-success'      => 'Erfolg: Artikel erfolgreich aus der Vergleichsliste entfernt.',
                'mass-remove-success' => 'Erfolg: Ausgewählte Artikel erfolgreich gelöscht.',
                'not-auth'            => 'Warnung: Sie sind nicht berechtigt, diese Aktion durchzuführen.',
            ],

            'reviews' => [
                'create-success'      => 'Erfolg: Bewertung erfolgreich erstellt.',
                'delete-success'      => 'Erfolg: Bewertung erfolgreich gelöscht.',
                'mass-delete-success' => 'Erfolg: Ausgewählte Bewertungen erfolgreich gelöscht.',
                'not-found'           => 'Warnung: Bewertung nicht gefunden.',
                'product-not-found'   => 'Warnung: Produkt nicht gefunden.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Warnung: Herunterladbare Links sind nicht verfügbar.',
                        'invalid-parameter'  => 'Warnung: Ungültige Parameter angegeben.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Erfolg: Produkt erfolgreich zum Warenkorb hinzugefügt.',
                        'update-to-cart'   => 'Erfolg: Produkt im Warenkorb erfolgreich aktualisiert.',
                        'delete-cart-item' => 'Erfolg: Artikel erfolgreich aus dem Warenkorb entfernt.',
                        'all-remove'       => 'Erfolg: Alle Artikel aus dem Warenkorb entfernt.',
                        'move-to-wishlist' => 'Erfolg: Ausgewählte Artikel erfolgreich in die Wunschliste verschoben.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Warnung: Nicht alle Artikel wurden aus dem Warenkorb entfernt.',
                        'update-to-cart'   => 'Warnung: Produkt im Warenkorb nicht aktualisiert.',
                        'delete-cart-item' => 'Warnung: Artikel wurde nicht aus dem Warenkorb entfernt.',
                        'not-found'        => 'Warnung: Warenkorb nicht gefunden.',
                        'item-not-found'   => 'Warnung: Artikel nicht gefunden.',
                        'move-to-wishlist' => 'Warnung: Ausgewählte Artikel wurden nicht in die Wunschliste verschoben.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Warnung: Gastbenutzer können keine Adresse hinzufügen.',
                'guest-checkout-warning'    => 'Warnung: Gastbenutzer können nicht zur Kasse gehen.',
                'no-billing-address-found'  => 'Warnung: Keine Rechnungsadresse gefunden.',
                'no-shipping-address-found' => 'Warnung: Keine Lieferadresse gefunden.',
                'address-save-success'      => 'Erfolg: Adresse erfolgreich gespeichert.',
            ],

            'shipping' => [
                'method-not-found' => 'Warnung: Versandmethode nicht gefunden.',
                'method-fetched'   => 'Erfolg: Versandmethode erfolgreich abgerufen.',
                'save-failed'      => 'Warnung: Versandmethode nicht gespeichert.',
                'save-success'     => 'Erfolg: Versandmethode erfolgreich gespeichert.',
            ],

            'payment' => [
                'method-not-found' => 'Warnung: Zahlungsmethode nicht gefunden.',
                'method-fetched'   => 'Erfolg: Zahlungsmethode erfolgreich abgerufen.',
                'save-failed'      => 'Warnung: Zahlungsmethode nicht gespeichert.',
                'save-success'     => 'Erfolg: Zahlungsmethode erfolgreich gespeichert.',
            ],

            'coupon' => [
                'apply-success'   => 'Erfolg: Gutscheincode erfolgreich angewendet.',
                'already-applied' => 'Warnung: Gutscheincode bereits angewendet.',
                'invalid-code'    => 'Warnung: Gutscheincode ist ungültig.',
                'remove-success'  => 'Erfolg: Gutscheincode erfolgreich entfernt.',
                'remove-failed'   => 'Warnung: Gutscheincode wurde nicht entfernt.',
            ],

            'something-wrong'          => 'Warnung: Etwas ist schiefgelaufen.',
            'invalid-guest-user'       => 'Warnung: Ungültiger Gastbenutzer.',
            'empty-cart'               => 'Warnung: Warenkorb ist leer.',
            'missing-billing-address'  => 'Warnung: Fehlende Rechnungsadresse.',
            'missing-shipping-address' => 'Warnung: Fehlende Lieferadresse.',
            'missing-shipping-method'  => 'Warnung: Fehlende Versandmethode.',
            'missing-payment-method'   => 'Warnung: Fehlende Zahlungsmethode.',
            'no-address-found'         => 'Warnung: Keine Rechnungs- und Lieferadresse gefunden.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Erstellen',
            'delete'            => 'Löschen',
            'edit'              => 'Bearbeiten',
            'mass-delete'       => 'Massenlöschung',
            'mass-update'       => 'Massenaktualisierung',
            'push-notification' => 'Push-Benachrichtigung',
            'send'              => 'Senden',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Push-Benachrichtigung',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Benachrichtigungsthema',
                        'info'                            => 'Benachrichtigungsbezogene Konfigurationen',
                        'push-notification-configuration' => 'FCM Push-Benachrichtigungskonfiguration',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Inhalt der privaten Schlüssel-JSON-Datei',
                        'info-get-private-key'            => 'Info: Um den privaten Schlüsselinhalt der FCM-JSON-Datei zu erhalten: <a href="https://console.firebase.google.com/" target="_blank">Hier klicken</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Erfolg: Benutzerdefinierte Skripte erfolgreich aktualisiert.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Warnung: Bestellung kann nicht storniert werden.',
                'cancel-success' => 'Erfolg: Bestellung erfolgreich storniert.',
                'not-found'      => 'Warnung: Bestellung nicht gefunden.',
            ],

            'shipments' => [
                'creation-error'   => 'Warnung: Lieferung nicht erstellt.',
                'not-found'        => 'Warnung: Lieferung nicht gefunden.',
                'quantity-invalid' => 'Warnung: Ungültige Menge angegeben.',
                'shipment-error'   => 'Warnung: Lieferung nicht erstellt.',
                'create-success'   => 'Erfolg: Lieferung erfolgreich erstellt.',
            ],

            'invoices' => [
                'creation-error' => 'Warnung: Rechnung nicht erstellt.',
                'not-found'      => 'Warnung: Rechnung nicht gefunden.',
                'product-error'  => 'Warnung: Ungültiges Produkt angegeben.',
                'create-success' => 'Erfolg: Rechnung erfolgreich erstellt.',
                'invalid-qty'    => 'Warnung: Es wurde eine ungültige Menge für Rechnungsartikel gefunden.',
            ],

            'refunds' => [
                'creation-error'      => 'Warnung: Rückerstattung nicht erstellt.',
                'refund-amount-error' => 'Warnung: Ungültiger Rückerstattungsbetrag angegeben.',
                'refund-limit-error'  => 'Warnung: Rückerstattungsbetrag überschreitet das Limit von :amount',
                'not-found'           => 'Warnung: Rückerstattung nicht gefunden.',
                'create-success'      => 'Erfolg: Rückerstattung erfolgreich erstellt.',
            ],

            'transactions' => [
                'already-paid'   => 'Warnung: Rechnung ist bereits bezahlt.',
                'amount-exceed'  => 'Warnung: Transaktionsbetrag überschreitet das Limit.',
                'zero-amount'    => 'Warnung: Transaktionsbetrag sollte größer als Null sein.',
                'create-success' => 'Erfolg: Transaktion erfolgreich erstellt.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Warnung: Kunde nicht gefunden.',
                'cart-not-found'           => 'Warnung: Warenkorb nicht gefunden.',
                'cart-item-not-found'      => 'Warnung: Warenkorb-Artikel nicht gefunden.',
                'cart-create-success'      => 'Erfolg: Warenkorb erfolgreich erstellt.',
                'cart-item-add-success'    => 'Erfolg: Produkt erfolgreich zum Warenkorb hinzugefügt.',
                'cart-item-remove-success' => 'Erfolg: Artikel wurde erfolgreich aus dem Warenkorb entfernt.',
                'cart-item-update-success' => 'Erfolg: Produkt erfolgreich im Warenkorb aktualisiert.',
                'something-wrong'          => 'Warnung: Etwas ist schiefgelaufen.',
                'address-save-success'     => 'Erfolg: Adresse erfolgreich gespeichert.',
                'shipping-save-success'    => 'Erfolg: Versandmethode erfolgreich gespeichert.',
                'payment-save-success'     => 'Erfolg: Zahlungsmethode erfolgreich gespeichert.',
                'order-placed-success'     => 'Erfolg: Bestellung erfolgreich aufgegeben.',
                'payment-method-not-found' => 'Warnung: Zahlungsmethode nicht gefunden.',
                'minimum-order-amount-err' => 'Warnung: Der Mindestbestellbetrag sollte :amount betragen.',
                'check-shipping-address'   => 'Warnung: Bitte überprüfen Sie die Lieferadresse.',
                'check-billing-address'    => 'Warnung: Bitte überprüfen Sie die Rechnungsadresse.',
                'specify-shipping-method'  => 'Warnung: Bitte geben Sie die Versandmethode an.',
                'specify-payment-method'   => 'Warnung: Bitte geben Sie die Zahlungsmethode an.',
                'coupon-not-valid'         => 'Warnung: Gutscheincode ist ungültig.',
                'coupon-already-applied'   => 'Warnung: Gutscheincode bereits angewendet.',
                'coupon-applied'           => 'Erfolg: Gutscheincode erfolgreich angewendet.',
                'coupon-removed'           => 'Erfolg: Gutscheincode erfolgreich entfernt.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Produkt erfolgreich erstellt.',
                'delete-success'            => 'Produkt erfolgreich gelöscht.',
                'not-found'                 => 'Warnung: Produkt nicht gefunden.',
                'update-success'            => 'Produkt erfolgreich aktualisiert.',
                'configurable-attr-missing' => 'Warnung: Konfigurierbares Attribut fehlt.',
                'simple-products-error'     => 'Warnung: Einfache Produkte fehlen.',
            ],

            'categories' => [
                'already-taken'  => 'Warnung: Der Slug ist bereits vergeben.',
                'create-success' => 'Kategorie erfolgreich erstellt.',
                'delete-success' => 'Kategorie erfolgreich gelöscht.',
                'not-found'      => 'Warnung: Kategorie nicht gefunden.',
                'update-success' => 'Kategorie erfolgreich aktualisiert.',
                'root-delete'    => 'Warnung: Die Hauptkategorie kann nicht gelöscht werden.',
            ],

            'attributes' => [
                'create-success'    => 'Attribut erfolgreich erstellt.',
                'delete-success'    => 'Attribut erfolgreich gelöscht.',
                'not-found'         => 'Warnung: Attribut nicht gefunden.',
                'update-success'    => 'Attribut erfolgreich aktualisiert.',
                'user-define-error' => 'Warnung: Sie sind nicht berechtigt, ein systemerstelltes Attribut zu löschen.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Attributgruppe erfolgreich erstellt.',
                'delete-success'    => 'Attributgruppe erfolgreich gelöscht.',
                'not-found'         => 'Warnung: Attributgruppe nicht gefunden.',
                'update-success'    => 'Attributgruppe erfolgreich aktualisiert.',
                'user-define-error' => 'Warnung: Sie sind nicht berechtigt, eine systemerstellte Attributgruppe zu löschen.',
            ],

            'attribute-families' => [
                'create-success'          => 'Attributfamilie erfolgreich erstellt.',
                'delete-success'          => 'Attributfamilie erfolgreich gelöscht.',
                'not-found'               => 'Warnung: Attributfamilie nicht gefunden.',
                'update-success'          => 'Attributfamilie erfolgreich aktualisiert.',
                'last-delete-error'       => 'Warnung: Die letzte Attributfamilie kann nicht gelöscht werden.',
                'attribute-product-error' => 'Warnung: Einige Produkte sind mit dieser Attributfamilie verbunden.',
                'user-define-error'       => 'Warnung: Sie sind nicht berechtigt, eine systemerstellte Attributfamilie zu löschen.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Kunde erfolgreich erstellt.',
                'delete-order-pending' => 'Kundenkonto kann nicht gelöscht werden, da einige Bestellungen noch ausstehen oder in Bearbeitung sind.',
                'delete-success'       => 'Kunde erfolgreich gelöscht.',
                'not-found'            => 'Warnung: Kunde nicht gefunden.',
                'note-created-success' => 'Notiz erfolgreich erstellt.',
                'update-success'       => 'Kunde erfolgreich aktualisiert.',
                'login-success'        => 'Kunde erfolgreich eingeloggt.',
            ],

            'addresses' => [
                'create-success'         => 'Kundenadresse erfolgreich erstellt.',
                'default-update-success' => 'Adresse wurde als Standard festgelegt.',
                'delete-success'         => 'Kundenadresse erfolgreich gelöscht.',
                'not-found'              => 'Warnung: Kundenadresse nicht gefunden.',
                'update-success'         => 'Kundenadresse erfolgreich aktualisiert.',
                'already-default'        => 'Warnung: Diese Adresse ist bereits als Standard festgelegt.',
            ],

            'groups' => [
                'create-success'     => 'Kundengruppe erfolgreich erstellt.',
                'customer-associate' => 'Warnung: Gruppe kann nicht gelöscht werden. Kunde ist mit ihr verbunden.',
                'delete-success'     => 'Kundengruppe erfolgreich gelöscht.',
                'not-found'          => 'Warnung: Kundengruppe nicht gefunden.',
                'update-success'     => 'Kundengruppe erfolgreich aktualisiert.',
                'user-define-error'  => 'Warnung: Sie sind nicht berechtigt, eine systemerstellte Kundengruppe zu löschen.',
            ],

            'reviews' => [
                'delete-success' => 'Bewertung erfolgreich gelöscht.',
                'not-found'      => 'Warnung: Bewertung nicht gefunden.',
                'update-success' => 'Bewertung erfolgreich aktualisiert.',
            ],

            'gdpr' => [
                'delete-success' => 'Erfolg: GDPR-Anfrage erfolgreich gelöscht.',
                'not-found'      => 'Warnung: GDPR-Anfrage nicht gefunden.',
                'update-success' => 'GDPR-Anfrage erfolgreich aktualisiert.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Warnung: Der Slug ist bereits vergeben.',
            'create-success' => 'CMS erfolgreich erstellt.',
            'delete-success' => 'CMS erfolgreich gelöscht.',
            'not-found'      => 'Warnung: CMS nicht gefunden.',
            'update-success' => 'CMS erfolgreich aktualisiert.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Katalogregel erfolgreich erstellt.',
                    'delete-failed'  => 'Warnung: Katalogregel wurde nicht gelöscht.',
                    'delete-success' => 'Katalogregel erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: Katalogregel nicht gefunden.',
                    'update-success' => 'Katalogregel erfolgreich aktualisiert.',
                ],

                'cart-rules' => [
                    'create-success' => 'Warenkorbregel erfolgreich erstellt.',
                    'delete-failed'  => 'Warnung: Warenkorbregel wurde nicht gelöscht.',
                    'delete-success' => 'Warenkorbregel erfolgreich gelöscht.',
                    'not-found'      => 'Warenkorbregel nicht gefunden.',
                    'update-success' => 'Warenkorbregel erfolgreich aktualisiert.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'E-Mail-Vorlage erfolgreich erstellt.',
                    'delete-success' => 'E-Mail-Vorlage erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: E-Mail-Vorlage nicht gefunden.',
                    'update-success' => 'E-Mail-Vorlage erfolgreich aktualisiert.',
                ],

                'events' => [
                    'create-success' => 'Ereignis erfolgreich erstellt.',
                    'delete-success' => 'Ereignis erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: Ereignis nicht gefunden.',
                    'update-success' => 'Ereignis erfolgreich aktualisiert.',
                ],

                'campaigns' => [
                    'create-success' => 'Kampagne erfolgreich erstellt.',
                    'delete-success' => 'Kampagne erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: Kampagne nicht gefunden.',
                    'update-success' => 'Kampagne erfolgreich aktualisiert.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Abonnement erfolgreich gelöscht.',
                    'not-found'           => 'Warnung: Abonnement nicht gefunden.',
                    'unsubscribe-success' => 'Erfolg: Abonnement erfolgreich abbestellt.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL-Umschreibung erfolgreich erstellt.',
                    'delete-success' => 'URL-Umschreibung erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: URL-Umschreibung nicht gefunden.',
                    'update-success' => 'URL-Umschreibung erfolgreich aktualisiert.',
                ],

                'search-terms' => [
                    'create-success' => 'Suchbegriff erfolgreich erstellt.',
                    'delete-success' => 'Suchbegriff erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: Suchbegriff nicht gefunden.',
                    'update-success' => 'Suchbegriff erfolgreich aktualisiert.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Suchsynonym erfolgreich erstellt.',
                    'delete-success' => 'Suchsynonym erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: Suchsynonym nicht gefunden.',
                    'update-success' => 'Suchsynonym erfolgreich aktualisiert.',
                ],

                'sitemaps' => [
                    'create-success' => 'Sitemap erfolgreich erstellt.',
                    'delete-success' => 'Sitemap erfolgreich gelöscht.',
                    'not-found'      => 'Warnung: Sitemap nicht gefunden.',
                    'update-success' => 'Sitemap erfolgreich aktualisiert.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Sprache erfolgreich erstellt.',
                'default-delete-error' => 'Die Standardsprache kann nicht gelöscht werden.',
                'delete-error'         => 'Löschen der Sprache fehlgeschlagen.',
                'delete-success'       => 'Sprache erfolgreich gelöscht.',
                'last-delete-error'    => 'Löschen der letzten Sprache fehlgeschlagen.',
                'not-found'            => 'Warnung: Sprache nicht gefunden.',
                'update-success'       => 'Sprache erfolgreich aktualisiert.',
            ],

            'currencies' => [
                'create-success'       => 'Währung erfolgreich erstellt.',
                'default-delete-error' => 'Die Standardwährung kann nicht gelöscht werden.',
                'delete-error'         => 'Löschen der Währung fehlgeschlagen.',
                'delete-success'       => 'Währung erfolgreich gelöscht.',
                'last-delete-error'    => 'Löschen der letzten Währung fehlgeschlagen.',
                'not-found'            => 'Warnung: Währung nicht gefunden.',
                'update-success'       => 'Währung erfolgreich aktualisiert.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Wechselkurs erfolgreich erstellt.',
                'delete-error'            => 'Löschen des Wechselkurses fehlgeschlagen.',
                'delete-success'          => 'Wechselkurs erfolgreich gelöscht.',
                'invalid-target-currency' => 'Warnung: Ungültige Zielwährung angegeben.',
                'last-delete-error'       => 'Löschen des letzten Wechselkurses fehlgeschlagen.',
                'not-found'               => 'Warnung: Wechselkurs nicht gefunden.',
                'update-success'          => 'Wechselkurs erfolgreich aktualisiert.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Inventarquelle erfolgreich erstellt.',
                'delete-error'      => 'Löschen der Inventarquelle fehlgeschlagen.',
                'delete-success'    => 'Inventarquelle erfolgreich gelöscht.',
                'last-delete-error' => 'Löschen der letzten Inventarquelle fehlgeschlagen.',
                'not-found'         => 'Warnung: Inventarquelle nicht gefunden.',
                'update-success'    => 'Inventarquelle erfolgreich aktualisiert.',
            ],

            'channels' => [
                'create-success'       => 'Kanal erfolgreich erstellt.',
                'default-delete-error' => 'Standardkanal kann nicht gelöscht werden.',
                'delete-error'         => 'Löschen des Kanals fehlgeschlagen.',
                'delete-success'       => 'Kanal erfolgreich gelöscht.',
                'last-delete-error'    => 'Löschen des letzten Kanals fehlgeschlagen.',
                'not-found'            => 'Warnung: Kanal nicht gefunden.',
                'update-success'       => 'Kanal erfolgreich aktualisiert.',
            ],

            'users' => [
                'activate-warning'  => 'Ihr Konto ist noch nicht aktiviert, bitte kontaktieren Sie den Administrator.',
                'create-success'    => 'Benutzer erfolgreich erstellt.',
                'delete-error'      => 'Löschen des Benutzers fehlgeschlagen.',
                'delete-success'    => 'Benutzer erfolgreich gelöscht.',
                'last-delete-error' => 'Löschen des letzten Benutzers fehlgeschlagen.',
                'login-error'       => 'Bitte überprüfen Sie Ihre Anmeldedaten und versuchen Sie es erneut.',
                'not-found'         => 'Warnung: Benutzer nicht gefunden.',
                'success-login'     => 'Benutzer erfolgreich eingeloggt.',
                'success-logout'    => 'Benutzer erfolgreich ausgeloggt.',
                'update-success'    => 'Benutzer erfolgreich aktualisiert.',
            ],

            'roles' => [
                'create-success'    => 'Rolle erfolgreich erstellt.',
                'delete-error'      => 'Löschen der Rolle fehlgeschlagen.',
                'delete-success'    => 'Rolle erfolgreich gelöscht.',
                'last-delete-error' => 'Die letzte Rolle kann nicht gelöscht werden.',
                'not-found'         => 'Warnung: Rolle nicht gefunden.',
                'update-success'    => 'Rolle erfolgreich aktualisiert.',
            ],

            'themes' => [
                'create-success' => 'Theme erfolgreich erstellt.',
                'delete-success' => 'Theme erfolgreich gelöscht.',
                'not-found'      => 'Warnung: Theme nicht gefunden.',
                'update-success' => 'Theme erfolgreich aktualisiert.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'Die angegebene category_id existiert nicht.',
                        'invalid-boolean-value' => 'Der Wert für :key muss entweder 0 oder 1 sein.',
                        'invalid-filter-key'    => 'Der Filter-Schlüssel ":key" ist nicht erlaubt.',
                        'invalid-limit-value'   => 'Der Limit-Wert muss einer der folgenden sein: :options.',
                        'invalid-select-option' => 'Der Wert :key ist ungültig. Gültige Optionen sind: :options.',
                        'invalid-sort-value'    => 'Der Sortierwert muss einer der folgenden sein: :options.',
                        'missing-limit-key'     => 'filtersInput muss einen "limit"-Schlüssel enthalten.',
                        'missing-sort-key'      => 'filtersInput muss einen "sort"-Schlüssel enthalten.',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Steuersatz erfolgreich erstellt.',
                'delete-error'   => 'Löschen des Steuersatzes fehlgeschlagen.',
                'delete-success' => 'Steuersatz erfolgreich gelöscht.',
                'not-found'      => 'Warnung: Steuersatz nicht gefunden.',
                'update-success' => 'Steuersatz erfolgreich aktualisiert.',
            ],

            'tax-category' => [
                'create-success'     => 'Steuerkategorie erfolgreich erstellt.',
                'delete-error'       => 'Löschen der Steuerkategorie fehlgeschlagen.',
                'delete-success'     => 'Steuerkategorie erfolgreich gelöscht.',
                'not-found'          => 'Warnung: Steuerkategorie nicht gefunden.',
                'tax-rate-not-found' => 'Die angegebenen IDs wurden nicht gefunden. IDs: :ids',
                'update-success'     => 'Steuerkategorie erfolgreich aktualisiert.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Benachrichtigung hinzufügen',
                    'general'   => 'Allgemein',
                    'title'     => 'Push-Benachrichtigung',

                    'datagrid' => [
                        'channel-name'         => 'Kanalname',
                        'created-at'           => 'Erstellungszeit',
                        'delete'               => 'Löschen',
                        'id'                   => 'ID',
                        'image'                => 'Bild',
                        'notification-content' => 'Benachrichtigungsinhalt',
                        'notification-status'  => 'Benachrichtigungsstatus',
                        'notification-type'    => 'Benachrichtigungstyp',
                        'text-title'           => 'Titel',
                        'update'               => 'Aktualisieren',
                        'updated-at'           => 'Aktualisierungszeit',

                        'status' => [
                            'disabled' => 'Deaktiviert',
                            'enabled'  => 'Aktiviert',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Zurück',
                    'content-and-image'    => 'Benachrichtigungsinhalt und Bild',
                    'create-btn-title'     => 'Benachrichtigung speichern',
                    'general'              => 'Allgemein',
                    'image'                => 'Bild',
                    'new-notification'     => 'Neue Benachrichtigung',
                    'notification-content' => 'Benachrichtigungsinhalt',
                    'notification-type'    => 'Benachrichtigungstyp',
                    'product-cat-id'       => 'Produkt-/Kategorie-ID',
                    'settings'             => 'Einstellung',
                    'status'               => 'Status',
                    'store-view'           => 'Kanäle',
                    'title'                => 'Push-Benachrichtigung',

                    'option-type' => [
                        'category' => 'Kategorie',
                        'others'   => 'Einfach',
                        'product'  => 'Produkt',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Zurück',
                    'content-and-image'    => 'Benachrichtigungsinhalt und Bild',
                    'edit-notification'    => 'Benachrichtigung bearbeiten',
                    'general'              => 'Allgemein',
                    'image'                => 'Bild',
                    'notification-content' => 'Benachrichtigungsinhalt',
                    'notification-type'    => 'Benachrichtigungstyp',
                    'product-cat-id'       => 'Produkt-/Kategorie-ID',
                    'send-title'           => 'Benachrichtigung senden',
                    'settings'             => 'Einstellung',
                    'status'               => 'Status',
                    'store-view'           => 'Kanäle',
                    'title'                => 'Push-Benachrichtigung',
                    'update-btn-title'     => 'Aktualisieren',

                    'option-type' => [
                        'category' => 'Kategorie',
                        'others'   => 'Einfach',
                        'product'  => 'Produkt',
                    ],
                ],

                'not-found'           => 'Warnung: Benachrichtigung nicht gefunden.',
                'create-success'      => 'Benachrichtigung erfolgreich erstellt.',
                'delete-failed'       => 'Löschen der Benachrichtigung fehlgeschlagen.',
                'delete-success'      => 'Benachrichtigung erfolgreich gelöscht.',
                'mass-update-success' => 'Ausgewählte Benachrichtigungen erfolgreich aktualisiert.',
                'mass-delete-success' => 'Ausgewählte Benachrichtigungen erfolgreich gelöscht.',
                'no-value-selected'   => 'Es sind keine Werte vorhanden.',
                'send-success'        => 'Benachrichtigung erfolgreich gesendet.',
                'update-success'      => 'Benachrichtigung erfolgreich aktualisiert.',
                'configuration-error' => 'Warnung: FCM-Konfiguration nicht gefunden.',
                'product-not-found'   => 'Warnung: Produkt nicht gefunden.',
                'category-not-found'  => 'Warnung: Kategorie nicht gefunden.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Warnung: Ungültige Parameter angegeben.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Warnung: E-Mail-Konfiguration nicht gefunden.',
    ],
];
