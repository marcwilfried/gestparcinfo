<?php

return [
    'includes' => [
        App\Filament\Resources\UserResource::class,
        App\Filament\Resources\AppareilResource::class,
        App\Filament\Resources\InterventionResource::class,
        App\Filament\Resources\ServiceResource::class,
        App\Filament\Resources\CaracteristiqueResource::class,
        App\Filament\Resources\PanneResource::class,
        App\Filament\Resources\LogicielResource::class,
        App\Filament\Resources\TypeAppareilResource::class,

    ],
    'excludes' => [
        // App\Filament\Resources\Blog\AuthorResource::class,
    ],
];
