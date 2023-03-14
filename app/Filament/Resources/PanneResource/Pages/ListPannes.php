<?php

namespace App\Filament\Resources\PanneResource\Pages;

use App\Filament\Resources\PanneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPannes extends ListRecords
{
    protected static string $resource = PanneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
