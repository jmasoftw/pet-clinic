<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Filament\Resources\PetResource\RelationManagers;
use App\Models\Pet;
use App\Enums\PetType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // This function uses form controls to create the form (Pets > Create) of this resource to add new resources
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\FileUpload::make('avatar')
                        ->image()
                        ->imageEditor(),
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\DatePicker::make('DOB')
                        ->closeOnDateSelection(true)
                        ->native(false)
                        ->required()
                        ->displayFormat('d / M / Y')
                        ->label('Date of birth'),
                    Forms\Components\Select::make('type')
                        ->native(false)
                        ->options(PetType::class), // We populate the list with enums coming from a PetType class
                    Forms\Components\Select::make('owner_id')
                        ->native(false)
                        ->relationship('owner','name') // We populate the list with values extracted from the owner relationship coming from the Owners DB table and using its 'name' field attribute as label
                        ->searchable()
                        ->preload() // We pre-populate the control to get some values available at once, otherwise the user has to start typing to start getting results appearing when searching
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->required(),
                            Forms\Components\TextInput::make('email')
                                ->required()
                                ->email(),
                            Forms\Components\TextInput::make('phone')
                                ->required()
                                ->tel(),
                            // We take the form input controls from the OwnerResource and make them available here. A '+' icon appears in the select control to allow for creating an owner for the pet on the fly
                        ]) //
                ])
            ]);
    }

    // This function uses tables to create the List (Pets > List) of this resource to show a list of existing resources
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('DOB')
                    ->date('d / M / Y')
                    ->sortable()
                    ->label('Date of birth'),
                Tables\Columns\TextColumn::make('owner.name')
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
