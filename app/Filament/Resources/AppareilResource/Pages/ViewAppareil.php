<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\AppareilResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAppareil extends ViewRecord
{
    protected static string $resource = AppareilResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
