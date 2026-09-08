<?php

/*
|--------------------------------------------------------------------------
| Übersetzungen des Kontaktformulars
|--------------------------------------------------------------------------
|
| Die Erläuterung zu diesen Schlüsseln steht in lang/en/messages.php.
|
*/

return [

    'form' => [
        'send' => 'Absenden',
        'success' => 'Danke für Ihre Nachricht. Wir melden uns so schnell wie möglich.',
        'choose' => 'Bitte wählen...',
        'honeypot' => 'Dieses Feld leer lassen',
        'not_configured' => 'Es sind noch keine Felder eingerichtet. Richten Sie sie unter Contact Plugin ein.',
        'throttled' => 'Zu viele Einsendungen. Bitte versuchen Sie es später erneut.',
        'yes' => 'Ja',
        'no' => 'Nein',
    ],

    'mail' => [
        'subject' => 'Kontaktformular',
        'heading' => 'Neue Einsendung über das Kontaktformular',
        'page' => 'Seite',
    ],

    'types' => [
        'text' => 'Text',
        'email' => 'E-Mail',
        'tel' => 'Telefon',
        'url' => 'URL',
        'number' => 'Zahl',
        'date' => 'Datum',
        'textarea' => 'Textfeld',
        'select' => 'Auswahlliste',
        'checkbox' => 'Kontrollkästchen',
    ],

    'roles' => [
        'none' => 'Keine',
        'name' => 'Name des Absenders',
        'email' => 'E-Mail des Absenders',
        'subject' => 'Betreff',
    ],

    'defaults' => [
        'name' => 'Name',
        'email' => 'E-Mail',
        'subject' => 'Betreff',
        'message' => 'Nachricht',
    ],

    'block' => [
        'label' => 'Kontaktformular',
        'description' => 'Das unter Contact Plugin eingerichtete Formular. Die Überschrift wird hier gesetzt.',
        'eyebrow' => 'Dachzeile',
        'heading' => 'Überschrift',
        'heading_default' => 'Kontakt aufnehmen',
        'lede' => 'Einleitung',
    ],

    'admin' => [
        'group' => 'Contact Plugin',
        'settings' => [
            'nav' => 'Formular',
            'title' => 'Kontaktformular',
            'saved' => 'Kontaktformular gespeichert',
            'save' => 'Speichern',
            'restore' => 'Standardfelder wiederherstellen',
            'delivery' => 'Versand',
            'delivery_hint' => 'Wohin eine Einsendung geht und was der Besucher danach sieht.',
            'recipient' => 'Empfänger',
            'recipient_hint' => 'Leer lassen verwendet CONTACT_FORM_RECIPIENT aus der .env.',
            'subject_prefix' => 'Betreff-Präfix',
            'subject_prefix_hint' => 'Steht vor dem Betreff in der Benachrichtigungsmail.',
            'button_label' => 'Beschriftung der Schaltfläche',
            'success_message' => 'Dankesnachricht',
            'privacy_note' => 'Datenschutzhinweis',
            'privacy_note_hint' => 'Optionaler Text unter dem Formular.',
            'fields' => 'Felder',
            'fields_hint' => 'Die Felder des Formulars. Die Reihenfolge hier ist die Reihenfolge auf der Seite.',
            'add_field' => 'Feld hinzufügen',
            'field_label' => 'Beschriftung',
            'field_key' => 'Schlüssel',
            'field_key_hint' => 'Wird mit der Einsendung gespeichert. Nicht mehr ändern, wenn es bereits Einsendungen gibt.',
            'field_type' => 'Typ',
            'field_role' => 'Rolle',
            'field_role_hint' => 'Bestimmt die Antwortadresse und die Spalten in der Übersicht.',
            'field_choices' => 'Auswahlmöglichkeiten',
            'field_choices_hint' => 'Eine Auswahl pro Zeile.',
            'field_placeholder' => 'Platzhalter',
            'field_width' => 'Breite',
            'field_width_full' => 'Volle Breite',
            'field_width_half' => 'Halbe Breite',
            'field_required' => 'Pflichtfeld',
        ],
        'submissions' => [
            'nav' => 'Einsendungen',
            'label' => 'Einsendung',
            'plural' => 'Einsendungen',
            'answers' => 'Antworten',
            'answer_field' => 'Feld',
            'answer_value' => 'Antwort',
            'page' => 'Seite',
            'locale' => 'Sprache',
            'ip' => 'IP',
            'received' => 'Eingegangen',
            'name' => 'Name',
            'email' => 'E-Mail',
            'subject' => 'Betreff',
        ],
    ],

];
