<?php

namespace App\Filament\Resources\LogicielResource\Pages;

use App\Filament\Resources\LogicielResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogiciels extends ListRecords
{
    protected static string $resource = LogicielResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
