<?php

namespace Shazzoo\ContactForm\Forms\Blocks;

use Shazzoo\ContentStudioCore\Support\Blocks\BlockDefinition;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\TextareaField;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\TextInput;

/**
 * Only the surrounding copy lives in the block. The form itself -- the fields,
 * the recipient, the button and the confirmation -- is configured once under
 * Contact Plugin, so every placement of this block stays in step.
 */
final class ContactFormDefinition
{
    public static function definition(): BlockDefinition
    {
        return BlockDefinition::make('contact-form.contact-form')
            ->label('Contact form')
            ->description('The form configured under Contact Plugin. Set the heading here.')
            ->group('Plugins')
            ->icon('heroicon-o-envelope')
            ->schema([
                TextInput::make('eyebrow')->label('Eyebrow')->columnSpan(12),
                TextInput::make('heading')->label('Heading')->default('Neem contact op')->columnSpan(12),
                TextareaField::make('lede')->label('Lede')->rows(3)->columnSpan(12),
            ]);
    }
}
