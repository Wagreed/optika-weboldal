<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Filament\Resources\ContactMessageResource\RelationManagers;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->tel(),
                Forms\Components\TextInput::make('subject')
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->columnSpanFull()
                    ->label('Üzenet'),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'Új',
                        'read' => 'Olvasott',
                        'replied' => 'Válaszolt',
                        'archived' => 'Archivált',
                    ])
                    ->required()
                    ->label('Státusz'),
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP cím'),
                Forms\Components\Textarea::make('user_agent')
                    ->columnSpanFull()
                    ->label('Böngésző'),
                Forms\Components\DateTimePicker::make('replied_at')
                    ->label('Válaszolva'),
                Forms\Components\Select::make('replied_by')
                    ->relationship('repliedBy', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Válaszolta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'info' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                        'secondary' => 'archived',
                    ])
                    ->searchable()
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('replied_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Válaszolva'),
                Tables\Columns\TextColumn::make('repliedBy.name')
                    ->searchable()
                    ->sortable()
                    ->label('Válaszolta'),
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
