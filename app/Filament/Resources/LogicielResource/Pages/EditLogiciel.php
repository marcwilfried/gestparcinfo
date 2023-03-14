<?php

namespace App\Filament\Resources\LogicielResource\Pages;

use App\Filament\Resources\LogicielResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogiciel extends EditRecord
{
    protected static string $resource = LogicielResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
