<?php

namespace App\Exports;

use App\Models\Intervention;
use Maatwebsite\Excel\Concerns\FromCollection;

class InterventionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Intervention::all();
    }
}
