<?php

namespace App\Filament\Resources\InterventionResource\Pages;

use Filament\Pages\Actions;
use Filament\Forms\Components\Card;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use App\Filament\Resources\InterventionResource;

class EditIntervention extends EditRecord
{
    use EditRecord\Concerns\HasWizard;
    protected static string $resource = InterventionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

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
