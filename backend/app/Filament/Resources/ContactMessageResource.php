<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Üzenetek';
    protected static ?string $navigationGroup = 'Tartalom';
    protected static ?int $navigationSort = 80;
    protected static ?string $modelLabel = 'Üzenet';
    protected static ?string $pluralModelLabel = 'Üzenetek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Feladó adatai')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Név'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->label('Email'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->label('Telefon'),
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->label('Tárgy'),
                    ])->columns(2),

                Forms\Components\Section::make('Üzenet')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->columnSpanFull()
                            ->rows(5)
                            ->label('Üzenet'),
                    ]),

                Forms\Components\Section::make('Kezelés')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'Új',
                                'read' => 'Olvasott',
                                'replied' => 'Megválaszolt',
                                'archived' => 'Archivált',
                            ])
                            ->required()
                            ->label('Státusz'),
                        Forms\Components\Select::make('replied_by')
                            ->relationship('repliedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Válaszolta'),
                        Forms\Components\DateTimePicker::make('replied_at')
                            ->label('Válasz időpontja'),
                    ])->columns(2),

                Forms\Components\Section::make('Technikai adatok')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP cím'),
                        Forms\Components\Textarea::make('user_agent')
                            ->columnSpanFull()
                            ->label('Böngésző'),
                    ])->columns(2)->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Érkezett'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Név'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->label('Tárgy'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'info' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                        'secondary' => 'archived',
                    ])
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('repliedBy.name')
                    ->searchable()
                    ->sortable()
                    ->label('Válaszolta')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('replied_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Válaszolva')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'Új',
                        'read' => 'Olvasott',
                        'replied' => 'Megválaszolt',
                        'archived' => 'Archivált',
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
