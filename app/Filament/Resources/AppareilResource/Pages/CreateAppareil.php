<?php

namespace App\Filament\Resources\AppareilResource\Pages;

use App\Mail\UserMail;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\AppareilResource;
use App\Models\Appareil;

class CreateAppareil extends CreateRecord
{
    protected static string $resource = AppareilResource::class;


    protected function getCreatedNotificationTitle(): ?string
    {
        return 'L\'Appareil à été bien crée';
    }

    protected function afterCreate(): void
    {
        $model = $this->record;
        $model->update(Appareil::etat(0));

        Mail::to('arcwilfried@gmail.com')->send(new UserMail($model));
        //dd('succes');
    }
}

