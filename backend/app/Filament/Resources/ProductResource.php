<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon  = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Termékek';
    protected static ?string $navigationGroup = 'Termékek & Rendelések';
    protected static ?int    $navigationSort  = 50;
    protected static ?string $modelLabel       = 'Termék';
    protected static ?string $pluralModelLabel = 'Termékek';

    // ──────────────────────────────────────────────────────────────────────
    // Előre definiált opciók — ezek az értékek kerülnek az adatbázisba,
    // és ezeket ellenőrzi a frontend a dinamikus tartalom megjelenítésekor.
    // ──────────────────────────────────────────────────────────────────────
    private static array $frameMaterialOptions = [
        'Acetát'                   => 'Acetát',
        'Titánium'                 => 'Titánium',
        'Fém / Acél'               => 'Fém / Acél',
        'TR90 – Rugalmas műanyag'  => 'TR90 – Rugalmas műanyag',
        'Fa'                       => 'Fa',
        'Bambusz'                  => 'Bambusz',
        'Műanyag'                  => 'Műanyag',
        'Vegyes / Kombinált'       => 'Vegyes / Kombinált',
    ];

    private static array $lensTypeOptions = [
        'Egyfókuszú'                       => 'Egyfókuszú',
        'Progresszív (multifokális)'        => 'Progresszív (multifokális)',
        'Fotokromatikus (Transitions)'      => 'Fotokromatikus (Transitions)',
        'Polarizált'                        => 'Polarizált',
        'Kékfény-szűrős'                   => 'Kékfény-szűrős',
        'Bifokális'                         => 'Bifokális',
        'Aszferikus'                        => 'Aszferikus',
        'Sík / Normál (dioptria nélkül)'   => 'Sík / Normál (dioptria nélkül)',
    ];

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make()
                ->tabs([

                    // ── 1. TAB: Alapadatok ─────────────────────────────
                    Forms\Components\Tabs\Tab::make('Alapadatok')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Termék neve')
                                ->required()
                                ->maxLength(255)
                                // Automatikusan generálja a slug-ot szerkesztéskor
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                    if ($operation === 'create' && $state) {
                                        $set('slug', Str::slug($state));
                                    }
                                }),

                            Forms\Components\TextInput::make('slug')
                                ->label('URL azonosító (slug)')
                                ->required()
                                ->unique(Product::class, 'slug', ignoreRecord: true)
                                ->helperText('Automatikusan generált a névből. Módosítható, de csak kisbetű, szám és kötőjel.')
                                ->maxLength(255),

                            Forms\Components\TextInput::make('brand')
                                ->label('Márka')
                                ->maxLength(100),

                            Forms\Components\TextInput::make('model')
                                ->label('Modell szám')
                                ->maxLength(100),

                            Forms\Components\TextInput::make('sku')
                                ->label('Cikkszám (SKU)')
                                ->required()
                                ->unique(Product::class, 'sku', ignoreRecord: true)
                                ->maxLength(100),

                            Forms\Components\TextInput::make('price')
                                ->label('Normál ár')
                                ->required()
                                ->numeric()
                                ->prefix('RON')
                                ->minValue(0),

                            Forms\Components\TextInput::make('sale_price')
                                ->label('Akciós ár')
                                ->numeric()
                                ->prefix('RON')
                                ->minValue(0)
                                ->helperText('Ha ki van töltve, az oldalon áthúzva jelenik meg a normál ár.'),

                            Forms\Components\TextInput::make('stock_quantity')
                                ->label('Készlet (db)')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->minValue(0),

                            Forms\Components\Toggle::make('manage_stock')
                                ->label('Készletkezelés aktív')
                                ->helperText('Ha bekapcsolt, a rendszer figyeli a készletet.'),

                            Forms\Components\Textarea::make('short_description')
                                ->label('Rövid leírás')
                                ->rows(3)
                                ->maxLength(300)
                                ->columnSpanFull()
                                ->helperText('Max. 300 karakter. Ez jelenik meg a terméklistában és a termékoldal kiemelő szövegként.'),

                            Forms\Components\Textarea::make('description')
                                ->label('Teljes leírás')
                                ->rows(6)
                                ->columnSpanFull()
                                ->helperText('Részletes termékleírás. Formázáshoz használhat sortörést (Enter).'),
                        ])->columns(2),

                    // ── 2. TAB: Optikai adatok ─────────────────────────
                    Forms\Components\Tabs\Tab::make('Optikai adatok')
                        ->icon('heroicon-o-eye')
                        ->schema([
                            Forms\Components\Select::make('frame_material')
                                ->label('Keret anyaga')
                                ->options(self::$frameMaterialOptions)
                                ->searchable()
                                ->helperText('A frontend ezen érték alapján generál részletes anyagismertetőt és "Kinek ajánljuk" szöveget.'),

                            Forms\Components\Select::make('lens_type')
                                ->label('Lencse típusa')
                                ->options(self::$lensTypeOptions)
                                ->searchable()
                                ->helperText('A frontend ezen érték alapján generál részletes lencseismertetőt.'),

                            Forms\Components\TextInput::make('frame_color')
                                ->label('Keret színe')
                                ->maxLength(50)
                                ->helperText('Pl. "Fekete", "Havanna barna", "Gunmetal szürke"'),

                            Forms\Components\TextInput::make('frame_size')
                                ->label('Keret mérete')
                                ->maxLength(20)
                                ->helperText('Pl. "52-18-145" (lencse-orrnyereg-szár mm-ben)'),

                            Forms\Components\Select::make('gender')
                                ->label('Nem')
                                ->options([
                                    'male'   => 'Férfi',
                                    'female' => 'Női',
                                    'unisex' => 'Uniszex',
                                    'kids'   => 'Gyerek',
                                ])
                                ->required(),

                            Forms\Components\Select::make('age_group')
                                ->label('Korosztály')
                                ->options([
                                    'adult'  => 'Felnőtt',
                                    'senior' => 'Idős (60+)',
                                    'child'  => 'Gyerek',
                                ])
                                ->required()
                                ->helperText('A "Kinek ajánljuk" szekció tartalmát befolyásolja.'),

                            Forms\Components\Toggle::make('is_prescription')
                                ->label('Dioptriával rendelhető')
                                ->helperText('Ha bekapcsolt: megjelenik a "Dioptriás" badge és a kapcsolódó ajánlótext.'),

                            Forms\Components\Toggle::make('is_sunglasses')
                                ->label('Napszemüveg')
                                ->helperText('Ha bekapcsolt: megjelenik a "Napszemüveg" badge és az UV-védelem info.'),

                            Forms\Components\Select::make('categories')
                                ->label('Kategóriák')
                                ->relationship('categories', 'name')
                                ->multiple()
                                ->preload()
                                ->columnSpanFull()
                                ->helperText('Több kategóriát is választhat.'),
                        ])->columns(2),

                    // ── 3. TAB: Megjelenés & Állapot ──────────────────
                    Forms\Components\Tabs\Tab::make('Állapot')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Termék aktív (látható az oldalon)')
                                ->default(true),

                            Forms\Components\Toggle::make('featured')
                                ->label('Kiemelt termék (főoldalon jelenik meg)')
                                ->helperText('Maximum 8-10 kiemelt termék javasolt a főoldali karusel számára.'),
                        ]),

                    // ── 4. TAB: Képek ──────────────────────────────────
                    Forms\Components\Tabs\Tab::make('Képek')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\Repeater::make('images')
                                ->relationship()
                                ->schema([
                                    Forms\Components\FileUpload::make('image_path')
                                        ->label('Képfájl')
                                        ->image()
                                        ->disk('public')
                                        ->directory('products')
                                        ->imageEditor()
                                        ->required(),

                                    Forms\Components\TextInput::make('alt_text')
                                        ->label('Alt szöveg (SEO)')
                                        ->maxLength(125)
                                        ->helperText('Leírja a képet a keresőmotoroknak és akadálymentesítéshez. Pl. "Ray-Ban Wayfarer fekete keret"'),

                                    Forms\Components\TextInput::make('sort_order')
                                        ->label('Sorrend')
                                        ->numeric()
                                        ->default(0),

                                    Forms\Components\Toggle::make('is_primary')
                                        ->label('Elsődleges / Borítókép'),
                                ])
                                ->columns(2)
                                ->reorderable()
                                ->addActionLabel('+ Kép hozzáadása')
                                ->helperText('Az elsődleges kép jelenik meg a terméklistában és a megosztásoknál.'),
                        ]),

                    // ── 5. TAB: SEO ────────────────────────────────────
                    Forms\Components\Tabs\Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label('Meta cím (title tag)')
                                ->maxLength(70)
                                ->helperText('Ideálisan 50-60 karakter. Ha üres marad, a rendszer automatikusan generálja: "{Terméknév} - {Márka} | Optika"')
                                ->columnSpanFull(),

                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta leírás (description)')
                                ->rows(3)
                                ->maxLength(160)
                                ->columnSpanFull()
                                ->helperText('Ideálisan 120-155 karakter. Ha üres, a rendszer a rövid leírásból generálja. Ez a szöveg jelenik meg a Google keresési találatoknál.'),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images.image_path')
                    ->label('')
                    ->disk('public')
                    ->size(48)
                    ->square()
                    ->defaultImageUrl(asset('img/placeholder.png'))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Név')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Product $p) => $p->brand ?? ''),

                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('price')
                    ->label('Ár')
                    ->money('RON')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sale_price')
                    ->label('Akciós')
                    ->money('RON')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('frame_material')
                    ->label('Anyag')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Nem')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'male'   => 'info',
                        'female' => 'pink',
                        'kids'   => 'warning',
                        default  => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'male'   => 'Férfi',
                        'female' => 'Női',
                        'unisex' => 'Uniszex',
                        'kids'   => 'Gyerek',
                        default  => $state,
                    })
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_prescription')
                    ->label('Dioptria')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_sunglasses')
                    ->label('Nap')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Készlet')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state) => $state > 5 ? 'success' : ($state > 0 ? 'warning' : 'danger')),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean(),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Kiemelt')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y.m.d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktív'),

                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Kiemelt'),

                Tables\Filters\TernaryFilter::make('is_sunglasses')
                    ->label('Napszemüveg'),

                Tables\Filters\TernaryFilter::make('is_prescription')
                    ->label('Dioptriás'),

                Tables\Filters\SelectFilter::make('gender')
                    ->label('Nem')
                    ->options([
                        'male'   => 'Férfi',
                        'female' => 'Női',
                        'unisex' => 'Uniszex',
                        'kids'   => 'Gyerek',
                    ]),

                Tables\Filters\SelectFilter::make('age_group')
                    ->label('Korosztály')
                    ->options([
                        'adult'  => 'Felnőtt',
                        'senior' => 'Idős',
                        'child'  => 'Gyerek',
                    ]),

                Tables\Filters\SelectFilter::make('frame_material')
                    ->label('Keret anyaga')
                    ->options(self::$frameMaterialOptions),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
