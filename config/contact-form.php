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

    /*
    |--------------------------------------------------------------------------
    | Retention
    |--------------------------------------------------------------------------
    |
    | Days a submission is kept before it is deleted. A submission holds
    | personal data, so keeping it longer than the contact is worth is a
    | liability, not an archive. The plugin schedules a daily prune while this
    | is above zero; zero keeps everything until someone deletes it by hand.
    |
    */
    'retention_days' => (int) env('CONTACT_FORM_RETENTION_DAYS', 365),

    /*
    |--------------------------------------------------------------------------
    | Store the sender's IP address
    |--------------------------------------------------------------------------
    |
    | An IP address is personal data and is not needed to answer a message, so
    | it is left out by default. Rate limiting works either way -- it reads the
    | address of the request, it does not need a stored one. Turn this on only
    | with a reason to, and name it in your privacy statement.
    |
    */
    'store_ip' => (bool) env('CONTACT_FORM_STORE_IP', false),

];
