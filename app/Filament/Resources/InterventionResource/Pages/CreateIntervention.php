<?php

namespace App\Filament\Resources\InterventionResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Str;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\InterventionResource;

class CreateIntervention extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = InterventionResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Description de l\'intervention')
                ->schema([
                    Card::make(InterventionResource::getFormSchema())->columns(),
                ]),

            Step::make('Autres Informations')
                ->description('Prise en compte des appareils et des pièces')
                ->schema([
                    Card::make(InterventionResource::getFormSchema('pieces')),
                ]),
        ];
    }
}
