<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Rendelések';
    protected static ?string $navigationGroup = 'Termékek & Rendelések';
    protected static ?int $navigationSort = 40;
    protected static ?string $modelLabel = 'Rendelés';
    protected static ?string $pluralModelLabel = 'Rendelések';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rendelés adatai')
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
                    ])->columns(2),

                Forms\Components\Section::make('Összegek')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->required()
                            ->numeric()
                            ->prefix('RON')
                            ->label('Részösszeg'),
                        Forms\Components\TextInput::make('tax_amount')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->prefix('RON')
                            ->label('ÁFA'),
                        Forms\Components\TextInput::make('discount_amount')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->prefix('RON')
                            ->label('Kedvezmény'),
                        Forms\Components\TextInput::make('total_amount')
                            ->required()
                            ->numeric()
                            ->prefix('RON')
                            ->label('Végösszeg'),
                    ])->columns(2),

                Forms\Components\Section::make('Szállítási adatok')
                    ->schema([
                        Forms\Components\TextInput::make('shipping_name')
                            ->required()
                            ->label('Név'),
                        Forms\Components\TextInput::make('shipping_email')
                            ->email()
                            ->required()
                            ->label('Email'),
                        Forms\Components\TextInput::make('shipping_phone')
                            ->tel()
                            ->label('Telefon'),
                        Forms\Components\Textarea::make('shipping_address')
                            ->required()
                            ->columnSpanFull()
                            ->label('Cím'),
                    ])->columns(2),

                Forms\Components\Section::make('Számlázási adatok')
                    ->schema([
                        Forms\Components\Toggle::make('billing_same_as_shipping')
                            ->label('Megegyezik a szállítási adatokkal')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('billing_name')
                            ->required()
                            ->label('Név'),
                        Forms\Components\Textarea::make('billing_address')
                            ->required()
                            ->columnSpanFull()
                            ->label('Cím'),
                    ])->columns(2),

                Forms\Components\Section::make('Megjegyzések & Dátumok')
                    ->schema([
                        Forms\Components\Textarea::make('customer_notes')
                            ->label('Vásárló megjegyzései'),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Admin megjegyzések'),
                        Forms\Components\DateTimePicker::make('ordered_at')
                            ->required()
                            ->label('Rendelés időpontja'),
                        Forms\Components\DatePicker::make('estimated_ready_date')
                            ->label('Várható elkészülés'),
                        Forms\Components\DateTimePicker::make('completed_at')
                            ->label('Teljesítve'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->label('Rendelésszám'),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Vásárló'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'processing',
                        'info' => 'ready',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('RON')
                    ->sortable()
                    ->label('Végösszeg'),
                Tables\Columns\TextColumn::make('ordered_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Rendelés dátuma'),
                Tables\Columns\TextColumn::make('estimated_ready_date')
                    ->date()
                    ->sortable()
                    ->label('Várható elkészülés'),
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('RON')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tax_amount')
                    ->money('RON')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->money('RON')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('shipping_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('shipping_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('shipping_phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('billing_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('billing_same_as_shipping')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('ordered_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Függőben',
                        'processing' => 'Feldolgozás alatt',
                        'ready' => 'Kész',
                        'completed' => 'Teljesítve',
                        'cancelled' => 'Törölve',
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
