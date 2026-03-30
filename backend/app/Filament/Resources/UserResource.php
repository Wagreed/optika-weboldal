<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Felhasználók';
    protected static ?string $navigationGroup = 'Felhasználók';
    protected static ?int $navigationSort = 70;
    protected static ?string $modelLabel = 'Felhasználó';
    protected static ?string $pluralModelLabel = 'Felhasználók';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Alapadatok')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Név'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->label('Email'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->dehydrated(fn ($state) => filled($state))
                            ->hiddenOn('edit')
                            ->label('Jelszó'),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email megerősítve'),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->label('Aktív'),
                    ])->columns(2),

                Forms\Components\Section::make('Elérhetőségek & Személyes adatok')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->label('Telefonszám'),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Születési dátum'),
                        Forms\Components\Textarea::make('address')
                            ->columnSpanFull()
                            ->label('Cím'),
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
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label('Telefon'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktív'),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Email megerősítve')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable()
                    ->label('Születési dátum')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Regisztrálva')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktív'),
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->nullable()
                    ->label('Email megerősítve'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
