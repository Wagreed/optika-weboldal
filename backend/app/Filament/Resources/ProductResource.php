<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('short_description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('RON'),
                Forms\Components\TextInput::make('sale_price')
                    ->numeric()
                    ->prefix('RON'),
                Forms\Components\TextInput::make('stock_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('manage_stock')
                    ->required(),
                Forms\Components\TextInput::make('brand'),
                Forms\Components\TextInput::make('model'),
                Forms\Components\TextInput::make('frame_material'),
                Forms\Components\TextInput::make('lens_type'),
                Forms\Components\TextInput::make('frame_color')
                    ->label('Keret szín'),
                Forms\Components\TextInput::make('frame_size')
                    ->label('Keret méret'),
                Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'Férfi',
                        'female' => 'Női',
                        'unisex' => 'Uniszex',
                        'kids' => 'Gyerek',
                    ])
                    ->required()
                    ->label('Nem'),
                Forms\Components\Select::make('age_group')
                    ->options([
                        'adult' => 'Felnőtt',
                        'child' => 'Gyerek',
                        'senior' => 'Idős',
                    ])
                    ->required()
                    ->label('Korosztály'),
                Forms\Components\Toggle::make('is_prescription')
                    ->required(),
                Forms\Components\Toggle::make('is_sunglasses')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Toggle::make('featured')
                    ->required(),
                Forms\Components\TextInput::make('meta_title'),
                Forms\Components\Textarea::make('meta_description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->money('RON')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('manage_stock')
                    ->boolean(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('frame_material')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lens_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('frame_color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('frame_size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age_group')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_prescription')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_sunglasses')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('meta_title')
                    ->searchable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
