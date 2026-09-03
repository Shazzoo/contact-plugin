<?php

namespace Shazzoo\ContactForm\View\Components\Blocks;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\Component;

class ContactForm extends Component
{
    public function __construct(
        public array $data = [],
        public ?string $editorId = null,
    ) {}

    public function render(): View
    {
        $recipient = trim((string) ($this->data['recipient'] ?? ''));

        return view('contact-form::blocks.contact-form', [
            'data' => $this->data,
            'formId' => $this->editorId ?: 'contact-form',
            /** Encrypted so the address is neither readable nor swappable in the page source. */
            'recipientToken' => filter_var($recipient, FILTER_VALIDATE_EMAIL)
                ? Crypt::encryptString($recipient)
                : null,
        ]);
    }
}
