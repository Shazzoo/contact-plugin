<?php

namespace Shazzoo\ContactForm\Forms\Blocks;

use Shazzoo\ContentStudioCore\Support\Blocks\BlockDefinition;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\TextareaField;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\TextInput;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\ToggleField;

final class ContactFormDefinition
{
    public static function definition(): BlockDefinition
    {
        return BlockDefinition::make('contact-form.contact-form')
            ->label('Contact form')
            ->description('A contact form that stores submissions and mails them to a recipient.')
            ->group('Plugins')
            ->icon('heroicon-o-envelope')
            ->schema([
                TextInput::make('eyebrow')->label('Eyebrow')->columnSpan(12),
                TextInput::make('heading')->label('Heading')->default('Neem contact op')->columnSpan(12),
                TextareaField::make('lede')->label('Lede')->rows(3)->columnSpan(12),

                TextInput::make('recipient')
                    ->label('Recipient e-mail')
                    ->helperText('Leave empty to use the address configured in contact-form.recipient.')
                    ->columnSpan(12),

                ToggleField::make('show_phone')->label('Ask for a phone number')->default(false)->columnSpan(6),
                ToggleField::make('show_subject')->label('Ask for a subject')->default(true)->columnSpan(6),

                TextInput::make('button_label')->label('Button label')->default('Versturen')->columnSpan(12),
                TextareaField::make('success_message')
                    ->label('Success message')
                    ->rows(2)
                    ->default('Bedankt voor je bericht. We nemen zo snel mogelijk contact op.')
                    ->columnSpan(12),
                TextareaField::make('privacy_note')->label('Privacy note')->rows(2)->columnSpan(12),
            ]);
    }
}
