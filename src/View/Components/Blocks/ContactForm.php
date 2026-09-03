<?php

namespace Shazzoo\ContactForm\View\Components\Blocks;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Shazzoo\ContactForm\Models\ContactFormSetting;

class ContactForm extends Component
{
    public function __construct(
        public array $data = [],
        public ?string $editorId = null,
    ) {}

    public function render(): View
    {
        $settings = ContactFormSetting::singleton();

        return view('contact-form::blocks.contact-form', [
            'data' => $this->data,
            'settings' => $settings,
            'fields' => $settings->usableFields(),
            'formId' => $this->editorId ?: 'contact-form',
        ]);
    }
}
