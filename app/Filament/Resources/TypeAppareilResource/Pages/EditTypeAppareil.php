<?php

namespace App\Filament\Resources\TypeAppareilResource\Pages;

use App\Filament\Resources\TypeAppareilResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeAppareil extends EditRecord
{
    protected static string $resource = TypeAppareilResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
