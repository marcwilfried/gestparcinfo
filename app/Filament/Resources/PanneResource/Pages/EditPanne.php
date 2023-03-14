<?php

namespace App\Filament\Resources\PanneResource\Pages;

use App\Filament\Resources\PanneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPanne extends EditRecord
{
    protected static string $resource = PanneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
