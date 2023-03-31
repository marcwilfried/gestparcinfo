<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Panne;
use App\Models\Appareil;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\PanneResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Factories\Relationship;
use App\Filament\Resources\PanneResource\Pages\EditPanne;
use App\Filament\Resources\PanneResource\Pages\ListPannes;
use App\Filament\Resources\PanneResource\RelationManagers;
use App\Filament\Resources\PanneResource\Pages\CreatePanne;

class PanneResource extends Resource
{
    protected static ?string $model = Panne::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationGroup = 'Gestion des interventions';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                        ->label('Titre')
                        ->maxLength(255),

                        Select::make('appareil_id')
                        ->relationship('appareil','title',fn (Builder $query) => $query->where('etat',0)),

                    ]),

                    MarkdownEditor::make('description')
                    ->label('Description')
                    ->maxLength(255),


                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('Titre')
                ->searchable(),

                Tables\Columns\TextColumn::make('appareil.title')
                ->label('Appareils en panne')
                ->searchable(),

                Tables\Columns\TextColumn::make('userCreated.name')
                ->label('Crée par')
                ->searchable()
                ->toggleable()
                ->sortable(),

                Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->searchable()
                ->toggleable()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPannes::route('/'),
            'create' => Pages\CreatePanne::route('/create'),
            'edit' => Pages\EditPanne::route('/{record}/edit'),
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
