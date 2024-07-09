<?php

return [
    'admin' => [
        'menu' => [
            'push-notification' => 'Pushmelding',
        ],

        'acl' => [
            'push-notification' => 'Pushmelding',
            'send'              => 'Verzenden',
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'title'                           => 'GraphQL API',
                        'info'                            => 'Meldingsgerelateerde configuraties',
                        'push-notification-configuration' => 'FCM Pushmeldingsconfiguratie',
                        'server-key'                      => 'Server Sleutel',
                        'info-get-server-key'             => 'Info: Om FCM API-gegevens te verkrijgen: <a href="https://console.firebase.google.com/" target="_blank">Klik hier</a>',
                        'android-topic'                   => 'Android-onderwerp',
                        'ios-topic'                       => 'iOS-onderwerp',
                        'private-key'                     => 'Inhoud van het JSON-bestand van de privésleutel',
                        'info-get-private-key'            => 'Informatie: Voor het verkrijgen van de inhoud van het JSON-bestand van de privésleutel voor FCM: <a href="https://console.firebase.google.com/" target="_blank">Klik hier</a>',
                    ],
                ],
            ],
        ],

        'settings' => [
            'notification' => [
                'index' => [
                    'title'               => 'Pushmelding',
                    'add-title'           => 'Melding Toevoegen',
                    'delete-success'      => 'Melding succesvol verwijderd',
                    'mass-update-success' => 'Geselecteerde meldingen succesvol bijgewerkt',
                    'mass-delete-success' => 'Geselecteerde meldingen succesvol verwijderd',

                    'datagrid' => [
                        'id'                   => 'Id',
                        'image'                => 'Afbeelding',
                        'text-title'           => 'Titel',
                        'notification-content' => 'Meldingsinhoud',
                        'notification-type'    => 'Meldingstype',
                        'store-view'           => 'Kanalen',
                        'notification-status'  => 'Meldingsstatus',
                        'created-at'           => 'Aanmaakdatum',
                        'updated-at'           => 'Bijgewerkte datum',
                        'delete'               => 'Verwijderen',
                        'update'               => 'Bijwerken',

                        'status' => [
                            'enabled'  => 'Ingeschakeld',
                            'disabled' => 'Uitgeschakeld',
                        ],
                    ],
                ],

                'create' => [
                    'new-notification'     => 'Nieuwe Melding',
                    'back-btn'             => 'Terug',
                    'create-btn-title'     => 'Melding Opslaan',
                    'general'              => 'Algemeen',
                    'title'                => 'Pushmelding',
                    'content-and-image'    => 'Meldingsinhoud En Afbeelding',
                    'notification-content' => 'Meldingsinhoud',
                    'image'                => 'Afbeelding',
                    'settings'             => 'Instellingen',
                    'status'               => 'Status',
                    'store-view'           => 'Kanalen',
                    'notification-type'    => 'Meldingstype',
                    'product-cat-id'       => 'Product/Categorie Id',
                    'success'              => 'Melding succesvol aangemaakt',

                    'option-type' => [
                        'others'   => 'Eenvoudig',
                        'product'  => 'Product',
                        'category' => 'Categorie',
                    ],
                ],

                'edit' => [
                    'edit-notification'         => 'Melding Bewerken',
                    'back-btn'                  => 'Terug',
                    'send-title'                => 'Melding Verzenden',
                    'update-btn-title'          => 'Melding Bijwerken',
                    'general'                   => 'Algemeen',
                    'title'                     => 'Pushmelding',
                    'content-and-image'         => 'Meldingsinhoud En Afbeelding',
                    'notification-content'      => 'Meldingsinhoud',
                    'image'                     => 'Afbeelding',
                    'settings'                  => 'Instellingen',
                    'status'                    => 'Status',
                    'store-view'                => 'Kanalen',
                    'notification-type'         => 'Meldingstype',
                    'product-cat-id'            => 'Product/Categorie Id',
                    'success'                   => 'Melding succesvol bijgewerkt',
                    'notification-send-success' => 'Melding succesvol verzonden voor Android en iOS.',

                    'option-type' => [
                        'others'   => 'Eenvoudig',
                        'product'  => 'Product',
                        'category' => 'Categorie',
                    ],
                ],
            ],

            'exchange_rates' => [
                'error-invalid-target-currency' => 'Waarschuwing: Ongeldige doelvaluta opgegeven.',
                'delete-success'                => 'Succes: Wisselkoers succesvol verwijderd.',
            ],
        ],

        'customer' => [
            'no-customer-found' => 'Geen klant gevonden',
        ],

        'response' => [
            'delete-success'          => 'Succes: Gebruiker succesvol verwijderd.',
            'last-delete-error'       => 'Waarschuwing: Ten minste één gebruiker is vereist.',
            'delete-failed'           => 'Waarschuwing: Beheerdersgebruiker is niet verwijderd.',
            'error-invalid-parameter' => 'Waarschuwing: Ongeldige parameters verstrekt.',
            'success-login'           => 'Succes: Gebruiker succesvol ingelogd.',
            'error-login'             => 'Waarschuwing: Beheerdersgebruiker is niet ingelogd.',
            'session-expired'         => 'Waarschuwing: Sessie is verlopen. Log opnieuw in op uw account.',
            'invalid-header'          => 'Waarschuwing: Ongeldige kopertoken.',
            'success-logout'          => 'Succes: Gebruiker succesvol uitgelogd.',
            'no-login-user'           => 'Waarschuwing: Geen ingelogde gebruiker gevonden.',
            'error-customer-group'    => 'Waarschuwing: U bent niet gemachtigd om systeemgemaakte attribuutgroep te verwijderen.',
            'password-invalid'        => 'Waarschuwing: Voer het juiste wachtwoord in.',
            'password-match'          => 'Waarschuwing: Wachtwoorden komen niet overeen.',
            'success-registered'      => 'Succes: Gebruiker succesvol aangemaakt.',
            'cancel-error'            => 'Bestelling kan niet worden geannuleerd.',
            'creation-error'          => 'Terugbetaling kan niet worden aangemaakt voor deze bestelling.',
            'channel-failure'         => 'Kanaal niet gevonden.',
            'script-delete-success'   => 'Script succesvol verwijderd.',
        ],

        'shop' => [
            'response' => [
                'no-address-found'         => 'Waarschuwing: Geen adres gevonden.',
                'invalid-address'          => 'Waarschuwing: Geen adres gevonden voor opgegeven adres-ID.',
                'invalid-product'          => 'Waarschuwing: U vraagt om een ongeldig product.',
                'already-exist-inwishlist' => 'Informatie: Dit product bestaat al op de verlanglijst.',
                'un-authorized-access'     => 'Waarschuwing: U bent niet gemachtigd om dit gedeelte te gebruiken.',
            ],
        ],

        'validation' => [
            'unique'   => 'Dit :field is al in gebruik genomen.',
            'required' => 'Het veld :field is verplicht.',
            'same'     => 'Het veld :field en het wachtwoord moeten overeenkomen.',
        ],

        'mail' => [
            'customer' => [
                'password' => [
                    'heading' => config('app.name').' - Wachtwoord Reset',
                    'reset'   => 'E-mail voor wachtwoordreset',
                    'summary' => 'Deze e-mail heeft betrekking op het opnieuw instellen van het wachtwoord van uw account. Uw wachtwoord is succesvol gewijzigd.
                    Log alstublieft in op uw account met het onderstaande wachtwoord.',
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'save-cart-address'         => 'Succes: Winkelwagenadres succesvol opgeslagen.',
            'error-payment-selection'   => 'Waarschuwing: Er is een fout opgetreden bij het ophalen van betaalmethoden.',
            'selected-shipment'         => 'Succes: Verzending is succesvol geselecteerd.',
            'warning-empty-cart'        => 'Waarschuwing: Er zijn geen producten toegevoegd aan de winkelwagen.',
            'billing-address-missing'   => 'Waarschuwing: Factuuradres ontbreekt voor het afrekenen.',
            'shipping-address-missing'  => 'Waarschuwing: Verzendadres ontbreekt voor het afrekenen.',
            'invalid-guest-access'      => 'Waarschuwing: Gastklanten zijn niet toegestaan om adressen op te halen met behulp van factuur-/verzendadres-ID.',
            'guest-address-warning'     => 'Waarschuwing: Als u als gast probeert, probeer dan zonder autorisatietoken.',
            'wrong-error'               => 'Waarschuwing: Er is een fout opgetreden met uw winkelwagen, probeer het opnieuw.',
            'no-billing-address-found'  => 'Waarschuwing: Geen factuuradresrecord gevonden met :address_id factuur-id.',
            'no-shipping-address-found' => 'Waarschuwing: Geen verzendadresrecord gevonden met :address_id verzend-id.',
            'error-invalid-parameter'   => 'Waarschuwing: Ongeldige parameters verstrekt.',
            'already-applied'           => 'Kortingscode is al toegepast.',
            'success-apply'             => 'Kortingscode succesvol toegepast.',
            'coupon-removed'            => 'Succes: coupon succesvol verwijderd uit winkelwagen.',
            'coupon-remove-failed'      => 'Waarschuwing: er zijn fouten opgetreden bij het verwijderen van de coupon uit de winkelwagen of de coupon is niet gevonden.',
            'error-placing-order'       => 'Waarschuwing: Er is een fout opgetreden bij het plaatsen van de bestelling.',
            'selected-payment'          => 'Succes: Betaalmethode succesvol geselecteerd.',
            'error-payment-save'        => 'Waarschuwing: Er is een fout opgetreden bij het opslaan van de betaalmethode.',

            'cart' => [
                'item' => [
                    'success-all-remove'       => 'Alle items succesvol verwijderd uit de winkelwagen.',
                    'fail-all-remove'          => 'Fout bij het verwijderen van items uit de winkelwagen.',
                    'error-invalid-parameter'  => 'Waarschuwing: Ongeldige parameters verstrekt.',
                    'success-moved-cart-item'  => 'Succes: Winkelwagenitem succesvol verplaatst naar verlanglijstje.',
                    'fail-moved-cart-item'     => 'Mislukt: Winkelwagenitem is niet verplaatst naar verlanglijstje.',
                    'success-add-to-cart'      => 'Succes: Product succesvol toegevoegd aan winkelwagen.',
                    'fail-add-to-cart'         => 'Mislukt: Product is niet toegevoegd aan winkelwagen.',
                    'success-update-to-cart'   => 'Succes: Winkelwagenitem is succesvol bijgewerkt.',
                    'fail-update-to-cart'      => 'Mislukt: Winkelwagenitem is niet bijgewerkt.',
                    'success-delete-cart-item' => 'Succes: Winkelwagenitem is succesvol verwijderd.',
                    'fail-delete-cart-item'    => 'Mislukt: Winkelwagenitem niet gevonden.',
                ],
            ],
        ],

        'customer' => [
            'success-login'         => 'Succes: Klant succesvol ingelogd.',
            'success-logout'        => 'Succes: Klant succesvol uitgelogd.',
            'no-login-customer'     => 'Waarschuwing: Geen ingelogde klant gevonden.',
            'address-list'          => 'Succes: Klantadresgegevens opgehaald',
            'not-authorized'        => 'Waarschuwing: U bent niet gemachtigd om dit adres bij te werken.',
            'no-address-list'       => 'Waarschuwing: Geen klantadressen gevonden.',
            'text-password'         => 'Uw wachtwoord is: :password',
            'not-exists'            => 'Waarschuwing: Geen klant gevonden voor de verstrekte gegevens.',
            'success-address-list'  => 'Succes: Klantadressen succesvol opgehaald.',
            'reset-link-sent'       => 'Succes: E-mail voor wachtwoordreset is succesvol verzonden.',
            'password-reset-failed' => 'Waarschuwing: We hebben u al een e-mail voor wachtwoordreset gestuurd, probeer het later opnieuw.',
            'no-login-user'         => 'Waarschuwing: Geen ingelogde gebruiker gevonden.',
            'customer-details'      => 'Succes: Klantgegevens succesvol opgehaald.',

            'account' => [
                'not-found' => 'Waarschuwing: Geen :name gevonden.',

                'profile' => [
                    'edit-success'   => 'Profiel succesvol bijgewerkt',
                    'edit-fail'      => 'Profiel niet bijgewerkt',
                    'unmatch'        => 'Het oude wachtwoord komt niet overeen.',
                    'order-pending'  => 'Klantaccount kan niet worden verwijderd omdat sommige bestellingen in afwachting zijn of in verwerkingsstatus verkeren.',
                    'delete-success' => 'Klant succesvol verwijderd',
                    'wrong-password' => 'Verkeerd wachtwoord!',
                ],

                'order' => [
                    'no-order-found' => 'Waarschuwing: Geen bestelling gevonden.',
                    'cancel-success' => 'Bestelling succesvol geannuleerd',
                ],

                'review' => [
                    'success' => 'Succes: Review is succesvol ingediend, wacht op goedkeuring.',
                ],

                'wishlist' => [
                    'removed'            => 'Item succesvol verwijderd uit verlanglijstje',
                    'remove-fail'        => 'Item kan niet worden verwijderd uit verlanglijstje',
                    'remove-all-success' => 'Alle items uit uw verlanglijstje zijn verwijderd',
                    'success'            => 'Item succesvol toegevoegd aan verlanglijstje',
                    'already-exist'      => 'Product bestaat al in verlanglijstje',
                    'move-to-cart'       => 'Naar winkelwagen',
                    'moved-success'      => 'Item succesvol verplaatst naar winkelwagen',
                    'error-move-to-cart' => 'Waarschuwing: Dit product heeft mogelijk enkele vereiste opties, kan niet naar winkelwagen worden verplaatst.',
                    'no-item-found'      => 'Waarschuwing: Er is geen product gevonden.',
                ],

                'addresses' => [
                    'delete-success' => 'Klantadres succesvol verwijderd'
                ]
            ],

            'signup-form' => [
                'error-registration'       => 'Waarschuwing: klantregistratie mislukt.',
                'warning-num-already-used' => 'Waarschuwing: Dit :phone-nummer is geregistreerd met een ander e-mailadres.',
                'success-verify'           => 'Account succesvol aangemaakt, er is een e-mail verstuurd ter verificatie.',
                'invalid-creds'            => 'Controleer uw referenties en probeer het opnieuw.',

                'validation' => [
                    'unique'   => 'Dit :field is al in gebruik genomen.',
                    'required' => 'Het veld :field is verplicht.',
                    'same'     => 'Het veld :field en wachtwoord moeten overeenkomen.',
                ],
            ],

            'login-form' => [
                'not-activated' => 'Uw activering vereist goedkeuring van de beheerder',
                'invalid-creds' => 'Controleer uw referenties en probeer het opnieuw.',
            ],
        ],

        'response' => [
            'error-invalid-parameter' => 'Waarschuwing: Ongeldige parameters verstrekt.',
            'invalid-header'          => 'Waarschuwing: Ongeldige kopertoken.',
            'cancel-error'            => 'Bestelling kan niet worden geannuleerd.',
        ],
    ]
];