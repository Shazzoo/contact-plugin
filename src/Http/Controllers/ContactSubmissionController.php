<?php

namespace Shazzoo\ContactForm\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Shazzoo\ContactForm\Mail\ContactSubmissionReceived;
use Shazzoo\ContactForm\Models\ContactSubmission;

class ContactSubmissionController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $this->ensureNotRateLimited($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'form_id' => ['nullable', 'string', 'max:255'],
            'recipient' => ['nullable', 'string'],
            /** Honeypot: only a bot fills a field that is hidden from people. */
            'website' => ['prohibited'],
        ]);

        $submission = ContactSubmission::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
            'page_url' => $request->headers->get('referer'),
            'locale' => app()->getLocale(),
            'ip_address' => $request->ip(),
        ]);

        $recipient = $this->recipient($data['recipient'] ?? null);

        if ($recipient !== null) {
            Mail::to($recipient)->send(new ContactSubmissionReceived($submission));
        }

        return back()
            ->with('contact-form.success', $data['form_id'] ?? true)
            ->withFragment($this->fragment($data['form_id'] ?? null));
    }

    /**
     * The recipient travels through the page in an encrypted hidden field, so a
     * block can address its own mailbox without the form becoming an open relay:
     * a tampered value fails to decrypt and falls back to the configured one.
     */
    private function recipient(?string $encrypted): ?string
    {
        if ($encrypted !== null && $encrypted !== '') {
            try {
                $decrypted = Crypt::decryptString($encrypted);

                if (filter_var($decrypted, FILTER_VALIDATE_EMAIL)) {
                    return $decrypted;
                }
            } catch (DecryptException) {
                // Fall through to the configured recipient.
            }
        }

        $fallback = config('contact-form.recipient');

        return is_string($fallback) && filter_var($fallback, FILTER_VALIDATE_EMAIL)
            ? $fallback
            : null;
    }

    private function fragment(?string $formId): string
    {
        return $formId !== null && $formId !== '' ? $formId : 'contact-form';
    }

    private function ensureNotRateLimited(Request $request): void
    {
        $key = 'contact-form:'.$request->ip();
        $maxAttempts = max(1, (int) config('contact-form.max_attempts', 5));

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            throw ValidationException::withMessages([
                'message' => __('Too many submissions. Please try again later.'),
            ]);
        }

        RateLimiter::hit($key, max(1, (int) config('contact-form.decay_minutes', 10)) * 60);
    }
}
