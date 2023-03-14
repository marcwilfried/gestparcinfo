<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Piece;
use App\Models\Intervention;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Forms\Components\MarkdownEditort;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InterventionResource\Pages;
use App\Filament\Resources\InterventionResource\RelationManagers;
use App\Filament\Resources\InterventionResource\Pages\EditIntervention;
use App\Filament\Resources\InterventionResource\Pages\ListInterventions;
use App\Filament\Resources\InterventionResource\Pages\CreateIntervention;

class InterventionResource extends Resource
{
    protected static ?string $model = Intervention::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Gestion des interventions';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Card::make()
                        ->schema(static::getFormSchema())
                        ->columns(2),

                    Forms\Components\Section::make('Autres Informations')
                        ->schema(static::getFormSchema('pieces')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('Numéro de l\'intervention')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->limit(30)
                ->searchable()
                ->sortable()
                ->toggleable(),

                Tables\Columns\TextColumn::make('motif')
                ->label('Motif')
                ->limit(20)
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('appareils.title')
                ->label('Appareil en panne')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('date_intervention')
                ->label('Date Intervention')
                ->dateTime('d-M-Y'),
                Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->toggleable(),
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
            RelationManagers\PannesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInterventions::route('/'),
            'create' => Pages\CreateIntervention::route('/create'),
            'edit' => Pages\EditIntervention::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getFormSchema(?string $section = null): array
    {
        if ($section === 'pieces') {
            return [
                Forms\Components\Repeater::make(name:'pieces')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('piece_id')
                            ->label('Pièces')
                            ->options(Piece::query()->pluck('title',key:'id'))
                            ->reactive()
                            ->afterStateUpdated(function($state, callable $set){
                                $piece = Piece::find($state);
                                if ($piece){
                                    $set('price', number_format($piece->price / 100,2));
                                }
                            })
                            ->columnSpan([
                                'md' => 5,
                            ]),

                        Forms\Components\TextInput::make('quantite')
                            ->numeric()
                            ->default(1)
                            ->columnSpan([
                                'md' => 2,
                            ]),

                        Forms\Components\TextInput::make('price')
                            ->label('Prix Unitaire')
                            ->numeric()
                            ->disabled()
                            ->columnSpan([
                                'md' => 3,
                            ]),
                    ])
                    ->orderable()
                    ->defaultItems(1)
                    ->disableLabel()
                    ->columns([
                        'md' => 10,
                    ]),

                Card::make()
                ->schema([
                Select::make('appareil_id')
                    ->label('Appreil en panne')
                    ->relationship('appareils', 'title',fn (Builder $query) => $query->where('etat',0))
                    ->multiple()
                    ->required(),
                ]),
            ];

        }

        return [
            Card::make()
            ->schema([
                Grid::make(3)
                ->schema([
                    TextInput::make('title')
                        ->label('Numéro de l\'intervention')
                        ->default('INTERV-' . random_int(100000, 999999))
                        ->disabled()
                        ->required(),
                    TextInput::make('motif')
                        ->label('Motif')
                        ->required()
                        ->maxLength(255),
                    DateTimePicker::make('date_intervention')
                        ->required(),

                ]),
                    MarkdownEditor::make('description')
                        ->label('Description')
                        ->maxLength(255),
            ]),
        ];
    }
}
