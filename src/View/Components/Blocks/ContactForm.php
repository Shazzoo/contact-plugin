<?php

namespace Shazzoo\ContactForm\View\Components\Blocks;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Shazzoo\ContactForm\Models\ContactForm as ContactFormModel;

class ContactForm extends Component
{
    public function __construct(
        public array $data = [],
        public ?string $editorId = null,
    ) {}

    public function render(): View
    {
        $form = ContactFormModel::forKey($this->data['form'] ?? null);

        return view('contact-form::blocks.contact-form', [
            'data' => $this->data,
            'form' => $form,
            'fields' => $form?->usableFields() ?? [],
            // Twee blokken op één pagina moeten elk hun eigen anker en eigen
            // bedanktbericht hebben, dus valt de id terug op de sleutel van
            // het formulier in plaats van op één gedeelde naam.
            'formId' => $this->editorId ?: 'contact-form-'.($form?->key ?? 'contact'),
        ]);
    }
}
