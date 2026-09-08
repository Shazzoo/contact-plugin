<?php

namespace Shazzoo\ContactForm\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFormSetting extends Model
{
    protected $table = 'contact_form_settings';

    protected $fillable = [
        'recipient',
        'subject_prefix',
        'button_label',
        'success_message',
        'privacy_note',
        'fields',
    ];

    protected $casts = [
        'fields' => 'array',
    ];

    public static function singleton(): self
    {
        // Leeg gelaten: de vertaling van de actieve taal is de terugval bij
        // het renderen, dus een lege waarde volgt de taal van de bezoeker mee
        // tot iemand in de admin eigen tekst invult.
        return static::query()->firstOrCreate([], [
            'fields' => self::defaultFields(),
        ]);
    }

    /**
     * The form every site starts with. Editable in the admin from the first
     * visit, so nothing here is load-bearing beyond the initial fill.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function defaultFields(): array
    {
        return [
            ['name' => 'name', 'label' => (string) __('contact-form::messages.defaults.name'), 'type' => 'text', 'role' => 'name', 'required' => true, 'width' => 'half'],
            ['name' => 'email', 'label' => (string) __('contact-form::messages.defaults.email'), 'type' => 'email', 'role' => 'email', 'required' => true, 'width' => 'half'],
            ['name' => 'subject', 'label' => (string) __('contact-form::messages.defaults.subject'), 'type' => 'text', 'role' => 'subject', 'required' => false, 'width' => 'full'],
            ['name' => 'message', 'label' => (string) __('contact-form::messages.defaults.message'), 'type' => 'textarea', 'role' => 'none', 'required' => true, 'width' => 'full'],
        ];
    }

    /**
     * Configured fields, dropped to the ones that can actually be rendered and
     * validated: a row without a name or type would break both.
     *
     * @return array<int, array<string, mixed>>
     */
    public function usableFields(): array
    {
        $fields = is_array($this->fields) ? $this->fields : [];

        return array_values(array_filter(
            $fields,
            fn ($field) => is_array($field)
                && ! empty($field['name'])
                && ! empty($field['type']),
        ));
    }

    /** The field carrying a role, e.g. the one holding the sender's e-mail. */
    public function fieldWithRole(string $role): ?array
    {
        foreach ($this->usableFields() as $field) {
            if (($field['role'] ?? 'none') === $role) {
                return $field;
            }
        }

        return null;
    }
}
