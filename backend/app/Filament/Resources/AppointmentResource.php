<?php

namespace App\Filament\Resources;

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Kliens'),
                Forms\Components\Select::make('staff_id')
                    ->relationship('staff', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Munkatárs'),
                Forms\Components\Select::make('appointment_type_id')
                    ->relationship('appointmentType', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Időpont típusa'),
                Forms\Components\DatePicker::make('appointment_date')
                    ->required()
                    ->label('Időpont dátuma'),
                Forms\Components\TextInput::make('start_time')
                    ->required()
                    ->label('Kezdés'),
                Forms\Components\TextInput::make('end_time')
                    ->required()
                    ->label('Befejezés'),
                Forms\Components\Select::make('status')
                    ->options([
                        'scheduled' => 'Időpontfoglalva',
                        'confirmed' => 'Megerősítve',
                        'completed' => 'Befejezve',
                        'cancelled' => 'Törölve',
                        'no_show' => 'Nem jelent meg',
                    ])
                    ->required()
                    ->label('Státusz'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Jegyzetek'),
                Forms\Components\Textarea::make('customer_notes')
                    ->columnSpanFull()
                    ->label('Kliens jegyzetei'),
                Forms\Components\Textarea::make('internal_notes')
                    ->columnSpanFull()
                    ->label('Belső jegyzetek'),
                Forms\Components\Toggle::make('reminder_sent')
                    ->required()
                    ->label('Emlékeztető elküldve'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('RON')
                    ->label('Ár'),
                Forms\Components\DateTimePicker::make('cancelled_at')
                    ->label('Lemondva'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Kliens'),
                Tables\Columns\TextColumn::make('staff.name')
                    ->searchable()
                    ->sortable()
                    ->label('Munkatárs'),
                Tables\Columns\TextColumn::make('appointmentType.name')
                    ->searchable()
                    ->sortable()
                    ->label('Típus'),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->date()
                    ->sortable()
                    ->label('Dátum'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Kezdés'),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Befejezés'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'scheduled',
                        'primary' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                        'secondary' => 'no_show',
                    ])
                    ->searchable()
                    ->label('Státusz'),
                Tables\Columns\IconColumn::make('reminder_sent')
                    ->boolean(),
                Tables\Columns\TextColumn::make('price')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cancelled_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
