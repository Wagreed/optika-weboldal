<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentTypeResource\Pages;
use App\Models\AppointmentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentTypeResource extends Resource
{
    protected static ?string $model = AppointmentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Időpont típusok';
    protected static ?string $navigationGroup = 'Időpontok';
    protected static ?int $navigationSort = 20;
    protected static ?string $modelLabel = 'Időpont típus';
    protected static ?string $pluralModelLabel = 'Időpont típusok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Alapadatok')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Név'),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->required()
                            ->numeric()
                            ->default(30)
                            ->suffix('perc')
                            ->label('Időtartam'),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('RON')
                            ->label('Ár'),
                        Forms\Components\ColorPicker::make('color')
                            ->required()
                            ->label('Szín'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktív'),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->label('Leírás'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Név'),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->numeric()
                    ->sortable()
                    ->suffix(' perc')
                    ->label('Időtartam'),
                Tables\Columns\TextColumn::make('price')
                    ->money('RON')
                    ->sortable()
                    ->label('Ár'),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Szín'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktív'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAppointmentTypes::route('/'),
            'create' => Pages\CreateAppointmentType::route('/create'),
            'edit' => Pages\EditAppointmentType::route('/{record}/edit'),
        ];
    }
}
