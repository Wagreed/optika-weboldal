<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Termékek';
    protected static ?string $navigationGroup = 'Termékek & Rendelések';
    protected static ?int $navigationSort = 50;
    protected static ?string $modelLabel = 'Termék';
    protected static ?string $pluralModelLabel = 'Termékek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Alapadatok')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Név'),
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->required(),
                        Forms\Components\TextInput::make('brand')
                            ->label('Márka'),
                        Forms\Components\TextInput::make('model')
                            ->label('Modell'),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('RON')
                            ->label('Ár'),
                        Forms\Components\TextInput::make('sale_price')
                            ->numeric()
                            ->prefix('RON')
                            ->label('Akciós ár'),
                        Forms\Components\TextInput::make('stock_quantity')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Készlet'),
                        Forms\Components\Toggle::make('manage_stock')
                            ->label('Készletkezelés'),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->label('Leírás'),
                        Forms\Components\Textarea::make('short_description')
                            ->columnSpanFull()
                            ->label('Rövid leírás'),
                    ])->columns(2),

                Forms\Components\Section::make('Optikai adatok')
                    ->schema([
                        Forms\Components\TextInput::make('frame_material')
                            ->label('Keret anyaga'),
                        Forms\Components\TextInput::make('lens_type')
                            ->label('Lencse típusa'),
                        Forms\Components\TextInput::make('frame_color')
                            ->label('Keret színe'),
                        Forms\Components\TextInput::make('frame_size')
                            ->label('Keret mérete'),
                    ])->columns(2),

                Forms\Components\Section::make('Besorolás & Állapot')
                    ->schema([
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
                            ->label('Recept köteles'),
                        Forms\Components\Toggle::make('is_sunglasses')
                            ->label('Napszemüveg'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktív'),
                        Forms\Components\Toggle::make('featured')
                            ->label('Kiemelt'),
                    ])->columns(2),

                Forms\Components\Section::make('Képek')
                    ->schema([
                        Forms\Components\Repeater::make('images')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->image()
                                    ->disk('public')
                                    ->directory('products')
                                    ->required()
                                    ->label('Kép'),
                                Forms\Components\TextInput::make('alt_text')
                                    ->label('Alt szöveg'),
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->label('Sorrend'),
                                Forms\Components\Toggle::make('is_primary')
                                    ->label('Elsődleges kép'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Kép hozzáadása')
                            ->label('Termék képei'),
                    ]),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta cím'),
                        Forms\Components\Textarea::make('meta_description')
                            ->columnSpanFull()
                            ->label('Meta leírás'),
                    ])->columns(2)->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Név'),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->label('Márka'),
                Tables\Columns\TextColumn::make('price')
                    ->money('RON')
                    ->sortable()
                    ->label('Ár'),
                Tables\Columns\TextColumn::make('sale_price')
                    ->money('RON')
                    ->sortable()
                    ->label('Akciós ár')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Készlet'),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable()
                    ->label('Nem')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('age_group')
                    ->searchable()
                    ->label('Korosztály')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_prescription')
                    ->boolean()
                    ->label('Recept')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_sunglasses')
                    ->boolean()
                    ->label('Nap')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktív'),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->label('Kiemelt'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktív'),
                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Kiemelt'),
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'male' => 'Férfi',
                        'female' => 'Női',
                        'unisex' => 'Uniszex',
                        'kids' => 'Gyerek',
                    ])
                    ->label('Nem'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
