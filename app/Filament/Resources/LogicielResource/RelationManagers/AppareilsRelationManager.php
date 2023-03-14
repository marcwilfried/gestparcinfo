<?php

namespace App\Filament\Resources\LogicielResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class AppareilsRelationManager extends RelationManager
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

                    Forms\Components\Select::make('type_appareil_id')
                    ->label('Type Appareil')
                    ->relationship('type_appareil', 'title')
                    ->required(),

                    SpatieMediaLibraryFileUpload::make('image')
                    ->label('Image')
                    ->collection('image'),
            ])
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

                Tables\Columns\IconColumn::make('etat')
                ->label('Etat de l\'appareil')
                ->boolean()
                ->searchable()
                ->sortable(),

                Tables\Columns\IconColumn::make('disponibilite')
                ->label('Disponibilité')
                ->boolean()
                ->toggleable(),

                Tables\Columns\TextColumn::make('type_appareil.title')
                ->label('Type Appareil')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
