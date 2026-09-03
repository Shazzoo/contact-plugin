<x-mail::message>
# {{ __('New contact form submission') }}

@foreach ($answers as $label => $value)
**{{ $label }}:** {{ $value }}

@endforeach
@if ($submission->page_url)
---
{{ __('Page') }}: {{ $submission->page_url }}
@endif
</x-mail::message>
