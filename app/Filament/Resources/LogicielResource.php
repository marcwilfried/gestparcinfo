<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Logiciel;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use RelationManagers\AppareilRelationManager;
use App\Filament\Resources\LogicielResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LogicielResource\RelationManagers;

class LogicielResource extends Resource
{
    protected static ?string $model = Logiciel::class;

    protected static ?string $navigationIcon = 'heroicon-o-terminal';

    protected static ?string $navigationGroup = 'Parc Informatique';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Nom du Logiciel')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('version')
                        ->label('Version')
                        ->maxLength(255),
                ])
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('Nom du Logiciel')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('version')
                ->label('Version')
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
            'index' => Pages\ListLogiciels::route('/'),
            'create' => Pages\CreateLogiciel::route('/create'),
            'edit' => Pages\EditLogiciel::route('/{record}/edit'),
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
