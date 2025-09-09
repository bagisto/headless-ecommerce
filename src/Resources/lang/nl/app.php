<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'U bent al geabonneerd op onze nieuwsbrief.',
            'subscribe-success'  => 'U bent succesvol geabonneerd op onze nieuwsbrief.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Bedankt dat je contact met ons hebt opgenomen. We nemen snel contact met je op.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Waarschuwing: Downloadlink niet gevonden.',
                'sample-not-found' => 'Waarschuwing: Downloadbaar voorbeeld niet gevonden.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Let op: Geen ingelogde klant gevonden.',
            'success-login'     => 'Succes: Klant succesvol ingelogd.',
            'success-logout'    => 'Succes: Klant succesvol uitgelogd.',

            'signup' => [
                'error-registration' => 'Let op: Klantregistratie mislukt.',
                'success-verify'     => 'Account succesvol aangemaakt, een verificatie-e-mail is verzonden.',
                'success'            => 'Succes: Klant succesvol geregistreerd en ingelogd.',
            ],

            'social-login' => [
                'disabled' => 'Waarschuwing: Sociale login is uitgeschakeld.',
            ],

            'login' => [
                'invalid-creds' => 'Controleer je gegevens en probeer opnieuw.',
                'not-activated' => 'Je activatie vereist goedkeuring van de beheerder.',
                'verify-first'  => 'Verifieer eerst je e-mail.',
                'suspended'     => 'Je account is geschorst door de beheerder.',

                'validation' => [
                    'required' => 'Het veld :field is verplicht.',
                    'same'     => 'Het veld :field en het wachtwoord moeten overeenkomen.',
                    'unique'   => 'Dit :field is al in gebruik.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Wachtwoordherstel link is al naar je e-mail verzonden.',
                'email-not-exist' => 'Het e-mailadres bestaat niet.',
                'reset-link-sent' => 'Wachtwoordherstel link is naar je e-mail verzonden.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Succes: Klantgegevens succesvol opgehaald.',
                    'delete-success'   => 'Succes: Account succesvol verwijderd.',
                    'password-unmatch' => 'Wachtwoord komt niet overeen.',
                    'update-fail'      => 'Waarschuwing: Profiel is niet bijgewerkt.',
                    'update-success'   => 'Succes: Profiel succesvol bijgewerkt.',
                    'wrong-password'   => 'Waarschuwing: Onjuist wachtwoord opgegeven.',
                    'order-pending'    => 'U kunt het account niet verwijderen omdat u nog enkele openstaande bestellingen heeft.',
                ],

                'addresses' => [
                    'create-success'         => 'Adres succesvol aangemaakt.',
                    'default-update-success' => 'Het adres is ingesteld als standaard.',
                    'delete-success'         => 'Adres succesvol verwijderd.',
                    'not-found'              => 'Let op: Adres niet gevonden.',
                    'update-success'         => 'Adres succesvol bijgewerkt.',
                    'already-default'        => 'Waarschuwing: Dit adres is al ingesteld als standaard.',
                ],

                'wishlist' => [
                    'product-removed' => 'Let op: Product niet gevonden.',
                    'success'         => 'Succes: Product succesvol aan de verlanglijst toegevoegd.',
                    'already-exist'   => 'Let op: Al toegevoegd aan de verlanglijst.',
                    'remove-success'  => 'Succes: Item succesvol van de verlanglijst verwijderd.',
                    'not-found'       => 'Let op: Geen product gevonden op de verlanglijst.',
                    'moved-to-cart'   => 'Succes: Product succesvol verplaatst naar de winkelwagen.',
                ],

                'orders' => [
                    'not-found'      => 'Let op: Geen bestelling gevonden.',
                    'cancel-error'   => 'Let op: Bestelling niet geannuleerd.',
                    'cancel-success' => 'Succes: Bestelling succesvol geannuleerd.',

                    'shipment' => [
                        'not-found' => 'Let op: Verzending niet gevonden.',
                    ],

                    'invoice' => [
                        'not-found' => 'Let op: Factuur niet gevonden.',
                    ],

                    'refund' => [
                        'not-found' => 'Let op: Terugbetaling niet gevonden.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Let op: Downloadbaar product niet gevonden.',
                    'not-auth'       => 'Let op: Je bent niet gemachtigd om deze actie uit te voeren.',
                    'payment-error'  => 'De betaling is niet voltooid voor deze download.',
                    'download-error' => 'De downloadlink is verlopen.',
                ],

                'gdpr' => [
                    'create-success'       => 'Succes: GDPR-verzoek succesvol aangemaakt.',
                    'revoke-failed'        => 'Waarschuwing: GDPR-verzoek niet ingetrokken.',
                    'revoked-successfully' => 'Succes: GDPR-verzoek succesvol ingetrokken.',
                    'not-enabled'          => 'Waarschuwing: GDPR is niet ingeschakeld.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Waarschuwing: Vergelijkingsproduct niet gevonden.',
                'product-not-found'   => 'Waarschuwing: Product niet gevonden.',
                'already-added'       => 'Waarschuwing: Product is al toegevoegd aan de vergelijkingslijst.',
                'item-add-success'    => 'Succes: Product succesvol toegevoegd aan de vergelijkingslijst.',
                'remove-success'      => 'Succes: Item is succesvol verwijderd uit de vergelijkingslijst.',
                'mass-remove-success' => 'Succes: Geselecteerde items succesvol verwijderd.',
                'not-auth'            => 'Waarschuwing: U bent niet gemachtigd om deze actie uit te voeren.',
            ],

            'reviews' => [
                'create-success'      => 'Succes: Recensie succesvol aangemaakt.',
                'delete-success'      => 'Succes: Recensie succesvol verwijderd.',
                'mass-delete-success' => 'Succes: Geselecteerde recensies succesvol verwijderd.',
                'not-found'           => 'Let op: Recensie niet gevonden.',
                'product-not-found'   => 'Waarschuwing: Product niet gevonden.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Let op: Downloadbare links zijn niet beschikbaar.',
                        'invalid-parameter'  => 'Let op: Ongeldige parameters verstrekt.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Succes: Product succesvol aan de winkelwagen toegevoegd.',
                        'update-to-cart'   => 'Succes: Product succesvol bijgewerkt in de winkelwagen.',
                        'delete-cart-item' => 'Succes: Item succesvol uit de winkelwagen verwijderd.',
                        'all-remove'       => 'Succes: Alle items uit de winkelwagen verwijderd.',
                        'move-to-wishlist' => 'Succes: Geselecteerde items succesvol verplaatst naar de verlanglijst.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Let op: Alle items niet uit de winkelwagen verwijderd.',
                        'update-to-cart'   => 'Let op: Product niet bijgewerkt in de winkelwagen.',
                        'delete-cart-item' => 'Let op: Item niet uit de winkelwagen verwijderd.',
                        'not-found'        => 'Let op: Winkelwagen niet gevonden.',
                        'item-not-found'   => 'Let op: Item niet gevonden.',
                        'move-to-wishlist' => 'Let op: Geselecteerde items niet verplaatst naar de verlanglijst.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Let op: Gasten kunnen geen adressen toevoegen.',
                'guest-checkout-warning'    => 'Let op: Gasten kunnen niet afrekenen.',
                'no-billing-address-found'  => 'Let op: Geen factuuradres gevonden.',
                'no-shipping-address-found' => 'Let op: Geen verzendadres gevonden.',
                'address-save-success'      => 'Succes: Adres succesvol opgeslagen.',
            ],

            'shipping' => [
                'method-not-found' => 'Let op: Verzendmethode niet gevonden.',
                'method-fetched'   => 'Succes: Verzendmethode succesvol opgehaald.',
                'save-failed'      => 'Let op: Verzendmethode niet opgeslagen.',
                'save-success'     => 'Succes: Verzendmethode succesvol opgeslagen.',
            ],

            'payment' => [
                'method-not-found' => 'Let op: Betalingsmethode niet gevonden.',
                'method-fetched'   => 'Succes: Betalingsmethode succesvol opgehaald.',
                'save-failed'      => 'Let op: Betalingsmethode niet opgeslagen.',
                'save-success'     => 'Succes: Betalingsmethode succesvol opgeslagen.',
            ],

            'coupon' => [
                'apply-success'   => 'Succes: Couponcode succesvol toegepast.',
                'already-applied' => 'Let op: Couponcode al toegepast.',
                'invalid-code'    => 'Let op: Ongeldige couponcode.',
                'remove-success'  => 'Succes: Couponcode succesvol verwijderd.',
                'remove-failed'   => 'Let op: Couponcode niet verwijderd.',
            ],

            'something-wrong'          => 'Let op: Er is iets misgegaan.',
            'invalid-guest-user'       => 'Let op: Ongeldige gastgebruiker.',
            'empty-cart'               => 'Let op: De winkelwagen is leeg.',
            'missing-billing-address'  => 'Let op: Ontbrekend factuuradres.',
            'missing-shipping-address' => 'Let op: Ontbrekend verzendadres.',
            'missing-shipping-method'  => 'Let op: Ontbrekende verzendmethode.',
            'missing-payment-method'   => 'Let op: Ontbrekende betalingsmethode.',
            'no-address-found'         => 'Let op: Geen factuur- en verzendadres gevonden.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Maak aan',
            'delete'            => 'Verwijder',
            'edit'              => 'Bewerk',
            'mass-delete'       => 'Bulkverwijdering',
            'mass-update'       => 'Bulkuptate',
            'push-notification' => 'Pushmelding',
            'send'              => 'Verstuur',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Pushmelding',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Meldingsonderwerp',
                        'info'                            => 'Meldingsgerelateerde configuraties',
                        'push-notification-configuration' => 'FCM-pushmeldingsconfiguratie',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Privésleutel JSON-bestandsinhoud',
                        'info-get-private-key'            => 'Info: Om de inhoud van het privésleutel JSON-bestand van FCM te krijgen: <a href="https://console.firebase.google.com/" target="_blank">Klik hier</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Succes: Aangepaste scripts succesvol bijgewerkt.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Waarschuwing: De bestelling kan niet worden geannuleerd.',
                'cancel-success' => 'Succes: Bestelling succesvol geannuleerd.',
                'not-found'      => 'Waarschuwing: Bestelling niet gevonden.',
            ],

            'shipments' => [
                'creation-error'   => 'Waarschuwing: Verzending niet aangemaakt.',
                'not-found'        => 'Waarschuwing: Verzending niet gevonden.',
                'quantity-invalid' => 'Waarschuwing: Ongeldige hoeveelheid opgegeven.',
                'shipment-error'   => 'Waarschuwing: Verzending niet aangemaakt.',
                'create-success'   => 'Succes: Verzending succesvol aangemaakt.',
            ],

            'invoices' => [
                'creation-error' => 'Waarschuwing: Factuur niet aangemaakt.',
                'not-found'      => 'Waarschuwing: Factuur niet gevonden.',
                'product-error'  => 'Waarschuwing: Ongeldig product opgegeven.',
                'create-success' => 'Succes: Factuur succesvol aangemaakt.',
                'invalid-qty'    => 'Waarschuwing: We hebben een ongeldige hoeveelheid gevonden om factuuritems te factureren.',
            ],

            'refunds' => [
                'creation-error'      => 'Waarschuwing: Terugbetaling niet aangemaakt.',
                'refund-amount-error' => 'Waarschuwing: Ongeldig terugbetalingsbedrag opgegeven.',
                'refund-limit-error'  => 'Waarschuwing: Het terugbetalingsbedrag overschrijdt de limiet van :amount',
                'not-found'           => 'Waarschuwing: Terugbetaling niet gevonden.',
                'create-success'      => 'Succes: Terugbetaling succesvol aangemaakt.',
            ],

            'transactions' => [
                'already-paid'   => 'Waarschuwing: De factuur is al betaald.',
                'amount-exceed'  => 'Waarschuwing: Het transactiebedrag overschrijdt de limiet.',
                'zero-amount'    => 'Waarschuwing: Het transactiebedrag moet groter zijn dan nul.',
                'create-success' => 'Succes: Transactie succesvol aangemaakt.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Waarschuwing: Klant niet gevonden.',
                'cart-not-found'           => 'Waarschuwing: Winkelwagentje niet gevonden.',
                'cart-item-not-found'      => 'Waarschuwing: Winkelwagentje-item niet gevonden.',
                'cart-create-success'      => 'Succes: Winkelwagentje succesvol aangemaakt.',
                'cart-item-add-success'    => 'Succes: Product succesvol toegevoegd aan het winkelwagentje.',
                'cart-item-remove-success' => 'Succes: Item succesvol verwijderd uit het winkelwagentje.',
                'cart-item-update-success' => 'Succes: Product succesvol bijgewerkt in het winkelwagentje.',
                'something-wrong'          => 'Waarschuwing: Er is iets mis gegaan.',
                'address-save-success'     => 'Succes: Adres succesvol opgeslagen.',
                'shipping-save-success'    => 'Succes: Verzendingmethode succesvol opgeslagen.',
                'payment-save-success'     => 'Succes: Betalingsmethode succesvol opgeslagen.',
                'order-placed-success'     => 'Succes: Bestelling succesvol geplaatst.',
                'payment-method-not-found' => 'Waarschuwing: Betalingsmethode niet gevonden.',
                'minimum-order-amount-err' => 'Waarschuwing: Het minimale bestelbedrag moet :amount zijn',
                'check-shipping-address'   => 'Waarschuwing: Controleer het verzendadres.',
                'check-billing-address'    => 'Waarschuwing: Controleer het factuuradres.',
                'specify-shipping-method'  => 'Waarschuwing: Geef de verzendmethode op.',
                'specify-payment-method'   => 'Waarschuwing: Geef de betalingsmethode op.',
                'coupon-not-valid'         => 'Waarschuwing: De kortingscode is niet geldig.',
                'coupon-already-applied'   => 'Waarschuwing: De kortingscode is al toegepast.',
                'coupon-applied'           => 'Succes: Kortingscode succesvol toegepast.',
                'coupon-removed'           => 'Succes: Kortingscode succesvol verwijderd.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Product succesvol aangemaakt.',
                'delete-success'            => 'Product succesvol verwijderd.',
                'not-found'                 => 'Waarschuwing: Product niet gevonden.',
                'update-success'            => 'Product succesvol bijgewerkt.',
                'configurable-attr-missing' => 'Waarschuwing: Configurabel attribuut ontbreekt.',
                'simple-products-error'     => 'Waarschuwing: Eenvoudige producten ontbreken.',
            ],

            'categories' => [
                'already-taken'  => 'Waarschuwing: De slug is al in gebruik.',
                'create-success' => 'Categorie succesvol aangemaakt.',
                'delete-success' => 'Categorie succesvol verwijderd.',
                'not-found'      => 'Waarschuwing: Categorie niet gevonden.',
                'update-success' => 'Categorie succesvol bijgewerkt.',
                'root-delete'    => 'Waarschuwing: De hoofdcatgorie kan niet worden verwijderd.',
            ],

            'attributes' => [
                'create-success'    => 'Attribuut succesvol aangemaakt.',
                'delete-success'    => 'Attribuut succesvol verwijderd.',
                'not-found'         => 'Waarschuwing: Attribuut niet gevonden.',
                'update-success'    => 'Attribuut succesvol bijgewerkt.',
                'user-define-error' => 'Waarschuwing: Je bent niet bevoegd om het systeemgegenereerde attribuut te verwijderen.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Attribuutgroep succesvol aangemaakt.',
                'delete-success'    => 'Attribuutgroep succesvol verwijderd.',
                'not-found'         => 'Waarschuwing: Attribuutgroep niet gevonden.',
                'update-success'    => 'Attribuutgroep succesvol bijgewerkt.',
                'user-define-error' => 'Waarschuwing: Je bent niet bevoegd om de door het systeem aangemaakte attribuutgroep te verwijderen.',
            ],

            'attribute-families' => [
                'create-success'          => 'Attribuutfamilie succesvol aangemaakt.',
                'delete-success'          => 'Attribuutfamilie succesvol verwijderd.',
                'not-found'               => 'Waarschuwing: Attribuutfamilie niet gevonden.',
                'update-success'          => 'Attribuutfamilie succesvol bijgewerkt.',
                'last-delete-error'       => 'Waarschuwing: De laatste attribuutfamilie kan niet worden verwijderd.',
                'attribute-product-error' => 'Waarschuwing: Enkele producten zijn gekoppeld aan deze attribuutfamilie.',
                'user-define-error'       => 'Waarschuwing: Je bent niet bevoegd om de door het systeem aangemaakte attribuutfamilie te verwijderen.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Klant succesvol aangemaakt.',
                'delete-order-pending' => 'Kan klantaccount niet verwijderen omdat er nog lopende of verwerkte bestellingen zijn.',
                'delete-success'       => 'Klant succesvol verwijderd.',
                'not-found'            => 'Waarschuwing: Klant niet gevonden.',
                'note-created-success' => 'Notitie succesvol aangemaakt.',
                'update-success'       => 'Klant succesvol bijgewerkt.',
                'login-success'        => 'Klant succesvol ingelogd.',
            ],

            'addresses' => [
                'create-success'         => 'Klantadres succesvol aangemaakt.',
                'default-update-success' => 'Adres is ingesteld als standaard.',
                'delete-success'         => 'Klantadres succesvol verwijderd.',
                'not-found'              => 'Waarschuwing: Klantadres niet gevonden.',
                'update-success'         => 'Klantadres succesvol bijgewerkt.',
                'already-default'        => 'Waarschuwing: Dit adres is al ingesteld als standaard.',
            ],

            'groups' => [
                'create-success'     => 'Klantgroep succesvol aangemaakt.',
                'customer-associate' => 'Waarschuwing: Groep kan niet worden verwijderd. Klant is eraan gekoppeld.',
                'delete-success'     => 'Klantgroep succesvol verwijderd.',
                'not-found'          => 'Waarschuwing: Klantgroep niet gevonden.',
                'update-success'     => 'Klantgroep succesvol bijgewerkt.',
                'user-define-error'  => 'Waarschuwing: Je bent niet bevoegd om de door het systeem aangemaakte klantgroep te verwijderen.',
            ],

            'reviews' => [
                'delete-success' => 'Beoordeling succesvol verwijderd.',
                'not-found'      => 'Waarschuwing: Beoordeling niet gevonden.',
                'update-success' => 'Beoordeling succesvol bijgewerkt.',
            ],

            'gdpr' => [
                'delete-success' => 'Succes: GDPR-verzoek succesvol verwijderd.',
                'not-found'      => 'Waarschuwing: GDPR-verzoek niet gevonden.',
                'update-success' => 'GDPR-verzoek succesvol bijgewerkt.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Waarschuwing: De slug is al in gebruik.',
            'create-success' => 'CMS succesvol aangemaakt.',
            'delete-success' => 'CMS succesvol verwijderd.',
            'not-found'      => 'Waarschuwing: CMS niet gevonden.',
            'update-success' => 'CMS succesvol bijgewerkt.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Catalogusregel succesvol aangemaakt.',
                    'delete-failed'  => 'Waarschuwing: Catalogusregel niet verwijderd.',
                    'delete-success' => 'Catalogusregel succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: Catalogusregel niet gevonden.',
                    'update-success' => 'Catalogusregel succesvol bijgewerkt.',
                ],

                'cart-rules' => [
                    'create-success' => 'Winkelwagentregel succesvol aangemaakt.',
                    'delete-failed'  => 'Waarschuwing: Winkelwagentregel niet verwijderd.',
                    'delete-success' => 'Winkelwagentregel succesvol verwijderd.',
                    'not-found'      => 'Winkelwagentregel niet gevonden.',
                    'update-success' => 'Winkelwagentregel succesvol bijgewerkt.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'E-mailtemplate succesvol aangemaakt.',
                    'delete-success' => 'E-mailtemplate succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: E-mailtemplate niet gevonden.',
                    'update-success' => 'E-mailtemplate succesvol bijgewerkt.',
                ],

                'events' => [
                    'create-success' => 'Evenement succesvol aangemaakt.',
                    'delete-success' => 'Evenement succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: Evenement niet gevonden.',
                    'update-success' => 'Evenement succesvol bijgewerkt.',
                ],

                'campaigns' => [
                    'create-success' => 'Campagne succesvol aangemaakt.',
                    'delete-success' => 'Campagne succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: Campagne niet gevonden.',
                    'update-success' => 'Campagne succesvol bijgewerkt.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Abonnement succesvol verwijderd.',
                    'not-found'           => 'Waarschuwing: Abonnement niet gevonden.',
                    'unsubscribe-success' => 'Succes: Abonnement succesvol geannuleerd.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL Rewrite succesvol aangemaakt.',
                    'delete-success' => 'URL Rewrite succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: URL Rewrite niet gevonden.',
                    'update-success' => 'URL Rewrite succesvol bijgewerkt.',
                ],

                'search-terms' => [
                    'create-success' => 'Zoekterm succesvol aangemaakt.',
                    'delete-success' => 'Zoekterm succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: Zoekterm niet gevonden.',
                    'update-success' => 'Zoekterm succesvol bijgewerkt.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Zoeksynoniem succesvol aangemaakt.',
                    'delete-success' => 'Zoeksynoniem succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: Zoeksynoniem niet gevonden.',
                    'update-success' => 'Zoeksynoniem succesvol bijgewerkt.',
                ],

                'sitemaps' => [
                    'create-success' => 'Sitemap succesvol aangemaakt.',
                    'delete-success' => 'Sitemap succesvol verwijderd.',
                    'not-found'      => 'Waarschuwing: Sitemap niet gevonden.',
                    'update-success' => 'Sitemap succesvol bijgewerkt.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Taal succesvol aangemaakt.',
                'default-delete-error' => 'Kan de standaardtaal niet verwijderen.',
                'delete-error'         => 'Verwijderen van taal mislukt.',
                'delete-success'       => 'Taal succesvol verwijderd.',
                'last-delete-error'    => 'Verwijderen van de laatste taal mislukt.',
                'not-found'            => 'Waarschuwing: Taal niet gevonden.',
                'update-success'       => 'Taal succesvol bijgewerkt.',
            ],

            'currencies' => [
                'create-success'       => 'Valuta succesvol aangemaakt.',
                'default-delete-error' => 'Kan de standaardvaluta niet verwijderen.',
                'delete-error'         => 'Verwijderen van valuta mislukt.',
                'delete-success'       => 'Valuta succesvol verwijderd.',
                'last-delete-error'    => 'Verwijderen van de laatste valuta mislukt.',
                'not-found'            => 'Waarschuwing: Valuta niet gevonden.',
                'update-success'       => 'Valuta succesvol bijgewerkt.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Wisselkoers succesvol aangemaakt.',
                'delete-error'            => 'Verwijderen van wisselkoers mislukt.',
                'delete-success'          => 'Wisselkoers succesvol verwijderd.',
                'invalid-target-currency' => 'Waarschuwing: Ongeldige doelvaluta.',
                'last-delete-error'       => 'Verwijderen van de laatste wisselkoers mislukt.',
                'not-found'               => 'Waarschuwing: Wisselkoers niet gevonden.',
                'update-success'          => 'Wisselkoers succesvol bijgewerkt.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Voorraad succesvol aangemaakt.',
                'delete-error'      => 'Verwijderen van voorraad mislukt.',
                'delete-success'    => 'Voorraad succesvol verwijderd.',
                'last-delete-error' => 'Verwijderen van de laatste voorraad mislukt.',
                'not-found'         => 'Waarschuwing: Voorraad niet gevonden.',
                'update-success'    => 'Voorraad succesvol bijgewerkt.',
            ],

            'channels' => [
                'create-success'       => 'Kanaal succesvol aangemaakt.',
                'default-delete-error' => 'Kan het standaardkanaal niet verwijderen.',
                'delete-error'         => 'Verwijderen van kanaal mislukt.',
                'delete-success'       => 'Kanaal succesvol verwijderd.',
                'last-delete-error'    => 'Verwijderen van het laatste kanaal mislukt.',
                'not-found'            => 'Waarschuwing: Kanaal niet gevonden.',
                'update-success'       => 'Kanaal succesvol bijgewerkt.',
            ],

            'users' => [
                'activate-warning'  => 'Je account moet nog worden geactiveerd, neem contact op met de beheerder.',
                'create-success'    => 'Gebruiker succesvol aangemaakt.',
                'delete-error'      => 'Verwijderen van gebruiker mislukt.',
                'delete-success'    => 'Gebruiker succesvol verwijderd.',
                'last-delete-error' => 'Verwijderen van de laatste gebruiker mislukt.',
                'login-error'       => 'Controleer je inloggegevens en probeer het opnieuw.',
                'not-found'         => 'Waarschuwing: Gebruiker niet gevonden.',
                'success-login'     => 'Inloggen van gebruiker succesvol.',
                'success-logout'    => 'Uitloggen van gebruiker succesvol.',
                'update-success'    => 'Gebruiker succesvol bijgewerkt.',
            ],

            'roles' => [
                'create-success'    => 'Rol succesvol aangemaakt.',
                'delete-error'      => 'Verwijderen van rol mislukt.',
                'delete-success'    => 'Rol succesvol verwijderd.',
                'last-delete-error' => 'Kan de laatste rol niet verwijderen.',
                'not-found'         => 'Waarschuwing: Rol niet gevonden.',
                'update-success'    => 'Rol succesvol bijgewerkt.',
            ],

            'themes' => [
                'create-success' => 'Thema succesvol aangemaakt.',
                'delete-success' => 'Thema succesvol verwijderd.',
                'not-found'      => 'Waarschuwing: Thema niet gevonden.',
                'update-success' => 'Thema succesvol bijgewerkt.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'De opgegeven category_id bestaat niet.',
                        'invalid-boolean-value' => 'De waarde van :key moet 0 of 1 zijn.',
                        'invalid-filter-key'    => 'De filter sleutel ":key" is niet toegestaan.',
                        'invalid-limit-value'   => 'De limietwaarde moet een van de volgende zijn: :options.',
                        'invalid-select-option' => 'De waarde :key is ongeldig. Geldige opties zijn: :options.',
                        'invalid-sort-value'    => 'De sorteervolgorde moet een van de volgende zijn: :options.',
                        'missing-limit-key'     => 'filtersInput moet een "limit"-sleutel bevatten.',
                        'missing-sort-key'      => 'filtersInput moet een "sort"-sleutel bevatten.',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Belastingtarief succesvol aangemaakt.',
                'delete-error'   => 'Verwijderen van belastingtarief mislukt.',
                'delete-success' => 'Belastingtarief succesvol verwijderd.',
                'not-found'      => 'Waarschuwing: Belastingtarief niet gevonden.',
                'update-success' => 'Belastingtarief succesvol bijgewerkt.',
            ],

            'tax-category' => [
                'create-success'     => 'Belastingcategorie succesvol aangemaakt.',
                'delete-error'       => 'Verwijderen van belastingcategorie mislukt.',
                'delete-success'     => 'Belastingcategorie succesvol verwijderd.',
                'not-found'          => 'Waarschuwing: Belastingcategorie niet gevonden.',
                'tax-rate-not-found' => 'De opgegeven ID\'s zijn niet gevonden. ID: :ids',
                'update-success'     => 'Belastingcategorie succesvol bijgewerkt.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Voeg notificatie toe',
                    'general'   => 'Algemeen',
                    'title'     => 'Push-notificatie',

                    'datagrid' => [
                        'channel-name'         => 'Kanaalnaam',
                        'created-at'           => 'Aanmaakdatum',
                        'delete'               => 'Verwijder',
                        'id'                   => 'ID',
                        'image'                => 'Afbeelding',
                        'notification-content' => 'Notificatie-inhoud',
                        'notification-status'  => 'Notificatiestatus',
                        'notification-type'    => 'Notificatietype',
                        'text-title'           => 'Titel',
                        'update'               => 'Bijwerken',
                        'updated-at'           => 'Bijwerkdatum',

                        'status' => [
                            'disabled' => 'Uitgeschakeld',
                            'enabled'  => 'Ingeschakeld',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Terug',
                    'content-and-image'    => 'Inhoud en afbeelding van notificatie',
                    'create-btn-title'     => 'Sla notificatie op',
                    'general'              => 'Algemeen',
                    'image'                => 'Afbeelding',
                    'new-notification'     => 'Nieuwe notificatie',
                    'notification-content' => 'Notificatie-inhoud',
                    'notification-type'    => 'Notificatietype',
                    'product-cat-id'       => 'Product-/categorie-ID',
                    'settings'             => 'Instellingen',
                    'status'               => 'Status',
                    'store-view'           => 'Kanalen',
                    'title'                => 'Push-notificatie',

                    'option-type' => [
                        'category' => 'Categorie',
                        'others'   => 'Eenvoudig',
                        'product'  => 'Product',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Terug',
                    'content-and-image'    => 'Inhoud en afbeelding van notificatie',
                    'edit-notification'    => 'Wijzig notificatie',
                    'general'              => 'Algemeen',
                    'image'                => 'Afbeelding',
                    'notification-content' => 'Notificatie-inhoud',
                    'notification-type'    => 'Notificatietype',
                    'product-cat-id'       => 'Product-/categorie-ID',
                    'send-title'           => 'Verzend notificatie',
                    'settings'             => 'Instellingen',
                    'status'               => 'Status',
                    'store-view'           => 'Kanalen',
                    'title'                => 'Push-notificatie',
                    'update-btn-title'     => 'Bijwerken',

                    'option-type' => [
                        'category' => 'Categorie',
                        'others'   => 'Eenvoudig',
                        'product'  => 'Product',
                    ],
                ],

                'not-found'           => 'Waarschuwing: Notificatie niet gevonden.',
                'create-success'      => 'Notificatie succesvol aangemaakt.',
                'delete-failed'       => 'Verwijderen van notificatie mislukt.',
                'delete-success'      => 'Notificatie succesvol verwijderd.',
                'mass-update-success' => 'Geselecteerde notificaties succesvol bijgewerkt.',
                'mass-delete-success' => 'Geselecteerde notificaties succesvol verwijderd.',
                'no-value-selected'   => 'Geen waarde geselecteerd.',
                'send-success'        => 'Notificatie succesvol verzonden.',
                'update-success'      => 'Notificatie succesvol bijgewerkt.',
                'configuration-error' => 'Waarschuwing: FCM-configuratie niet gevonden.',
                'product-not-found'   => 'Waarschuwing: Product niet gevonden.',
                'category-not-found'  => 'Waarschuwing: Categorie niet gevonden.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Waarschuwing: Gegeven parameters zijn niet geldig.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Waarschuwing: E-mailconfiguratie niet gevonden.',
    ],
];
