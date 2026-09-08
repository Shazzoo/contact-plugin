<x-mail::message>
# {{ __('contact-form::messages.mail.heading') }}

@foreach ($answers as $label => $value)
**{{ $label }}:** {{ $value }}

@endforeach
@if ($submission->page_url)
---
{{ __('contact-form::messages.mail.page') }}: {{ $submission->page_url }}
@endif
</x-mail::message>
