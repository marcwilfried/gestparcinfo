<?php

namespace App\Filament\Resources\CaracteristiqueResource\Pages;

use App\Filament\Resources\CaracteristiqueResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaracteristique extends EditRecord
{
    protected static string $resource = CaracteristiqueResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
