<?php

/*
|--------------------------------------------------------------------------
| Contact form translations
|--------------------------------------------------------------------------
|
| Adding a language is copying this file to lang/<locale>/messages.php and
| translating the values -- nothing has to be registered. A key missing from
| a locale falls back to the app's fallback_locale.
|
| A site can override any line without touching the plugin:
|
|     php artisan vendor:publish --tag=contact-form-lang
|
*/

return [

    // Shown on the page the form is placed on.
    'form' => [
        'send' => 'Send',
        'success' => 'Thanks for your message. We will get back to you as soon as possible.',
        'choose' => 'Choose...',
        'honeypot' => 'Leave this field empty',
        'not_configured' => 'No form fields configured yet. Set them up under Contact Plugin.',
        'throttled' => 'Too many submissions. Please try again later.',
        'yes' => 'Yes',
        'no' => 'No',
    ],

    // The notification mail sent to the recipient.
    'mail' => [
        'subject' => 'Contact form',
        'heading' => 'New contact form submission',
        'page' => 'Page',
    ],

    // The field types a form can be built from.
    'types' => [
        'text' => 'Text',
        'email' => 'E-mail',
        'tel' => 'Phone',
        'url' => 'URL',
        'number' => 'Number',
        'date' => 'Date',
        'textarea' => 'Text area',
        'select' => 'Dropdown',
        'checkbox' => 'Checkbox',
    ],

    // What an answer means, beyond being an answer.
    'roles' => [
        'none' => 'None',
        'name' => "Sender's name",
        'email' => "Sender's e-mail",
        'subject' => 'Subject',
    ],

    // The form every site starts with, before it is edited in the admin.
    'defaults' => [
        'name' => 'Name',
        'email' => 'E-mail',
        'subject' => 'Subject',
        'message' => 'Message',
    ],

    // The block as it appears in the page editor.
    'block' => [
        'label' => 'Contact form',
        'description' => 'The form configured under Contact Plugin. Set the heading here.',
        'eyebrow' => 'Eyebrow',
        'heading' => 'Heading',
        'heading_default' => 'Get in touch',
        'lede' => 'Lede',
    ],

    // The admin: the settings page and the submissions list.
    'admin' => [
        'group' => 'Contact Plugin',
        'settings' => [
            'nav' => 'Form',
            'title' => 'Contact form',
            'saved' => 'Contact form saved',
            'save' => 'Save',
            'restore' => 'Restore default fields',
            'delivery' => 'Delivery',
            'delivery_hint' => 'Where a submission goes and what the visitor sees afterwards.',
            'recipient' => 'Recipient',
            'recipient_hint' => 'Leaving this empty uses CONTACT_FORM_RECIPIENT from the .env.',
            'subject_prefix' => 'Subject prefix',
            'subject_prefix_hint' => 'Precedes the subject in the notification mail.',
            'button_label' => 'Button label',
            'success_message' => 'Thank-you message',
            'privacy_note' => 'Privacy text',
            'privacy_note_hint' => 'Optional text below the form.',
            'fields' => 'Fields',
            'fields_hint' => 'The fields of the form. The order here is the order on the page.',
            'add_field' => 'Add field',
            'field_label' => 'Label',
            'field_key' => 'Key',
            'field_key_hint' => 'Stored with the submission. Do not change it once there are submissions.',
            'field_type' => 'Type',
            'field_role' => 'Role',
            'field_role_hint' => 'Determines the reply-to address and the columns in the list.',
            'field_choices' => 'Choices',
            'field_choices_hint' => 'One choice per line.',
            'field_placeholder' => 'Placeholder',
            'field_width' => 'Width',
            'field_width_full' => 'Full width',
            'field_width_half' => 'Half width',
            'field_required' => 'Required',
        ],
        'submissions' => [
            'nav' => 'Submissions',
            'label' => 'Submission',
            'plural' => 'Submissions',
            'answers' => 'Answers',
            'answer_field' => 'Field',
            'answer_value' => 'Answer',
            'page' => 'Page',
            'locale' => 'Language',
            'ip' => 'IP',
            'received' => 'Received',
            'name' => 'Name',
            'email' => 'E-mail',
            'subject' => 'Subject',
        ],
    ],

];
