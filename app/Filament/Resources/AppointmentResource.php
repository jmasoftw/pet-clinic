<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // This function uses form controls to create the form (Appointments > Create) of this resource to add new resources
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->closeOnDateSelection(true)
                            ->native(false),
                        Forms\Components\TimePicker::make('start')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(10) // Check that only chosen intervals of 10 min (at 10,20,..50) are valid on picking
                            ->closeOnDateSelection(true)
                            ->displayFormat('H:i'),
                        Forms\Components\TimePicker::make('end')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(10) // Check that only chosen intervals of 10 min (at 10,20,..50) are valid on picking
                            ->closeOnDateSelection(true)
                            ->displayFormat('H:i'),
                        Forms\Components\Select::make('pet_id')
                            ->relationship('pet','name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('description')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->native(false)
                            ->options(AppointmentStatus::class)
                            ->visibleOn(Pages\EditAppointment::class) //Only show to allow the user change the status in the edit form (Appointments > Edit) and not in the listing (Appointments > List) form nor when creating one new appointment
                ])

            ]);
    }

    // This function uses tables to create the List (Appointments > List) of this resource to show a list of existing resources
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('pet.avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('pet.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('d / M / Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start')
                    ->time('H:i')
                    ->label('From')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->time('H:i')
                    ->label('To')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
               // Add an action to let the user confirm an appointment by clicking in this confirm button
                Tables\Actions\Action::make('Confirm')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Confirmed;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status == AppointmentStatus::Created)
                    ->color('success')
                    ->icon('heroicon-o-check'),

                // Add an action to let the user cancel an appointment by clicking in this cancel button
                Tables\Actions\Action::make('Cancel')
                    ->action(function (Appointment $record) {
                        $record->status = AppointmentStatus::Canceled;
                        $record->save();
                    })
                    ->visible(fn (Appointment $record) => $record->status != AppointmentStatus::Canceled)
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
