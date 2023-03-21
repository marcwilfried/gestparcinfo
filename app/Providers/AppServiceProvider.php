<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;
use Yepsua\Filament\Themes\Facades\FilamentThemes;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {  
        FilamentThemes::register(function() {
            if (auth()->user()->hasRole(['Employé'])){
                return app(Vite::class)('resources/css/filament.css');  
            }
            elseif (auth()->user()->hasRole(['Technicien', 'super_admin'])){
                return app(Vite::class)('resources/css/app.css');  
            }
        });

    

       /*  Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                     ->label('Shop')
                     ->icon('heroicon-s-shopping-cart'),
                NavigationGroup::make()
                    ->label('Blog')
                    ->icon('heroicon-s-pencil'),
                NavigationGroup::make()
                    ->label('Settings')
                    ->icon('heroicon-s-cog')
                    ->collapsed(),
            ]);
        }); */
    }
}
