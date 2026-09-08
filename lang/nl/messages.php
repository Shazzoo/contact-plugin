<?php

/*
|--------------------------------------------------------------------------
| Vertalingen van het contactformulier
|--------------------------------------------------------------------------
|
| Zie lang/en/messages.php voor de toelichting bij deze sleutels.
|
*/

return [

    'form' => [
        'send' => 'Versturen',
        'success' => 'Bedankt voor je bericht. We nemen zo snel mogelijk contact op.',
        'choose' => 'Maak een keuze...',
        'honeypot' => 'Laat dit veld leeg',
        'not_configured' => 'Er zijn nog geen velden ingesteld. Stel ze in onder Contact Plugin.',
        'throttled' => 'Te veel inzendingen. Probeer het later opnieuw.',
        'yes' => 'Ja',
        'no' => 'Nee',
    ],

    'mail' => [
        'subject' => 'Contactformulier',
        'heading' => 'Nieuwe inzending via het contactformulier',
        'page' => 'Pagina',
    ],

    'types' => [
        'text' => 'Tekst',
        'email' => 'E-mail',
        'tel' => 'Telefoon',
        'url' => 'URL',
        'number' => 'Getal',
        'date' => 'Datum',
        'textarea' => 'Tekstvak',
        'select' => 'Keuzelijst',
        'checkbox' => 'Aanvinkvakje',
    ],

    'roles' => [
        'none' => 'Geen',
        'name' => 'Naam van de afzender',
        'email' => 'E-mail van de afzender',
        'subject' => 'Onderwerp',
    ],

    'defaults' => [
        'name' => 'Naam',
        'email' => 'E-mail',
        'subject' => 'Onderwerp',
        'message' => 'Bericht',
    ],

    'block' => [
        'label' => 'Contactformulier',
        'description' => 'Het formulier dat onder Contact Plugin is ingesteld. Stel hier de kop in.',
        'eyebrow' => 'Bovenkop',
        'heading' => 'Kop',
        'heading_default' => 'Neem contact op',
        'lede' => 'Intro',
    ],

    'admin' => [
        'group' => 'Contact Plugin',
        'settings' => [
            'nav' => 'Formulier',
            'title' => 'Contactformulier',
            'saved' => 'Contactformulier opgeslagen',
            'save' => 'Opslaan',
            'restore' => 'Standaardvelden terugzetten',
            'delivery' => 'Verzending',
            'delivery_hint' => 'Waar een inzending naartoe gaat en wat de bezoeker daarna ziet.',
            'recipient' => 'Ontvanger',
            'recipient_hint' => 'Leeg laten gebruikt CONTACT_FORM_RECIPIENT uit de .env.',
            'subject_prefix' => 'Onderwerp-prefix',
            'subject_prefix_hint' => 'Komt voor het onderwerp in de notificatiemail.',
            'button_label' => 'Label van de knop',
            'success_message' => 'Bedanktbericht',
            'privacy_note' => 'Privacytekst',
            'privacy_note_hint' => 'Optionele tekst onder het formulier.',
            'fields' => 'Velden',
            'fields_hint' => 'De velden van het formulier. De volgorde hier is de volgorde op de pagina.',
            'add_field' => 'Veld toevoegen',
            'field_label' => 'Label',
            'field_key' => 'Sleutel',
            'field_key_hint' => 'Wordt opgeslagen bij de inzending. Wijzig dit niet meer als er al inzendingen zijn.',
            'field_type' => 'Type',
            'field_role' => 'Rol',
            'field_role_hint' => 'Bepaalt het antwoord-adres en de kolommen in het overzicht.',
            'field_choices' => 'Keuzes',
            'field_choices_hint' => 'Een keuze per regel.',
            'field_placeholder' => 'Placeholder',
            'field_width' => 'Breedte',
            'field_width_full' => 'Hele breedte',
            'field_width_half' => 'Halve breedte',
            'field_required' => 'Verplicht',
        ],
        'submissions' => [
            'nav' => 'Inzendingen',
            'label' => 'Inzending',
            'plural' => 'Inzendingen',
            'answers' => 'Antwoorden',
            'answer_field' => 'Veld',
            'answer_value' => 'Antwoord',
            'page' => 'Pagina',
            'locale' => 'Taal',
            'ip' => 'IP',
            'received' => 'Ontvangen',
            'name' => 'Naam',
            'email' => 'E-mail',
            'subject' => 'Onderwerp',
        ],
    ],

];
