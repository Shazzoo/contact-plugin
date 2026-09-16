{{--
    Styling is hand-written CSS on the plugin's own class names, driven by the
    theme's CSS variables with plain fallbacks. Tailwind only scans the theme's
    view directories, so utility classes written here would never be compiled --
    this keeps the block correct under any theme, and restyleable by publishing
    the view.

    Every input is rendered by contact-form::fields.<type>, so a site can
    override one field type without touching the rest of the form.
--}}
@php
    $succeeded = session('contact-form.success') === $formId;
@endphp

<section id="{{ $formId }}" class="cf-section">
    @include('contact-form::partials.styles')

    <div class="cf-wrap">
        @if (!empty($data['eyebrow']))
            <span class="cf-eyebrow">{{ $data['eyebrow'] }}</span>
        @endif

        @if (!empty($data['heading']))
            <h2 class="cf-heading">{{ $data['heading'] }}</h2>
        @endif

        @if (!empty($data['lede']))
            <p class="cf-lede">{{ $data['lede'] }}</p>
        @endif

        @if ($succeeded)
            <p class="cf-success">{{ $form?->success_message ?: __('contact-form::messages.form.success') }}</p>
        @endif

        @error('contact-form')
            <p class="cf-error cf-error-form">{{ $message }}</p>
        @enderror

        @if ($form === null || empty($fields))
            {{-- Niets te tonen zolang er geen velden ingesteld zijn. --}}
            @if (auth()->check())
                <p class="cf-note">{{ __('contact-form::messages.form.not_configured') }}</p>
            @endif
        @else
            <form class="cf-form" method="POST" action="{{ route('contact-form.submit') }}">
                @csrf
                {{-- Welk formulier is ingezonden, en waar het bedanktbericht
                     en het anker naartoe moeten. --}}
                <input type="hidden" name="form" value="{{ $form->key }}">
                <input type="hidden" name="form_id" value="{{ $formId }}">

                <div class="cf-honeypot" aria-hidden="true">
                    <label>
                        {{ __('contact-form::messages.form.honeypot') }}
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </label>
                </div>

                <div class="cf-grid">
                    @foreach ($fields as $field)
                        @php
                            // De puntsleutel is voor validatie, old() en @error;
                            // het name-attribuut moet haakjes gebruiken, anders
                            // komt het antwoord als losse sleutel binnen in
                            // plaats van in de fields-array.
                            $key = 'fields.'.$field['name'];
                            $inputName = 'fields['.$field['name'].']';
                            $id = $formId.'-'.$field['name'];
                            $type = $field['type'] ?? 'text';
                        @endphp

                        <div class="cf-field cf-field-{{ ($field['width'] ?? 'full') === 'half' ? 'half' : 'full' }}">
                            @includeFirst(
                                ['contact-form::fields.'.$type, 'contact-form::fields.text'],
                                ['field' => $field, 'key' => $key, 'inputName' => $inputName, 'id' => $id]
                            )

                            @error($key)
                                <p class="cf-error">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                @if ($form->privacy_note)
                    <p class="cf-note">{{ $form->privacy_note }}</p>
                @endif

                <button class="cf-button" type="submit">{{ $form->button_label ?: __('contact-form::messages.form.send') }}</button>
            </form>
        @endif
    </div>
</section>
