{{-- Publiceer deze view om de vormgeving van het formulier over te nemen. --}}
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
    .cf-form { margin-top: 28px; display: grid; gap: 20px; }
    .cf-grid { display: grid; gap: 16px; }
    @media (min-width: 640px) {
        .cf-grid { grid-template-columns: 1fr 1fr; }
        .cf-field-full { grid-column: span 2; }
    }
    .cf-label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: var(--ink-800, #1e293b); }
    .cf-required { margin-left: 2px; color: var(--amber-600, #b45309); }
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
    .cf-checkbox { display: flex; gap: 10px; align-items: flex-start; font-size: 15px; color: var(--ink-800, #1e293b); }
    .cf-checkbox input { margin-top: 3px; }
    .cf-error { margin: 6px 0 0; font-size: 14px; color: #b91c1c; }
    .cf-error-form { margin-top: 16px; }
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
