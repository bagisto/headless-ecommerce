<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Sei già iscritto alla nostra newsletter.',
            'subscribe-success'  => 'Ti sei iscritto con successo alla nostra newsletter.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Grazie per averci contattato. Ti risponderemo al più presto.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Avviso: Link di download non trovato.',
                'sample-not-found' => 'Avviso: Campione scaricabile non trovato.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Attenzione: Nessun cliente loggato trovato.',
            'success-login'     => 'Successo: Accesso cliente riuscito.',
            'success-logout'    => 'Successo: Logout cliente riuscito.',

            'signup' => [
                'error-registration' => 'Attenzione: Registrazione cliente fallita.',
                'success-verify'     => 'Account creato con successo, è stata inviata una e-mail per la verifica.',
                'success'            => 'Successo: Cliente registrato e accesso effettuato con successo.',
            ],

            'social-login' => [
                'disabled' => 'Avviso: Accesso social disabilitato.',
            ],

            'login' => [
                'invalid-creds' => 'Controlla le tue credenziali e riprova.',
                'not-activated' => 'La tua attivazione richiede l\'approvazione dell\'amministratore',
                'verify-first'  => 'Verifica prima la tua email.',
                'suspended'     => 'Il tuo account è stato sospeso dall\'amministratore.',

                'validation' => [
                    'required' => 'Il campo :field è obbligatorio.',
                    'same'     => 'Il campo :field e la password devono corrispondere.',
                    'unique'   => 'Questo :field è già stato preso.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Link per il ripristino della password già inviato alla tua email.',
                'email-not-exist' => 'L\'email non esiste.',
                'reset-link-sent' => 'Link per il ripristino della password inviato alla tua email.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Successo: Dettagli del cliente recuperati con successo.',
                    'delete-success'   => 'Successo: Account eliminato con successo.',
                    'password-unmatch' => 'La password non corrisponde.',
                    'update-fail'      => 'Avviso: Profilo non aggiornato.',
                    'update-success'   => 'Successo: Profilo aggiornato con successo.',
                    'wrong-password'   => 'Avviso: Password errata fornita.',
                    'order-pending'    => 'Non puoi eliminare l\'account perché hai alcuni ordini in sospeso.',
                ],

                'addresses' => [
                    'create-success'         => 'Indirizzo creato con successo.',
                    'default-update-success' => 'L\'indirizzo è impostato come predefinito',
                    'delete-success'         => 'Indirizzo eliminato con successo',
                    'not-found'              => 'Attenzione: Indirizzo non trovato.',
                    'update-success'         => 'Indirizzo aggiornato con successo.',
                    'already-default'        => 'Avviso: Questo indirizzo è già impostato come predefinito.',
                ],

                'wishlist' => [
                    'product-removed' => 'Attenzione: Prodotto non trovato.',
                    'success'         => 'Successo: Prodotto aggiunto alla lista dei desideri con successo.',
                    'already-exist'   => 'Attenzione: Già aggiunto alla lista dei desideri.',
                    'remove-success'  => 'Successo: Elemento rimosso con successo dalla lista dei desideri.',
                    'not-found'       => 'Attenzione: Nessun prodotto trovato nella lista dei desideri.',
                    'moved-to-cart'   => 'Successo: Prodotto spostato con successo nel carrello.',
                ],

                'orders' => [
                    'not-found'      => 'Attenzione: Nessun ordine trovato.',
                    'cancel-error'   => 'Attenzione: Ordine non annullato.',
                    'cancel-success' => 'Successo: Ordine annullato con successo.',

                    'shipment' => [
                        'not-found' => 'Attenzione: Spedizione non trovata.',
                    ],

                    'invoice' => [
                        'not-found' => 'Attenzione: Fattura non trovata.',
                    ],

                    'refund' => [
                        'not-found' => 'Attenzione: Rimborso non trovato.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Attenzione: Prodotto scaricabile non trovato.',
                    'not-auth'       => 'Attenzione: Non sei autorizzato a eseguire questa azione.',
                    'payment-error'  => 'Il pagamento non è stato effettuato per questo download.',
                    'download-error' => 'Il link di download è scaduto.',
                ],

                'gdpr' => [
                    'create-success'       => 'Successo: Richiesta GDPR creata con successo.',
                    'revoke-failed'        => 'Avviso: La richiesta GDPR non è stata revocata.',
                    'revoked-successfully' => 'Successo: Richiesta GDPR revocata con successo.',
                    'not-enabled'          => 'Avviso: Il GDPR non è abilitato.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Avviso: Prodotto da confrontare non trovato.',
                'product-not-found'   => 'Avviso: Prodotto non trovato.',
                'already-added'       => 'Avviso: Prodotto già aggiunto alla lista di confronto.',
                'item-add-success'    => 'Successo: Prodotto aggiunto con successo alla lista di confronto.',
                'remove-success'      => 'Successo: Articolo rimosso con successo dalla lista di confronto.',
                'mass-remove-success' => 'Successo: Elementi selezionati eliminati con successo.',
                'not-auth'            => 'Avviso: Non sei autorizzato a eseguire questa azione.',
            ],

            'reviews' => [
                'create-success'      => 'Successo: Recensione creata con successo.',
                'delete-success'      => 'Successo: Recensione eliminata con successo.',
                'mass-delete-success' => 'Successo: Recensioni selezionate eliminate con successo.',
                'not-found'           => 'Attenzione: Recensione non trovata.',
                'product-not-found'   => 'Avviso: Prodotto non trovato.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Attenzione: I link scaricabili non sono disponibili.',
                        'invalid-parameter'  => 'Attenzione: Parametri non validi forniti.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Successo: Prodotto aggiunto al carrello con successo.',
                        'update-to-cart'   => 'Successo: Prodotto aggiornato nel carrello con successo.',
                        'delete-cart-item' => 'Successo: Elemento rimosso con successo dal carrello.',
                        'all-remove'       => 'Successo: Tutti gli elementi rimossi dal carrello.',
                        'move-to-wishlist' => 'Successo: Elementi selezionati spostati con successo nella lista dei desideri.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Attenzione: Tutti gli elementi non rimossi dal carrello.',
                        'update-to-cart'   => 'Attenzione: Prodotto non aggiornato nel carrello.',
                        'delete-cart-item' => 'Attenzione: Elemento non rimosso dal carrello.',
                        'not-found'        => 'Attenzione: Carrello non trovato.',
                        'item-not-found'   => 'Attenzione: Elemento non trovato.',
                        'move-to-wishlist' => 'Attenzione: Elementi selezionati non spostati nella lista dei desideri.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Attenzione: L\'utente ospite non può aggiungere indirizzi.',
                'guest-checkout-warning'    => 'Attenzione: L\'utente ospite non può effettuare il checkout.',
                'no-billing-address-found'  => 'Attenzione: Nessun indirizzo di fatturazione trovato.',
                'no-shipping-address-found' => 'Attenzione: Nessun indirizzo di spedizione trovato.',
                'address-save-success'      => 'Successo: Indirizzo salvato con successo.',
            ],

            'shipping' => [
                'method-not-found' => 'Attenzione: Metodo di spedizione non trovato.',
                'method-fetched'   => 'Successo: Metodo di spedizione recuperato con successo.',
                'save-failed'      => 'Attenzione: Metodo di spedizione non salvato.',
                'save-success'     => 'Successo: Metodo di spedizione salvato con successo.',
            ],

            'payment' => [
                'method-not-found' => 'Attenzione: Metodo di pagamento non trovato.',
                'method-fetched'   => 'Successo: Metodo di pagamento recuperato con successo.',
                'save-failed'      => 'Attenzione: Metodo di pagamento non salvato.',
                'save-success'     => 'Successo: Metodo di pagamento salvato con successo.',
            ],

            'coupon' => [
                'apply-success'   => 'Successo: Codice coupon applicato con successo.',
                'already-applied' => 'Attenzione: Codice coupon già applicato.',
                'invalid-code'    => 'Attenzione: Codice coupon non valido.',
                'remove-success'  => 'Successo: Codice coupon rimosso con successo.',
                'remove-failed'   => 'Attenzione: Codice coupon non rimosso.',
            ],

            'something-wrong'          => 'Attenzione: Qualcosa è andato storto.',
            'invalid-guest-user'       => 'Attenzione: Utente ospite non valido.',
            'empty-cart'               => 'Attenzione: Il carrello è vuoto.',
            'missing-billing-address'  => 'Attenzione: Indirizzo di fatturazione mancante.',
            'missing-shipping-address' => 'Attenzione: Indirizzo di spedizione mancante.',
            'missing-shipping-method'  => 'Attenzione: Metodo di spedizione mancante.',
            'missing-payment-method'   => 'Attenzione: Metodo di pagamento mancante.',
            'no-address-found'         => 'Attenzione: Nessun indirizzo di fatturazione e spedizione trovato.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Crea',
            'delete'            => 'Elimina',
            'edit'              => 'Modifica',
            'mass-delete'       => 'Eliminazione di massa',
            'mass-update'       => 'Aggiornamento di massa',
            'push-notification' => 'Notifica push',
            'send'              => 'Invia',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Notifica push',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Argomento della notifica',
                        'info'                            => 'Configurazioni relative alle notifiche',
                        'push-notification-configuration' => 'Configurazione delle notifiche push FCM',
                        'title'                           => 'API GraphQL',
                        'private-key'                     => 'Contenuto del file JSON della chiave privata',
                        'info-get-private-key'            => 'Info: Per ottenere il contenuto del file JSON della chiave privata FCM: <a href="https://console.firebase.google.com/" target="_blank">Clicca qui</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Successo: Script personalizzati aggiornati con successo.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Attenzione: L\'ordine non può essere annullato.',
                'cancel-success' => 'Successo: Ordine annullato con successo.',
                'not-found'      => 'Attenzione: Ordine non trovato.',
            ],

            'shipments' => [
                'creation-error'   => 'Attenzione: Spedizione non creata.',
                'not-found'        => 'Attenzione: Spedizione non trovata.',
                'quantity-invalid' => 'Attenzione: Quantità non valida fornita.',
                'shipment-error'   => 'Attenzione: Spedizione non creata.',
                'create-success'   => 'Successo: Spedizione creata con successo.',
            ],

            'invoices' => [
                'creation-error' => 'Attenzione: Fattura non creata.',
                'not-found'      => 'Attenzione: Fattura non trovata.',
                'product-error'  => 'Attenzione: Prodotto non valido fornito.',
                'create-success' => 'Successo: Fattura creata con successo.',
                'invalid-qty'    => 'Avviso: Abbiamo trovato una quantità non valida per gli articoli da fatturare.',
            ],

            'refunds' => [
                'creation-error'      => 'Attenzione: Rimborso non creato.',
                'refund-amount-error' => 'Attenzione: Importo di rimborso non valido fornito.',
                'refund-limit-error'  => 'Attenzione: L\'importo del rimborso supera il limite di :amount',
                'not-found'           => 'Attenzione: Rimborso non trovato.',
                'create-success'      => 'Successo: Rimborso creato con successo.',
            ],

            'transactions' => [
                'already-paid'   => 'Attenzione: La fattura è già stata pagata.',
                'amount-exceed'  => 'Attenzione: L\'importo della transazione supera il limite.',
                'zero-amount'    => 'Attenzione: L\'importo della transazione deve essere maggiore di zero.',
                'create-success' => 'Successo: Transazione creata con successo.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Attenzione: Cliente non trovato.',
                'cart-not-found'           => 'Attenzione: Carrello non trovato.',
                'cart-item-not-found'      => 'Attenzione: Elemento del carrello non trovato.',
                'cart-create-success'      => 'Successo: Carrello creato con successo.',
                'cart-item-add-success'    => 'Successo: Prodotto aggiunto al carrello con successo.',
                'cart-item-remove-success' => 'Successo: L\'elemento è stato rimosso con successo dal carrello.',
                'cart-item-update-success' => 'Successo: Prodotto aggiornato nel carrello con successo.',
                'something-wrong'          => 'Attenzione: Qualcosa è andato storto.',
                'address-save-success'     => 'Successo: Indirizzo salvato con successo.',
                'shipping-save-success'    => 'Successo: Metodo di spedizione salvato con successo.',
                'payment-save-success'     => 'Successo: Metodo di pagamento salvato con successo.',
                'order-placed-success'     => 'Successo: Ordine effettuato con successo.',
                'payment-method-not-found' => 'Attenzione: Metodo di pagamento non trovato.',
                'minimum-order-amount-err' => 'Attenzione: L\'importo minimo dell\'ordine deve essere :amount',
                'check-shipping-address'   => 'Attenzione: Controlla l\'indirizzo di spedizione.',
                'check-billing-address'    => 'Attenzione: Controlla l\'indirizzo di fatturazione.',
                'specify-shipping-method'  => 'Attenzione: Specifica il metodo di spedizione.',
                'specify-payment-method'   => 'Attenzione: Specifica il metodo di pagamento.',
                'coupon-not-valid'         => 'Attenzione: Il codice coupon non è valido.',
                'coupon-already-applied'   => 'Attenzione: Il codice coupon è già stato applicato.',
                'coupon-applied'           => 'Successo: Codice coupon applicato con successo.',
                'coupon-removed'           => 'Successo: Codice coupon rimosso con successo.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Prodotto creato con successo.',
                'delete-success'            => 'Prodotto eliminato con successo',
                'not-found'                 => 'Avviso: Prodotto non trovato.',
                'update-success'            => 'Prodotto aggiornato con successo.',
                'configurable-attr-missing' => 'Avviso: Attributo configurabile mancante.',
                'simple-products-error'     => 'Avviso: Prodotti semplici mancanti.',
            ],

            'categories' => [
                'already-taken'  => 'Avviso: Lo slug è già stato utilizzato.',
                'create-success' => 'Categoria creata con successo.',
                'delete-success' => 'Categoria eliminata con successo',
                'not-found'      => 'Avviso: Categoria non trovata.',
                'update-success' => 'Categoria aggiornata con successo.',
                'root-delete'    => 'Avviso: La categoria principale non può essere eliminata.',
            ],

            'attributes' => [
                'create-success'    => 'Attributo creato con successo.',
                'delete-success'    => 'Attributo eliminato con successo',
                'not-found'         => 'Avviso: Attributo non trovato.',
                'update-success'    => 'Attributo aggiornato con successo.',
                'user-define-error' => 'Avviso: Non sei autorizzato a eliminare l\'attributo creato dal sistema.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Gruppo di attributi creato con successo.',
                'delete-success'    => 'Gruppo di attributi eliminato con successo',
                'not-found'         => 'Avviso: Gruppo di attributi non trovato.',
                'update-success'    => 'Gruppo di attributi aggiornato con successo.',
                'user-define-error' => 'Avviso: Non sei autorizzato a eliminare il gruppo di attributi creato dal sistema.',
            ],

            'attribute-families' => [
                'create-success'          => 'Famiglia di attributi creata con successo.',
                'delete-success'          => 'Famiglia di attributi eliminata con successo',
                'not-found'               => 'Avviso: Famiglia di attributi non trovata.',
                'update-success'          => 'Famiglia di attributi aggiornata con successo.',
                'last-delete-error'       => 'Avviso: L\'ultima famiglia di attributi non può essere eliminata.',
                'attribute-product-error' => 'Avviso: Alcuni prodotti sono associati a questa famiglia di attributi.',
                'user-define-error'       => 'Avviso: Non sei autorizzato a eliminare la famiglia di attributi creata dal sistema.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Cliente creato con successo.',
                'delete-order-pending' => 'Impossibile eliminare l\'account cliente perché alcuni ordini sono in sospeso o in stato di elaborazione.',
                'delete-success'       => 'Cliente eliminato con successo',
                'not-found'            => 'Avviso: Cliente non trovato.',
                'note-created-success' => 'Nota creata con successo',
                'update-success'       => 'Cliente aggiornato con successo.',
                'login-success'        => 'Cliente accesso effettuato con successo.',
            ],

            'addresses' => [
                'create-success'         => 'Indirizzo del cliente creato con successo.',
                'default-update-success' => 'L\'indirizzo è impostato come predefinito.',
                'delete-success'         => 'Indirizzo del cliente eliminato con successo.',
                'not-found'              => 'Avviso: Indirizzo del cliente non trovato.',
                'update-success'         => 'Indirizzo del cliente aggiornato con successo.',
                'already-default'        => 'Avviso: Questo indirizzo è già impostato come predefinito.',
            ],

            'groups' => [
                'create-success'     => 'Gruppo cliente creato con successo.',
                'customer-associate' => 'Avviso: Il gruppo non può essere eliminato. Il cliente è associato ad esso.',
                'delete-success'     => 'Gruppo cliente eliminato con successo',
                'not-found'          => 'Avviso: Gruppo cliente non trovato.',
                'update-success'     => 'Gruppo cliente aggiornato con successo.',
                'user-define-error'  => 'Avviso: Non sei autorizzato a eliminare il Gruppo cliente creato dal sistema.',
            ],

            'reviews' => [
                'delete-success' => 'Recensione eliminata con successo',
                'not-found'      => 'Avviso: Recensione non trovata.',
                'update-success' => 'Recensione aggiornata con successo.',
            ],

            'gdpr' => [
                'delete-success' => 'Successo: Richiesta GDPR eliminata con successo.',
                'not-found'      => 'Avviso: Richiesta GDPR non trovata.',
                'update-success' => 'Richiesta GDPR aggiornata con successo.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Avviso: Lo slug è già stato utilizzato.',
            'create-success' => 'CMS creato con successo.',
            'delete-success' => 'CMS eliminato con successo',
            'not-found'      => 'Avviso: CMS non trovato.',
            'update-success' => 'CMS aggiornato con successo.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Regola del catalogo creata con successo.',
                    'delete-failed'  => 'Avviso: La regola del catalogo non è stata eliminata',
                    'delete-success' => 'Regola del catalogo eliminata con successo',
                    'not-found'      => 'Avviso: Regola del catalogo non trovata.',
                    'update-success' => 'Regola del catalogo aggiornata con successo.',
                ],

                'cart-rules' => [
                    'create-success' => 'Regola del carrello creata con successo.',
                    'delete-failed'  => 'Avviso: La regola del carrello non è stata eliminata',
                    'delete-success' => 'Regola del carrello eliminata con successo',
                    'not-found'      => 'Regola del carrello non trovata',
                    'update-success' => 'Regola del carrello aggiornata con successo.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Modello di email creato con successo.',
                    'delete-success' => 'Modello di email eliminato con successo',
                    'not-found'      => 'Avviso: Modello di email non trovato.',
                    'update-success' => 'Modello di email aggiornato con successo.',
                ],

                'events' => [
                    'create-success' => 'Evento creato con successo.',
                    'delete-success' => 'Evento eliminato con successo',
                    'not-found'      => 'Avviso: Evento non trovato.',
                    'update-success' => 'Evento aggiornato con successo.',
                ],

                'campaigns' => [
                    'create-success' => 'Campagna creata con successo.',
                    'delete-success' => 'Campagna eliminata con successo',
                    'not-found'      => 'Avviso: Campagna non trovata.',
                    'update-success' => 'Campagna aggiornata con successo.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Iscrizione eliminata con successo',
                    'not-found'           => 'Avviso: Iscrizione non trovata.',
                    'unsubscribe-success' => 'Successo: Iscrizione annullata con successo.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'URL Rewrite creato con successo.',
                    'delete-success' => 'URL Rewrite eliminato con successo',
                    'not-found'      => 'Avviso: URL Rewrite non trovato.',
                    'update-success' => 'URL Rewrite aggiornato con successo.',
                ],

                'search-terms' => [
                    'create-success' => 'Termine di ricerca creato con successo.',
                    'delete-success' => 'Termine di ricerca eliminato con successo',
                    'not-found'      => 'Avviso: Termine di ricerca non trovato.',
                    'update-success' => 'Termine di ricerca aggiornato con successo.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Sinonimo di ricerca creato con successo.',
                    'delete-success' => 'Sinonimo di ricerca eliminato con successo',
                    'not-found'      => 'Avviso: Sinonimo di ricerca non trovato.',
                    'update-success' => 'Sinonimo di ricerca aggiornato con successo.',
                ],

                'sitemaps' => [
                    'create-success' => 'Sitemap creata con successo.',
                    'delete-success' => 'Sitemap eliminata con successo',
                    'not-found'      => 'Avviso: Sitemap non trovata.',
                    'update-success' => 'Sitemap aggiornata con successo.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Locale creato con successo.',
                'default-delete-error' => 'Impossibile eliminare la lingua predefinita.',
                'delete-error'         => 'Eliminazione della lingua non riuscita.',
                'delete-success'       => 'Lingua eliminata con successo.',
                'last-delete-error'    => 'Eliminazione dell\'ultima lingua non riuscita.',
                'not-found'            => 'Avviso: Lingua non trovata.',
                'update-success'       => 'Lingua aggiornata con successo.',
            ],

            'currencies' => [
                'create-success'       => 'Valuta creata con successo.',
                'default-delete-error' => 'Impossibile eliminare la valuta predefinita.',
                'delete-error'         => 'Eliminazione della valuta non riuscita.',
                'delete-success'       => 'Valuta eliminata con successo.',
                'last-delete-error'    => 'Eliminazione dell\'ultima valuta non riuscita.',
                'not-found'            => 'Avviso: Valuta non trovata.',
                'update-success'       => 'Valuta aggiornata con successo.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Tasso di cambio creato con successo.',
                'delete-error'            => 'Eliminazione del tasso di cambio non riuscita.',
                'delete-success'          => 'Tasso di cambio eliminato con successo.',
                'invalid-target-currency' => 'Avviso: Valuta di destinazione non valida.',
                'last-delete-error'       => 'Eliminazione dell\'ultimo tasso di cambio non riuscita.',
                'not-found'               => 'Avviso: Tasso di cambio non trovato.',
                'update-success'          => 'Tasso di cambio aggiornato con successo.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Inventario creato con successo.',
                'delete-error'      => 'Eliminazione dell\'inventario non riuscita.',
                'delete-success'    => 'Inventario eliminato con successo.',
                'last-delete-error' => 'Eliminazione dell\'ultimo inventario non riuscita.',
                'not-found'         => 'Avviso: Inventario non trovato.',
                'update-success'    => 'Inventario aggiornato con successo.',
            ],

            'channels' => [
                'create-success'       => 'Canale creato con successo.',
                'default-delete-error' => 'Impossibile eliminare il canale predefinito.',
                'delete-error'         => 'Eliminazione del canale non riuscita.',
                'delete-success'       => 'Canale eliminato con successo.',
                'last-delete-error'    => 'Eliminazione dell\'ultimo canale non riuscita.',
                'not-found'            => 'Avviso: Canale non trovato.',
                'update-success'       => 'Canale aggiornato con successo.',
            ],

            'users' => [
                'activate-warning'  => 'Il tuo account deve ancora essere attivato, contatta l\'amministratore.',
                'create-success'    => 'Utente creato con successo.',
                'delete-error'      => 'Eliminazione dell\'utente non riuscita.',
                'delete-success'    => 'Utente eliminato con successo.',
                'last-delete-error' => 'Eliminazione dell\'ultimo utente non riuscita.',
                'login-error'       => 'Controlla le tue credenziali e riprova.',
                'not-found'         => 'Avviso: Utente non trovato.',
                'success-login'     => 'Accesso utente effettuato con successo.',
                'success-logout'    => 'Logout utente effettuato con successo.',
                'update-success'    => 'Utente aggiornato con successo.',
            ],

            'roles' => [
                'create-success'    => 'Ruolo creato con successo.',
                'delete-error'      => 'Eliminazione del ruolo non riuscita.',
                'delete-success'    => 'Ruolo eliminato con successo.',
                'last-delete-error' => 'Impossibile eliminare l\'ultimo ruolo.',
                'not-found'         => 'Avviso: Ruolo non trovato.',
                'update-success'    => 'Ruolo aggiornato con successo.',
            ],

            'themes' => [
                'create-success' => 'Tema creato con successo.',
                'delete-success' => 'Tema eliminato con successo.',
                'not-found'      => 'Avviso: Tema non trovato.',
                'update-success' => 'Tema aggiornato con successo.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => "L'ID categoria specificato non esiste.",
                        'invalid-boolean-value' => 'Il valore :key deve essere 0 o 1.',
                        'invalid-filter-key'    => 'La chiave del filtro ":key" non è consentita.',
                        'invalid-limit-value'   => 'Il valore del limite deve essere uno dei seguenti: :options.',
                        'invalid-select-option' => 'Il valore :key non è valido. Le opzioni valide sono: :options.',
                        'invalid-sort-value'    => 'Il valore di ordinamento deve essere uno dei seguenti: :options.',
                        'missing-limit-key'     => 'filtersInput deve includere una chiave "limit".',
                        'missing-sort-key'      => 'filtersInput deve includere una chiave "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Aliquota fiscale creata con successo.',
                'delete-error'   => 'Eliminazione dell\'aliquota fiscale non riuscita.',
                'delete-success' => 'Aliquota fiscale eliminata con successo.',
                'not-found'      => 'Avviso: Aliquota fiscale non trovata.',
                'update-success' => 'Aliquota fiscale aggiornata con successo.',
            ],

            'tax-category' => [
                'create-success'     => 'Categoria fiscale creata con successo.',
                'delete-error'       => 'Eliminazione della categoria fiscale non riuscita.',
                'delete-success'     => 'Categoria fiscale eliminata con successo.',
                'not-found'          => 'Avviso: Categoria fiscale non trovata.',
                'tax-rate-not-found' => 'Gli ID forniti non sono stati trovati. ID: :ids',
                'update-success'     => 'Categoria fiscale aggiornata con successo.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Aggiungi notifica',
                    'general'   => 'Generale',
                    'title'     => 'Notifica push',

                    'datagrid' => [
                        'channel-name'         => 'Nome canale',
                        'created-at'           => 'Ora creazione',
                        'delete'               => 'Elimina',
                        'id'                   => 'ID',
                        'image'                => 'Immagine',
                        'notification-content' => 'Contenuto notifica',
                        'notification-status'  => 'Stato notifica',
                        'notification-type'    => 'Tipo notifica',
                        'text-title'           => 'Titolo',
                        'update'               => 'Aggiorna',
                        'updated-at'           => 'Ora aggiornamento',

                        'status' => [
                            'disabled' => 'Disabilitato',
                            'enabled'  => 'Abilitato',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Indietro',
                    'content-and-image'    => 'Contenuto e immagine notifica',
                    'create-btn-title'     => 'Salva notifica',
                    'general'              => 'Generale',
                    'image'                => 'Immagine',
                    'new-notification'     => 'Nuova notifica',
                    'notification-content' => 'Contenuto notifica',
                    'notification-type'    => 'Tipo notifica',
                    'product-cat-id'       => 'ID prodotto/categoria',
                    'settings'             => 'Impostazioni',
                    'status'               => 'Stato',
                    'store-view'           => 'Canali',
                    'title'                => 'Notifica push',

                    'option-type' => [
                        'category' => 'Categoria',
                        'others'   => 'Semplice',
                        'product'  => 'Prodotto',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Indietro',
                    'content-and-image'    => 'Contenuto e immagine notifica',
                    'edit-notification'    => 'Modifica notifica',
                    'general'              => 'Generale',
                    'image'                => 'Immagine',
                    'notification-content' => 'Contenuto notifica',
                    'notification-type'    => 'Tipo notifica',
                    'product-cat-id'       => 'ID prodotto/categoria',
                    'send-title'           => 'Invia notifica',
                    'settings'             => 'Impostazioni',
                    'status'               => 'Stato',
                    'store-view'           => 'Canali',
                    'title'                => 'Notifica push',
                    'update-btn-title'     => 'Aggiorna',

                    'option-type' => [
                        'category' => 'Categoria',
                        'others'   => 'Semplice',
                        'product'  => 'Prodotto',
                    ],
                ],

                'not-found'           => 'Avviso: Notifica non trovata.',
                'create-success'      => 'Notifica creata con successo.',
                'delete-failed'       => 'Eliminazione della notifica non riuscita.',
                'delete-success'      => 'Notifica eliminata con successo.',
                'mass-update-success' => 'Notifiche selezionate aggiornate con successo.',
                'mass-delete-success' => 'Notifiche selezionate eliminate con successo.',
                'no-value-selected'   => 'Nessun valore selezionato.',
                'send-success'        => 'Notifica inviata con successo.',
                'update-success'      => 'Notifica aggiornata con successo.',
                'configuration-error' => 'Avviso: Configurazione FCM non trovata.',
                'product-not-found'   => 'Avviso: Prodotto non trovato.',
                'category-not-found'  => 'Avviso: Categoria non trovata.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Avviso: Parametri forniti non validi.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Attenzione: configurazione email non trovata.',
    ],
];
