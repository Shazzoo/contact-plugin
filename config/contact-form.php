<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fallback recipient
    |--------------------------------------------------------------------------
    |
    | Used when a contact form block leaves its own recipient empty. Without
    | either, submissions are stored but no notification is sent.
    |
    */
    'recipient' => env('CONTACT_FORM_RECIPIENT'),

    /*
    |--------------------------------------------------------------------------
    | Rate limiting
    |--------------------------------------------------------------------------
    |
    | Submissions allowed per IP address within the decay window, in minutes.
    |
    */
    'max_attempts' => (int) env('CONTACT_FORM_MAX_ATTEMPTS', 5),
    'decay_minutes' => (int) env('CONTACT_FORM_DECAY_MINUTES', 10),
];
