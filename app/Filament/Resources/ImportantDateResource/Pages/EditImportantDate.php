<?php

namespace App\Filament\Resources\ImportantDateResource\Pages;

use App\Filament\Resources\ImportantDateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImportantDate extends EditRecord
{
    protected static string $resource = ImportantDateResource::class;

    protected static ?string $title = 'Editar Fecha Importante';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
