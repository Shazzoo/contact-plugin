<?php

namespace Shazzoo\ContactForm\Forms\Blocks;

use Shazzoo\ContactForm\Models\ContactForm;
use Shazzoo\ContentStudioCore\Support\Blocks\BlockDefinition;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\SelectField;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\TextareaField;
use Shazzoo\ContentStudioCore\Support\Fields\Definitions\TextInput;

/**
 * The block picks one of the forms configured under Contact Plugin and carries
 * the copy around it, so the same form can stand on as many pages as it needs
 * to and two blocks can show two different forms.
 */
final class ContactFormDefinition
{
    public static function definition(): BlockDefinition
    {
        $forms = ContactForm::options();

        return BlockDefinition::make('contact-form.contact-form')
            ->label(__('contact-form::messages.block.label'))
            ->description(__('contact-form::messages.block.description'))
            ->group('Plugins')
            ->icon('heroicon-o-envelope')
            ->schema([
                SelectField::make('form')
                    ->label(__('contact-form::messages.block.form'))
                    ->helperText(__('contact-form::messages.block.form_hint'))
                    ->options($forms)
                    ->default(array_key_first($forms))
                    ->columnSpan(12),
                TextInput::make('eyebrow')->label(__('contact-form::messages.block.eyebrow'))->columnSpan(12),
                TextInput::make('heading')->label(__('contact-form::messages.block.heading'))->default(__('contact-form::messages.block.heading_default'))->columnSpan(12),
                TextareaField::make('lede')->label(__('contact-form::messages.block.lede'))->rows(3)->columnSpan(12),
            ]);
    }
}
