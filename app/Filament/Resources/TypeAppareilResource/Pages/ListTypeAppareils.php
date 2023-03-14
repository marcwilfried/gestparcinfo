<?php

namespace App\Filament\Resources\TypeAppareilResource\Pages;

use App\Filament\Resources\TypeAppareilResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeAppareils extends ListRecords
{
    protected static string $resource = TypeAppareilResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
