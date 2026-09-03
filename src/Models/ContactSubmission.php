<?php

namespace Shazzoo\ContactForm\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $table = 'contact_submissions';

    protected $fillable = [
        'data',
        'name',
        'email',
        'subject',
        'page_url',
        'locale',
        'ip_address',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    /**
     * The answers paired with the labels they were given at the time of
     * reading, falling back to the stored key for a field that has since been
     * removed from the form.
     *
     * @param  array<int, array<string, mixed>>  $fields
     * @return array<string, mixed>
     */
    public function labelledAnswers(array $fields): array
    {
        $labels = [];

        foreach ($fields as $field) {
            if (! empty($field['name'])) {
                $labels[$field['name']] = (string) ($field['label'] ?? $field['name']);
            }
        }

        $answers = [];

        foreach ((array) $this->data as $key => $value) {
            $answers[$labels[$key] ?? $key] = $value;
        }

        return $answers;
    }
}
