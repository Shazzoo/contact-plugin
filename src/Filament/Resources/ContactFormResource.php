<?php

namespace Shazzoo\ContactForm\Filament\Resources;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Shazzoo\ContactForm\Filament\Resources\ContactFormResource\Pages;
use Shazzoo\ContactForm\Models\ContactForm;
use Shazzoo\ContactForm\Support\FieldTypes;

class ContactFormResource extends Resource
{
    protected static ?string $model = ContactForm::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return (string) __('contact-form::messages.admin.plugins_group');
    }

    public static function getNavigationLabel(): string
    {
        return (string) __('contact-form::messages.admin.forms.nav');
    }

    public static function getModelLabel(): string
    {
        return (string) __('contact-form::messages.admin.forms.label');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('contact-form::messages.admin.forms.plural');
    }

    public static function form(Schema $form): Schema
    {
        return $form->columns(1)->schema([
            Section::make(__('contact-form::messages.admin.forms.identity'))
                ->description(__('contact-form::messages.admin.forms.identity_hint'))
                ->collapsible()
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label(__('contact-form::messages.admin.forms.name'))
                        ->required()
                        ->live(onBlur: true)
                        // Vult de sleutel alleen bij een nieuw formulier: een
                        // geplaatst blok wijst ernaar.
                        ->afterStateUpdated(function (Get $get, $state, $set): void {
                            if (blank($get('key'))) {
                                $set('key', Str::slug((string) $state));
                            }
                        }),

                    TextInput::make('key')
                        ->label(__('contact-form::messages.admin.forms.key'))
                        ->required()
                        ->alphaDash()
                        ->unique(ignoreRecord: true)
                        ->helperText(__('contact-form::messages.admin.forms.key_hint')),
                ]),

            Section::make(__('contact-form::messages.admin.settings.delivery'))
                ->description(__('contact-form::messages.admin.settings.delivery_hint'))
                ->collapsible()
                ->columns(2)
                ->schema([
                    TextInput::make('recipient')
                        ->label(__('contact-form::messages.admin.settings.recipient'))
                        ->email()
                        ->helperText(__('contact-form::messages.admin.settings.recipient_hint')),

                    TextInput::make('subject_prefix')
                        ->label(__('contact-form::messages.admin.settings.subject_prefix'))
                        ->placeholder(__('contact-form::messages.mail.subject'))
                        ->helperText(__('contact-form::messages.admin.settings.subject_prefix_hint')),

                    TextInput::make('button_label')
                        ->label(__('contact-form::messages.admin.settings.button_label'))
                        ->placeholder(__('contact-form::messages.form.send')),

                    Textarea::make('success_message')
                        ->label(__('contact-form::messages.admin.settings.success_message'))
                        ->placeholder(__('contact-form::messages.form.success'))
                        ->rows(2),

                    Textarea::make('privacy_note')
                        ->label(__('contact-form::messages.admin.settings.privacy_note'))
                        ->rows(2)
                        ->columnSpanFull()
                        ->helperText(__('contact-form::messages.admin.settings.privacy_note_hint')),
                ]),

            Section::make(__('contact-form::messages.admin.settings.fields'))
                ->description(__('contact-form::messages.admin.settings.fields_hint'))
                ->collapsible()
                ->schema([
                    Repeater::make('fields')
                        ->hiddenLabel()
                        ->addActionLabel(__('contact-form::messages.admin.settings.add_field'))
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? $state['name'] ?? null)
                        ->default(fn (): array => ContactForm::defaultFields())
                        ->columns(2)
                        ->schema([
                            TextInput::make('label')
                                ->label(__('contact-form::messages.admin.settings.field_label'))
                                ->required()
                                ->live(onBlur: true)
                                // Vult de sleutel bij een nieuw veld, zonder
                                // die van bestaande velden te overschrijven:
                                // opgeslagen inzendingen verwijzen ernaar.
                                ->afterStateUpdated(function (Get $get, $state, $set): void {
                                    if (blank($get('name'))) {
                                        $set('name', Str::slug((string) $state, '_'));
                                    }
                                }),

                            TextInput::make('name')
                                ->label(__('contact-form::messages.admin.settings.field_key'))
                                ->required()
                                ->alphaDash()
                                ->helperText(__('contact-form::messages.admin.settings.field_key_hint')),

                            Select::make('type')
                                ->label(__('contact-form::messages.admin.settings.field_type'))
                                ->options(FieldTypes::options())
                                ->default(FieldTypes::TEXT)
                                ->required()
                                ->live(),

                            Select::make('role')
                                ->label(__('contact-form::messages.admin.settings.field_role'))
                                ->options(FieldTypes::roleOptions())
                                ->default('none')
                                ->helperText(__('contact-form::messages.admin.settings.field_role_hint')),

                            Textarea::make('options')
                                ->label(__('contact-form::messages.admin.settings.field_choices'))
                                ->rows(4)
                                ->columnSpanFull()
                                ->helperText(__('contact-form::messages.admin.settings.field_choices_hint'))
                                ->visible(fn (Get $get): bool => $get('type') === FieldTypes::SELECT),

                            TextInput::make('placeholder')
                                ->label(__('contact-form::messages.admin.settings.field_placeholder'))
                                ->visible(fn (Get $get): bool => ! in_array($get('type'), [FieldTypes::CHECKBOX, FieldTypes::SELECT], true)),

                            Select::make('width')
                                ->label(__('contact-form::messages.admin.settings.field_width'))
                                ->options([
                                    'full' => __('contact-form::messages.admin.settings.field_width_full'),
                                    'half' => __('contact-form::messages.admin.settings.field_width_half'),
                                ])
                                ->default('full'),

                            Toggle::make('required')
                                ->label(__('contact-form::messages.admin.settings.field_required'))
                                ->default(false),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('contact-form::messages.admin.forms.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('key')->label(__('contact-form::messages.admin.forms.key'))->badge()->searchable(),
                Tables\Columns\TextColumn::make('recipient')->label(__('contact-form::messages.admin.settings.recipient'))->placeholder('—'),
                Tables\Columns\TextColumn::make('submissions_count')
                    ->label(__('contact-form::messages.admin.submissions.plural'))
                    ->counts('submissions'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactForms::route('/'),
            'create' => Pages\CreateContactForm::route('/create'),
            'edit' => Pages\EditContactForm::route('/{record}/edit'),
        ];
    }
}
