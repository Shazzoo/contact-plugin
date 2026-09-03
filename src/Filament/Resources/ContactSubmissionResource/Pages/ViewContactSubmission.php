<?php

namespace Shazzoo\ContactForm\Filament\Resources\ContactSubmissionResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Shazzoo\ContactForm\Filament\Resources\ContactSubmissionResource;

class ViewContactSubmission extends ViewRecord
{
    protected static string $resource = ContactSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
