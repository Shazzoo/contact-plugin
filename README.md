# Contact Plugin

A Content Studio plugin that adds a **Contact form** block.

Forms are built in the admin under **Plugins → Formulieren**: as many as the
site needs, each with its own fields, recipient, button label and confirmation
message. A block picks one of them and carries the copy around it, so the same
form can stand on several pages and two blocks on one page can show two
different forms.

Submissions are stored in `contact_submissions`, attributed to the form they
came from, and listed under **Contact Plugin → Inzendingen**.

## Install

1. Activate "Contact Plugin" under Plugins in the admin.
2. Run `php artisan migrate` (the plugin ships its own migrations).
3. Open **Plugins → Formulieren**, create a form and set the recipient. Without
   one, the `CONTACT_FORM_RECIPIENT` from `.env` is used; without either,
   submissions are stored but nothing is mailed.
4. Place a **Contact form** block on a page and choose the form.

A form has a **key** next to its name. That is what a placed block stores, so
renaming the key orphans the blocks pointing at it — they fall back to the
oldest form. The name can be changed freely.

## Fields

Each field has a label, a key, a type (text, e-mail, phone, URL, number, date,
textarea, select, checkbox), a width and an optional **role**. Roles tell the
plugin which answer is the sender's name, e-mail (used as the mail's reply-to)
and subject — those get their own columns in the submissions list. Everything
else is stored in the `data` payload.

The key is what a submission is stored under; renaming it leaves older
submissions showing the old key.

## Blocks

The block has a form picker, an eyebrow, a heading and a lede. Everything else
— the fields, the button, the thank-you message, the privacy text — belongs to
the form, so it stays in step across every page the form is on.

Deleting a form leaves its submissions in place, without a form to link to; a
block that pointed at it falls back to the oldest form.

## Options

`config/contact-form.php` (publish with `--tag=contact-form-config`):

- `recipient` — fallback address when the admin sets none.
- `max_attempts` / `decay_minutes` — per-IP rate limit on submissions.
- `retention_days` — days a submission is kept; `0` keeps everything.
- `store_ip` — whether the sender's IP is stored. Off by default.

## Languages

Dutch, English, German, Spanish and French ship with the plugin; the form and
the admin follow the app's locale, and a missing line falls back to
`fallback_locale`.

Adding a language is copying `lang/en/messages.php` to
`lang/<locale>/messages.php` and translating the values. Nothing has to be
registered.

To change the shipped wording per site, publish the files and edit them in
`lang/vendor/contact-form`:

```
php artisan vendor:publish --tag=contact-form-lang
```

The recipient, the button label, the thank-you message and the privacy text are
per-site content, so they are set in the admin instead. Left empty, they fall
back to the translation of the visitor's language.

## Personal data

A submission is personal data. The plugin keeps as little of it as it can:

- **Retention.** Submissions older than `retention_days` (a year by default)
  are deleted for good by a daily `model:prune`, which the plugin schedules
  itself. This needs Laravel's scheduler to be running.
- **IP addresses** are not stored unless `store_ip` is turned on. Rate limiting
  works either way.
- **Erasure.** A submission can be deleted from the detail page or in bulk from
  the list, which is a hard delete.

What the plugin cannot decide for you: add a required checkbox field for
consent if you need one, and use the privacy text under the form to link your
privacy statement. Both are set under **Contact Plugin → Formulier**.

## Restyling

Publish the views and edit them in `resources/views/vendor/contact-form`:

```
php artisan vendor:publish --tag=contact-form-views
```

Every input renders through `contact-form::fields.<type>` and all CSS lives in
`partials/styles.blade.php`, so a single field type or the whole look can be
replaced without forking the plugin.

Views published before forms became plural need two edits: the block view gets
its form as `$form` instead of `$settings`, and the `<form>` needs the hidden
`form` input carrying `$form->key` — without it the submission cannot tell
which form it came from.

## License

MIT. See [LICENSE](LICENSE).
