<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Oldalak';
    protected static ?string $navigationGroup = 'Tartalom';
    protected static ?int $navigationSort = 100;
    protected static ?string $modelLabel = 'Oldal';
    protected static ?string $pluralModelLabel = 'Oldalak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tartalom')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Cím'),
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                        Forms\Components\Select::make('author_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Szerző'),
                        Forms\Components\TextInput::make('template')
                            ->required()
                            ->label('Sablon'),
                        Forms\Components\Textarea::make('excerpt')
                            ->columnSpanFull()
                            ->label('Kivonat'),
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->rows(10)
                            ->label('Tartalom'),
                    ])->columns(2),

                Forms\Components\Section::make('Publikálás')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Piszkozat',
                                'published' => 'Publikált',
                                'archived' => 'Archivált',
                            ])
                            ->required()
                            ->label('Státusz'),
                        Forms\Components\TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Sorrend'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publikálás időpontja'),
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->label('Kiemelt kép'),
                    ])->columns(2),

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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Cím'),
                Tables\Columns\TextColumn::make('template')
                    ->searchable()
                    ->label('Sablon'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ])
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('author.name')
                    ->searchable()
                    ->sortable()
                    ->label('Szerző'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->label('Sorrend'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Publikálva'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Piszkozat',
                        'published' => 'Publikált',
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
