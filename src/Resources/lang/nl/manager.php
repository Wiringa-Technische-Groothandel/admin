<?php

return [
    'table' => [
        'head' => [
            'name' => 'Naam',
            'street' => 'Straat',
            'postcode' => 'Postcode',
            'city' => 'Plaats',
            'status' => 'Status',
            'created_at' => 'Aangemaakt op',
            'username' => 'Gebruikersnaam',
            'email' => 'E-Mail',
            'manager' => 'Beheerder',
            'password' => 'Wachtwoord',
            'customer_number' => 'Debiteurnummer'
        ],
    ],

    'form' => [
        'name' => 'Naam',
        'customer_number' => 'Debiteurnummer',
        'save' => 'Opslaan',
        'password' => 'Wachtwoord',
        'optional_password_help' => 'Optioneel, laat leeg om een wachtwoord te laten genereren.',
        'delete' => 'Verwijderen',
        'yes' => 'Ja',
        'no' => 'Nee',
        'active' => 'Actief',
        'inactive' => 'Inactief',
        'close' => 'Sluiten',
        'manager' => 'Beheerder',
        'password_verification' => 'Wachtwoord (verificatie)',
        'email' => 'E-Mail',
        'username' => 'Gebruikersnaam'
    ],

    'text' => [
        'details' => 'Details',
        'create_company' => 'Debiteur aanmaken',
        'search' => 'Zoeken',
        'accounts' => 'Accounts',
        'no_accounts' => 'Deze debiteur heeft geen gekoppelde accounts.',
        'no_companies' => 'Geen debiteuren gevonden.',
        'user_manager' => 'Gebruikersbeheer',
        'edit_company' => 'Debiteur aanpassen',
        'create_account' => 'Account toevoegen',
        'delete_company_warning' => 'Weet u zeker dat u debiteur ":name" wilt verwijderen?',
        'password_hidden' => 'Wachtwoord verborgen',
        'password_shown_warning' => ':password - Dit wachtwoord wordt veborgen als de pagina ververst wordt.',
        'company_deleted' => 'De debiteur en bijbehorende accounts zijn verwijderd.',
        'remove_current_company_error' => 'Dit account is momenteel ingelogd, deze kan niet verwijderd worden.',
        'company_creation_success' => 'De debiteur is aangemaakt.',
        'company_creation_error' => 'Er is een fout opgetreden tijdens het aanmaken van de debiteur.',
        'account_creation_success' => 'Het account is aangemaakt.',
        'account_creation_error' => 'Er is een fout opgetreden tijdens het aanmaken van de gebruiker.',
        'company_update_success' => 'De debiteur is aangepast.'
    ]
];