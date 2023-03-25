<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Appareil;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Tables\Actions\DeleteAction;
use Tables\Filters\TrashedFilter;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\RestoreAction;
use Phpsa\FilamentPasswordReveal\Password;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Utilisateurs';
    protected static ?string $navigationGroup = 'ADMIN MANAGERS';

    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make(3)->schema([
                        TextInput::make('name')
                        ->label('Nom')
                        ->required()
                        ->maxLength(255),

                        TextInput::make('prenom')
                        ->label('Prénoms')
                        ->maxLength(255),

                        TextInput::make('phone')
                        ->label('Téléphone')
                        ->tel()
                        ->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->unique(User::class, 'email',ignoreRecord: true)
                        ->required()
                        ->maxLength(255),

                        Password::make('password')
                        ->label('Mot de passe')
                        ->password()
                        ->showIcon('heroicon-o-eye')
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (Page $livewire) => ($livewire instanceof CreateUser)),
                    ]),
                    Grid::make(2)->schema([
                        Select::make('type_user')
                        ->relationship('roles', 'name')
                        ->options(Role::all()->pluck('name','id'))
                        ->multiple()
                        ->required(),

                        Select::make('service_id')
                        ->label('Département')
                        ->relationship('service', 'title')
                        ->required(),
                    ]),

                    /* Card::make()->schema([
                        Repeater::make('appareils')
                            ->relationship()
                            ->schema([
                                Select::make('appareil_id')
                                ->label('Appareils affecté à cet utilisateur')
                                ->options(Appareil::query()->pluck('title',key:'id')),

                            ])
                            ->createItemButtonLabel('Ajouter un appareil')

                    ]), */

                    Card::make()->schema([
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
                ->circular()
                ->width(25)
                ->height(25)
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('name')
                ->label('Nom')
                ->searchable()
                ->sortable(),

                TextColumn::make('prenom')
                ->label('Prénoms')
                ->searchable()
                ->sortable(),

                TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),

                TextColumn::make('roles.name')
                ->label('Rôle')
                ->searchable()
                ->sortable(),

                TextColumn::make('phone')
                ->label('Téléphone')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('created_at')
                ->since()
                ->label('Date')
                ->sortable(),
            ])
            ->defaultSort(column:'created_at', direction:'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                /* Tables\Filters\Filter::make('verified')
                ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')), */
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
            //Tables\Filters\TrashedFilter::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
