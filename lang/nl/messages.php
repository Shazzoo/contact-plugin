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
        'not_configured' => 'Dit blok heeft nog geen formulier. Maak er een onder Plugins en kies het hier.',
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
        'form' => 'Formulier',
        'form_hint' => 'Welk van de formulieren onder Plugins dit blok toont.',
        'description' => 'Een van de formulieren onder Plugins. Kies welk, en stel hier de tekst eromheen in.',
        'eyebrow' => 'Bovenkop',
        'heading' => 'Kop',
        'heading_default' => 'Neem contact op',
        'lede' => 'Intro',
    ],

    'admin' => [
        'group' => 'Contact Plugin',
        'plugins_group' => 'Plugins',
        'forms' => [
            'nav' => 'Formulieren',
            'label' => 'Formulier',
            'plural' => 'Formulieren',
            'identity' => 'Het formulier',
            'identity_hint' => 'Waaraan je dit formulier herkent, en waar een blok naar wijst.',
            'name' => 'Naam',
            'key' => 'Sleutel',
            'key_hint' => 'Wordt opgeslagen in een geplaatst blok. Wijzig dit niet meer als het formulier op een pagina staat.',
        ],
        'settings' => [
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
            'form' => 'Formulier',
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
