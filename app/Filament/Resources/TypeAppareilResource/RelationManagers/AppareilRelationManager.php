<?php

namespace App\Filament\Resources\TypeAppareilResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AppareilRelationManager extends RelationManager
{
    protected static string $relationship = 'appareils';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                        ->label('Nom de l\'appareil')
                        ->maxLength(255),

                        Forms\Components\TextInput::make('marque')
                        ->label('Marque')
                        ->maxLength(255),

                        Forms\Components\TextInput::make('num_serie')
                        ->label('Numéro de serie')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255),

                        Forms\Components\Toggle::make('etat')
                        ->label('Etat de l\'appareil')
                        ->required(),

                        Forms\Components\Toggle::make('disponibilite')
                        ->label('Disponibilité')
                        ->required(),

                        Forms\Components\Select::make('service_id')
                        ->label('Département')
                        ->relationship('service', 'title')
                        ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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

                Tables\Columns\IconColumn::make('etat')
                ->label('Etat de l\'appareil')
                ->boolean()
                ->searchable()
                ->sortable(),

                Tables\Columns\IconColumn::make('disponibilite')
                ->label('Disponibilité')
                ->boolean()
                ->toggleable(),

                Tables\Columns\TextColumn::make('service.title')
                ->label('Département')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Ajouter'),
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
}
