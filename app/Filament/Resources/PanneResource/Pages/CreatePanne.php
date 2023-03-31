<?php

namespace App\Filament\Resources\PanneResource\Pages;

use App\Filament\Resources\PanneResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePanne extends CreateRecord
{
    protected static string $resource = PanneResource::class;

    protected function afterCreate(): void
    {
        $model = $this->record;
        $model->update([
            'user_created' => auth()->user()->id,
        ]);
    }
}
