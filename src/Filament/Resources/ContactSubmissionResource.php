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
use Shazzoo\ContactForm\Models\ContactSubmission;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Plugins';

    protected static ?string $label = 'Contact submission';

    protected static ?string $pluralLabel = 'Contact submissions';

    /** Submissions come from visitors; the admin only reads and deletes them. */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Infolists\Components\TextEntry::make('name'),
            Infolists\Components\TextEntry::make('email')->copyable(),
            Infolists\Components\TextEntry::make('phone')->placeholder('—'),
            Infolists\Components\TextEntry::make('subject')->placeholder('—'),
            Infolists\Components\TextEntry::make('message')->columnSpanFull(),
            Infolists\Components\TextEntry::make('page_url')->placeholder('—')->columnSpanFull(),
            Infolists\Components\TextEntry::make('locale')->placeholder('—'),
            Infolists\Components\TextEntry::make('ip_address')->placeholder('—'),
            Infolists\Components\TextEntry::make('created_at')->dateTime(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Received')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('subject')->searchable()->limit(40)->placeholder('—'),
                Tables\Columns\TextColumn::make('message')->limit(60)->wrap(),
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
