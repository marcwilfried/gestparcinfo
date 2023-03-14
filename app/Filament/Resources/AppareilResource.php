<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Tables;
use App\Models\Appareil;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Tables\Actions\ViewAction;
use Tables\Columns\BadgeColums;
use Filament\Resources\Resource;
use Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\StockResource;
use Filament\Pages\Actions\RestoreAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\AppareilResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\AppareilResource\RelationManagers;
use App\Filament\Resources\AppareilResource\Pages\EditAppareil;
use App\Filament\Resources\AppareilResource\Pages\ListAppareils;
use App\Filament\Resources\AppareilResource\Pages\CreateAppareil;
use App\Filament\Resources\AppareilResource\RelationManagers\LogicielsRelationManager;

class AppareilResource extends Resource
{
    protected static ?string $model = Appareil::class;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    protected static ?string $navigationIcon = 'heroicon-o-device-mobile';

    protected static ?string $navigationGroup = 'Parc Informatique';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Card::make()->schema([
                        Forms\Components\TextInput::make('title')
                        ->label('Nom de l\'appareil')
                        ->required()
                        ->maxLength(255),

                        Forms\Components\TextInput::make('marque')
                        ->label('Marque')
                        ->required()
                        ->maxLength(255),

                        Forms\Components\TextInput::make('num_serie')
                        ->label('Numéro de serie')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255),

                        Forms\Components\Select::make('type_appareil_id')
                        ->label('Type Appareil')
                        ->relationship('type_appareil', 'title')
                        ->required(),

                        Forms\Components\Select::make('service_id')
                        ->label('Département')
                        ->relationship('service', 'title')
                        ->required(),

                        Forms\Components\Select::make('logiciel_id')
                        ->label('Logiciel')
                        ->multiple()
                        ->relationship('logiciels', 'title'),

                        Forms\Components\Select::make('caracteristique_id')
                        ->label('Caractéristiques')
                        ->multiple()
                        ->relationship('caracteristiques', 'title')
                        ->required(),

                        SpatieMediaLibraryFileUpload::make('image')
                        ->label('Image')
                        ->collection('image'),
                    ])
                    ->columns(2),
                ])
                ->columnSpan(['lg' => 2]),

                Group::make()->schema([
                    Section::make('Status')->schema([
                        Grid::make(1)->schema([
                            Forms\Components\Toggle::make('etat')
                            ->label('Etat de l\'appareil')
                            ->required(),

                            Forms\Components\Toggle::make('disponibilite')
                            ->label('Disponibilité')
                            ->required(),
                        ]),
                    ]),

                    Card::make()
                        ->schema([
                        Placeholder::make('created_at')
                                ->label('Crée le')
                                ->content(fn (Appareil $record): ?string => $record->created_at?->diffForHumans()),

                        Placeholder::make('updated_at')
                                ->label('Dernière modification')
                                ->content(fn (Appareil $record): ?string => $record->updated_at?->diffForHumans()),
                        ])
                        ->columnSpan(['lg' => 1])
                        ->hidden(fn (?Appareil $record) => $record === null),
                ])
                ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
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

                Tables\Columns\TextColumn::make('service.title')
                ->label('Département')
                ->searchable()
                ->sortable(),

                Tables\Columns\ToggleColumn::make('etat')
                ->label('Etat de l\'appareil')
                ->toggleable(),

                Tables\Columns\ToggleColumn::make('disponibilite')
                ->label('Disponibilité')
                ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                ->label('Crée le')
                ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('Appareil en stock')
                    ->query(fn(Builder $query): Builder => $query->where('disponibilite',0) ),

                Filter::make('Appareil en Panne')
                    ->query(fn(Builder $query): Builder => $query->where('etat',0) ),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Du'),
                        Forms\Components\DatePicker::make('created_until')->label('Au'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
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
            RelationManagers\LogicielsRelationManager::class,
            RelationManagers\CaracteristiquesRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppareils::route('/'),
            'create' => Pages\CreateAppareil::route('/create'),
            'edit' => Pages\EditAppareil::route('/{record}/edit'),
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

