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

    protected static ?string $navigationLabel = 'Formulier';

    protected static string|\UnitEnum|null $navigationGroup = 'Contact Plugin';

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'Contactformulier';

    protected string $view = 'contact-form::filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(ContactFormSetting::singleton()->toArray());
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Verzending')
                    ->description('Waar een inzending naartoe gaat en wat de bezoeker daarna ziet.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('recipient')
                            ->label('Ontvanger')
                            ->email()
                            ->helperText('Leeg laten gebruikt CONTACT_FORM_RECIPIENT uit de .env.'),

                        TextInput::make('subject_prefix')
                            ->label('Onderwerp-prefix')
                            ->placeholder('Contactformulier')
                            ->helperText('Komt voor het onderwerp in de notificatiemail.'),

                        TextInput::make('button_label')
                            ->label('Label van de knop')
                            ->default('Versturen'),

                        Textarea::make('success_message')
                            ->label('Bedanktbericht')
                            ->rows(2),

                        Textarea::make('privacy_note')
                            ->label('Privacytekst')
                            ->rows(2)
                            ->columnSpanFull()
                            ->helperText('Optionele tekst onder het formulier.'),
                    ]),

                Section::make('Velden')
                    ->description('De velden van het formulier. De volgorde hier is de volgorde op de pagina.')
                    ->schema([
                        Repeater::make('fields')
                            ->hiddenLabel()
                            ->addActionLabel('Veld toevoegen')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? $state['name'] ?? null)
                            ->defaultItems(0)
                            ->columns(2)
                            ->schema([
                                TextInput::make('label')
                                    ->label('Label')
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
                                    ->label('Sleutel')
                                    ->required()
                                    ->alphaDash()
                                    ->helperText('Wordt opgeslagen bij de inzending. Wijzig dit niet meer als er al inzendingen zijn.'),

                                Select::make('type')
                                    ->label('Type')
                                    ->options(FieldTypes::options())
                                    ->default(FieldTypes::TEXT)
                                    ->required()
                                    ->live(),

                                Select::make('role')
                                    ->label('Rol')
                                    ->options(FieldTypes::roleOptions())
                                    ->default('none')
                                    ->helperText('Bepaalt het antwoord-adres en de kolommen in het overzicht.'),

                                Textarea::make('options')
                                    ->label('Keuzes')
                                    ->rows(4)
                                    ->columnSpanFull()
                                    ->helperText('Een keuze per regel.')
                                    ->visible(fn (Get $get): bool => $get('type') === FieldTypes::SELECT),

                                TextInput::make('placeholder')
                                    ->label('Placeholder')
                                    ->visible(fn (Get $get): bool => ! in_array($get('type'), [FieldTypes::CHECKBOX, FieldTypes::SELECT], true)),

                                Select::make('width')
                                    ->label('Breedte')
                                    ->options(['full' => 'Hele breedte', 'half' => 'Halve breedte'])
                                    ->default('full'),

                                Toggle::make('required')
                                    ->label('Verplicht')
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
            ->title('Contactformulier opgeslagen')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Opslaan')
                ->icon('heroicon-o-check')
                ->keyBindings(['mod+s'])
                ->action('save'),

            Action::make('restoreDefaults')
                ->label('Standaardvelden terugzetten')
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
