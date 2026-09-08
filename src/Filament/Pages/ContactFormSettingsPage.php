<?php

namespace Shazzoo\ContactForm\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Shazzoo\ContactForm\Models\ContactFormSetting;
use Shazzoo\ContactForm\Support\FieldTypes;

class ContactFormSettingsPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?int $navigationSort = 10;

    protected string $view = 'contact-form::filament.pages.settings';

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return (string) __('contact-form::messages.admin.settings.nav');
    }

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return (string) __('contact-form::messages.admin.group');
    }

    public function getTitle(): string
    {
        return (string) __('contact-form::messages.admin.settings.title');
    }

    public function mount(): void
    {
        $this->form->fill(ContactFormSetting::singleton()->toArray());
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make(__('contact-form::messages.admin.settings.delivery'))
                    ->description(__('contact-form::messages.admin.settings.delivery_hint'))
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
                    ->schema([
                        Repeater::make('fields')
                            ->hiddenLabel()
                            ->addActionLabel(__('contact-form::messages.admin.settings.add_field'))
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? $state['name'] ?? null)
                            ->defaultItems(0)
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
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $model = ContactFormSetting::singleton();
        $model->fill($this->form->getState());
        $model->save();

        Notification::make()
            ->title(__('contact-form::messages.admin.settings.saved'))
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('contact-form::messages.admin.settings.save'))
                ->icon('heroicon-o-check')
                ->keyBindings(['mod+s'])
                ->action('save'),

            Action::make('restoreDefaults')
                ->label(__('contact-form::messages.admin.settings.restore'))
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('gray')
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->form->fill([
                        ...$this->form->getState(),
                        'fields' => ContactFormSetting::defaultFields(),
                    ]);
                }),
        ];
    }
}
