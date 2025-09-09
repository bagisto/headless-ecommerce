<?php

return [
    'shop' => [
        'subscription' => [
            'already-subscribed' => 'Jesteś już zapisany do naszego newslettera.',
            'subscribe-success'  => 'Pomyślnie zapisałeś się do naszego newslettera.',
        ],

        'contact-us' => [
            'thanks-for-contact' => 'Dziękujemy za skontaktowanie się z nami. Skontaktujemy się z Tobą wkrótce.',
        ],

        'downloadable-products' => [
            'download-sample' => [
                'link-not-found'   => 'Ostrzeżenie: Link do pobrania nie znaleziony.',
                'sample-not-found' => 'Ostrzeżenie: Próbka do pobrania nie znaleziona.',
            ],
        ],

        'customers' => [
            'no-login-customer' => 'Ostrzeżenie: Nie znaleziono zalogowanego klienta.',
            'success-login'     => 'Sukces: Pomyślnie zalogowano klienta.',
            'success-logout'    => 'Sukces: Pomyślnie wylogowano klienta.',

            'signup' => [
                'error-registration' => 'Ostrzeżenie: Rejestracja klienta nie powiodła się.',
                'success-verify'     => 'Konto zostało pomyślnie utworzone, e-mail z instrukcjami weryfikacyjnymi został wysłany.',
                'success'            => 'Sukces: Klient został pomyślnie zarejestrowany i zalogowany.',
            ],

            'social-login' => [
                'disabled' => 'Ostrzeżenie: Logowanie społecznościowe jest wyłączone.',
            ],

            'login' => [
                'invalid-creds' => 'Sprawdź swoje dane logowania i spróbuj ponownie.',
                'not-activated' => 'Twoje konto wymaga zatwierdzenia przez administratora.',
                'verify-first'  => 'Proszę najpierw zweryfikować swój adres e-mail.',
                'suspended'     => 'Twoje konto zostało zawieszone przez administratora.',

                'validation' => [
                    'required' => 'Pole :field jest wymagane.',
                    'same'     => 'Pole :field i hasło muszą być takie same.',
                    'unique'   => 'Ten :field jest już zajęty.',
                ],
            ],

            'forgot-password' => [
                'already-sent'    => 'Link do resetowania hasła został już wysłany na Twój adres e-mail.',
                'email-not-exist' => 'Adres e-mail nie istnieje.',
                'reset-link-sent' => 'Link do resetowania hasła został wysłany na Twój adres e-mail.',
            ],

            'account' => [
                'profile' => [
                    'customer-details' => 'Sukces: Szczegóły klienta zostały pomyślnie pobrane.',
                    'delete-success'   => 'Sukces: Konto zostało pomyślnie usunięte.',
                    'password-unmatch' => 'Hasło nie pasuje.',
                    'update-fail'      => 'Ostrzeżenie: Profil nie został zaktualizowany.',
                    'update-success'   => 'Sukces: Profil został pomyślnie zaktualizowany.',
                    'wrong-password'   => 'Ostrzeżenie: Podano błędne hasło.',
                    'order-pending'    => 'Nie można usunąć konta, ponieważ masz niektóre zamówienia w toku.',
                ],

                'addresses' => [
                    'create-success'         => 'Adres został pomyślnie utworzony.',
                    'default-update-success' => 'Adres został ustawiony jako domyślny.',
                    'delete-success'         => 'Adres został pomyślnie usunięty.',
                    'not-found'              => 'Ostrzeżenie: Nie znaleziono adresu.',
                    'update-success'         => 'Adres został pomyślnie zaktualizowany.',
                    'already-default'        => 'Ostrzeżenie: Ten adres jest już ustawiony jako domyślny.',
                ],

                'wishlist' => [
                    'product-removed' => 'Ostrzeżenie: Nie znaleziono produktu.',
                    'success'         => 'Sukces: Produkt został pomyślnie dodany do listy życzeń.',
                    'already-exist'   => 'Ostrzeżenie: Już dodano do listy życzeń.',
                    'remove-success'  => 'Sukces: Element został pomyślnie usunięty z listy życzeń.',
                    'not-found'       => 'Ostrzeżenie: Brak produktów w liście życzeń.',
                    'moved-to-cart'   => 'Sukces: Wybrane elementy zostały pomyślnie przeniesione do koszyka.',
                ],

                'orders' => [
                    'not-found'      => 'Ostrzeżenie: Nie znaleziono zamówień.',
                    'cancel-error'   => 'Ostrzeżenie: Nie można anulować zamówienia.',
                    'cancel-success' => 'Sukces: Zamówienie zostało pomyślnie anulowane.',

                    'shipment' => [
                        'not-found' => 'Ostrzeżenie: Nie znaleziono przesyłki.',
                    ],

                    'invoice' => [
                        'not-found' => 'Ostrzeżenie: Nie znaleziono faktury.',
                    ],

                    'refund' => [
                        'not-found' => 'Ostrzeżenie: Nie znaleziono zwrotu.',
                    ],
                ],

                'downloadable-products' => [
                    'not-found'      => 'Ostrzeżenie: Nie znaleziono produktu do pobrania.',
                    'not-auth'       => 'Ostrzeżenie: Nie masz uprawnień do wykonania tej operacji.',
                    'payment-error'  => 'Płatność nie została dokonana za ten plik do pobrania.',
                    'download-error' => 'Link do pobrania wygasł.',
                ],

                'gdpr' => [
                    'create-success'       => 'Sukces: Żądanie GDPR zostało pomyślnie utworzone.',
                    'revoke-failed'        => 'Ostrzeżenie: Nie udało się odwołać żądania GDPR.',
                    'revoked-successfully' => 'Sukces: Żądanie GDPR zostało pomyślnie odwołane.',
                    'not-enabled'          => 'Ostrzeżenie: GDPR nie jest włączone.',
                ],
            ],

            'compare-product' => [
                'not-found'           => 'Ostrzeżenie: Produkt do porównania nie został znaleziony.',
                'product-not-found'   => 'Ostrzeżenie: Produkt nie został znaleziony.',
                'already-added'       => 'Ostrzeżenie: Produkt został już dodany do listy porównawczej.',
                'item-add-success'    => 'Sukces: Produkt został pomyślnie dodany do listy porównawczej.',
                'remove-success'      => 'Sukces: Przedmiot został pomyślnie usunięty z listy porównawczej.',
                'mass-remove-success' => 'Sukces: Wybrane przedmioty zostały pomyślnie usunięte.',
                'not-auth'            => 'Ostrzeżenie: Nie masz uprawnień do wykonania tej operacji.',
            ],

            'reviews' => [
                'create-success'      => 'Sukces: Recenzja została pomyślnie utworzona.',
                'delete-success'      => 'Sukces: Recenzja została pomyślnie usunięta.',
                'mass-delete-success' => 'Sukces: Wybrane recenzje zostały pomyślnie usunięte.',
                'not-found'           => 'Ostrzeżenie: Nie znaleziono recenzji.',
                'product-not-found'   => 'Ostrzeżenie: Produkt nie znaleziony.',
            ],
        ],

        'checkout' => [
            'cart' => [
                'item' => [
                    'error' => [
                        'downloadable-links' => 'Ostrzeżenie: Nie można pobrać linków do produktów.',
                        'invalid-parameter'  => 'Ostrzeżenie: Podano nieprawidłowe parametry.',
                    ],

                    'success' => [
                        'add-to-cart'      => 'Sukces: Produkt został pomyślnie dodany do koszyka.',
                        'update-to-cart'   => 'Sukces: Produkt został pomyślnie zaktualizowany w koszyku.',
                        'delete-cart-item' => 'Sukces: Element został pomyślnie usunięty z koszyka.',
                        'all-remove'       => 'Sukces: Wszystkie elementy zostały usunięte z koszyka.',
                        'move-to-wishlist' => 'Sukces: Wybrane elementy zostały pomyślnie przeniesione do listy życzeń.',
                    ],

                    'fail' => [
                        'all-remove'       => 'Ostrzeżenie: Wszystkie elementy nie zostały usunięte z koszyka.',
                        'update-to-cart'   => 'Ostrzeżenie: Produkt nie został zaktualizowany w koszyku.',
                        'delete-cart-item' => 'Ostrzeżenie: Element nie został usunięty z koszyka.',
                        'not-found'        => 'Ostrzeżenie: Nie znaleziono koszyka.',
                        'item-not-found'   => 'Ostrzeżenie: Nie znaleziono elementu.',
                        'move-to-wishlist' => 'Ostrzeżenie: Wybrane elementy nie zostały przeniesione do listy życzeń.',
                    ],
                ],
            ],

            'addresses' => [
                'guest-address-warning'     => 'Ostrzeżenie: Gość nie może dodać adresu.',
                'guest-checkout-warning'    => 'Ostrzeżenie: Gość nie może dokonać zamówienia.',
                'no-billing-address-found'  => 'Ostrzeżenie: Nie znaleziono adresu rozliczeniowego.',
                'no-shipping-address-found' => 'Ostrzeżenie: Nie znaleziono adresu dostawy.',
                'address-save-success'      => 'Sukces: Adres został pomyślnie zapisany.',
            ],

            'shipping' => [
                'method-not-found' => 'Ostrzeżenie: Nie znaleziono metody dostawy.',
                'method-fetched'   => 'Sukces: Metoda dostawy została pomyślnie pobrana.',
                'save-failed'      => 'Ostrzeżenie: Metoda dostawy nie została zapisana.',
                'save-success'     => 'Sukces: Metoda dostawy została pomyślnie zapisana.',
            ],

            'payment' => [
                'method-not-found' => 'Ostrzeżenie: Nie znaleziono metody płatności.',
                'method-fetched'   => 'Sukces: Metoda płatności została pomyślnie pobrana.',
                'save-failed'      => 'Ostrzeżenie: Metoda płatności nie została zapisana.',
                'save-success'     => 'Sukces: Metoda płatności została pomyślnie zapisana.',
            ],

            'coupon' => [
                'apply-success'   => 'Sukces: Kod kuponu został pomyślnie zastosowany.',
                'already-applied' => 'Ostrzeżenie: Kod kuponu został już zastosowany.',
                'invalid-code'    => 'Ostrzeżenie: Kod kuponu jest nieprawidłowy.',
                'remove-success'  => 'Sukces: Kod kuponu został pomyślnie usunięty.',
                'remove-failed'   => 'Ostrzeżenie: Kod kuponu nie został usunięty.',
            ],

            'something-wrong'          => 'Ostrzeżenie: Coś poszło nie tak.',
            'invalid-guest-user'       => 'Ostrzeżenie: Nieprawidłowy gościnny użytkownik.',
            'empty-cart'               => 'Ostrzeżenie: Koszyk jest pusty.',
            'missing-billing-address'  => 'Ostrzeżenie: Brak adresu rozliczeniowego.',
            'missing-shipping-address' => 'Ostrzeżenie: Brak adresu dostawy.',
            'missing-shipping-method'  => 'Ostrzeżenie: Brak metody dostawy.',
            'missing-payment-method'   => 'Ostrzeżenie: Brak metody płatności.',
            'no-address-found'         => 'Ostrzeżenie: Nie znaleziono adresu rozliczeniowego i dostawy.',
        ],
    ],

    'admin' => [
        'acl' => [
            'create'            => 'Utwórz',
            'delete'            => 'Usuń',
            'edit'              => 'Edytuj',
            'mass-delete'       => 'Usuń masowo',
            'mass-update'       => 'Aktualizuj masowo',
            'push-notification' => 'Powiadomienie push',
            'send'              => 'Wyślij',
        ],

        'components' => [
            'layouts' => [
                'sidebar' => [
                    'push-notification' => 'Powiadomienie push',
                ],
            ],
        ],

        'configuration' => [
            'index' => [
                'general' => [
                    'graphql-api' => [
                        'notification-topic'              => 'Temat powiadomienia',
                        'info'                            => 'Konfiguracje powiązane z powiadomieniami',
                        'push-notification-configuration' => 'Konfiguracja powiadomień push FCM',
                        'title'                           => 'GraphQL API',
                        'private-key'                     => 'Zawartość pliku JSON z kluczem prywatnym',
                        'info-get-private-key'            => 'Informacja: Aby uzyskać zawartość pliku JSON z kluczem prywatnym FCM: <a href="https://console.firebase.google.com/" target="_blank">Kliknij tutaj</a>',
                    ],

                    'content' => [
                        'custom-script' => [
                            'update-success' => 'Sukces: Skrypty niestandardowe zostały pomyślnie zaktualizowane.',
                        ],
                    ],
                ],
            ],
        ],

        'sales' => [
            'orders' => [
                'cancel-error'   => 'Ostrzeżenie: Nie można anulować zamówienia.',
                'cancel-success' => 'Sukces: Zamówienie zostało pomyślnie anulowane.',
                'not-found'      => 'Ostrzeżenie: Zamówienie nie zostało znalezione.',
            ],

            'shipments' => [
                'creation-error'   => 'Ostrzeżenie: Wysyłka nie została utworzona.',
                'not-found'        => 'Ostrzeżenie: Wysyłka nie została znaleziona.',
                'quantity-invalid' => 'Ostrzeżenie: Podano nieprawidłową ilość.',
                'shipment-error'   => 'Ostrzeżenie: Wysyłka nie została utworzona.',
                'create-success'   => 'Sukces: Wysyłka została pomyślnie utworzona.',
            ],

            'invoices' => [
                'creation-error' => 'Ostrzeżenie: Faktura nie została utworzona.',
                'not-found'      => 'Ostrzeżenie: Faktura nie została znaleziona.',
                'product-error'  => 'Ostrzeżenie: Podano nieprawidłowy produkt.',
                'create-success' => 'Sukces: Faktura została pomyślnie utworzona.',
                'invalid-qty'    => 'Ostrzeżenie: Znaleziono nieprawidłową ilość do fakturowania pozycji.',
            ],

            'refunds' => [
                'creation-error'      => 'Ostrzeżenie: Zwrot nie został utworzony.',
                'refund-amount-error' => 'Ostrzeżenie: Podano nieprawidłową kwotę zwrotu.',
                'refund-limit-error'  => 'Ostrzeżenie: Kwota zwrotu przekracza limit :amount',
                'not-found'           => 'Ostrzeżenie: Zwrot nie został znaleziony.',
                'create-success'      => 'Sukces: Zwrot został pomyślnie utworzony.',
            ],

            'transactions' => [
                'already-paid'   => 'Ostrzeżenie: Faktura jest już opłacona.',
                'amount-exceed'  => 'Ostrzeżenie: Kwota transakcji przekracza limit.',
                'zero-amount'    => 'Ostrzeżenie: Kwota transakcji powinna być większa niż zero.',
                'create-success' => 'Sukces: Transakcja została pomyślnie utworzona.',
            ],

            'reorder' => [
                'customer-not-found'       => 'Ostrzeżenie: Klient nie został znaleziony.',
                'cart-not-found'           => 'Ostrzeżenie: Koszyk nie został znaleziony.',
                'cart-item-not-found'      => 'Ostrzeżenie: Pozycja koszyka nie została znaleziona.',
                'cart-create-success'      => 'Sukces: Koszyk został pomyślnie utworzony.',
                'cart-item-add-success'    => 'Sukces: Produkt został pomyślnie dodany do koszyka.',
                'cart-item-remove-success' => 'Sukces: Pozycja została pomyślnie usunięta z koszyka.',
                'cart-item-update-success' => 'Sukces: Produkt został pomyślnie zaktualizowany w koszyku.',
                'something-wrong'          => 'Ostrzeżenie: Coś poszło nie tak.',
                'address-save-success'     => 'Sukces: Adres został pomyślnie zapisany.',
                'shipping-save-success'    => 'Sukces: Metoda wysyłki została pomyślnie zapisana.',
                'payment-save-success'     => 'Sukces: Metoda płatności została pomyślnie zapisana.',
                'order-placed-success'     => 'Sukces: Zamówienie zostało pomyślnie złożone.',
                'payment-method-not-found' => 'Ostrzeżenie: Metoda płatności nie została znaleziona.',
                'minimum-order-amount-err' => 'Ostrzeżenie: Minimalna kwota zamówienia powinna wynosić :amount',
                'check-shipping-address'   => 'Ostrzeżenie: Sprawdź adres dostawy.',
                'check-billing-address'    => 'Ostrzeżenie: Sprawdź adres rozliczeniowy.',
                'specify-shipping-method'  => 'Ostrzeżenie: Określ metodę wysyłki.',
                'specify-payment-method'   => 'Ostrzeżenie: Określ metodę płatności.',
                'coupon-not-valid'         => 'Ostrzeżenie: Kod kuponu jest nieprawidłowy.',
                'coupon-already-applied'   => 'Ostrzeżenie: Kod kuponu został już zastosowany.',
                'coupon-applied'           => 'Sukces: Kod kuponu został pomyślnie zastosowany.',
                'coupon-removed'           => 'Sukces: Kod kuponu został pomyślnie usunięty.',
            ],
        ],

        'catalog' => [
            'products' => [
                'create-success'            => 'Produkt został pomyślnie utworzony.',
                'delete-success'            => 'Produkt został pomyślnie usunięty.',
                'not-found'                 => 'Ostrzeżenie: Produkt nie został znaleziony.',
                'update-success'            => 'Produkt został pomyślnie zaktualizowany.',
                'configurable-attr-missing' => 'Ostrzeżenie: Brakuje atrybutu konfigurowalnego.',
                'simple-products-error'     => 'Ostrzeżenie: Brakuje produktów prostych.',
            ],

            'categories' => [
                'already-taken'  => 'Ostrzeżenie: Ten slug jest już zajęty.',
                'create-success' => 'Kategoria została pomyślnie utworzona.',
                'delete-success' => 'Kategoria została pomyślnie usunięta.',
                'not-found'      => 'Ostrzeżenie: Kategoria nie została znaleziona.',
                'update-success' => 'Kategoria została pomyślnie zaktualizowana.',
                'root-delete'    => 'Ostrzeżenie: Kategoria główna nie może zostać usunięta.',
            ],

            'attributes' => [
                'create-success'    => 'Atrybut został pomyślnie utworzony.',
                'delete-success'    => 'Atrybut został pomyślnie usunięty.',
                'not-found'         => 'Ostrzeżenie: Atrybut nie został znaleziony.',
                'update-success'    => 'Atrybut został pomyślnie zaktualizowany.',
                'user-define-error' => 'Ostrzeżenie: Nie masz uprawnień do usunięcia atrybutu utworzonego przez system.',
            ],

            'attribute-groups' => [
                'create-success'    => 'Grupa atrybutów została pomyślnie utworzona.',
                'delete-success'    => 'Grupa atrybutów została pomyślnie usunięta.',
                'not-found'         => 'Ostrzeżenie: Grupa atrybutów nie została znaleziona.',
                'update-success'    => 'Grupa atrybutów została pomyślnie zaktualizowana.',
                'user-define-error' => 'Ostrzeżenie: Nie masz uprawnień do usunięcia grupy atrybutów utworzonej przez system.',
            ],

            'attribute-families' => [
                'create-success'          => 'Rodzina atrybutów została pomyślnie utworzona.',
                'delete-success'          => 'Rodzina atrybutów została pomyślnie usunięta.',
                'not-found'               => 'Ostrzeżenie: Rodzina atrybutów nie została znaleziona.',
                'update-success'          => 'Rodzina atrybutów została pomyślnie zaktualizowana.',
                'last-delete-error'       => 'Ostrzeżenie: Ostatnia rodzina atrybutów nie może zostać usunięta.',
                'attribute-product-error' => 'Ostrzeżenie: Niektóre produkty są powiązane z tą rodziną atrybutów.',
                'user-define-error'       => 'Ostrzeżenie: Nie masz uprawnień do usunięcia rodziny atrybutów utworzonej przez system.',
            ],
        ],

        'customers' => [
            'customers' => [
                'create-success'       => 'Klient został pomyślnie utworzony.',
                'delete-order-pending' => 'Nie można usunąć konta klienta, ponieważ istnieją niezrealizowane zamówienia lub zamówienia w trakcie przetwarzania.',
                'delete-success'       => 'Klient został pomyślnie usunięty.',
                'not-found'            => 'Ostrzeżenie: Klient nie został znaleziony.',
                'note-created-success' => 'Notatka została pomyślnie utworzona.',
                'update-success'       => 'Klient został pomyślnie zaktualizowany.',
                'login-success'        => 'Klient został pomyślnie zalogowany.',
            ],

            'addresses' => [
                'create-success'         => 'Adres klienta został pomyślnie utworzony.',
                'default-update-success' => 'Adres został ustawiony jako domyślny.',
                'delete-success'         => 'Adres klienta został pomyślnie usunięty.',
                'not-found'              => 'Ostrzeżenie: Adres klienta nie został znaleziony.',
                'update-success'         => 'Adres klienta został pomyślnie zaktualizowany.',
                'already-default'        => 'Ostrzeżenie: Ten adres jest już ustawiony jako domyślny.',
            ],

            'groups' => [
                'create-success'     => 'Grupa klientów została pomyślnie utworzona.',
                'customer-associate' => 'Ostrzeżenie: Grupy nie można usunąć. Klient jest z nią powiązany.',
                'delete-success'     => 'Grupa klientów została pomyślnie usunięta.',
                'not-found'          => 'Ostrzeżenie: Grupa klientów nie została znaleziona.',
                'update-success'     => 'Grupa klientów została pomyślnie zaktualizowana.',
                'user-define-error'  => 'Ostrzeżenie: Nie masz uprawnień do usunięcia grupy klientów utworzonej przez system.',
            ],

            'reviews' => [
                'delete-success' => 'Recenzja została pomyślnie usunięta.',
                'not-found'      => 'Ostrzeżenie: Recenzja nie została znaleziona.',
                'update-success' => 'Recenzja została pomyślnie zaktualizowana.',
            ],

            'gdpr' => [
                'delete-success' => 'Succes: GDPR-verzoek succesvol verwijderd.',
                'not-found'      => 'Waarschuwing: GDPR-verzoek niet gevonden.',
                'update-success' => 'GDPR-verzoek succesvol bijgewerkt.',
            ],
        ],

        'cms' => [
            'already-taken'  => 'Ostrzeżenie: Ten slug jest już zajęty.',
            'create-success' => 'CMS zostało pomyślnie utworzone.',
            'delete-success' => 'CMS zostało pomyślnie usunięte.',
            'not-found'      => 'Ostrzeżenie: CMS nie zostało znalezione.',
            'update-success' => 'CMS zostało pomyślnie zaktualizowane.',
        ],

        'marketing' => [
            'promotions' => [
                'catalog-rules' => [
                    'create-success' => 'Reguła katalogu została pomyślnie utworzona.',
                    'delete-failed'  => 'Ostrzeżenie: Reguła katalogu nie została usunięta.',
                    'delete-success' => 'Reguła katalogu została pomyślnie usunięta.',
                    'not-found'      => 'Ostrzeżenie: Reguła katalogu nie została znaleziona.',
                    'update-success' => 'Reguła katalogu została pomyślnie zaktualizowana.',
                ],

                'cart-rules' => [
                    'create-success' => 'Reguła koszyka została pomyślnie utworzona.',
                    'delete-failed'  => 'Ostrzeżenie: Reguła koszyka nie została usunięta.',
                    'delete-success' => 'Reguła koszyka została pomyślnie usunięta.',
                    'not-found'      => 'Reguła koszyka nie została znaleziona.',
                    'update-success' => 'Reguła koszyka została pomyślnie zaktualizowana.',
                ],
            ],

            'communications' => [
                'email-templates' => [
                    'create-success' => 'Szablon e-maila został pomyślnie utworzony.',
                    'delete-success' => 'Szablon e-maila został pomyślnie usunięty.',
                    'not-found'      => 'Ostrzeżenie: Szablon e-maila nie został znaleziony.',
                    'update-success' => 'Szablon e-maila został pomyślnie zaktualizowany.',
                ],

                'events' => [
                    'create-success' => 'Wydarzenie zostało pomyślnie utworzone.',
                    'delete-success' => 'Wydarzenie zostało pomyślnie usunięte.',
                    'not-found'      => 'Ostrzeżenie: Wydarzenie nie zostało znalezione.',
                    'update-success' => 'Wydarzenie zostało pomyślnie zaktualizowane.',
                ],

                'campaigns' => [
                    'create-success' => 'Kampania została pomyślnie utworzona.',
                    'delete-success' => 'Kampania została pomyślnie usunięta.',
                    'not-found'      => 'Ostrzeżenie: Kampania nie została znaleziona.',
                    'update-success' => 'Kampania została pomyślnie zaktualizowana.',
                ],

                'subscriptions' => [
                    'delete-success'      => 'Subskrypcja została pomyślnie usunięta.',
                    'not-found'           => 'Ostrzeżenie: Subskrypcja nie została znaleziona.',
                    'unsubscribe-success' => 'Sukces: Subskrypcja została pomyślnie anulowana.',
                ],
            ],

            'seo' => [
                'url-rewrites' => [
                    'create-success' => 'Przekierowanie URL zostało pomyślnie utworzone.',
                    'delete-success' => 'Przekierowanie URL zostało pomyślnie usunięte.',
                    'not-found'      => 'Ostrzeżenie: Przekierowanie URL nie zostało znalezione.',
                    'update-success' => 'Przekierowanie URL zostało pomyślnie zaktualizowane.',
                ],

                'search-terms' => [
                    'create-success' => 'Wyszukiwane hasło zostało pomyślnie utworzone.',
                    'delete-success' => 'Wyszukiwane hasło zostało pomyślnie usunięte.',
                    'not-found'      => 'Ostrzeżenie: Wyszukiwane hasło nie zostało znalezione.',
                    'update-success' => 'Wyszukiwane hasło zostało pomyślnie zaktualizowane.',
                ],

                'search-synonyms' => [
                    'create-success' => 'Synonim wyszukiwania został pomyślnie utworzony.',
                    'delete-success' => 'Synonim wyszukiwania został pomyślnie usunięty.',
                    'not-found'      => 'Ostrzeżenie: Synonim wyszukiwania nie został znaleziony.',
                    'update-success' => 'Synonim wyszukiwania został pomyślnie zaktualizowany.',
                ],

                'sitemaps' => [
                    'create-success' => 'Mapa witryny została pomyślnie utworzona.',
                    'delete-success' => 'Mapa witryny została pomyślnie usunięta.',
                    'not-found'      => 'Ostrzeżenie: Mapa witryny nie została znaleziona.',
                    'update-success' => 'Mapa witryny została pomyślnie zaktualizowana.',
                ],
            ],
        ],

        'settings' => [
            'locales' => [
                'create-success'       => 'Lokalizacja została pomyślnie utworzona.',
                'default-delete-error' => 'Nie można usunąć domyślnej lokalizacji.',
                'delete-error'         => 'Usuwanie lokalizacji nie powiodło się.',
                'delete-success'       => 'Lokalizacja została pomyślnie usunięta.',
                'last-delete-error'    => 'Ostatnia lokalizacja nie może zostać usunięta.',
                'not-found'            => 'Ostrzeżenie: Lokalizacja nie została znaleziona.',
                'update-success'       => 'Lokalizacja została pomyślnie zaktualizowana.',
            ],

            'currencies' => [
                'create-success'       => 'Waluta została pomyślnie utworzona.',
                'default-delete-error' => 'Nie można usunąć domyślnej waluty.',
                'delete-error'         => 'Usuwanie waluty nie powiodło się.',
                'delete-success'       => 'Waluta została pomyślnie usunięta.',
                'last-delete-error'    => 'Ostatnia waluta nie może zostać usunięta.',
                'not-found'            => 'Ostrzeżenie: Waluta nie została znaleziona.',
                'update-success'       => 'Waluta została pomyślnie zaktualizowana.',
            ],

            'exchange-rates' => [
                'create-success'          => 'Kurs wymiany został pomyślnie utworzony.',
                'delete-error'            => 'Usuwanie kursu wymiany nie powiodło się.',
                'delete-success'          => 'Kurs wymiany został pomyślnie usunięty.',
                'invalid-target-currency' => 'Ostrzeżenie: Podano nieprawidłową walutę docelową.',
                'last-delete-error'       => 'Ostatni kurs wymiany nie może zostać usunięty.',
                'not-found'               => 'Ostrzeżenie: Kurs wymiany nie został znaleziony.',
                'update-success'          => 'Kurs wymiany został pomyślnie zaktualizowany.',
            ],

            'inventory-sources' => [
                'create-success'    => 'Magazyn został pomyślnie utworzony.',
                'delete-error'      => 'Usuwanie magazynu nie powiodło się.',
                'delete-success'    => 'Magazyn został pomyślnie usunięty.',
                'last-delete-error' => 'Ostatni magazyn nie może zostać usunięty.',
                'not-found'         => 'Ostrzeżenie: Magazyn nie został znaleziony.',
                'update-success'    => 'Magazyn został pomyślnie zaktualizowany.',
            ],

            'channels' => [
                'create-success'       => 'Kanał został pomyślnie utworzony.',
                'default-delete-error' => 'Nie można usunąć domyślnego kanału.',
                'delete-error'         => 'Usuwanie kanału nie powiodło się.',
                'delete-success'       => 'Kanał został pomyślnie usunięty.',
                'last-delete-error'    => 'Ostatni kanał nie może zostać usunięty.',
                'not-found'            => 'Ostrzeżenie: Kanał nie został znaleziony.',
                'update-success'       => 'Kanał został pomyślnie zaktualizowany.',
            ],

            'users' => [
                'activate-warning'  => 'Twoje konto nie zostało jeszcze aktywowane, skontaktuj się z administratorem.',
                'create-success'    => 'Użytkownik został pomyślnie utworzony.',
                'delete-error'      => 'Usuwanie użytkownika nie powiodło się.',
                'delete-success'    => 'Użytkownik został pomyślnie usunięty.',
                'last-delete-error' => 'Ostatni użytkownik nie może zostać usunięty.',
                'login-error'       => 'Sprawdź swoje dane logowania i spróbuj ponownie.',
                'not-found'         => 'Ostrzeżenie: Użytkownik nie został znaleziony.',
                'success-login'     => 'Sukces: Użytkownik pomyślnie zalogowany.',
                'success-logout'    => 'Sukces: Użytkownik pomyślnie wylogowany.',
                'update-success'    => 'Użytkownik został pomyślnie zaktualizowany.',
            ],

            'roles' => [
                'create-success'    => 'Rola została pomyślnie utworzona.',
                'delete-error'      => 'Usuwanie roli nie powiodło się.',
                'delete-success'    => 'Rola została pomyślnie usunięta.',
                'last-delete-error' => 'Ostatnia rola nie może zostać usunięta.',
                'not-found'         => 'Ostrzeżenie: Rola nie została znaleziona.',
                'update-success'    => 'Rola została pomyślnie zaktualizowana.',
            ],

            'themes' => [
                'create-success' => 'Motyw został pomyślnie utworzony.',
                'delete-success' => 'Motyw został pomyślnie usunięty.',
                'not-found'      => 'Ostrzeżenie: Motyw nie został znaleziony.',
                'update-success' => 'Motyw został pomyślnie zaktualizowany.',

                'validation' => [
                    'filter-input' => [
                        'category-not-exist'    => 'Określony category_id nie istnieje.',
                        'invalid-boolean-value' => 'Wartość :key musi być 0 lub 1.',
                        'invalid-filter-key'    => 'Klucz filtra ":key" nie jest dozwolony.',
                        'invalid-limit-value'   => 'Wartość limitu musi być jedną z następujących: :options.',
                        'invalid-select-option' => 'Wartość :key jest nieprawidłowa. Dostępne opcje to: :options.',
                        'invalid-sort-value'    => 'Wartość sortowania musi być jedną z następujących: :options.',
                        'missing-limit-key'     => 'filtersInput musi zawierać klucz "limit".',
                        'missing-sort-key'      => 'filtersInput musi zawierać klucz "sort".',
                    ],
                ],
            ],

            'tax-rates' => [
                'create-success' => 'Stawka podatku została pomyślnie utworzona.',
                'delete-error'   => 'Usuwanie stawki podatku nie powiodło się.',
                'delete-success' => 'Stawka podatku została pomyślnie usunięta.',
                'not-found'      => 'Ostrzeżenie: Stawka podatku nie została znaleziona.',
                'update-success' => 'Stawka podatku została pomyślnie zaktualizowana.',
            ],

            'tax-category' => [
                'create-success'     => 'Kategoria podatku została pomyślnie utworzona.',
                'delete-error'       => 'Usuwanie kategorii podatku nie powiodło się.',
                'delete-success'     => 'Kategoria podatku została pomyślnie usunięta.',
                'not-found'          => 'Ostrzeżenie: Kategoria podatku nie została znaleziona.',
                'tax-rate-not-found' => 'Podane identyfikatory nie zostały znalezione. Identyfikatory: :ids',
                'update-success'     => 'Kategoria podatku została pomyślnie zaktualizowana.',
            ],

            'notification' => [
                'index' => [
                    'add-title' => 'Dodaj powiadomienie',
                    'general'   => 'Ogólne',
                    'title'     => 'Powiadomienie push',

                    'datagrid' => [
                        'channel-name'         => 'Nazwa kanału',
                        'created-at'           => 'Czas utworzenia',
                        'delete'               => 'Usuń',
                        'id'                   => 'Identyfikator',
                        'image'                => 'Obraz',
                        'notification-content' => 'Treść powiadomienia',
                        'notification-status'  => 'Status powiadomienia',
                        'notification-type'    => 'Typ powiadomienia',
                        'text-title'           => 'Tytuł',
                        'update'               => 'Aktualizuj',
                        'updated-at'           => 'Czas aktualizacji',

                        'status' => [
                            'disabled' => 'Wyłączone',
                            'enabled'  => 'Włączone',
                        ],
                    ],
                ],

                'create' => [
                    'back-btn'             => 'Powrót',
                    'content-and-image'    => 'Treść i obraz powiadomienia',
                    'create-btn-title'     => 'Zapisz powiadomienie',
                    'general'              => 'Ogólne',
                    'image'                => 'Obraz',
                    'new-notification'     => 'Nowe powiadomienie',
                    'notification-content' => 'Treść powiadomienia',
                    'notification-type'    => 'Typ powiadomienia',
                    'product-cat-id'       => 'Identyfikator produktu/kategorii',
                    'settings'             => 'Ustawienia',
                    'status'               => 'Status',
                    'store-view'           => 'Kanały',
                    'title'                => 'Powiadomienie push',

                    'option-type' => [
                        'category' => 'Kategoria',
                        'others'   => 'Proste',
                        'product'  => 'Produkt',
                    ],
                ],

                'edit' => [
                    'back-btn'             => 'Powrót',
                    'content-and-image'    => 'Treść i obraz powiadomienia',
                    'edit-notification'    => 'Edytuj powiadomienie',
                    'general'              => 'Ogólne',
                    'image'                => 'Obraz',
                    'notification-content' => 'Treść powiadomienia',
                    'notification-type'    => 'Typ powiadomienia',
                    'product-cat-id'       => 'Identyfikator produktu/kategorii',
                    'send-title'           => 'Wyślij powiadomienie',
                    'settings'             => 'Ustawienia',
                    'status'               => 'Status',
                    'store-view'           => 'Kanały',
                    'title'                => 'Powiadomienie push',
                    'update-btn-title'     => 'Aktualizuj',

                    'option-type' => [
                        'category' => 'Kategoria',
                        'others'   => 'Proste',
                        'product'  => 'Produkt',
                    ],
                ],

                'not-found'           => 'Ostrzeżenie: Powiadomienie nie zostało znalezione.',
                'create-success'      => 'Powiadomienie zostało pomyślnie utworzone.',
                'delete-failed'       => 'Usuwanie powiadomienia nie powiodło się.',
                'delete-success'      => 'Powiadomienie zostało pomyślnie usunięte.',
                'mass-update-success' => 'Wybrane powiadomienia zostały pomyślnie zaktualizowane.',
                'mass-delete-success' => 'Wybrane powiadomienia zostały pomyślnie usunięte.',
                'no-value-selected'   => 'brak dostępnych wartości.',
                'send-success'        => 'Powiadomienie zostało pomyślnie wysłane.',
                'update-success'      => 'Powiadomienie zostało pomyślnie zaktualizowane.',
                'configuration-error' => 'Ostrzeżenie: Konfiguracja FCM nie została znaleziona.',
                'product-not-found'   => 'Ostrzeżenie: Produkt nie został znaleziony.',
                'category-not-found'  => 'Ostrzeżenie: Kategoria nie została znaleziona.',
            ],
        ],

        'response' => [
            'error' => [
                'invalid-parameter' => 'Ostrzeżenie: Podano nieprawidłowe parametry.',
            ],
        ],
    ],

    'email' => [
        'configuration-error' => 'Ostrzeżenie: Nie znaleziono konfiguracji e-maila.',
    ],
];
