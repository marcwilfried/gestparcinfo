<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Piece;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\PieceResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PieceResource\Pages\EditPiece;
use App\Filament\Resources\PieceResource\Pages\ListPieces;
use App\Filament\Resources\PieceResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use App\Filament\Resources\PieceResource\Pages\CreatePiece;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PieceResource extends Resource
{
    protected static ?string $model = Piece::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Gestion des interventions';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->label('Nom de la pièce')
                            ->maxLength(255),

                        TextInput::make('num_serie')
                            ->label('Numéro de serie')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('made_in')
                            ->label('Made-in')
                            ->maxLength(255),

                        TextInput::make('quantite')
                            ->numeric()
                            ->default(1),

                        TextInput::make('price')
                            ->label('Prix Unitaire')
                            ->numeric(),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Image')
                            ->collection('image'),
                    ])

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
                ->toggleable()
                ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Nom de la pièce')
                    ->searchable(),
                Tables\Columns\TextColumn::make('num_serie')
                    ->label('Numéro de serie')
                    ->searchable(),
                Tables\Columns\TextColumn::make('made_in')
                    ->label('Made-in')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Prix unitaire')
                    ->searchable(),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPieces::route('/'),
            'create' => Pages\CreatePiece::route('/create'),
            'edit' => Pages\EditPiece::route('/{record}/edit'),
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
