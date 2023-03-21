<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\UserResource;


class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
           if (auth()->user()) {
                if (auth()->user()->hasRole(['super_admin'])){
                    Filament::registerUserMenuItems([
                        UserMenuItem::make()
                            ->label('Personnels')
                            ->url(UserResource::getUrl())
                            ->icon('heroicon-s-users'),
                        // ...
                    
                    ]);
                }
            }
        });
    }
}
