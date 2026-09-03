<?php

namespace Shazzoo\ContactForm\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Shazzoo\ContactForm\Models\ContactSubmission;

class ContactSubmissionReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, array<string, mixed>>  $fields
     */
    public function __construct(
        public ContactSubmission $submission,
        public array $fields = [],
        public ?string $subjectPrefix = null,
    ) {}

    public function envelope(): Envelope
    {
        $prefix = trim((string) ($this->subjectPrefix ?: __('Contact form')));
        $subject = $this->submission->subject
            ? $prefix.': '.$this->submission->subject
            : $prefix;

        return new Envelope(
            subject: $subject,
            // Alleen als het formulier een e-mailveld heeft: zonder antwoord-
            // adres zou replyTo op een leeg adres stukgaan.
            replyTo: $this->submission->email
                ? [new Address($this->submission->email, $this->submission->name ?: $this->submission->email)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'contact-form::mail.submission',
            with: ['answers' => $this->submission->labelledAnswers($this->fields)],
        );
    }
}
