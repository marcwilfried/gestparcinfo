<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaracteristiqueResource\Pages;
use App\Filament\Resources\CaracteristiqueResource\RelationManagers;
use App\Models\Caracteristique;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaracteristiqueResource extends Resource
{
    protected static ?string $model = Caracteristique::class;

    protected static ?string $navigationIcon = 'heroicon-o-chip';

    protected static ?string $navigationGroup = 'Parc Informatique';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Nom')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nom'),

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
            RelationManagers\AppareilsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaracteristiques::route('/'),
            'create' => Pages\CreateCaracteristique::route('/create'),
            'edit' => Pages\EditCaracteristique::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
