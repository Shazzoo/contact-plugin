<?php

namespace Shazzoo\ContactForm\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Shazzoo\ContactForm\Filament\Resources\ContactSubmissionResource\Pages;
use Shazzoo\ContactForm\Models\ContactFormSetting;
use Shazzoo\ContactForm\Models\ContactSubmission;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static string|\UnitEnum|null $navigationGroup = 'Contact Plugin';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Inzendingen';

    protected static ?string $label = 'Inzending';

    protected static ?string $pluralLabel = 'Inzendingen';

    /** Submissions come from visitors; the admin only reads and deletes them. */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Infolists\Components\KeyValueEntry::make('data')
                ->label('Antwoorden')
                ->keyLabel('Veld')
                ->valueLabel('Antwoord')
                ->state(fn (ContactSubmission $record): array => $record->labelledAnswers(
                    ContactFormSetting::singleton()->usableFields(),
                ))
                ->columnSpanFull(),

            Infolists\Components\TextEntry::make('page_url')->label('Pagina')->placeholder('—')->columnSpanFull(),
            Infolists\Components\TextEntry::make('locale')->label('Taal')->placeholder('—'),
            Infolists\Components\TextEntry::make('ip_address')->label('IP')->placeholder('—'),
            Infolists\Components\TextEntry::make('created_at')->label('Ontvangen')->dateTime(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Ontvangen')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Naam')->searchable()->sortable()->placeholder('—'),
                Tables\Columns\TextColumn::make('email')->label('E-mail')->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('subject')->label('Onderwerp')->searchable()->limit(40)->placeholder('—'),

                // De overige antwoorden verschillen per formulier, dus die vat
                // een enkele kolom samen in plaats van een kolom per veld.
                Tables\Columns\TextColumn::make('data')
                    ->label('Antwoorden')
                    ->limit(60)
                    ->wrap()
                    ->state(fn (ContactSubmission $record): string => collect($record->labelledAnswers(
                        ContactFormSetting::singleton()->usableFields(),
                    ))->map(fn ($value, $label): string => $label.': '.$value)->implode(' · ')),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'view' => Pages\ViewContactSubmission::route('/{record}'),
        ];
    }
}
