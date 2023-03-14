<?php

namespace App\Filament\Resources\StockResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\StockResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AppareilResource;

class ListStocks extends ListRecords
{
    protected static string $resource = StockResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


}
