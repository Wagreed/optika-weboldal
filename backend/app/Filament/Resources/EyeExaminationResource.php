<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EyeExaminationResource\Pages;
use App\Filament\Resources\EyeExaminationResource\RelationManagers;
use App\Models\EyeExamination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EyeExaminationResource extends Resource
{
    protected static ?string $model = EyeExamination::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('appointment_id')
                    ->relationship('appointment', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->customer->name} - {$record->appointment_date}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Időpont'),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Páciens'),
                Forms\Components\Select::make('examiner_id')
                    ->relationship('examiner', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Vizsgáló'),
                Forms\Components\DatePicker::make('examination_date')
                    ->required()
                    ->label('Vizsgálat dátuma'),
                Forms\Components\TextInput::make('visual_acuity_right_eye'),
                Forms\Components\TextInput::make('visual_acuity_left_eye'),
                Forms\Components\TextInput::make('sphere_right')
                    ->numeric(),
                Forms\Components\TextInput::make('cylinder_right')
                    ->numeric(),
                Forms\Components\TextInput::make('axis_right')
                    ->numeric(),
                Forms\Components\TextInput::make('sphere_left')
                    ->numeric(),
                Forms\Components\TextInput::make('cylinder_left')
                    ->numeric(),
                Forms\Components\TextInput::make('axis_left')
                    ->numeric(),
                Forms\Components\TextInput::make('pupillary_distance')
                    ->numeric(),
                Forms\Components\TextInput::make('intraocular_pressure_right')
                    ->numeric(),
                Forms\Components\TextInput::make('intraocular_pressure_left')
                    ->numeric(),
                Forms\Components\TextInput::make('color_vision_test_result'),
                Forms\Components\Textarea::make('examination_notes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('recommendations')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('next_examination_recommended'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Páciens'),
                Tables\Columns\TextColumn::make('examiner.name')
                    ->searchable()
                    ->sortable()
                    ->label('Vizsgáló'),
                Tables\Columns\TextColumn::make('examination_date')
                    ->date()
                    ->label('Vizsgálat dátuma')
                    ->sortable(),
                Tables\Columns\TextColumn::make('visual_acuity_right_eye')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visual_acuity_left_eye')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sphere_right')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cylinder_right')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('axis_right')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sphere_left')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cylinder_left')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('axis_left')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pupillary_distance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('intraocular_pressure_right')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('intraocular_pressure_left')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('color_vision_test_result')
                    ->searchable(),
                Tables\Columns\TextColumn::make('next_examination_recommended')
                    ->date()
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
            'index' => Pages\ListEyeExaminations::route('/'),
            'create' => Pages\CreateEyeExamination::route('/create'),
            'edit' => Pages\EditEyeExamination::route('/{record}/edit'),
        ];
    }
}
