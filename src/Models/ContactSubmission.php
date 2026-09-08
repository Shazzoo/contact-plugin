<?php

namespace Shazzoo\ContactForm\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class ContactSubmission extends Model
{
    use Prunable;

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
     * Submissions older than the retention window, deleted for good by the
     * daily prune the service provider schedules. Zero days keeps everything.
     */
    public function prunable(): Builder
    {
        $days = (int) config('contact-form.retention_days', 0);

        // Nul betekent bewaren, ook als iemand model:prune met de hand draait:
        // zonder deze grens zou "ouder dan nul dagen" alles opruimen.
        return $days > 0
            ? static::query()->where('created_at', '<', now()->subDays($days))
            : static::query()->whereRaw('1 = 0');
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
