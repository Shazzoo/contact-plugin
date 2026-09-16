<?php

namespace Shazzoo\ContactForm\Filament\Resources\ContactFormResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Shazzoo\ContactForm\Filament\Resources\ContactFormResource;

class ListContactForms extends ListRecords
{
    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
