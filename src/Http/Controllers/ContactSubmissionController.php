<?php

namespace Shazzoo\ContactForm\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Shazzoo\ContactForm\Mail\ContactSubmissionReceived;
use Shazzoo\ContactForm\Models\ContactFormSetting;
use Shazzoo\ContactForm\Models\ContactSubmission;
use Shazzoo\ContactForm\Support\FieldTypes;

class ContactSubmissionController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $this->ensureNotRateLimited($request);

        $settings = ContactFormSetting::singleton();
        $fields = $settings->usableFields();

        $validated = $request->validate(
            [
                'form_id' => ['nullable', 'string', 'max:255'],
                /** Honeypot: only a bot fills a field that is hidden from people. */
                'website' => ['prohibited'],
                ...$this->rules($fields),
            ],
            [],
            $this->attributes($fields),
        );

        $answers = $this->answers($fields, $validated);

        $submission = ContactSubmission::create([
            'data' => $answers,
            'name' => $this->valueForRole($settings, $answers, 'name'),
            'email' => $this->valueForRole($settings, $answers, 'email'),
            'subject' => $this->valueForRole($settings, $answers, 'subject'),
            'page_url' => $request->headers->get('referer'),
            'locale' => app()->getLocale(),
            'ip_address' => $request->ip(),
        ]);

        $recipient = $this->recipient($settings);

        if ($recipient !== null) {
            Mail::to($recipient)->send(new ContactSubmissionReceived($submission, $fields, $settings->subject_prefix));
        }

        return back()
            ->with('contact-form.success', $validated['form_id'] ?? true)
            ->withFragment($validated['form_id'] ?? 'contact-form');
    }

    /**
     * @param  array<int, array<string, mixed>>  $fields
     * @return array<string, array<int, string>>
     */
    private function rules(array $fields): array
    {
        $rules = [];

        foreach ($fields as $field) {
            $key = 'fields.'.$field['name'];
            $required = (bool) ($field['required'] ?? false);

            if (($field['type'] ?? null) === FieldTypes::CHECKBOX) {
                $rules[$key] = $required ? ['accepted'] : ['nullable'];

                continue;
            }

            $rules[$key] = [$required ? 'required' : 'nullable', ...FieldTypes::rulesFor($field)];
        }

        return $rules;
    }

    /**
     * Error messages read "Het bericht veld is verplicht", not "fields.message".
     *
     * @param  array<int, array<string, mixed>>  $fields
     * @return array<string, string>
     */
    private function attributes(array $fields): array
    {
        $attributes = [];

        foreach ($fields as $field) {
            $attributes['fields.'.$field['name']] = (string) ($field['label'] ?? $field['name']);
        }

        return $attributes;
    }

    /**
     * Answers keyed by field name, dropped to the configured fields, so a
     * renamed or removed field cannot smuggle extra keys into the database.
     *
     * @param  array<int, array<string, mixed>>  $fields
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function answers(array $fields, array $validated): array
    {
        $answers = [];

        foreach ($fields as $field) {
            $value = $validated['fields'][$field['name']] ?? null;

            if ($value === null || $value === '') {
                continue;
            }

            if (($field['type'] ?? null) === FieldTypes::CHECKBOX) {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'Ja' : 'Nee';
            }

            $answers[$field['name']] = $value;
        }

        return $answers;
    }

    /**
     * @param  array<string, mixed>  $answers
     */
    private function valueForRole(ContactFormSetting $settings, array $answers, string $role): ?string
    {
        $field = $settings->fieldWithRole($role);

        if ($field === null) {
            return null;
        }

        $value = $answers[$field['name']] ?? null;

        return is_string($value) && $value !== '' ? $value : null;
    }

    private function recipient(ContactFormSetting $settings): ?string
    {
        foreach ([$settings->recipient, config('contact-form.recipient')] as $candidate) {
            if (is_string($candidate) && filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
                return $candidate;
            }
        }

        return null;
    }

    private function ensureNotRateLimited(Request $request): void
    {
        $key = 'contact-form:'.$request->ip();
        $maxAttempts = max(1, (int) config('contact-form.max_attempts', 5));

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            throw ValidationException::withMessages([
                'contact-form' => __('Too many submissions. Please try again later.'),
            ]);
        }

        RateLimiter::hit($key, max(1, (int) config('contact-form.decay_minutes', 10)) * 60);
    }
}
