<?php
namespace App\Filament\Resources\InterventionResource\Pages;

use App\Filament\Resources\InterventionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\Action;
use App\Exports\InterventionsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Intervention;
use Filament\Forms;

class ListInterventions extends ListRecords
{
    protected static string $resource = InterventionResource::class;

    protected function getActions(): array
    {
        return array_merge(parent::getActions(), [
            Action::make('export')
                ->button()
                ->action('export'),
        ]);
    }

    public function export()
    {
        return Excel::download(new InterventionsExport, 'interventions.xlsx');
    }
}
