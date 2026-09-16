<?php

namespace Shazzoo\ContactForm\Filament\Resources\ContactFormResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Shazzoo\ContactForm\Filament\Resources\ContactFormResource;
use Shazzoo\ContactForm\Models\ContactForm;

class EditContactForm extends EditRecord
{
    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('restoreDefaults')
                ->label(__('contact-form::messages.admin.settings.restore'))
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('gray')
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->form->fill([
                        ...$this->form->getState(),
                        'fields' => ContactForm::defaultFields(),
                    ]);
                }),

            DeleteAction::make(),
        ];
    }
}
