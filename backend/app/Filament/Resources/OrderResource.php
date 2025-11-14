<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

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
                    ->label('Vásárló'),
                Forms\Components\TextInput::make('order_number')
                    ->required()
                    ->label('Rendelésszám'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Függőben',
                        'processing' => 'Feldolgozás alatt',
                        'ready' => 'Kész',
                        'completed' => 'Teljesítve',
                        'cancelled' => 'Törölve',
                    ])
                    ->required()
                    ->label('Státusz'),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->prefix('RON'),
                Forms\Components\TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('RON'),
                Forms\Components\TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('RON'),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('RON'),
                Forms\Components\TextInput::make('shipping_name')
                    ->required(),
                Forms\Components\TextInput::make('shipping_email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('shipping_phone')
                    ->tel(),
                Forms\Components\Textarea::make('shipping_address')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('billing_name')
                    ->required(),
                Forms\Components\Textarea::make('billing_address')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('billing_same_as_shipping')
                    ->required(),
                Forms\Components\Textarea::make('customer_notes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('admin_notes')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('ordered_at')
                    ->required(),
                Forms\Components\DatePicker::make('estimated_ready_date'),
                Forms\Components\DateTimePicker::make('completed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Vásárló'),
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->label('Rendelésszám'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'processing',
                        'info' => 'ready',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->searchable()
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax_amount')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('billing_name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('billing_same_as_shipping')
                    ->boolean(),
                Tables\Columns\TextColumn::make('ordered_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_ready_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
