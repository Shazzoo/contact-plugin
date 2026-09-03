# Contact Form

A Content Studio plugin that adds a **Contact form** block. Submissions are
stored in `contact_submissions` and mailed to a recipient.

## Install

1. Activate "Contact Form" under Plugins in the admin.
2. Run `php artisan migrate` (the plugin ships its own migration).
3. Set a fallback recipient in `.env`:

   ```
   CONTACT_FORM_RECIPIENT=info@example.com
   ```

Each block can override the recipient in the page editor. The address travels
through the page encrypted, so the form cannot be turned into an open relay.

## Options

`config/contact-form.php` (publish with `--tag=contact-form-config`):

- `recipient` — fallback address when a block sets none.
- `max_attempts` / `decay_minutes` — per-IP rate limit on submissions.

## Restyling

Publish the views and edit them in `resources/views/vendor/contact-form`:

```
php artisan vendor:publish --tag=contact-form-views
```
