<?php

namespace Shazzoo\ContactForm\Support;

/**
 * The field types a form can be built from. One list feeds the admin's select,
 * the validation rules and the rendered input, so adding a type here is the
 * only edit needed to offer it everywhere.
 */
final class FieldTypes
{
    public const TEXT = 'text';

    public const EMAIL = 'email';

    public const TEL = 'tel';

    public const URL = 'url';

    public const NUMBER = 'number';

    public const DATE = 'date';

    public const TEXTAREA = 'textarea';

    public const SELECT = 'select';

    public const CHECKBOX = 'checkbox';

    /** @return array<string, string> */
    public static function options(): array
    {
        $options = [];

        foreach ([self::TEXT, self::EMAIL, self::TEL, self::URL, self::NUMBER, self::DATE, self::TEXTAREA, self::SELECT, self::CHECKBOX] as $type) {
            $options[$type] = (string) __('contact-form::messages.types.'.$type);
        }

        return $options;
    }

    /** @return array<string, string> */
    public static function roleOptions(): array
    {
        $options = [];

        foreach (['none', 'name', 'email', 'subject'] as $role) {
            $options[$role] = (string) __('contact-form::messages.roles.'.$role);
        }

        return $options;
    }

    /**
     * Validation rules for one configured field, on top of required/nullable.
     *
     * @param  array<string, mixed>  $field
     * @return array<int, string>
     */
    public static function rulesFor(array $field): array
    {
        return match ($field['type'] ?? self::TEXT) {
            self::EMAIL => ['email', 'max:255'],
            self::URL => ['url', 'max:255'],
            self::NUMBER => ['numeric'],
            self::DATE => ['date'],
            self::TEL => ['string', 'max:50'],
            self::TEXTAREA => ['string', 'max:5000'],
            self::CHECKBOX => ['accepted'],
            self::SELECT => ['string', 'in:'.implode(',', self::choices($field))],
            default => ['string', 'max:255'],
        };
    }

    /**
     * Choices for a select, entered in the admin as one option per line.
     *
     * @param  array<string, mixed>  $field
     * @return array<int, string>
     */
    public static function choices(array $field): array
    {
        $raw = (string) ($field['options'] ?? '');

        return array_values(array_filter(array_map(
            'trim',
            preg_split('/\r\n|\r|\n/', $raw) ?: [],
        ), fn (string $option): bool => $option !== ''));
    }
}
