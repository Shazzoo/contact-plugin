<x-mail::message>
# {{ __('New contact form submission') }}

**{{ __('Name') }}:** {{ $submission->name }}
**{{ __('E-mail') }}:** {{ $submission->email }}
@if ($submission->phone)
**{{ __('Phone') }}:** {{ $submission->phone }}
@endif
@if ($submission->subject)
**{{ __('Subject') }}:** {{ $submission->subject }}
@endif
@if ($submission->page_url)
**{{ __('Page') }}:** {{ $submission->page_url }}
@endif

{{ $submission->message }}
</x-mail::message>
