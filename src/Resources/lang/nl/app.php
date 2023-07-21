<?php

return [
    'admin'     => [
        'menu'  => [
            'push-notification' => 'Pushmelding',
        ],

        'acl'  => [
            'push-notification' => 'Pushmelding',
            'send'              => 'Verzenden',
        ],

        'system' => [
            'graphql-api'                       => 'GraphQL API',
            'push-notification-configuration'   => 'FCM Pushmelding Configuratie',
            'server-key'                        => 'Server Sleutel',
            'info-get-server-key'               => 'Info: Voor het verkrijgen van fcm API-inloggegevens: <a href="https://console.firebase.google.com/" target="_blank">Klik hier</a>',
            'android-topic'                     => 'Android-onderwerp',
            'ios-topic'                         => 'IOS-onderwerp',
        ],

        'notification'  => [
            'title'                 => 'Pushmelding',
            'add-title'             => 'Melding toevoegen',
            'general'               => 'Algemeen',

            'id'                    => 'Id',
            'image'                 => 'Afbeelding',
            'text-title'            => 'Titel',
            'edit-notification'     => 'Melding bewerken',
            'manage'                => 'Meldingen',
            'new-notification'      => 'Nieuwe melding',
            'create-btn-title'      => 'Melding opslaan',
            'notification-image'    => 'Meldingsafbeelding',
            'notification-title'    => 'Meldingstitel',
            'notification-content'  => 'Meldingsinhoud',
            'notification-type'     => 'Meldingstype',
            'product-cat-id'        => 'Product/Categorie Id',
            'store-view'            => 'Kanalen',
            'notification-status'   => 'Meldingsstatus',
            'created'               => 'Aangemaakt',
            'modified'              => 'Aangepast',
            'collection-autocomplete'   => 'Aangepaste verzameling - (Autocomplete)',
            'no-collection-found'       => 'Geen verzamelingen gevonden met dezelfde naam.',
            'collection-search-hint'    => 'Begin met het typen van de naam van de verzameling',
            
            'Action'    => [
                'edit'      => 'Bewerken',
            ],

            'status'    => [
                'enabled'   => 'Ingeschakeld',
                'disabled'  => 'Uitgeschakeld',
            ],

            'notification-type-option'  => [
                'select'            => '-- Selecteer --',
                'simple'            => 'Eenvoudig type',
                'product'           => 'Product gebaseerd',
                'category'          => 'Categorie gebaseerd',
            ],
        ],

        'alert' => [
            'create-success'        => ':name succesvol aangemaakt',
            'update-success'        => ':name succesvol bijgewerkt',
            'delete-success'        => ':name succesvol verwijderd',
            'delete-failed'         => ':name verwijderen mislukt',
            'sended-successfully'   => ':name succesvol verzonden voor Android en iOS.',
            'no-value-selected'     => 'er zijn geen bestaande waarden',
        ],

        'settings'   => [
            'exchange_rates' => [
                'error-invalid-target-currency' => 'Waarschuwing: Ongeldige doelvaluta opgegeven.',
                'delete-success'        => 'Succes: Wisselkoers succesvol verwijderd.',
            ]
        ],
        
        'response'  => [
            'error-invalid-parameter'   => 'Waarschuwing: Ongeldige parameters opgegeven.',
            'success-login'             => 'Succes: Gebruiker succesvol ingelogd.',
            'error-login'               => 'Waarschuwing: Beheerder is niet ingelogd.',
            'session-expired'           => 'Waarschuwing: De sessie is verlopen. Log opnieuw in op uw account.',
            'invalid-header'            => 'Waarschuwing: Ongeldige koptoken.',
            'success-logout'            => 'Succes: Gebruiker succesvol uitgelogd.',
            'no-login-user'             => 'Waarschuwing: Geen ingelogde gebruiker gevonden.',
            'error-customer-group'      => 'Waarschuwing: U bent niet gemachtigd om een door het systeem aangemaakte attribuutgroep te verwijderen.',
            'password-invalid'          => 'Waarschuwing: Voer het juiste wachtwoord in.',
            'password-match'            => 'Waarschuwing: Wachtwoord komt niet overeen.',
            'success-registered'        => 'Succes: Gebruiker succesvol aangemaakt.',
            'cancel-error'              => 'Bestelling kan niet worden geannuleerd.',
            'creation-error'            => 'Terugbetaling kan niet worden aangemaakt voor deze bestelling.',
            'channel-failure'           => 'Kanaal niet gevonden.',
            'script-delete-success'     => 'Script succesvol verwijderd.'
        ]
    ],

    'shop'  => [
        'customer'  => [
            'success-login'         => 'Succes: Klant succesvol ingelogd.',
            'success-logout'        => 'Succes: Klant succesvol uitgelogd.',
            'no-login-customer'     => 'Waarschuwing: Geen ingelogde klant gevonden.',
            'address-list'          => 'Succes: Adresgegevens van de klant opgehaald',
            'not-authorized'        => 'Waarschuwing: U bent niet gemachtigd om dit adres bij te werken.',
            'success-address-list'  => 'Succes: Adressen van de klant succesvol opgehaald.',
            'no-address-list'       => 'Waarschuwing: Geen adres van klant gevonden.',
            'text-password'         => 'Uw wachtwoord is: :password',
            'not-exists'            => 'Waarschuwing: Geen klant gevonden voor de opgegeven gegevens.',
        ],
        'response'  => [
            'error-registration'        => 'Waarschuwing: klantregistratie mislukt.',
            'password-reset-failed'     => 'Waarschuwing: We hebben u al een e-mail voor het opnieuw instellen van het wachtwoord gestuurd, probeer het later opnieuw.',
            'customer-details'          => 'Succes: Klantgegevens succesvol opgehaald.',
            'not-found'                 => 'Waarschuwing: Geen :name gevonden.',
            'no-address-found'          => 'Waarschuwing: Geen adres gevonden.',
            'no-order-found'            => 'Waarschuwing: Geen bestelling gevonden.',
            'warning-empty-cart'        => 'Waarschuwing: Er zijn geen producten aan de winkelwagen toegevoegd.',
            'success-add-to-cart'       => 'Succes: Product succesvol aan de winkelwagen toegevoegd.',
            'success-update-to-cart'    => 'Succes: Winkelwagenitem is succesvol bijgewerkt.',
            'success-delete-cart-item'  => 'Succes: Winkelwagenitem is succesvol verwijderd.',
            'success-moved-cart-item'   => 'Succes: Winkelwagenitem succesvol verplaatst naar verlanglijstje.',
            'billing-address-missing'   => 'Waarschuwing: Factuuradres ontbreekt voor afrekenen.',
            'shipping-address-missing'  => 'Waarschuwing: Afleveradres ontbreekt voor afrekenen.',
            'invalid-address'           => 'Waarschuwing: Geen adres gevonden voor opgegeven adresId.',
            'wrong-error'               => 'Waarschuwing: Er is een fout opgetreden met uw winkelwagen, probeer het opnieuw.',
            'save-cart-address'         => 'Succes: Winkelwagenadres succesvol opgeslagen.',
            'error-payment-selection'   => 'Waarschuwing: Er is een fout opgetreden bij het ophalen van betaalmethoden.',
            'selected-shipment'         => 'Succes: Verzending is succesvol geselecteerd.',
            'error-payment-save'        => 'Waarschuwing: Er is een fout opgetreden bij het opslaan van de betaalmethode.',
            'selected-payment'          => 'Succes: Betaalmethode succesvol geselecteerd.',
            'error-placing-order'       => 'Waarschuwing: Er is een fout opgetreden bij het plaatsen van de bestelling.',
            'invalid-product'           => 'Waarschuwing: U vraagt om een ongeldig product.',
            'already-exist-inwishlist'  => 'Informatie: Dit product bestaat al in het verlanglijstje.',
            'error-move-to-cart'        => 'Waarschuwing: Dit product heeft mogelijk enkele vereiste opties en kan niet naar de winkelwagen worden verplaatst.',
            'no-billing-address-found'  => 'Waarschuwing: Geen factuuradres gevonden met factuur-id :address_id.',
            'no-shipping-address-found'  => 'Waarschuwing: Geen verzendadres gevonden met verzend-id :address_id.',
            'invalid-guest-access'      => 'Waarschuwing: Gastklanten mogen geen adressen krijgen met behulp van facturering / verzendadres-id.',
            'guest-address-warning'     => 'Waarschuwing: Als u als gast probeert, probeer het dan zonder autorisatietoken.',
            'warning-num-already-used'  => 'Waarschuwing: Dit :phone nummer is geregistreerd met een ander e-mailadres.',
            'coupon-removed'            => 'Succes: coupon succesvol uit de winkelwagen verwijderd.',
            'coupon-remove-failed'      => 'Waarschuwing: er zijn enkele fouten bij het verwijderen van de coupon uit de winkelwagen of de coupon is niet gevonden.',
            'review-create-success'     => 'Succes: Beoordeling is succesvol ingediend, wacht op goedkeuring.',
        ]
    ],
    
    'validation' => [
        'unique'    => 'Deze :field is al in gebruik.',
        'required'  => 'Het veld :field is verplicht.',
        'same'      => 'Het veld :field en wachtwoord moeten overeenkomen.'
    ],
    
    'mail' => [
        'customer'  => [
            'password' => [
                'heading'   => config('app.name') . ' - Wachtwoord opnieuw instellen',
                'reset'     => 'E-mail voor het opnieuw instellen van het wachtwoord',
                'summary' => 'Deze e-mail heeft betrekking op het opnieuw instellen van het wachtwoord van uw account. Uw wachtwoord is succesvol gewijzigd.
                Meld u aan bij uw account met het hieronder vermelde wachtwoord.',
            ]
        ]
    ]
];