<?php

namespace Shazzoo\ContactForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactForm extends Model
{
    protected $table = 'contact_forms';

    protected $fillable = [
        'name',
        'key',
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

    public function submissions(): HasMany
    {
        return $this->hasMany(ContactSubmission::class);
    }

    /**
     * The form a block points at, falling back to the oldest one: a block
     * placed before this form was deleted -- or before there was anything to
     * choose -- still renders instead of leaving a hole in the page.
     */
    public static function forKey(?string $key): ?self
    {
        return (($key !== null && $key !== '')
            ? static::query()->where('key', $key)->first()
            : null) ?? static::query()->oldest('id')->first();
    }

    /**
     * The forms to choose from in the block, keyed by what is stored.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return static::query()->orderBy('name')->pluck('name', 'key')->all();
    }

    /**
     * The form a site starts with. Editable in the admin from the first visit,
     * so nothing here is load-bearing beyond the initial fill.
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
