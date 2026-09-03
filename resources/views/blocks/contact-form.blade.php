{{--
    Styling is hand-written CSS on the plugin's own class names, driven by the
    theme's CSS variables with plain fallbacks. Tailwind only scans the theme's
    view directories, so utility classes written here would never be compiled --
    this keeps the block correct under any theme, and restyleable by publishing
    the view.
--}}
@php
    $showPhone = (bool) ($data['show_phone'] ?? false);
    $showSubject = (bool) ($data['show_subject'] ?? true);
    $succeeded = session('contact-form.success') === $formId;
@endphp

<section id="{{ $formId }}" class="cf-section">
    <style>
        .cf-section { padding: 56px 0; }
        .cf-wrap { margin: 0 auto; max-width: 720px; padding: 0 24px; }
        .cf-eyebrow {
            display: block; margin-bottom: 10px; font-size: 13px; font-weight: 600;
            letter-spacing: .08em; text-transform: uppercase;
            color: var(--amber-600, #b45309);
        }
        .cf-heading { margin: 0; font-size: clamp(26px, 3vw, 36px); color: var(--ink-950, #020617); }
        .cf-lede { margin: 14px 0 0; font-size: 18px; line-height: 1.6; color: var(--ink-600, #475569); }
        .cf-form { margin-top: 28px; display: grid; gap: 16px; }
        .cf-row { display: grid; gap: 16px; }
        @media (min-width: 640px) { .cf-row-2 { grid-template-columns: 1fr 1fr; } }
        .cf-label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: var(--ink-800, #1e293b); }
        .cf-input, .cf-textarea {
            width: 100%; box-sizing: border-box; padding: 12px 14px; font: inherit; font-size: 16px;
            color: var(--ink-950, #020617);
            background: var(--surface, #fff);
            border: 1px solid var(--line, #e2e8f0); border-radius: 10px;
        }
        .cf-input:focus, .cf-textarea:focus {
            outline: 2px solid var(--amber, #ffbf00); outline-offset: 1px;
            border-color: var(--line-strong, #cbd5e1);
        }
        .cf-textarea { min-height: 160px; resize: vertical; }
        .cf-error { margin: 6px 0 0; font-size: 14px; color: #b91c1c; }
        .cf-note { margin: 0; font-size: 14px; line-height: 1.5; color: var(--ink-600, #475569); }
        .cf-button {
            justify-self: start; padding: 12px 22px; font: inherit; font-weight: 600; cursor: pointer;
            color: var(--amber-ink, #1c1305); background: var(--amber, #ffbf00);
            border: 0; border-radius: 999px;
        }
        .cf-button:hover { background: var(--amber-hover, #ffcc33); }
        .cf-success {
            margin-top: 24px; padding: 16px 18px; border-radius: 12px;
            border: 1px solid var(--emerald, #10b981);
            background: var(--bg-alt, #f8fafc);
            color: var(--ink-800, #1e293b);
        }
        .cf-honeypot { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
    </style>

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
            <p class="cf-success">{{ $data['success_message'] ?? __('Thanks for your message.') }}</p>
        @endif

        <form class="cf-form" method="POST" action="{{ route('contact-form.submit') }}">
            @csrf
            <input type="hidden" name="form_id" value="{{ $formId }}">
            @if ($recipientToken)
                <input type="hidden" name="recipient" value="{{ $recipientToken }}">
            @endif

            <div class="cf-honeypot" aria-hidden="true">
                <label>
                    {{ __('Leave this field empty') }}
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </label>
            </div>

            <div class="cf-row cf-row-2">
                <div>
                    <label class="cf-label" for="{{ $formId }}-name">{{ __('Name') }}</label>
                    <input class="cf-input" id="{{ $formId }}-name" type="text" name="name"
                        value="{{ old('name') }}" required autocomplete="name">
                    @error('name')<p class="cf-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="cf-label" for="{{ $formId }}-email">{{ __('E-mail') }}</label>
                    <input class="cf-input" id="{{ $formId }}-email" type="email" name="email"
                        value="{{ old('email') }}" required autocomplete="email">
                    @error('email')<p class="cf-error">{{ $message }}</p>@enderror
                </div>
            </div>

            @if ($showPhone || $showSubject)
                <div class="cf-row {{ $showPhone && $showSubject ? 'cf-row-2' : '' }}">
                    @if ($showPhone)
                        <div>
                            <label class="cf-label" for="{{ $formId }}-phone">{{ __('Phone') }}</label>
                            <input class="cf-input" id="{{ $formId }}-phone" type="tel" name="phone"
                                value="{{ old('phone') }}" autocomplete="tel">
                            @error('phone')<p class="cf-error">{{ $message }}</p>@enderror
                        </div>
                    @endif

                    @if ($showSubject)
                        <div>
                            <label class="cf-label" for="{{ $formId }}-subject">{{ __('Subject') }}</label>
                            <input class="cf-input" id="{{ $formId }}-subject" type="text" name="subject"
                                value="{{ old('subject') }}">
                            @error('subject')<p class="cf-error">{{ $message }}</p>@enderror
                        </div>
                    @endif
                </div>
            @endif

            <div>
                <label class="cf-label" for="{{ $formId }}-message">{{ __('Message') }}</label>
                <textarea class="cf-textarea" id="{{ $formId }}-message" name="message" required>{{ old('message') }}</textarea>
                @error('message')<p class="cf-error">{{ $message }}</p>@enderror
            </div>

            @if (!empty($data['privacy_note']))
                <p class="cf-note">{{ $data['privacy_note'] }}</p>
            @endif

            <button class="cf-button" type="submit">{{ $data['button_label'] ?? __('Send') }}</button>
        </form>
    </div>
</section>
