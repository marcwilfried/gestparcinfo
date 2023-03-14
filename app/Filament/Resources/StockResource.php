<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Stock;
use App\Models\Appareil;
use Faker\Provider\Text;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StockResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationGroup = 'Parc Informatique';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            SpatieMediaLibraryImageColumn::make('image')
            ->label('Photo')
            ->collection('image')
            ->circular()
            ->width(25)
            ->height(25)
            ->toggleable()
            ->toggledHiddenByDefault(),

            Tables\Columns\TextColumn::make('title')
            ->label('Nom de l\'appareil')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('marque')
            ->label('Marque')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('num_serie')
            ->label('Numéro de serie')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('type_appareil.title')
            ->label('Type Appareil')
            ->searchable()
            ->sortable(),
            Tables\Columns\ToggleColumn::make('etat')
            ->label('Etat de l\'appareil')
            ->toggleable(),

            Tables\Columns\TextColumn::make('service.title')
            ->label('Département')
            ->searchable()
            ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
            ->label('Crée le')
            ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('appareils', function($q){
                $q->where('disponibilite',0);
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
