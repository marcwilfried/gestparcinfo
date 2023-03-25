<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Panne;
use App\Models\Piece;
use App\Models\Appareil;
use Pages\ViewIntervention;
use App\Models\Intervention;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
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
use App\Filament\Resources\PieceResource\Pages\CreatePiece;
use App\Filament\Resources\AppareilResource\Pages\CreateAppareil;
use App\Filament\Resources\InterventionResource\RelationManagers;
use App\Filament\Resources\InterventionResource\Pages\EditIntervention;
use App\Filament\Resources\InterventionResource\Pages\ListInterventions;
use App\Filament\Resources\InterventionResource\Pages\CreateIntervention;

class InterventionResource extends Resource
{
    protected static ?string $model = Intervention::class;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

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
                ->label('Crée')
                ->since()
                ->toggleable(),
            ])
            ->defaultSort(column:'created_at', direction:'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\PannesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInterventions::route('/'),
            'create' => Pages\CreateIntervention::route('/create'),
            'view' => Pages\ViewIntervention::route('/{record}'),
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
                Card::make()->schema([
                    Select::make('panne_id')
                    ->label('Les pannes')
                    ->options(Panne::all()->pluck('title','id'))
                    ->multiple(),
                ]),

                Card::make()->schema([
                    Select::make('piece_id')
                    ->label('Les pièces à utiliser')
                    ->relationship('pieces', 'title')
                    ->options(Piece::all()->pluck('title','id'))
                    ->multiple()
                    ->required(fn (Page $livewire) => ($livewire instanceof CreateIntervention)),
                ]),

                Card::make()->schema([
                    Select::make('appareil_id')
                    ->label('Appreil en panne')
                    ->relationship('appareils', 'title'/* ,fn (Builder $query) => $query->where('etat',0) */)
                    ->options(Appareil::where('etat',0)->pluck('title','id'))
                    ->multiple()
                    ->required(fn (Page $livewire) => ($livewire instanceof CreateIntervention)),
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
                        ->default('INTERV-' . random_int(100, 999))
                        ->disabled(),

                    TextInput::make('motif')
                        ->label('Motif')
                        ->required(fn (Page $livewire) => ($livewire instanceof CreateIntervention))
                        ->maxLength(255),

                    DateTimePicker::make('date_intervention')
                        ->required(fn (Page $livewire) => ($livewire instanceof CreateIntervention)),

                ]),
                    MarkdownEditor::make('description')
                        ->label('Description')
                        ->maxLength(255),
            ]),
        ];
    }
}
