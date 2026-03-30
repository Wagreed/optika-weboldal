<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EyeExaminationResource\Pages;
use App\Models\EyeExamination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EyeExaminationResource extends Resource
{
    protected static ?string $model = EyeExamination::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationLabel = 'Szemvizsgálatok';
    protected static ?string $navigationGroup = 'Szemészet';
    protected static ?int $navigationSort = 30;
    protected static ?string $modelLabel = 'Szemvizsgálat';
    protected static ?string $pluralModelLabel = 'Szemvizsgálatok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Alapadatok')
                    ->schema([
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
                        Forms\Components\Select::make('appointment_id')
                            ->relationship('appointment', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->customer->name} - {$record->appointment_date}")
                            ->searchable()
                            ->preload()
                            ->label('Kapcsolódó időpont'),
                        Forms\Components\DatePicker::make('examination_date')
                            ->required()
                            ->label('Vizsgálat dátuma'),
                        Forms\Components\DatePicker::make('next_examination_recommended')
                            ->label('Következő ajánlott vizsgálat'),
                    ])->columns(2),

                Forms\Components\Section::make('Látásélesség')
                    ->schema([
                        Forms\Components\TextInput::make('visual_acuity_right_eye')
                            ->label('Jobb szem látásélessége'),
                        Forms\Components\TextInput::make('visual_acuity_left_eye')
                            ->label('Bal szem látásélessége'),
                    ])->columns(2),

                Forms\Components\Section::make('Jobb szem dioptria')
                    ->schema([
                        Forms\Components\TextInput::make('sphere_right')
                            ->numeric()
                            ->label('Szféra (D)'),
                        Forms\Components\TextInput::make('cylinder_right')
                            ->numeric()
                            ->label('Cilinder (D)'),
                        Forms\Components\TextInput::make('axis_right')
                            ->numeric()
                            ->label('Tengely (°)'),
                    ])->columns(3),

                Forms\Components\Section::make('Bal szem dioptria')
                    ->schema([
                        Forms\Components\TextInput::make('sphere_left')
                            ->numeric()
                            ->label('Szféra (D)'),
                        Forms\Components\TextInput::make('cylinder_left')
                            ->numeric()
                            ->label('Cilinder (D)'),
                        Forms\Components\TextInput::make('axis_left')
                            ->numeric()
                            ->label('Tengely (°)'),
                    ])->columns(3),

                Forms\Components\Section::make('Egyéb mérések')
                    ->schema([
                        Forms\Components\TextInput::make('pupillary_distance')
                            ->numeric()
                            ->suffix('mm')
                            ->label('Pupillatávolság'),
                        Forms\Components\TextInput::make('intraocular_pressure_right')
                            ->numeric()
                            ->suffix('mmHg')
                            ->label('Szemnyomás – jobb'),
                        Forms\Components\TextInput::make('intraocular_pressure_left')
                            ->numeric()
                            ->suffix('mmHg')
                            ->label('Szemnyomás – bal'),
                        Forms\Components\TextInput::make('color_vision_test_result')
                            ->label('Színlátás teszt eredménye'),
                    ])->columns(2),

                Forms\Components\Section::make('Megjegyzések')
                    ->schema([
                        Forms\Components\Textarea::make('examination_notes')
                            ->label('Vizsgálat megjegyzései')
                            ->rows(3),
                        Forms\Components\Textarea::make('recommendations')
                            ->label('Javaslatok')
                            ->rows(3),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('examination_date')
                    ->date()
                    ->sortable()
                    ->label('Dátum'),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Páciens'),
                Tables\Columns\TextColumn::make('examiner.name')
                    ->searchable()
                    ->sortable()
                    ->label('Vizsgáló'),
                Tables\Columns\TextColumn::make('visual_acuity_right_eye')
                    ->label('Látásélesség J.')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('visual_acuity_left_eye')
                    ->label('Látásélesség B.')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sphere_right')
                    ->numeric()
                    ->label('Szféra J.')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sphere_left')
                    ->numeric()
                    ->label('Szféra B.')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pupillary_distance')
                    ->numeric()
                    ->suffix(' mm')
                    ->label('Pupillatáv.')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('next_examination_recommended')
                    ->date()
                    ->sortable()
                    ->label('Következő vizsgálat'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('examination_date', 'desc')
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
            'index' => Pages\ListEyeExaminations::route('/'),
            'create' => Pages\CreateEyeExamination::route('/create'),
            'edit' => Pages\EditEyeExamination::route('/{record}/edit'),
        ];
    }
}
