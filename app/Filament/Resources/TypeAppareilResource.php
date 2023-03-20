<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\TypeAppareil;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use RelationManagers\AppareilRelationManager;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TypeAppareilResource\Pages;
use App\Filament\Resources\TypeAppareilResource\RelationManagers;

class TypeAppareilResource extends Resource
{
    protected static ?string $model = TypeAppareil::class;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Parc Informatique';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                ->label('Type d\'appareil')
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('Type d\'appareil')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                ->label('Crée le')
                ->dateTime(),
            ])
            ->defaultSort(column:'created_at', direction:'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            RelationManagers\AppareilRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTypeAppareils::route('/'),
            'create' => Pages\CreateTypeAppareil::route('/create'),
            'edit' => Pages\EditTypeAppareil::route('/{record}/edit'),
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
