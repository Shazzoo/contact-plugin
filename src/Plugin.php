<?php

namespace Shazzoo\ContactForm;

class Plugin
{
    public static function key(): string
    {
        return 'shazzoo/contact-form';
    }

    public static function provider(): string
    {
        return ContactFormServiceProvider::class;
    }
}
