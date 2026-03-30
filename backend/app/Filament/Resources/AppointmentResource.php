<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Időpontok';
    protected static ?string $navigationGroup = 'Időpontok';
    protected static ?int $navigationSort = 10;
    protected static ?string $modelLabel = 'Időpont';
    protected static ?string $pluralModelLabel = 'Időpontok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Időpont adatai')
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
                            ->label('Dátum'),
                        Forms\Components\TextInput::make('start_time')
                            ->required()
                            ->label('Kezdés'),
                        Forms\Components\TextInput::make('end_time')
                            ->required()
                            ->label('Befejezés'),
                    ])->columns(2),

                Forms\Components\Section::make('Státusz & Ár')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'scheduled' => 'Foglalva',
                                'confirmed' => 'Megerősítve',
                                'completed' => 'Befejezve',
                                'cancelled' => 'Törölve',
                                'no_show' => 'Nem jelent meg',
                            ])
                            ->required()
                            ->label('Státusz'),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('RON')
                            ->label('Ár'),
                        Forms\Components\Toggle::make('reminder_sent')
                            ->label('Emlékeztető elküldve'),
                        Forms\Components\DateTimePicker::make('cancelled_at')
                            ->label('Lemondva'),
                    ])->columns(2),

                Forms\Components\Section::make('Megjegyzések')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Általános jegyzetek')
                            ->rows(3),
                        Forms\Components\Textarea::make('customer_notes')
                            ->label('Kliens megjegyzései')
                            ->rows(3),
                        Forms\Components\Textarea::make('internal_notes')
                            ->label('Belső jegyzetek')
                            ->rows(3),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('appointment_date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->label('Dátum'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Kezdés'),
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
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'scheduled',
                        'primary' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                        'secondary' => 'no_show',
                    ])
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('price')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\IconColumn::make('reminder_sent')
                    ->boolean()
                    ->label('Emlékeztető')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cancelled_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('appointment_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'scheduled' => 'Foglalva',
                        'confirmed' => 'Megerősítve',
                        'completed' => 'Befejezve',
                        'cancelled' => 'Törölve',
                        'no_show' => 'Nem jelent meg',
                    ])
                    ->label('Státusz'),
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
        return [];
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
