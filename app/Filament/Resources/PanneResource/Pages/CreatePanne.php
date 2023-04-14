<?php

namespace App\Filament\Resources\PanneResource\Pages;

use App\Models\User;
use App\Mail\UserMail;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\Mail;
use App\Filament\Resources\PanneResource;
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

        Mail::to('arcwilfried@gmail.com')->send(new UserMail($model));
        //dd('succes');
    }

}
