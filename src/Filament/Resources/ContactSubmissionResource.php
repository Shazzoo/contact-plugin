<?php

namespace Shazzoo\ContactForm\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Shazzoo\ContactForm\Filament\Resources\ContactSubmissionResource\Pages;
use Shazzoo\ContactForm\Models\ContactSubmission;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static ?int $navigationSort = 20;

    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return (string) __('contact-form::messages.admin.group');
    }

    public static function getNavigationLabel(): string
    {
        return (string) __('contact-form::messages.admin.submissions.nav');
    }

    public static function getModelLabel(): string
    {
        return (string) __('contact-form::messages.admin.submissions.label');
    }

    public static function getPluralModelLabel(): string
    {
        return (string) __('contact-form::messages.admin.submissions.plural');
    }

    /** Submissions come from visitors; the admin only reads and deletes them. */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Infolists\Components\KeyValueEntry::make('data')
                ->label(__('contact-form::messages.admin.submissions.answers'))
                ->keyLabel(__('contact-form::messages.admin.submissions.answer_field'))
                ->valueLabel(__('contact-form::messages.admin.submissions.answer_value'))
                ->state(fn (ContactSubmission $record): array => $record->labelledAnswers(
                    $record->contactForm?->usableFields() ?? [],
                ))
                ->columnSpanFull(),

            Infolists\Components\TextEntry::make('contactForm.name')->label(__('contact-form::messages.admin.submissions.form'))->placeholder('—'),
            Infolists\Components\TextEntry::make('page_url')->label(__('contact-form::messages.admin.submissions.page'))->placeholder('—')->columnSpanFull(),
            Infolists\Components\TextEntry::make('locale')->label(__('contact-form::messages.admin.submissions.locale'))->placeholder('—'),
            Infolists\Components\TextEntry::make('ip_address')->label(__('contact-form::messages.admin.submissions.ip'))->placeholder('—'),
            Infolists\Components\TextEntry::make('created_at')->label(__('contact-form::messages.admin.submissions.received'))->dateTime(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('contactForm'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label(__('contact-form::messages.admin.submissions.received'))->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('contactForm.name')
                    ->label(__('contact-form::messages.admin.submissions.form'))
                    ->badge()
                    ->sortable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('name')->label(__('contact-form::messages.admin.submissions.name'))->searchable()->sortable()->placeholder('—'),
                Tables\Columns\TextColumn::make('email')->label(__('contact-form::messages.admin.submissions.email'))->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('subject')->label(__('contact-form::messages.admin.submissions.subject'))->searchable()->limit(40)->placeholder('—'),

                // De overige antwoorden verschillen per formulier, dus die vat
                // een enkele kolom samen in plaats van een kolom per veld.
                Tables\Columns\TextColumn::make('data')
                    ->label(__('contact-form::messages.admin.submissions.answers'))
                    ->limit(60)
                    ->wrap()
                    ->state(fn (ContactSubmission $record): string => collect($record->labelledAnswers(
                        $record->contactForm?->usableFields() ?? [],
                    ))->map(fn ($value, $label): string => $label.': '.$value)->implode(' · ')),
            ])
            ->filters([
                SelectFilter::make('contact_form_id')
                    ->label(__('contact-form::messages.admin.submissions.form'))
                    ->relationship('contactForm', 'name'),
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
